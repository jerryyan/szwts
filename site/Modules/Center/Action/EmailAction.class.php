<?php
class EmailAction extends MainAction {

	//绑定邮箱地址
	public function bind(){
		$user_result = M("User")->where("user_id='%d' and email_status=1", $this->users['user_id'])->find();
		if(!empty($user_result)){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		$this->display();
	}
	
	//发送验证链接到邮箱
	public function sendEmail(){
		$_q = getParams();
		$user = M("User");
		$obj = new stdClass();
		switch ($_q->check){
			default:
				$obj->email = $_q->email;
				break;
			case 'old_email':
				$user_result = $user->field("email")->where("user_id='%d'", $this->users['user_id'])->find();
				$obj->email = $user_result['email'];
				break;
			case 'new_email':
				$obj->email = $_q->email;
				$user_result = $user->field("email")->where("user_id='%d' and email='%s'", $this->users['user_id'], $_q->email)->find();
				if(!empty($user_result)){
					$o = new stdClass();
					$o->state = 0;
					$o->msg = "新邮箱地址不能和原邮箱地址一致";
					echo json_encode($o);
					die();
				}
				break;
		}
		$obj->type = 0;
		$obj->check = $_q->check;
		$o = $this->sendMail($obj);
		echo json_encode($o);
		die();
	}
	
	//绑定邮箱地址（验证邮箱）
	public function verify(){
		$_q = getParams();
		if(!empty($_q->email)){
			$user_result = M("User")->field("temp_email")->where("user_id='%d' and temp_email='%s'", $this->users['user_id'], $_q->email)->find();
			if(empty($user_result)){				
				$this->error("您的操作有误", "javascript:history.go(-1)");
				die();
			}
		}
		$tempData['user_result']['email'] = $user_result['temp_email'];
		$tempData['user_result']['email_hide'] = $this->ModifierDisplay($user_result['temp_email'], 'email');
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//绑定邮箱地址（完成）
	public function active(){
		$_q = getParams();
		$code = $_q->code;
		$check = $_q->check;
		if(empty($code)){
			$this->display("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		$user = M("User");
		$time = time();
		$user_result = $user->where("user_id='%d' and token='%s' and token_verify_status='0'", $this->users['user_id'], $code)->find();
		if(empty($user_result)){
			$this->error("您的激活链接已经失效，请重新发送激活邮件", __GROUP__."/Safeinfo");
			die();
		}			
		if($time>$user_result['token_exptime']){
			$this->error("您的激活链接已经失效，请重新发送激活邮件", __GROUP__."/Safeinfo");
			die();
		}
		switch ($check){
			default:
				$user_data = array(
					'user_id' => $user_result['user_id'],
					'email' => $user_result['temp_email'],
					'temp_email' => '',
					'email_status' => 1,
					'token_verify_status' => 1
				);					
				$result = M("User")->save($user_data);
				if($result>0){
					if(!empty($this->users)){
						$_SESSION['Home_user']['email_status'] = 1;
					}
					$user_result['email'] = $this->ModifierDisplay($user_result['temp_email'], 'email');
					$tempData['user_result'] = $user_result;
					$this->assign("tempData", $tempData);
					$this->display("finishbind");				
				}
				break;
			case 'old_email':
				$tempData['keycode'] = $code;
				$this->assign("tempData", $tempData);
				$this->display("inputbyemail");
				break;
			case 'new_email':
				$user_data = array(
					'user_id' => $user_result['user_id'],
					'email' => $user_result['temp_email'],
					'temp_email' => '',
					'token_verify_status' => 1
				);					
				M("User")->save($user_data);
				$user_result['email'] = $this->ModifierDisplay($user_result['temp_email'], 'email');
				$tempData['user_result'] = $user_result;
				$this->assign("tempData", $tempData);
				$this->display("finishrebind");
				break;
		}
	}
	
	//修改绑定的邮箱地址
	public function rebind(){
		$user_result = M("User")->field("email")->where("user_id='%d' and email_status=1", $this->users['user_id'])->find();
		if(empty($user_result)){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		$user_result['email'] = $this->ModifierDisplay($user_result['email'], 'email');
		$tempData['user_result'] = $user_result;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//修改绑定的邮箱地址（通过邮箱地址）
	public function rebindbyemail(){
		$user_result = M("User")->field("email")->where("user_id='%d' and email_status=1", $this->users['user_id'])->find();
		if(empty($user_result)){
			$this->error("您还未绑定邮箱地址", __GROUP__."/Email/bind");
			die();
		}
		$user_result['email_hide'] = $this->ModifierDisplay($user_result['email'], 'email');
		$tempData['user_result'] = $user_result;
		$this->assign("tempData", $tempData);
		$this->display();
	}	
	
	//修改绑定邮箱地址（验证码校验并发送邮件）
	public function verifyoldbyemail(){
		$_q = getParams();
		$captcha = $_SESSION['captcha'];
		if($captcha!=strtolower($_q->code)){
			$this->error("验证码输入有误", "javascript:history.go(-1)");
			die();
		}
		if(empty($_q->email)){
			$this->error("您还未绑定邮箱地址", "javascript:history.go(-1)");
			die();
		}
		$obj = new stdClass();
		$obj->email = $_q->email;
		$obj->type = 0;
		$obj->check = 'old_email';
		$o = $this->sendMail($obj);
		if($o->state==0){
			$this->error($o->msg, "javascript:history.go(-1)");
			die();
		}
		$tempData['user_result']['email'] = $_q->email;
		$tempData['user_result']['email_hide'] = $this->ModifierDisplay($_q->email, 'email');
		$this->assign("tempData", $tempData);
		$this->display();	
	}
	
	//修改绑定邮箱地址（验证新的邮箱地址）
	public function verifynewbyemail(){
		$_q = getParams();
		if(empty($_q->keycode)){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		if(empty($_q->newemail)){
			$this->error("邮箱地址不能为空", "javascript:history.go(-1)");
			die();
		}
		$user_result = M("User")->field("user_id")->where("user_id='%d' and token='%s'", $this->users['user_id'], $_q->keycode)->find();
		if(empty($user_result)){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		$obj = new stdClass();
		$obj->email = $_q->newemail;
		$obj->check = "new_email";
		$obj->type = 0;
		$o = $this->sendMail($obj);
		if($o->state==0){
			$this->error($o->msg, "javascript:history.go(-1)");
			die();			
		}
		$tempData['user_result']['email'] = $_q->newemail;
		$tempData['user_result']['email_hide'] = $this->ModifierDisplay($_q->newemail, 'email');
		$this->assign("tempData", $tempData);
		$this->display();	
	}
	
	//修改绑定邮箱地址（通过手机）
	public function rebindbymobile(){
		$user_result = M("User")->field("phone,phone_status,real_status")->where("user_id='%d'", $this->users['user_id'])->find();
		if(empty($user_result)){
			$this->error("您的操作有误", "javascript:history.go(-1)");
		}elseif($user_result['phone_status']==0){
			$this->error("您还未绑定手机", __GROUP__."/Mobile/bind");
		}elseif($user_result['real_status']==0){
			$this->error("您还未进行实名认证", __GROUP__."/Realname");
		}else{
			$user_result['phone_hide'] = $this->ModifierDisplay($user_result['phone'], 'phone');
			$tempData['user_result'] = $user_result;
			$this->assign("tempData", $tempData);
			$this->display();
		}
	}
	
	//修改绑定邮箱地址（发送手机验证码）
	public function sendSmsForReBind(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->type = 1;
		$obj->oprate = "申请更换邮箱地址";
		$obj->tips = "如非本人操作请致电：".C("PLATFORM_HOTLINE");
		$o = $this->sendSms($obj);
		echo json_encode($o);
		die();
	}
	
	//修改绑定的邮箱地址（输入新的邮箱地址）
	public function inputbymobile(){
		$_q = getParams();
		if($_SESSION['PhoneCode']!=$_q->code){
			$this->error("手机验证码输入有误", "javascript:history.go(-1)");
			die();
		}
		$cardid_len = mb_strlen($_q->card_id, 'utf8');
		if($cardid_len!=18){
			$this->error("身份证号码格式不正确", "javascript:history.go(-1)");
			die();
		}
		$user_result = M("User")->where("user_id='%d' and card_id='%s' and real_status=1", $this->users['user_id'], $_q->card_id)->find();
		if(empty($user_result)){
			$this->error("身份证号码输入有误", "javascript:history.go(-1)");
			die();
		}
		$tempData['code'] = $_q->code;
		$tempData['card_id'] = $_q->card_id;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//修改绑定邮箱地址（通过手机验证新的邮箱地址）
	public function verifynewbymobile(){
		$_q = getParams();
		if(empty($_q->newemail)){
			$this->error("邮箱地址不能为空", "javascript:history.go(-1)");
			die();
		}
		if($_SESSION['PhoneCode']!=$_q->code){
			$this->error("手机验证码输入有误", "javascript:history.go(-1)");
			die();
		}
		$cardid_len = mb_strlen($_q->card_id, 'utf8');
		if($cardid_len!=18){
			$this->error("身份证号码格式不正确", "javascript:history.go(-1)");
			die();
		}
		$user_result = M("User")->where("user_id='%d' and card_id='%s' and real_status=1", $this->users['user_id'], $_q->card_id)->find();
		if(empty($user_result)){
			$this->error("身份证号码输入有误", "javascript:history.go(-1)");
			die();
		}
		$obj = new stdClass();
		$obj->email = $_q->newemail;
		$obj->check = "new_email";
		$obj->type = 0;
		$o = $this->sendMail($obj);
		if($o->state==0){
			$this->error($o->msg, "javascript:history.go(-1)");
			die();			
		}
		$tempData['user_result']['email'] = $_q->newemail;
		$tempData['user_result']['email_hide'] = $this->ModifierDisplay($_q->newemail, 'email');
		$this->assign("tempData", $tempData);
		$this->display("verifynewbyemail");	
	}

	
}