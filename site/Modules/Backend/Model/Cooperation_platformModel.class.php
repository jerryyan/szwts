<?php
class Cooperation_platformModel extends CommonModel{

	//获取合作平台列表数据
	public function getList($obj){
		$select = " p1.id,p1.code,p1.signkey,p1.name,p1.logo,p1.grade,p1.website,p1.injection,p1.location,p1.online_time,p1.status,p1.orderby,
		p1.icp,p1.telephone,p1.email,p1.management_fee,p1.vip_fee,p1.recharge_fee,p1.cash_fee,p2.name as grade_name,
		from_unixtime(p1.addtime) as atime,from_unixtime(p1.updatetime) as utime,p3.username as op_username ";
		$sql = " select $select from `{$this->tablePrefix}cooperation_platform` as p1 left join `{$this->tablePrefix}grade` as p2 on p1.grade=p2.id 
		left join `{$this->tablePrefix}sys_user` as p3 on p1.op_user=p3.id where 1=1 ";
		if(!empty($obj->name)){
			$sql .= " and p1.name like '%{$obj->name}%' ";
		}
		$sql .= " order by p1.orderby asc,p1.id desc ";
		$this->_ssql = $sql.$obj->limit;
		return $this->getDataList($select, $sql);
	}
	
	//获取平台绑定的用户信息
	public function getRelationList($obj){
		$select = " p1.username,p1.realname,p2.relation_name,from_unixtime(p2.addtime) as atime,
		p3.name as platname,if(p2.relation_name is null, 0, 1) as status,if(p2.relation_name is null, '', '网投所账户绑定') as atype ";
		$sql = " select $select from `{$this->tablePrefix}user` as p1 
		left join `{$this->tablePrefix}platform_relation` as p2 on p1.user_id=p2.user_id 
		left join `{$this->tablePrefix}cooperation_platform` as p3 on p2.platform_id=p3.id where 1=1 ";
		if(!empty($obj->plat_id)){
			$sql .= " and p3.id={$obj->plat_id} ";
		}
		if(!empty($obj->username)){
			$sql .= " and p1.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p1.realname like '%{$obj->realname}%' ";
		}
		if($obj->status>-1){
			if($obj->status==1){
				$sql .= " and p2.relation_name is not null ";
			}else{
				$sql .= " and p2.relation_name is null ";
			}
		}
		$sql .= " order by p1.user_id desc ";
		$this->_ssql = $sql.$obj->limit;
		return $this->getDataList($select, $sql);
	}

}
?>