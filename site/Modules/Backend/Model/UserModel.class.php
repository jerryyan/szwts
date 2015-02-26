<?php
class UserModel extends CommonModel{

	//获取注册用户信息
	public function getUserList($obj){
		$select = " p1.user_id,p1.username,p1.realname,p1.sex,p1.email,p1.phone,p1.card_id,
		p1.card_type,p1.card_pic1,p1.card_pic2,p1.islock,from_unixtime(p1.addtime) as atime,from_unixtime(p1.lasttime) as ltime,
		p1.lastip,p1.last_modify_time ";
		$sql = " select $select from `{$this->tablePrefix}user` as p1 where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p1.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p1.realname like '%{$obj->realname}%' ";
		}
		if(!empty($obj->start)){
			$start_time = strtotime($obj->start);
			$sql .= " and p1.addtime>{$start_time} ";
		}
		if(!empty($obj->end)){
			$end_time = strtotime($obj->end);
			$sql .= " and p1.addtime<{$end_time} ";
		}
		if(!empty($obj->email)){
			$sql .= " and p1.email like '%{$obj->email}%' ";
		}
		if(!empty($obj->phone)){
			$sql .= " and p1.phone like '%{$obj->phone}%' ";
		}
		if($obj->islock>-1){
			$sql .= " and p1.islock='{$obj->islock}' ";
		}
		$sql .= " order by p1.addtime desc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
	//获取会员实名信息列表
	public function getRealList($obj){
		$select = " user_id,username,realname,real_status,sex,DATE_FORMAT(DATE_ADD(FROM_UNIXTIME(0), INTERVAL birthday SECOND),'%Y-%m-%d') as birth,card_id,'身份证' as card_type,card_pic1,card_pic2 ";
		$sql = " select $select from `{$this->tablePrefix}user` where card_type=1 ";
		if(!empty($obj->username)){
			$sql .= " and username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and realname like '%{$obj->realname}%' ";
		}
		if($obj->status>-1){
			$sql .= " and real_status='{$obj->status}' ";
		}
		$sql .= " order by uptime desc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
	public function getOne($obj){
		$sql = " select user_id from `{$this->tablePrefix}user` where user_id!={$obj->user_id} ";
		if(!empty($obj->email)){
			$sql .= " and email='{$obj->email}' ";
		}
		if(!empty($obj->phone)){
			$sql .= " and phone='{$obj->phone}' ";
		}
		$result = $this->query($sql);
		return $result[0]['user_id'];
	}

}