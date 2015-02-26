<?php
class UserModel extends CommonModel{

	//获取推荐的好友记录
	public function getInvitationList($obj){
		$sql = " select distinct p1.username,p1.email_status,p1.phone_status,p1.real_status,p1.addtime,p1.invite_money,
		if(p2.amount is null, 0, 1) as is_tender from `{$this->tablePrefix}user` as p1 
		left join `{$this->tablePrefix}tender_log` as p2 on p1.username=p2.username 
		where p1.invite_userid={$obj->user_id} ";
		$sql .= " order by p1.addtime desc ".$obj->limit;
		return $this->query($sql);
	}
	
}