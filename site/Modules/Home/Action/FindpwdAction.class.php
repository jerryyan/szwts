<?php
class FindpwdAction extends MainAction {
		
	//找回密码
	public function index(){
		$this->display();
	}
	
	//通过电子邮箱找回密码
	public function byemail(){
		$_q = getParams();
		$tempData = array(
			'infoType' => 'cw1',
			'returnUrl' => 'javascript:history.go(-1);',
			'returnText' => '返回'
		);
		$email = $_q->email;
		$emailcode = $_q->emailcode;
		if(!empty($email) && !empty($emailcode)){
			$valicode = $_SESSION['captcha'];
			$code_len = mb_strlen($emailcode, 'utf8');
			if($code_len!=4){
				$tempData['promptInfo'] = "验证码长度必须为4位";
			}else{				
				if($valicode!=$emailcode){
					$tempData['promptInfo'] = "验证码输入不正确";
				}else{
					$user_result = M("User")->where("email='%s' and email_status=1", $email)->find();
					if(!empty($user_result)){
						$code = getRandCode();
						$_SESSION['FindPwdCode'] = $code;
						$email_data = array(
							'code' => $code,
							'type' => 1
						);
						$content = getMailInfo($email_data);
						$send_mail_data = array(
							'module' => MODULE_NAME,
							'user_id' => $user_result['user_id'],
							'email' => $email,
							'title' => '网投所找回登录密码',
							'msg' => $content							
						);
						$state = $this->sendEmailOne($send_mail_data);
						$tempData = array(
							'byVerifyTitle' => '“网投所找回登录密码邮件”已发送至您的邮箱',
							'byVerifyName' => $email, 
							'uid' => $user_result['user_id']
						);
						$this->assign("tempData", $tempData);
						$this->display("verify");
						die();
					}else{
						$tempData['promptInfo'] = "请输入正确的邮箱地址";
					}
				}
			}
		}else{
			$tempData['promptInfo'] = "您的操作有误";
		}
		$this->assign("tempData", $tempData);
		$this->display("Common/prompt");
	}
	
	//通过手机找回密码
	public function bymobile(){
		$_q = getParams();
		$tempData = array(
			'infoType' => 'cw1',
			'returnUrl' => 'javascript:history.go(-1);',
			'returnText' => '返回'
		);
		$phone = trim($_q->phone);
		$phonecode = $_q->phonecode;
		if(!empty($phone) && !empty($phonecode)){
			$valicode = $_SESSION['captcha'];
			$code_len = mb_strlen($phonecode, 'utf8');
			if($code_len!=4){
				$tempData['promptInfo'] = "验证码长度必须为4位";
			}else{				
				if($valicode!=$phonecode){
					$tempData['promptInfo'] = "验证码输入不正确";
				}else{
					$user_result = M("User")->where("phone='%s' and phone_status=1", $phone)->find();
					if(!empty($user_result)){
						$check = $this->checkSendNum($phone);
						if($check>0){
							$tempData['promptInfo'] = "您的操作次数已到，如有疑问请联系客服";
						}else{
							$code = getRandCode();
							$_SESSION['FindPwdCode'] = $code;
							$phone_array = array(0=>$phone);
							$content = "【网投所】您于".date('m月d日 H:i')."申请找回登录密码，验证码：".$code."。如非本人操作请致电：".C("PLATFORM_HOTLINE");
							$smsContent = array('user_id'=>$user_result['user_id'], 'phone'=>$phone_array, 'content'=>$content);
							$send_status = $this->sendSmsOne($smsContent);
							$tempData = array(
								'byVerifyTitle' => '“网投所找回登录密码短信”已发送至您的手机',
								'byVerifyName' => $phone, 
								'uid' => $user_result['user_id']
							);
							$this->assign("tempData", $tempData);
							$this->display("verify");
							die();
						}
					}else{
						$tempData['promptInfo'] = "请输入正确的手机号码";
					}
				}
			}
		}else{
			$tempData['promptInfo'] = "您的操作有误";
		}
		$this->assign("tempData", $tempData);
		$this->display("Common/prompt");
	}
	
