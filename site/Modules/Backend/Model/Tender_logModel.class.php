<?php
class Tender_logModel extends CommonModel{
	
	//获取各平台的投资记录
	public function getList($obj){
		$select = " p1.*,from_unixtime(p1.addtime) as atime,from_unixtime(p1.repaytime) as etime,p2.name as platform_name,p3.realname ";
		$sql = " select $select from `{$this->tablePrefix}tender_log` as p1 
		left join `{$this->tablePrefix}cooperation_platform` as p2 
		on p1.platform_id=p2.id left join `{$this->tablePrefix}user` as p3 on p1.username=p3.username where 1=1 ";
		if(!empty($obj->plat_id)){
			$sql .= " and p1.platform_id='{$obj->plat_id}' ";
		}
		if(!empty($obj->username)){
			$sql .= " and p1.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p3.realname like '%{$obj->realname}%' ";
		}
		if(!empty($obj->start)){
			$start_time = strtotime($obj->start);
			$sql .= " and p1.addtime>{$start_time} ";
		}
		if(!empty($obj->end)){
			$end_time = strtotime($obj->end);
			$sql .= " and p1.addtime<{$end_time} ";
		}
		if($obj->state>-1){
			$sql .= " and p1.state='{$obj->state}' ";
		}
		$sql .= " order by p1.addtime desc ";
		$this->_ssql = $sql.$obj->limit;
		return $this->getDataList($select, $sql);
	}
	
		
	//获取各平台中今日待还完记录
	public function getRepayList(){
		$date = date('Y-m-d');
		$start = strtotime("$date");
		$end = strtotime("$date +1 day");
		$select = " p1.order_id,p1.username,p1.project_name,p1.amount,p1.wait_amount,p1.rate,p1.isday,p1.term,
		from_unixtime(p1.addtime,'%Y-%m-%d') as atime,from_unixtime(p1.repaytime, '%Y-%m-%d') as etime,p2.name as platform_name,p3.realname ";
		$sql = " select $select from `{$this->tablePrefix}tender_log` as p1 left join `{$this->tablePrefix}cooperation_platform` as p2 
		on p1.platform_id=p2.id left join `{$this->tablePrefix}user` as p3 on p1.username=p3.username 
		where state=0 and p1.repaytime>{$start} and p1.repaytime<{$end} ";
		if(!empty($obj->plat_id)){
			$sql .= " and p1.platform_id='{$obj->plat_id}' ";
		}
		if(!empty($obj->username)){
			$sql .= " and p1.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p3.realname like '%{$obj->realname}%' ";
		}
		$sql .= " order by p1.addtime desc ";
		$this->_ssql = $sql.$obj->limit;
		return $this->getDataList($select, $sql);
	}

}
?>