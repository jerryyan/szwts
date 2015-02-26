<?php
class Account_cashModel extends CommonModel{
	
	//获取会员提现总记录数
	public function getTotalRows($obj){
		$sql = " select count(1) as num from `{$this->tablePrefix}account_cash` as p1 left join `{$this->tablePrefix}linkage` as p2 
		on p1.bank=p2.id where 1=1 ";
		if(!empty($obj->user_id)){
			$sql .= " and p1.user_id={$obj->user_id} ";
		}
		$result = $this->query($sql);
		if(!empty($result)){
			return $result[0]['num'];
		}else{
			return 0;
		}	
	}
	
	//获取会员提现记录
	public function getList($obj){
		$sql = " select p1.id,p1.status,p1.account,p1.branch,p1.total,p1.money,p1.verify_remark,p1.fee,p1.addtime,p2.name as bank_name from `{$this->tablePrefix}account_cash` as p1 
		left join `{$this->tablePrefix}linkage` as p2 on p1.bank=p2.id where 1=1 ";
		if(!empty($obj->user_id)){
			$sql .= " and p1.user_id={$obj->user_id} ";
		}
		$sql .= " order by p1.id desc ".$obj->limit;
		return $this->query($sql);
	}

	
}