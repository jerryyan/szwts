<?php
class Account_cashModel extends CommonModel{
	
	public function getAccountCashOne($obj){
		$sql = " select t1.*,t2.username,t2.realname,t3.name as bankname,t4.username as verify_username 
		from `{$this->tablePrefix}account_cash` as t1 left join `{$this->tablePrefix}user` as t2 on t1.user_id=t2.user_id 
		left join `{$this->tablePrefix}linkage` as t3 on t1.bank=t3.id left join `{$this->tablePrefix}user` as t4 on t1.verify_userid=t4.user_id where 1=1 ";
		if(!empty($obj->id)){
			$sql .= " and t1.id = {$obj->id} ";
		}
		$result = $this->query($sql);
		return $result[0];
	}
	
	
	//获取可以提现的记录
	public function getSureCashList($obj){
		$sql = " select p1.* from `{$this->tablePrefix}account` as p1 left join `{$this->tablePrefix}user` as p2 on p1.user_id=p2.user_id where p1.use_money>=50 and p2.utype=2 and p2.islock=0  ";
		if(!empty($obj->user_ids)){
			$sql .= " and p1.user_id not in({$obj->user_ids}) ";
		}
		return $this->query($sql);
	}

}
?>