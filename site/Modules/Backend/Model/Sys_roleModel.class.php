<?php
class Sys_roleModel extends SyscommonModel{

	//获取所有的角色列表
	public function getRoleList($obj){
		$obj->fields = " *,from_unixtime(addtime) as atime ";
		$obj->table = "{$this->tablePrefix}sys_role";
		$result = $this->getPageList($obj);
		unset($obj->limit);
		$obj->fields = " count(*) as num ";
		$counts = $this->getPageList($obj);
		return array('rows'=>$result, 'total'=>$counts[0]['num']);
	}
	
	//获取单个角色的详细信息
	public function getOne($obj){
		$sql = " select * from `{$this->tablePrefix}sys_role` where id='{$obj->id}' ";
		$result = $this->db->query($sql);
		return $result[0];
	}

}