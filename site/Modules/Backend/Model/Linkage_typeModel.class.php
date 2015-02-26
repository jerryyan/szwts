<?php
class Linkage_typeModel extends CommonModel{

	public function getList($obj){
		$select = " p1.id,p1.name,p1.nid,from_unixtime(p1.addtime) as atime,from_unixtime(p1.updatetime) as utime,
		p1.addip,p1.updateip,p2.username as op_username,'查看明细' as linkage_list ";
		$sql = " select $select from `{$this->tablePrefix}linkage_type` as p1 left join `{$this->tablePrefix}sys_user` as p2 on p1.op_user=p2.id where 1=1 ";
		if(!empty($obj->name)){
			$sql .= " and p1.name like '%{$obj->name}%' ";
		}
		if(!empty($obj->nid)){
			$sql .= " and p1.nid like '%{$obj->nid}%' ";
		}
		$sql .= " order by p1.id desc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
}