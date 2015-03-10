<?php
class Pro_answersModel extends CommonModel{

	public function getList($obj){
		$select = "a.id,a.user_id,a.status,a.content,a.addip,a.upip,a.is_adopt,from_unixtime(a.addtime) as atime,from_unixtime(a.uptime) as utime,b.username as op_username,c.title";
		$sql = " select $select from `{$this->tablePrefix}pro_answers` as a left join `{$this->tablePrefix}user` as b on a.user_id=b.user_id left join `{$this->tablePrefix}pro_contents` as c on a.con_id=c.id where 1=1 ";      
		if(!empty($obj->name)){
			$sql .= " and name like '%{$obj->name}%' ";
		}	
		if($obj->status>-1){
			$sql .= " and status='{$obj->status}' ";
		}
		$sql .= " order by a.uptime desc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
}