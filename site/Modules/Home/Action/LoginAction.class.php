<?php
class LoginAction extends MainAction {
	
	// 判断是否已经登录
	public function __construct(){
		parent::__construct();
		$users = $this->users;
		if(!empty($users['user_id'])){
			$this->redirect('/Center');
			exit;
		}
	}
	
	//会员登录页面
	public function index(){
		$this->assign("loginPage", 1);
		$this->display();
	}
	
	//获取验证码
	public function getValicode(){
		getValicode();	
	}
	
	//验证会员登录
	public function verify(){
		$_q = getParams();
		$valicode = $_q->valicode;
		$o = new stdClass();
		$o->state = 0;
		$o->msg = "";
		if(empty($valicode) || strlen($valicode)<4){
			$o->msg = "验证码格式不正确";
			echo json_encode($o);
			die();
		}
		$captcha = $_SESSION['captcha'];
		if(strtolower($valicode) != $captcha){
			$o->msg = "验证码输入不正确";
			echo json_encode($o);
			die();
		}
		$username = $_q->uname;
		$password = md5(C("FRONT_SERVER_KEY").$_q->upwd);
		$user = M("User");
		$user_result = $user->where("(username='%s' or email='%s' or phone='%s') and password='%s'", $username, $username, $username, $password)->find();
		$time = strtotime(date('Y-m-d'));
		if(empty($user_result)){
			//判断输入的用户名，邮箱或密码是否存在，存在则记录错误次数
			$user_result_1 = $user->where("username='%s' or email='%s' or phone='%s'", $username, $username, $username)->find();
			if(!empty($user_result_1['user_id'])){
				$user_data['user_id'] = $user_result_1['user_id'];
				if($time>$user_result_1['login_time']){
					$user_data['login_num'] = 1;
					$user_data['login_time'] = $time;			
				}else{
					if($user_result_1['login_num']>3){
						$o->msg = "此账号当天连续输入错误3次，已被锁定";
						echo json_encode($o);
						die();
					}
					$user_data['login_num'] = $user_result_1['login_num']+1;
				}
				$user->save($user_data);
			}
			$o->msg = "用户名或密码不正确，当天连续输入错误3次账号将被锁定";
			echo json_encode($o);
			die();
		}
		if($user_result['islock']==1){
			$o->msg = "您的账号已被冻结";
			echo json_encode($o);
			die();
		}
		if($user_result['login_num']>3 && $time==$user_result['login_time']){
			$o->msg = "此账号当天连续输入错误3次，已被锁定";
			echo json_encode($o);
			die();
		}
		$_SESSION['Home_user'] = $user_result;
		$data['user_id'] = $user_result['user_id'];
		$data['lasttime'] = time();
		$data['lastip'] = get_client_ip();
		$data['login_num'] = 0;
		$user->save($data);
		if(intval($_q->oid)>0){
			$oauth_user_data = array(
				'oauth_id' => $_q->oid,
				'user_id' => $user_result['user_id']
			);
			M("Oauth_user")->save($oauth_user_data);
		}
		$o->state = 1;
		$o->msg = "登录成功";
		echo json_encode($o);
	}
	
	//QQ和微博第三方登录入口
	public function oauth(){
		$_q = getParams();
		if(intval($_q->type)>0){
			include_once('./api/weibo/saetv2.ex.class.php');
			$o = new SaeTOAuthV2(C("WB_AKEY"), C("WB_SKEY"));
			$code_url = $o->getAuthorizeURL(C("WB_CALLBACK_URL"));
			header("location:".$code_url);	
		}else{
			include_once("./api/qqConnectAPI.php");
			$qc = new QC();
			$qc->qq_login();
		}
	}
	
	//QQ登录回调接口
	public function qq_callback(){
		include_once("./api/qqConnectAPI.php");
		$qc = new QC();
		$data['token'] = $qc->qq_callback();	
		$data['open_id'] = $qc->get_openid();
		if(isset($data['open_id']) && isset($data['token'])){
			$oauth_user = M("Oauth_user");
			$oauth_user_result = $oauth_user->where(array('open_id'=>$data['open_id']))->find();
			if(!empty($oauth_user_result)){
				$oauth_id = $oauth_user_result['oauth_id'];
				$data['oauth_id'] = $oauth_id;
				$oauth_user->save($data);	
			}else{
				$oauth_id = M("Oauth_user")->add($data);
			}
			$_SESSION['oauth_id'] = $oauth_id;
			$this->redirect("/Login/relation");
		}else{
			$_SESSION['oauth_id'] = 0;
			$this->redirect("/Login/index");
		}
	}
	
