<?php
class Phone_sendlogModel extends CommonModel{

	//获取平台短信通知日志记录
	public function getList($obj){
		$select = " p1.id,p1.phone,p1.status,p1.content,from_unixtime(p1.addtime) as atime,p1.addip,p2.username,p2.realname ";
		$sql = " select $select from `{$this->tablePrefix}phone_sendlog` as p1 left join `{$this->tablePrefix}user` as p2 on p1.user_id=p2.user_id where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p2.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p2.realname like '%{$obj->realname}%' ";
		}
		if(!empty($obj->phone)){
			$sql .= " and p1.phone like '%{$obj->phone}%' ";
		}
		if(!empty($obj->start)){
			$start_time = strtotime($obj->start);
			$sql .= " and p1.addtime>{$start_time} ";
		}
		if(!empty($obj->end)){
			$end_time = strtotime($obj->end);
			$sql .= " and p1.addtime<{$end_time} ";
		}
		$sql .= " order by p1.id desc ";
		$this->_ssql = $sql.$obj->limit;

		return $this->getDataList($select, $sql);
	}

}
?>