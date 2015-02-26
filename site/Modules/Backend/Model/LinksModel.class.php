<?php
class LinksModel extends CommonModel{

	public function getList($obj){
		$select = "p1.id,p1.type_id,p1.webname,p1.logo,p1.weblink,p1.status,from_unixtime(p1.addtime) as atime,
		p1.addip,from_unixtime(p1.updatetime) as utime,p1.updateip,p2.username as op_username";
		$sql = " select $select from `{$this->tablePrefix}links` as p1 left join `{$this->tablePrefix}sys_user` as p2 on p1.op_user=p2.id where 1=1 ";
		if(!empty($obj->webname)){
			$sql .= " and p1.webname like '%{$obj->webname}%' ";
		}
		if(!empty($obj->type_id)){
			$sql .= " and p1.type_id='{$obj->type_id}' ";
		}
		if($obj->status>-1){
			$sql .= " and p1.status='{$obj->status}' ";
		}
		$sql .= " order by p1.id desc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
}