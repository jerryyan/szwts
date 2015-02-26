<?php
class Account_bankModel extends CommonModel{

	//获取会员绑定银行卡总记录数
	public function getTotalRows($obj){
		$sql = " select count(1) as num from `{$this->tablePrefix}account_bank` as p1 left join `{$this->tablePrefix}linkage` as p2 
		on p1.bank=p2.id where 1=1 ";
		if(!empty($obj->user_id)){
			$sql .= " and p1.user_id={$obj->user_id} ";
		}
		$result = $this->query($sql);
		return $result[0]['num'];
	}
	
	//获取会员绑定的银行卡总记录
	public function getList($obj){
		$sql = " select p1.id,p1.account,p2.name,p2.pic from `{$this->tablePrefix}account_bank` as p1 
		left join `{$this->tablePrefix}linkage` as p2 on p1.bank=p2.id where 1=1 ";
		if(!empty($obj->user_id)){
			$sql .= " and p1.user_id={$obj->user_id} ";
		}
		$sql .= " order by p1.id desc ";
		if(!empty($obj->limit)){
			$sql .= $obj->limit;
		}
		return $this->query($sql);
	}
	
}