<?php
class LinkageModel extends CommonModel{

	public function getList($obj){
		$select = " t1.id,t1.name,t1.value,t1.status,t2.name as type_name,from_unixtime(t1.addtime) as atime,
		from_unixtime(t1.updatetime) as utime,t1.addip,t1.updateip,t3.username as op_username ";
		$sql = " select $select from `{$this->tablePrefix}linkage` as t1 left join `{$this->tablePrefix}linkage_type` as t2 
		on t1.type_id=t2.id left join `{$this->tablePrefix}sys_user` as t3 on t1.op_user=t3.id where 1=1 ";
		if(!empty($obj->type_id)){
			$sql .= " and t1.type_id='{$obj->type_id}' ";
		}
		if(!empty($obj->name)){
			$sql .= " and t1.name like '%{$obj->name}%' ";
		}
		if($obj->status>-1){
			$sql .= " and t1.status='{$obj->status}' ";
		}
		$sql .= " order by t1.id desc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $this->_ssql);
	}
	
	public function getCache(){
		$sql = " select t1.id,t2.nid,t1.name,t1.value from `{$this->tablePrefix}linkage` as t1 
		left join `{$this->tablePrefix}linkage_type` as t2 on t1.type_id=t2.id where t1.status=1 order by t2.nid,t1.id asc  ";
		$result = $this->query($sql);
		return $result;
	}

}