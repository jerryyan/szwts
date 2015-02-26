<?php
class SafeinfoAction extends MainAction {

	public function Index(){
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

}