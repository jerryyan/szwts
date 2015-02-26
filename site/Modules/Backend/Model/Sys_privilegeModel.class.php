<?php
class Sys_privilegeModel extends SyscommonModel{

	public function getSelected($obj){
		$sql = " select function_id from `{$this->tablePrefix}sys_privilege` where role_id='{$obj->role_id}' ";
		$result = $this->query($sql);
		$list = array();
		foreach ($result as $v){
			$list[] = $v['function_id'];
		}
		return $list;
	}
	
	public function delPrivilege($role_id){
		$sql = " delete from `{$this->tablePrefix}sys_privilege` where role_id='{$role_id}' ";
		return $this->query($sql);
	}
	
	public function addPrivilegeList($data){
		return $this->addAll($data);
	}
	
	public function getUserPrivilege($role_id){
		$sql = " select t1.role_id,t2.id,t2.name,t2.pid,t2.sorder,t2.porder,t2.plevel,
		t2.is_function,t2.group_name,t2.module_name,t2.method_name from `{$this->tablePrefix}sys_privilege` as t1 
		left join `{$this->tablePrefix}sys_function` as t2 on t1.function_id = t2.id left join `{$this->tablePrefix}sys_role` 
		as t3 on t1.role_id=t3.id where t1.role_id='{$role_id}' and t2.is_disabled=0 and t3.is_disabled=0 order by t2.porder asc ";
		$result = $this->query($sql);
		return $result;
	}
	
}