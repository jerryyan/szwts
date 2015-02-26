<?php
class AnalysisAction extends MainAction {
	
	// 投资分析
	public function index(){
		$tender_log_result = M("Tender_log")->field("sum(amount) as sum_amount")->where("username='%s'", $this->users['username'])->find();
		$obj = new stdClass();
		$obj->username = $this->users['username'];
		$obj->sum_amount = 0;
		if(!empty($tender_log_result['sum_amount'])){
			$obj->sum_amount = $tender_log_result['sum_amount'];
		}
		$list = D("Tender_log")->getAnalysisList($obj);
		$count = count($list);
		$this->assign("count", $count);
		$this->assign("list", $list);
		$this->display();
	}
	
}