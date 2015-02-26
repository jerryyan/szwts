<?php
class Account_bankModel extends CommonModel{
	
	public function getList($obj){
		$select = " p1.id,p1.account,p1.branch,from_unixtime(p1.addtime) as atime,from_unixtime(p1.updatetime) as utime,
		p1.addip,p1.updateip,p2.username,p2.realname,p3.name as bank_name,p4.username as op_username ";
		$sql = " select $select from `{$this->tablePrefix}account_bank` as p1 left join `{$this->tablePrefix}user` as p2 on p1.user_id=p2.user_id 
		left join `{$this->tablePrefix}linkage` as p3 on p1.bank=p3.id left join `{$this->tablePrefix}sys_user` as p4 on p1.op_user=p4.id where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p2.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p2.realname like '%{$obj->realname}%' ";
		}
		if(!empty($obj->start)){
			$start_time = strtotime($obj->start);
			$sql .= " and p1.addtime>{$start_time} ";
		}
		if(!empty($obj->end)){
			$end_time = strtotime($obj->end);
			$sql .= " and p1.addtime<{$end_time} ";
		}
		if(!empty($obj->bank)){
			$sql .= " and p1.bank='{$obj->bank}' ";
		}
		$sql .= " order by p1.id desc ";
		$this->_ssql = $sql.$obj->limit;
		return $this->getDataList($select, $sql);
	}
	
	public function getOne($obj){
		$sql = " select p1.id,p1.user_id,p1.account,p1.bank,p1.branch,p2.username from `{$this->tablePrefix}account_bank` as p1 
		left join `{$this->tablePrefix}user` as p2 on p1.user_id=p2.user_id where 1=1 ";
		if(!empty($obj->id)){
			$sql .= " and p1.id='{$obj->id}' ";
		}
		$result = $this->query($sql);
		return $result[0];
	}

}
?>