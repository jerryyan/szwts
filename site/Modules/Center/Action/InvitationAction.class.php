<?php
class InvitationAction extends MainAction {

	//邀请好友管理
	public function index(){
		$invite_userid = Key2Url($this->users['user_id'], "register_invite");
		$user_result = M("User")->field("count(1) as num,sum(invite_money) as sum_money")->where("invite_userid='%d'", $this->users['user_id'])->find();
		// 计算总数 
		$count = $user_result['num'];
		// 导入分页类 
		import("ORG.Util.Page"); 
		// 实例化分页类 
		$p = new Page($count, 8); 
		// 分页显示输出 
		$page = $p->show(); 
		$obj = new stdClass();
		$obj->user_id = $this->users['user_id'];
		$obj->limit = " limit $p->firstRow,$p->listRows ";
		$list = D("User")->getInvitationList($obj);
		
		$this->assign("page", $page);
		$this->assign("list", $list);
		$this->assign("invite_userid", $invite_userid);
		$tempData = array();
		$tempData['num'] = $count;
		$tempData['sum_money'] = $user_result['sum_money'];
		$account_result = M("Account")->field("use_money,no_use_money")->find($this->users['user_id']);
		$account_cash_result = M("Account_cash")->field("sum(total) as cash_money")->where("user_id='%d' and status=1", $this->users['user_id'])->find();
		$tempData['use_money'] = $account_result['use_money'];
		$tempData['no_use_money'] = $account_result['no_use_money'];
		$tempData['cash_money'] = $account_cash_result['cash_money'];
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
}