<?php
class Pro_categorysModel extends CommonModel{

	public function getList($obj){
		$select = "a.id,a.name,a.status,a.summary,a.updateip,a.op_user,from_unixtime(a.addtime) as atime,from_unixtime(a.uptime) as utime,b.username as op_username";
		$sql = " select $select from `{$this->tablePrefix}pro_categorys` as a left join `{$this->tablePrefix}sys_user` as b on a.op_user=b.id where 1=1 ";
		if(!empty($obj->name)){
			$sql .= " and name like '%{$obj->name}%' ";
		}	
		if($obj->status>-1){
			$sql .= " and status='{$obj->status}' ";
		}
		$sql .= " order by uptime desc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
}