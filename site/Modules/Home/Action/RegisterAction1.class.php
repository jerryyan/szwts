<?php
class RegisterAction extends MainAction {
	
	// 判断是否已经登录
	public function __construct(){
		parent::__construct();
		$users = $this->users;
		$action_name = ACTION_NAME;
		$actions = array('index', 'save', 'agreement');
		if(!empty($users['user_id']) && in_array($action_name, $actions)){
			$this->redirect('/Center');
			exit;
		}
	}
	
	//会员注册页面
	public function index(){
		$_q = getParams();
		if(!empty($_q->u)){
			$user = Url2Key($_q->u, "register_invite");
			$invite_userid = $user[1];
			$this->assign("invite_userid", $invite_userid);
		}
		$this->display();
	}
	
	//保存会员的注册信息
	public function save(){
		$_q = getParams();
		$uname = $_q->uname;
		$upwd = $_q->upwd;
		$valicode = $_q->valicode;
		$o = new stdClass();
		$o->state = 0;
		$o->msg = "";
		$uname_len = mb_strlen($uname, 'utf8');
		$upwd_len = mb_strlen($upwd, 'utf8');
		$code_len = mb_strlen($valicode, 'utf8');
		if($uname_len<2 || $uname_len>16){
			$o->msg = "用户名格式不正确";
			echo json_encode($o);
			die();
		}
		if($upwd_len<6 || $upwd_len>20){
			$o->msg = "密码格式不正确";
			echo json_encode($o);
			die();
		}
		if($code_len!=4){
			$o->msg = "验证码长度必须为4位";
			echo json_encode($o);
			die();
		}
		$captcha = $_SESSION['captcha'];
		if(strtolower($valicode) != $captcha){
			$o->msg = "验证码输入不正确";
			echo json_encode($o);
			die();
		}
		$user = M("User");
		$user_result = $user->where("username='%s'", $uname)->find();
		if(!empty($user_result)){
			$o->msg = "用户名已经存在";
			echo json_encode($o);
			die();
		}
		$time = time();
		$ip = get_client_ip();
		$user_data = array(
			'username' => $uname,
			'password' => md5(C("FRONT_SERVER_KEY").$upwd),
			'addtime' => $time,
			'addip' => $time,
			'uptime' => $time,
			'upip' => $ip,
			'lasttime' => $time,
			'lastip' =>$ip
		);
		if(intval($_q->invite_id)){
			$user_data['invite_userid'] = $_q->invite_id;
		}
		$user_id = $user->add($user_data);
		if($user_id>0){
			if(intval($_q->oid)>0){
				$oauth_user_data = array(
					'oauth_id' => $_q->oid,
					'user_id' => $user_id
				);
				M("Oauth_user")->save($oauth_user_data);
			}
			$user_result = $user->where("username='%s'", $user_data['username'])->find();
			$_SESSION['Home_user'] = $user_result;
			M("User_cache")->add(array('user_id'=>$user_id));
			M("Account")->add(array('user_id'=>$user_id));
			$o->state = 1;
			$o->msg = "注册成功";
		}else{
			$o->msg = "注册失败";
		}
		echo json_encode($o);
		die();
	}

	//用户协议
	public function agreement(){
		$this->display();
	}
	
	//验证用户手机或邮箱以完成认证
	public function verify(){
		if(!empty($this->users)){
			$user_result = M("User")->field("email_status,phone_status")->find($this->users['user_id']);
			if($user_result['email_status']==0 && $user_result['phone_status']==0){
				$this->display();
			}else{
				$this->redirect("/Center");
			}
		}else{
			$this->redirect("/Login");
		}
	}
	
	//发送手机验证码
	public function sendcode(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->phone = $_q->phone;
		$obj->oprate = "注册新账户";
                $obj->tips = "如非本人操作请致电：".C("PLATFORM_HOTLINE");
		$o = $this->sendSms($obj);
		echo json_encode($o);
		die();
	}
	
	//检测手机验证码并保存数据
	public function verifybymobile(){
		$_q = getParams();
		$o = new stdClass();
		$o->state = 0;
		$o->msg = "";
		$phone_len = mb_strlen($_q->phone, 'utf-8');
		if($phone_len!=11){
			$o->msg = "手机号码格式不正确";
			echo json_encode($o);
			die();
		}
		if($_SESSION['PhoneCode']!=$_q->code){
			$o->msg = "验证码输入不正确";
			echo json_encode($o);
			die();
		}
		$user = M("User");
		$user_result = $user->field("phone")->where("phone='%s' and phone_status=1", $_q->phone)->find();
		if(!empty($user_result)){
			$o->msg = "此手机号码已被占用";
			echo json_encode($o);
			die();
		}
		$user_data = array(
			'user_id' => $this->users['user_id'],
			'phone' => $_q->phone,
			'phone_status' => 1
		);
		$result = $user->save($user_data);
		$_SESSION['PhoneCode'] = null;
		if($result>0){
			$_SESSION['Home_user']['phone_status'] = 1;
			$o->state = 1;
			$o->msg = '手机号码验证通过';
		}else{
			$o->msg = '手机号码验证失败';
		}
		echo json_encode($o);
		die();
	}
	
	//检测电子邮箱地址并保存数据
	public function verifybyemail(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->email = $_q->email;
		$obj->type = 0;
		$o = $this->sendMail($obj);
		echo json_encode($o);
		die();
	}
	
	//通过邮箱收到的加密链接验证邮箱
	public function active(){
		$_q = getParams();
		$check = $_q->check;
		$code = $_q->code;
		if(!empty($code)){
			$user = M("User");
			$time = time();
			$user_result = $user->where("token='%s' and token_verify_status='0'", $code)->find();
			if(!empty($user_result)){
				if($time<=$user_result['token_exptime']){
					$user_data = array(
						'user_id' => $user_result['user_id'],
						'email' => $user_result['temp_email'],
						'temp_email' => '',
						'email_status' => 1,
						'token_verify_status' => 1
					);
					$result = M("User")->save($user_data);
					if($result>0){
						$_SESSION['Home_user'] = $user_result;
						$tempData = array('uname'=>$user_result['username']);
						$this->assign("tempData", $tempData);
						$this->display("finish");
						die();
					}
				}
			}		
		}
		$tempData = array(
			'promptInfo' => '您的激活链接已经失效，请重新发送激活邮件',
			'infoType' => 'cw1',
			'returnUrl' => '/login',
			'returnText' => '返回登录页面'
		);			
		$this->assign("tempData", $tempData);
		$this->display("Common/prompt");
	}
}