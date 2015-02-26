<?php
class AdvertModel extends CommonModel{

	public function getList($obj){
		$select = " p1.id,p1.title,p1.url,p1.pic,p1.status,from_unixtime(p1.addtime) as atime,p1.position,p1.order,
		from_unixtime(p1.updatetime) as utime,p1.addip,p1.updateip,p2.modules,p2.modules_name,p3.username as op_username ";
		$sql = " select $select from `{$this->tablePrefix}advert` as p1 left join `{$this->tablePrefix}advert_modules` as p2 
		on p1.type_id=p2.id left join `{$this->tablePrefix}sys_user` as p3 on p1.op_user=p3.id where 1=1 ";
		if(!empty($obj->title)){
			$sql .= " and p1.title like '%{$obj->title}%' ";
		}
		if(!empty($obj->type_id)){
			$sql .= " and p1.type_id='{$obj->type_id}' ";
		}
		if($obj->status>-1){
			$sql .= " and p1.status='{$obj->status}' ";
		}
		$sql .= " order by p1.order asc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
}