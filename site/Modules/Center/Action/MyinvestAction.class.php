<?php
class MyinvestAction extends MainAction {
	
	// 我的投资记录
	public function index(){
		$_q = getParams();
		$tender_log = D("Tender_log");
		$obj = new stdClass();
		$obj->username = $this->users['username'];
		$obj->start = $_q->start;
		$obj->end = $_q->end;
		$obj->state = $_q->selectValue;
		// 计算总数 
		$count = $tender_log->getTotalRows($obj);
		// 导入分页类 
		import("ORG.Util.Page"); 
		// 实例化分页类 
		$p = new Page($count, 10); 
		// 分页显示输出 
		$page = $p->show(); 
		$obj->limit = " limit {$p->firstRow},{$p->listRows} ";
		$list = $tender_log->getList($obj);
		$this->assign("page", $page);
		$this->assign("list", $list);
		// 统计
		$tender_log_result = M("Tender_log")->field("sum(amount) as sum_amount,(sum(wait_amount)-sum(amount)) as sum_rate")->where("username='%s'", $this->users['username'])->find();
		$tender_log_result['rate_now'] = empty($list[0]['rate'])?0:$list[0]['rate'];
		$baobao_rate = C("BAOBAO_RATE");
		$tender_log_result['compare'] = round($tender_log_result['rate_now']/$baobao_rate, 1);
		$tender_log_result['start'] = $_q->start;
		$tender_log_result['end'] = $_q->end;
		$tender_log_result['selectValue'] = $_q->selectValue;
		$tender_log_result['selectText'] = $_q->selectText;
		
		$this->assign("tempData", $tender_log_result);
		$this->assign("count", $count);
		$this->display();
	}
	
}