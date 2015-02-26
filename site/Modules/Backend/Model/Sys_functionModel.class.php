<?php
class Sys_functionModel extends SyscommonModel{

	public function getFunctionList($obj){
		$obj->fields = " *,from_unixtime(addtime) as atime ";
		$obj->order = " porder asc ";
		$obj->table = "{$this->tablePrefix}sys_function";
		$result = $this->getPageList($obj);
		unset($obj->limit);
		$obj->fields = " count(*) as num ";
		$counts = $this->getPageList($obj);
		
		return array('rows'=>$result,'total'=>$counts[0]['num']);
	}
	
	public function getOne($obj){
		$sql = " select * from `{$this->tablePrefix}sys_function` where id='{$obj->id}' ";
		$result = $this->query($sql);
		return $result[0];
	}
	
	function saveFunction($data){
		return $this->saveTreeNode($data);
	}
	
	//获取系统后台所有的功能列表
	public function getFunctionTree($obj){
		$result = $this->getTreeList($obj);
		return $result;
	}
}