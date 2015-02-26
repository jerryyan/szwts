<?php
class AccountModel extends CommonModel{

	//获取客户提现详情
	public function getCashList($obj){
		$select = " p1.id,p1.user_id,p2.username,p2.realname,p1.account,p3.name,p1.branch,p1.total,p1.money,
					p1.fee,FROM_UNIXTIME(p1.addtime) as atime,FROM_UNIXTIME(p1.verify_time) as vtime,p1.status,p4.username as realname2,p5.use_money ";
		$sql = " select $select from `{$this->tablePrefix}account_cash` as p1 left join `{$this->tablePrefix}user` as p2 on p1.user_id=p2.user_id 
				left join `{$this->tablePrefix}linkage` as p3 on p1.bank=p3.id left join `{$this->tablePrefix}sys_user` as p4 on p1.verify_userid=p4.id 
				left join `{$this->tablePrefix}account` p5 on p1.user_id=p5.user_id where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p2.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p2.realname like '%{$obj->realname}%' ";
		}
		if(!empty($obj->start)){
			$start_time = strtotime($obj->start);
			$sql .= " and p1.addtime>{$start_time} ";
		}
		if(!empty($obj->end)){
			$end_time = strtotime($obj->end);
			$sql .= " and p1.addtime<{$end_time} ";
		}
		if($obj->status>-1){
			$sql .= " and p1.status='{$obj->status}' ";
		}
		$sql .= " order by p1.id desc ";
		$this->_ssql = $sql;
		if(empty($obj->operation)){
			$this->_ssql .= $obj->limit;
		}
		return $this->getDataList($select, $sql);
	}
	//获取客户资金账户信息
	public function getAccountList($obj){
		$select = " t1.user_id,t1.username,t1.realname,t1.islock,t2.total,t2.use_money,t2.no_use_money ";
		$sql = " select $select from `{$this->tablePrefix}user` as t1 left join `{$this->tablePrefix}account` t2 on t1.user_id=t2.user_id where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and t1.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and t1.realname like '%{$obj->realname}%' ";
		}
		if($obj->islock>-1){
			$sql .= " and t1.islock = {$obj->islock} ";
		}
		$this->_ssql = $sql;
		if(empty($obj->operation)){
			$this->_ssql .= $obj->limit;
		}
		$result = $this->query($this->_ssql);
		
		$this->_ssql = str_replace($select, 'count(*) as num', $sql);
		$counts = $this->query($this->_ssql);
		
		if(count($result)>0){
			foreach ($result as $k=>$v){
				$this->_ssql = " select money,type from `{$this->tablePrefix}account_log` where user_id='{$v['user_id']}' and type='recommend_reward' ";
				if(!empty($obj->start)){
					$start_time = strtotime($obj->start);
					$this->_ssql .= " and addtime>{$start_time} ";
				}
				if(!empty($obj->end)){
					$end_time = strtotime($obj->end);
					$this->_ssql .= " and addtime<{$end_time} ";
				}
				$result2 = $this->query($this->_ssql);
				foreach ($result2 as $k2=>$v2){
					$type = $v2['type'];
					$result[$k][$type] += $v2['money'];
				}
			}
		}
		return array('rows'=>$result,'total'=>$counts[0]['num']);
	}
	//获取客户的资金使用记录
	public function getAccountLogList($obj){
		$select = " p1.id,p1.user_id,p2.username,p2.realname,p1.type,p1.total,p1.money,p1.use_money,p1.no_use_money,
					FROM_UNIXTIME(p1.addtime) as atime,p1.addip ";
		$sql = " select $select from `{$this->tablePrefix}account_log` as p1 left join `{$this->tablePrefix}user` as p2 on p1.user_id=p2.user_id where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p2.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p2.realname like '%{$obj->realname}%' ";
		}
		if(!empty($obj->start)){
			$start_time = strtotime($obj->start);
			$sql .= " and p1.addtime>{$start_time} ";
		}
		if(!empty($obj->end)){
			$end_time = strtotime($obj->end);
			$sql .= " and p1.addtime<{$end_time} ";
		}
		if(!empty($obj->operate_type)){
			$sql .= " and p1.type='{$obj->operate_type}' ";
		}
		if($obj->islock>-1){
			$sql .= " and p2.islock='{$obj->islock}' ";
		}
		$sql .= " order by p1.id desc ";
		$this->_ssql = $sql;
		if(empty($obj->operation)){
			$this->_ssql .= $obj->limit;
		}
		return $this->getDataList($select, $sql);
	}
	//获取会员邀请注册列表
	public function getInvitationList($obj){
		$money = C("invitation_money");
		$select = " t1.user_id,t1.username,t1.realname,t1.real_status,t1.phone_status,t1.email_status,from_unixtime(t1.addtime) as atime,'$money' as money,t1.invite_money,
		(select sum(amount) from `{$this->tablePrefix}tender_log` where username=t1.username) as summoney,t2.user_id as uid,t2.username as uname,t2.realname as rname ";
		
		$sql = " select $select from `{$this->tablePrefix}user` as t1 left join `{$this->tablePrefix}user` as t2 on t1.invite_userid=t2.user_id 
		where t1.invite_userid>0 and t1.user_id is not null ";
		if(!empty($obj->uname)){
			$sql .= " and t2.username like '%{$obj->uname}%' ";
		}
		if(!empty($obj->username)){
			$sql .= " and t1.username like '%{$obj->username}%' ";
		}
		$this->_ssql = $sql;
		$this->_ssql .= $obj->limit;
		$result = $this->query($this->_ssql);
		foreach ($result as $k=>$v){
			if(empty($v['summoney'])){
				$result[$k]['summoney'] = 0;
				$result[$k]['money'] = 0;
			}
		}
		 
		$this->_ssql = str_replace($select, "count(*) as num", $sql);
		$counts = $this->query($this->_ssql);
		
		return array('rows'=>$result,'total'=>$counts[0]['num']);
	}
	//获取被邀请会员的详细信息
	public function getInvitationOne($obj){
		$sql = " select t1.username,t1.invite_userid from `{$this->tablePrefix}user` as t1 
		left join `{$this->tablePrefix}tender_log` as t2 on t1.username=t2.username 
		where t1.user_id={$obj->user_id} and t1.real_status=1 and t1.email_status=1 and t1.phone_status=1 
		group by t2.username having sum(t2.amount)>=0 ";
		$user_result = $this->query($sql);
		return $user_result[0];
	}
}