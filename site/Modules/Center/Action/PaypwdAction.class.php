<?php
class PaypwdAction extends MainAction {

	//设置提现密码
	public function setup(){
		$user_result = M("User")->field("paypassword")->find($this->users['user_id']);
		if(!empty($user_result['paypassword'])){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		$this->display();
	}

	//设置提现密码（验证并保存）
	public function verify(){
		$_q = getParams();
		$o = new stdClass();
		$o->state = 0;
		$paypwd_len = mb_strlen($_q->paypwd, 'utf8');
		if($paypwd_len<6 || $paypwd_len>20){
			$o->msg = "提现密码格式不正确";
			echo json_encode($o);
			die();
		}
		$user = M("User");
		$pwd = md5(C("FRONT_SERVER_KEY").$_q->paypwd);
		$user_result = $user->where("user_id='%s' and password='%s'", $this->users['user_id'], $pwd)->find();
		if(!empty($user_result)){
			$o->msg = "提现密码不能和登录密码相同";
			echo json_encode($o);
			die();
		}
		$user_data = array(
			'user_id' => $this->users['user_id'],
			'paypassword' => md5($_q->paypwd)
		);
		$result = $user->save($user_data);
		if($result>0){
			$o->state = 1;
			$o->msg = "提现密码设置成功";
		}else{
			$o->msg = "提现密码设置失败";
		}
		echo json_encode($o);
		die();
	}
	
	//修改提现密码
	public function modify(){
		$user_result = M("User")->field("paypassword")->find($this->users['user_id']);
		if(empty($user_result['paypassword'])){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		$this->display();
	}
	
	//修改提现密码（验证并保存）
	public function verifynew(){
		$_q = getParams();
		$o = new stdClass();
		$o->state = 0;
		$oldpwd_len = mb_strlen($_q->oldpwd, 'utf8');
		$newpwd_len = mb_strlen($_q->newpwd, 'utf8');
		if($oldpwd_len<6 || $oldpwd_len>20){
			$o->msg = "原始提现密码格式不正确";
			echo json_encode($o);
			die();			
		}
		if($newpwd_len<6 || $newpwd_len>20){
			$o->msg = "新提现密码格式不正确";
			echo json_encode($o);
			die();			
		}
		$user = M("User");
		$oldpwd = md5($_q->oldpwd);
		$user_result = $user->where("user_id='%s' and paypassword='%s'", $this->users['user_id'], $oldpwd)->find();
		if(empty($user_result)){
			$o->msg = "原始提现密码输入有误";
			echo json_encode($o);
			die();			
		}
		$loginpwd = md5(C("FRONT_SERVER_KEY").$_q->newpwd);
		if($user_result['password']==$loginpwd){
			$o->msg = "提现密码不能和登录密码相同";
			echo json_encode($o);
			die();
		}
		$user_data = array(
			'user_id' => $this->users['user_id'],
			'paypassword' => md5($_q->newpwd)
		);
		$result = $user->save($user_data);
		if($result>0){
			$o->state = 1;
			$o->msg = "提现密码重置成功";
		}else{
			$o->msg = "提现密码重置失败";
		}
		echo json_encode($o);
		die();
	}
	
	//找回提现密码
	public function find(){
		$_q = getParams();
		$user = M("User");
		$user_result = $user->field("phone")->where("user_id='%d' and phone_status=1", $this->users['user_id'])->find();
		if(empty($user_result)){
			$this->error("您还未绑定手机", __GROUP__."/Mobile/bind");
			die();
		}
		$user_result['phone'] = $this->ModifierDisplay($user_result['phone'], 'phone');
		$tempData['user_result'] = $user_result;
		$this->assign("tempData", $tempData);
		$this->display();
		
	}
	
	//找回提现密码（发送手机验证码）
	public function sendCode(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->type = 1;
		$obj->oprate = "申请找回提现密码";
		$obj->tips = "如非本人操作请致电：".C("PLATFORM_HOTLINE");
		$o = $this->sendSms($obj);
		echo json_encode($o);
		die();
	}
	
	//找回提现密码（验证手机验证码并重置提现密码）
	public function resetup(){
		$_q = getParams();
		if($_SESSION['PhoneCode']!=$_q->code){
			$this->error("手机验证码输入有误", "javascript:history.go(-1)");
			die();
		}
		$this->display();		
	}
	
	//找回提现密码（完成）
	public function findfinish(){
		$_SESSION['PhoneCode'] = null;
		$this->display();
	}
}