	//验证找回密码（邮件或手机）
	public function resetup(){
		$_q = getParams();
		$uid = trim($_q->uid);
		$code = trim($_q->code);
		$tempData = array(
			'infoType' => 'cw1',
			'returnUrl' => 'javascript:history.go(-1);',
			'returnText' => '返回'
		);
		if(!empty($uid) && !empty($code)){
			$code_len = mb_strlen($code, 'utf8'); 
			if($code_len!=6){
				$tempData['promptInfo'] = "验证码长度必须为6位";
			}elseif($_SESSION['FindPwdCode']!=$code){
				$tempData['promptInfo'] = "验证码输入不正确";
			}else{
				$tempData = array('uid'=>$uid);
				$this->assign("tempData", $tempData);
				$this->display();
				die();
			}
		}else{
			$tempData['promptInfo'] = "您的操作有误";
		}
		$this->assign("tempData", $tempData);
		$this->display("Common/prompt");
	}
	
	//验证并完成设置新的登录密码
	public function finish(){
		$_q = getParams();
		$uid = trim($_q->uid);
		$newpwd = trim($_q->newpwd);
		$newpwd_confirm = trim($_q->newpwd_confirm);
		$tempData = array(
			'infoType' => 'cw1',
			'returnUrl' => 'javascript:history.go(-1);',
			'returnText' => '返回'
		);
		if(!empty($uid) && !empty($newpwd) && !empty($newpwd_confirm)){
			$pwd_len = mb_strlen($newpwd, 'utf8');
			if($pwd_len<6 || $pwd_len>20){
				$tempData['promptInfo'] = "新密码格式不正确";
			}elseif($newpwd!=$newpwd_confirm){
				$tempData['promptInfo'] = "两次密码输入不一致";
			}else{
				$password = md5(C("FRONT_SERVER_KEY").$newpwd);
				$user_data = array(
					'user_id' => $uid,
					'password' => $password,
					'login_num' => 0
				);
				M("User")->save($user_data);
				$_SESSION['FindPwdCode'] = null;
				$tempData['infoType'] = 'cw2';
				$tempData['promptInfo'] = "您已经成功重置登录密码";
				$tempData['returnUrl'] = '/Login';
				$tempData['returnText'] = '返回登录';
			}
		}else{
			$tempData['promptInfo'] = "您的操作有误";
		}
		$this->assign("tempData", $tempData);
		$this->display("Common/prompt");
	}
	
	
	
	//验证用户手机或邮箱以完成认证
	public function verify(){
		$this->display();
	}
	
	//发送手机验证码
	public function sendCodeForReg(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->phone = $_q->phone;
		$obj->oprate = "注册新账户";
		$o = $this->sendSms($obj);
		echo json_encode($o);
		die();
	}
	
	//检测手机验证码并保存数据
	public function verifyphone(){
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
		$o->state = $user->save($user_data);
		$_SESSION['PhoneCode'] = null;
		$_SESSION['Home_user']['phone_status'] = 1;
		if($o->state){
			$o->msg = '手机号码验证通过';
		}else{
			$o->msg = '手机号码验证失败';
		}
		echo json_encode($o);
		die();
	}
	
	//检测电子邮箱地址并保存数据
	public function verifyEmail(){
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
					M("User")->save($user_data);
					$_SESSION['Home_user']['email_status'] = 1;
					$tempData = array('uname'=>$user_result['username']);
					$this->assign("tempData", $tempData);
					$this->display("complete");
					die();
				}
			}		
		}
		$tempData = array(
			'promptInfo' => '您的激活链接已经失效，请重新发送激活邮件',
			'infoType' => 'cw1',
			'returnUrl' => '/User/login',
			'returnText' => '返回登录页面'
		);			
		$this->assign("tempData", $tempData);
		$this->display("prompt");
	}
	
	//注册完成
	public function complete(){
		$tempData = array('uname'=>$this->users['username']);
		$this->assign("tempData", $tempData);
		$this->display();
	}

}