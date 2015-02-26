<?php
class Tender_logModel extends CommonModel{

	//获取会员投资总记录数
	public function getTotalRows($obj){
		$sql = " select count(1) as num from `{$this->tablePrefix}tender_log` p1 where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p1.username='{$obj->username}' ";
		}
		if(!empty($obj->start)){
			$start_date = strtotime($obj->start);
			$sql .= " and p1.addtime>={$start_date} ";
		}
		if(!empty($obj->end)){
			$end_date = strtotime($obj->end);
			$sql .= " and p1.addtime<={$end_date} ";
		}
		if($obj->state>-1){
			$sql .= " and p1.state='{$obj->state}' ";
		}
		$result = $this->query($sql);
		if(!empty($result)){
			return $result[0]['num'];
		}else{
			return array();
		}
	}
	
	//获取会员投资明细记录
	public function getList($obj){
		$sql = " select p1.*,p2.name as platform_name from `{$this->tablePrefix}tender_log` as p1 
		left join `{$this->tablePrefix}cooperation_platform` as p2 on p1.platform_id=p2.id where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p1.username='{$obj->username}' ";
		}
		if(!empty($obj->start)){
			$start_date = strtotime($obj->start);
			$sql .= " and p1.addtime>={$start_date} ";
		}
		if(!empty($obj->end)){
			$end_date = strtotime($obj->end);
			$sql .= " and p1.addtime<={$end_date} ";
		}
		if($obj->state>-1){
			$sql .= " and p1.state='{$obj->state}' ";
		}
		$sql .= " order by p1.addtime desc ".$obj->limit;
		return $this->query($sql);
	}
	
	//获取投资统计记录
	public function getAnalysisList($obj){
		$sql = " select p2.name as platform_name,sum(amount) as sum_amount,sum(wait_amount)-sum(amount) as sum_rate,
		round((sum(amount)/{$obj->sum_amount})*100, 2) as scale from `{$this->tablePrefix}tender_log` as p1 
		left join `{$this->tablePrefix}cooperation_platform` as p2 
		on p1.platform_id=p2.id where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p1.username='{$obj->username}' ";
		}
		$sql .= " group by platform_name ";
		return $this->query($sql);
	}
	
}