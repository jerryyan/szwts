<?php
class Cooperation_platformModel extends CommonModel{

	// 获取合作平台列表详情
	public function getList($obj){
		$sql = " select p1.id,p1.code,p1.name as platform_name,p1.website,p1.logo as platform_logo,p1.grade,
		p1.interface_list,p1.interface_count,p2.name as grade_name,p2.logo as grade_logo,p2.config 
		from `{$this->tablePrefix}cooperation_platform` p1 left join `{$this->tablePrefix}grade` p2 
		on p1.grade=p2.id where p1.status=0 and p1.is_del=0 ";
		if(!empty($obj->id)){
			$sql .= " and p1.id in({$obj->id}) ";
		}
		if(!empty($obj->grade)){
			$sql .= " and p1.grade='{$obj->grade}' ";
		}
		$order = " p1.id asc ";
		if(!empty($obj->order)){
			$order = $obj->order;
		}
		$sql .= " order by ".$order;
		if(!empty($obj->limit)){
			$sql .= " limit {$obj->limit} ";
		}
		return $this->query($sql); 
	}
	
	// 根据id获取单个合作平台数据
	public function getOne($obj){
		$sql = " select p1.*,p2.name as grade_name from `{$this->tablePrefix}cooperation_platform` as p1 
		left join `{$this->tablePrefix}grade` as p2 on p1.grade=p2.id where p1.id='{$obj->id}' and p1.status=0 and p1.is_del=0 ";
		$result = $this->query($sql);
		return $result[0];
	}
	
	// 更新平台浏览次数
	public function updateViewNum($obj){
		$sql = " update `{$this->tablePrefix}cooperation_platform` set click_num=click_num+1 where id='{$obj->id}' ";
		return $this->query($sql);
	}
	
}