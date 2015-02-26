<?php
class AccountAction extends MainAction {
	
	//资金明细
	public function index(){	
		$_q = getParams();
		$account_log = D("Account_log");
		$obj = new stdClass();
		$obj->user_id = $this->users['user_id'];
		// 计算总数 
		$count = $account_log->getTotalRows($obj);
		// 导入分页类 
		import("ORG.Util.Page"); 
		// 实例化分页类 
		$p = new Page($count, 10); 
		// 分页显示输出 
		$page = $p->show(); 
		$obj->limit = " limit {$p->firstRow},{$p->listRows} ";
		$list = $account_log->getList($obj);
		
		$this->assign("page", $page);
		$this->assign("list", $list);
		$tempData = M("Account")->find($obj->user_id);
		$tempData['num'] = $count;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//获取资金操作类型下拉菜单
	private function getAccountTypeOptions(){
		$linkage = A($this->admin_group."/Linkage");
		$linkage_result = $linkage->getCache();
		$li = '';
		foreach ($linkage_result['account_type'] as $v){
			$li .= '<li tid="'.$v['value'].'">'.$v['name'].'</li>';
		}
		return $li;
	}
	
}