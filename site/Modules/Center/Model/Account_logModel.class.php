<?php
class Account_logModel extends CommonModel{

	//获取会员资金明细总记录数
	public function getTotalRows($obj){
		$sql = " select count(1) as num from `{$this->tablePrefix}account_log` p1 where 1=1 ";
		if(!empty($obj->user_id)){
			$sql .= " and p1.user_id={$obj->user_id} ";
		}
		$result = $this->query($sql);
		if(!empty($result)){
			return $result[0]['num'];
		}else{
			return array();
		}
	}
	
	//获取会员资金明细记录
	public function getList($obj){
		$sql = " select p1.id,p1.type,p1.total,p1.money,p1.use_money,p1.no_use_money,p1.addtime,p2.name as type_name,
		p1.remark,p1.addip from `{$this->tablePrefix}account_log` as p1 left join `{$this->tablePrefix}linkage` as p2 on p1.type=p2.value where 1=1 ";
		if(!empty($obj->user_id)){
			$sql .= " and p1.user_id={$obj->user_id} ";
		}
		$sql .= " order by p1.id desc ".$obj->limit;
		return $this->query($sql);
	}
	
}