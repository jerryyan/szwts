<?php
class IndexAction extends MainAction {

	public function index(){
		$this->assign('menu', $this->menus);
		$users = $this->users;
		//实名认证待审核
		$user_result = M("User")->field("count(1) as num")->where(array('real_status'=>0,'card_type'=>1))->find();
		//提现待审核
		$account_cash_result = M("Account_cash")->field("count(1) as num")->where(array('status'=>0))->find();
		//今日待还完记录
		$time = strtotime(date('Y-m-d'));
		$tender_log_result = M("Tender_log")->field("count(1) as num")->where("state=0 and unix_timestamp(from_unixtime(repaytime, '%Y-%m-%d'))=$time")->find();
		
		$tempData['username'] = $users['username'];
		$tempData['realname_num'] = $user_result['num'];
		$tempData['repay_num'] = $tender_log_result['num'];
		$tempData['account_cash_num'] = $account_cash_result['num'];;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	public function loginout(){
		$_SESSION['Admin_user'] = null;
		$this->redirect(GROUP_NAME."/Sysuser/login");
	}
	
}