<?php
class MessageModel extends Model{

	//获取会员站内信总记录数
	public function getTotalRows($obj){
		$sql = " select count(*) as num from `{$this->tablePrefix}message` where 1=1 ";
		if(!empty($obj->user_id)){
			$sql .= " and receive_user='{$obj->user_id}' ";
		}
		if($obj->status!=""){
			$sql .= " and status='{$obj->status}' ";
		}
		$result = $this->query($sql);
		return $result[0]['num'];
	}
	
	//获取会员站内信息列表
	public function getList($obj){
		$sql = " select id,name,status,content,addtime from `{$this->tablePrefix}message` where 1=1 ";
		if(!empty($obj->user_id)){
			$sql .= " and receive_user='{$obj->user_id}' ";
		}
		if($obj->status!=""){
			$sql .= " and status='{$obj->status}' ";
		}
		$sql .= " order by id desc ".$obj->limit;
		return $this->query($sql);	
	}
	
}

?>