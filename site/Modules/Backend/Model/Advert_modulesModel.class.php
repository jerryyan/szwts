<?php
class Advert_modulesModel extends CommonModel{

	public function getList($obj){
		$select = " p1.id,p1.modules,p1.modules_name,p1.status,from_unixtime(p1.addtime) as atime,
		p1.addip,from_unixtime(p1.updatetime) as utime,p1.updateip,p2.username as op_username ";
		$sql = " select $select from `{$this->tablePrefix}advert_modules` as p1 left join `{$this->tablePrefix}sys_user` as p2 
		on p1.op_user=p2.id where 1=1 ";
		if($obj->status>-1){
			$sql .= " and p1.status='{$obj->status}' ";
		}
		$sql .= " order by p1.id asc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
}