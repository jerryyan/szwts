<?php
class LoginpwdAction extends MainAction {

	//更改登录密码
	public function modify(){
		$this->display();
	}
	
	//更改登录密码（验证原始登录密码及更换新密码）
	public function verify(){
		$_q = getParams();
		$oldpwd_len = mb_strlen($_q->oldpwd, 'utf8');
		$newpwd_len = mb_strlen($_q->newpwd, 'utf8');
		$o = new stdClass();
		$o->state = 0;
		if($oldpwd_len<6 || $oldpwd_len>20){
			$o->msg = "原始密码格式不正确";
			echo json_encode($o);
			die();
		}
		if($newpwd_len<6 || $newpwd_len>20){
			$o->msg = "新密码格式不正确";
			echo json_encode($o);
			die();
		}
		$user = M("User");
		$user_id = $this->users['user_id'];
		$oldpwd = md5(C("FRONT_SERVER_KEY").$_q->oldpwd);
		$user_result = $user->where("user_id='%s' and password='%s'", $user_id, $oldpwd)->find();
		if(empty($user_result)){
			$o->msg = "原始登录密码输入有误";
			echo json_encode($o);
			die();
		}
		$paypwd = md5($_q->newpwd);
		if($user_result['paypassword']==$paypwd){
			$o->msg = "登录密码不能和提现密码相同";
			echo json_encode($o);
			die();
		}
		$user_data = array(
			'user_id' => $user_id,
			'password' => md5(C("FRONT_SERVER_KEY").$_q->newpwd)
		);
		$result = $user->save($user_data);
		if($result>0){
			$o->state = 1;
			$o->msg = "登录密码重置成功";
		}else{
			$o->msg = "登录密码重置失败";
		}
		echo json_encode($o);
		die();
	}

}