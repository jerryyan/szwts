<?php
class GradeModel extends CommonModel{
	
	//获取安全评级列表数据
	public function getList($obj){
		$select = " p1.id,p1.name,p1.logo,p1.config,p1.status,from_unixtime(p1.addtime) as atime,
		from_unixtime(p1.updatetime) as utime,p1.is_del,p2.username as op_username ";
		$sql = " select $select from `{$this->tablePrefix}grade` as p1 left join `{$this->tablePrefix}sys_user` as p2 on p1.op_user=p2.id where 1=1 ";
		if(!empty($obj->name)){
			$sql .= " and p1.name like '%{$obj->name}%' ";
		}
		$sql .= " order by p1.id desc ";
		$this->_ssql = $sql.$obj->limit;
		return $this->getDataList($select, $sql);
	}
	
}
?>