<?php
class MobileAction extends MainAction {

	//绑定手机号码（初次绑定）
	public function bind(){
		$user_result = M("User")->field("phone")->where("user_id='%d' and phone_status=1", $this->users['user_id'])->find();
		if(!empty($user_result)){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		$this->display();
	}
	
	//绑定手机号码（发送手机验证码）
	public function sendSmsForBind(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->phone = $_q->phone;
		$obj->oprate = "申请绑定手机";
		$obj->tips = "如非本人操作请致电：".C("PLATFORM_HOTLINE");
		$o = $this->sendSms($obj);
		echo json_encode($o);
		die();
	}
	
	//绑定手机号码（检测并保存手机号码）
	public function verify(){
		$_q = getParams();
		$o = new stdClass();
		$o->state = 0;
		$o->msg = "";
		if($this->users['phone_status'] == 1){
			$o->msg = "您的操作有误";
			echo json_encode($o);
			die();
		}
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
		$_SESSION['Home_user']['phone_status'] = 1;
		if($result>0){
			$o->state = 1;
			$o->msg = '手机号码验证通过';
		}else{
			$o->msg = '手机号码验证失败';
		}
		echo json_encode($o);
		die();
	}
	
	//修改绑定的手机
	public function rebind(){
		$user_result = M("User")->field("phone")->where("user_id='%d' and phone_status=1", $this->users['user_id'])->find();
		if(empty($user_result)){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		$user_result['phone_hide'] = $this->ModifierDisplay($user_result['phone'], 'phone');
		$tempData['user_result'] = $user_result;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//修改绑定手机（通过手机短信）
	public function rebindbysms(){
		$user_result = M("User")->field("paypassword,phone")->where("user_id='%d' and phone_status=1", $this->users['user_id'])->find();
		if(empty($user_result['phone'])){
			$this->error("您还未绑定手机号码", __GROUP__."/Mobile/bind");
			die();
		}
		if(empty($user_result['paypassword'])){
			$this->error("您还未设置提现密码", __GROUP__."/Paypwd/setup");
			die();
		}
		$user_result['phone_hide'] = $this->ModifierDisplay($user_result['phone'], 'phone');
		$tempData['user_result'] = $user_result;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//修改绑定手机（发送手机短信）
	public function sendSmsForReBind(){
		$_q = getParams();
		$obj = new stdClass();
		if(!empty($_q->type)){//发送验证码到原有手机
			$obj->type = 1;
			$obj->sessionKey = "PhoneOldCode";
			$obj->oprate = "申请修改绑定手机";
		}else{//发送验证码到新的手机
			$obj->type = 2;
			$obj->phone = $_q->phone;
			$obj->sessionKey = "PhoneNewCode";
			$obj->oprate = "申请绑定新手机";
		}
		$obj->tips = "如非本人操作请致电：".C("PLATFORM_HOTLINE");
		$o = $this->sendSms($obj);
		echo json_encode($o);
		die();
	}
	
	//修改绑定手机（校验原手机）
	public function verifyold(){
		$_q = getParams();
		if($_SESSION['PhoneOldCode']!=$_q->code){
			$this->error("手机验证码输入不正确", "javascript:history.go(-1)");
			die();
		}
		$paypwd_len = mb_strlen($_q->paypwd, 'utf-8');
		if($paypwd_len<6 || $paypwd_len>20){
			$this->error("提现密码格式不正确", "javascript:history.go(-1)");
			die();
		}
		$user_result = M("User")->field("user_id")->where("user_id='%d' and paypassword='%s'", $this->users['user_id'], md5($_q->paypwd))->find();
		if(empty($user_result)){
			$this->error("提现密码输入不正确", "javascript:history.go(-1)");
			die();
		}
		$this->display();
	}
	
	//修改绑定手机（绑定新手机）
	public function verifynew(){
		$_q = getParams();
		$phone_len = mb_strlen($_q->phone, 'utf-8');
		if($phone_len!=11){
			$this->error("新手机号码格式不正确", "javascript:history.go(-1)");
			die();
		}
		if($_SESSION['PhoneNewCode']!=$_q->code){
			$this->error("手机验证码输入不正确", "javascript:history.go(-1)");
			die();
		}
		$user = M("User");
		$user_result = $user->field("user_id")->where("phone='%s' and phone_status=1", $_q->phone)->find();
		if(!empty($user_result)){
			if($this->users['user_id']==$user_result['user_id']){
				$this->error("新手机号码不能和原有手机号码一致", "javascript:history.go(-1)");
			}else{
				$this->error("此手机号码已被占用", "javascript:history.go(-1)");
			}
			die();
		}
		$user_data = array(
			'user_id' => $this->users['user_id'],
			'phone' => $_q->phone
		);
		$user->save($user_data);
		$tempData['phone_hide'] = $this->ModifierDisplay($_q->phone, "phone");
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//修改绑定手机（通过身份认证）
	public function rebindbyid(){
		$user_result = M("User")->field("paypassword,card_id")->where("user_id='%d' and real_status=1", $this->users['user_id'])->find();
		if(empty($user_result['card_id'])){
			$this->error("您还未进行实名认证", __GROUP__."/Realname");
			die();
		}
		if(empty($user_result['paypassword'])){
			$this->error("您还未设置提现密码", __GROUP__."/Paypwd/setup");
			die();
		}
		$tempData['username_hide'] = $this->ModifierDisplay($this->users['username'], "username");
		$this->assign("tempData", $tempData);
		$this->display();	
	}
	
	//修改绑定手机（校验身份证号码和提现密码）
	public function verifyidandpwd(){
		$_q = getParams();
		$card_len = mb_strlen($_q->card_id, 'utf-8');
		if($card_len!=18){
			$this->error("身份证号码格式不正确", "javascript:history.go(-1)");
			die();
		}
		$paypwd_len = mb_strlen($_q->paypwd, 'utf-8');
		if($paypwd_len<6 || $paypwd_len>20){
			$this->error("提现密码格式不正确", "javascript:history.go(-1)");
			die();
		}
		$user_result = M("User")->field("paypassword,card_id")->where("user_id='%d' and real_status=1", $this->users['user_id'])->find();
		if(empty($user_result['card_id'])){
			$this->error("您还未进行实名认证", __GROUP__."/Realname");
			die();
		}
		if(empty($user_result['paypassword'])){
			$this->error("您还未设置提现密码", __GROUP__."/Paypwd/setup");
			die();
		}
		$paypwd = md5($_q->paypwd);
		if($user_result['card_id']!=$_q->card_id || $user_result['paypassword']!=$paypwd){
			$this->error("身份证号码或提现密码错误", "javascript:history.go(-1)");
			die();
		}
		$this->display("verifyold");
	}

}