	//微博登录回调接口
	public function weibo_callback(){
		$_q = getParams();
		include_once('./api/weibo/saetv2.ex.class.php');
		$o = new SaeTOAuthV2(C("WB_AKEY"), C("WB_SKEY"));
		if (!empty($_q->code)){
			$keys = array();
			$keys['code'] = $_q->code;
			$keys['redirect_uri'] = C("WB_CALLBACK_URL");
			try {
				$token = $o->getAccessToken('code', $keys) ;
			}catch(OAuthException $e){
			}
			if ($token) {
				$_SESSION['token'] = $token;
				$str = http_build_query($token);
				$arr = explode('&', $str);
				$user = array_reverse($arr);
				$user_arr = explode('=', $user[0]);
				$token_arr = explode('=', $arr[0]);
				$data['token'] = $token_arr[1];
				$data['open_id'] = $user_arr[1];
				$data['type'] = 1;
				setcookie('weibojs_'.$o->client_id, http_build_query($token));
			}else{
				$this->error('授权失败', '/Login', 3);
			}
		}
		if(isset($data['open_id']) && isset($data['token'])){
			$oauth_user = M("Oauth_user");
			$oauth_user_result = $oauth_user->where(array('open_id'=>$data['open_id']))->find();
			if(!empty($oauth_user_result)){
				$oauth_id = $oauth_user_result['oauth_id'];
				$data['oauth_id'] = $oauth_id;
				$oauth_user->save($data);
			}else{
				$oauth_id = M("Oauth_user")->add($data);
			}
			$_SESSION['oauth_id'] = $oauth_id;
			$this->redirect("/Login/relation");
		}else{
			$_SESSION['oauth_id'] = 0;
			$this->redirect("/Login");
		}
	}
	
	//第三方登录api关联页面
	public function relation(){
		$oauth_id = $_SESSION['oauth_id'];
		$tempData = array(
			'infoType' => 'cw1',
			'returnUrl' => '/Login',
			'returnText' => '返回登录'
		);
		if(!empty($oauth_id)){
			$oauth_user = M("Oauth_user");
			$oauth_user_result = $oauth_user->find($oauth_id);
			if(!empty($oauth_user_result) && $oauth_user_result['user_id']>0){
				$user_result = M("User")->find($oauth_user_result['user_id']);
				$_SESSION['Home_user'] = $user_result;
				$this->redirect("Center/Basicinfo.html");
			}else{
				if(!empty($oauth_user_result['type'])){
					include_once('./api/weibo/saetv2.ex.class.php');
					$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
					$ms = $c->home_timeline(); //done
					$uid_get = $c->get_uid();
					$uid = $uid_get['uid'];
					$userInfo = $c->show_user_by_id($uid);//根据ID获取用户等基本信息
					$oauth_user_data = array(
						'oauth_id' => $oauth_id,
						'nickname' => $userInfo['screen_name'],
					);
					$oauth_user->save($oauth_user_data);
					$tempData = $oauth_user_data;
					$this->assign("tempData", $tempData);
					$this->display();
					die();
				}else{
					include_once("./api/qqConnectAPI.php");
					$qc = new QC();
					$userInfo = $qc->get_user_info();
					if(is_array($userInfo)){
						$ret = $userInfo['ret'];
						if($ret==0){
							$oauth_user_data = array();
							foreach ($userInfo as $k=>$v){
								$oauth_user_data[$k] = $v;
							}
							$oauth_user_data['oauth_id'] = $oauth_id;
							$oauth_user->save($oauth_user_data);
							$tempData = $oauth_user_data;
							$this->assign("tempData", $tempData);
							$this->display();
							die();
						}else{
							$tempData['promptInfo'] = $userInfo['msg'];
						}
					}else{
						$tempData['promptInfo'] = "授权失败";
					}
				}
			}
		}else{
			$tempData['promptInfo'] = "您的操作有误";
		}
		$this->assign("tempData", $tempData);
		$this->display("Common/prompt");
	}
	
}