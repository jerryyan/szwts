<?php
class Sys_userModel extends SyscommonModel{

	public function getList($obj){
		$select = " t1.*,from_unixtime(t1.addtime) as atime,t2.role_name ";
		$sql = " select {$select} from `{$this->tablePrefix}sys_user` as t1 left join 
		{$this->tablePrefix}sys_role as t2 on t1.role_id=t2.id where 1=1 ";
		if($obj->login_role!=1){//只有超级管理员可以修改所有人密码
			$sql .= " and t1.id='{$obj->id}' ";
		}
		$this->_ssql = $sql.$obj->limit;
		$rows = $this->query($this->_ssql);
		
		$this->_ssql = str_replace($select, " count(*) as num ", $sql);
		$result = $this->query($this->_ssql);
		
		return array('rows'=>$rows, 'total'=>$result[0]['num']);
	}
	
	public function getOne($obj){
		$sql = " select * from `{$this->tablePrefix}sys_user` where id='{$obj->id}' ";
		$list = $this->query($sql);
		return $list[0];
	}
	
	public function getRoleList($obj){
		$sql = " select id,role_name from `{$this->tablePrefix}sys_role` where is_disabled=0 ";
		if($obj->login_role!=1){
			$sql .= " and id='{$obj->login_role}' ";
		}		
		$list = $this->query($sql);
		$result = _getOptionHtml($list, $obj->role_id, 'id', 'role_name');
		return $result;
	}

}