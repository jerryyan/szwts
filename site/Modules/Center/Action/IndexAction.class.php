<?php
class IndexAction extends MainAction {

	//个人基础信息
	public function index(){
		$user_id = $this->users['user_id'];
		$user = M("User");
		$user_result = $user->find($user_id);
		$user_result['realname'] = $this->ModifierDisplay($user_result['realname']);
		$user_result['card_id'] = $this->ModifierDisplay($user_result['card_id'], 'card_id');
		$user_result['phone'] = $this->ModifierDisplay($user_result['phone'], 'phone');
		$user_result['email'] = $this->ModifierDisplay($user_result['email'], 'email');
		$tempData['user_result'] = $user_result;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//根据id获取地区联动数据
	public function getAreaList(){
		$_q = getParams();
		$result = array();
		if(intval($_q->id)){
			$area = M("area");
			$result = $area->where("pid='%d'", $_q->id)->select();
		}
		echo json_encode($result);
	}
	
	//获取验证码
	public function getValicode(){
		getValicode();	
	}
	
	//退出系统
	public function loginout(){
		$_SESSION['Home_user'] = null;
		$this->redirect("/Login");
	}

}