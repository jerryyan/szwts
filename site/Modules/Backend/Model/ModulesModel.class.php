<?php
class ModulesModel extends CommonModel{

	public function getList($obj){
		$select = " p1.id,p1.nid,p1.name,p1.is_list,p1.pid,p1.plevel,p1.is_hide,from_unixtime(p1.addtime) as atime,
		p1.pindex,p1.addip,from_unixtime(p1.updatetime) as utime,p1.updateip,p2.username as op_username ";
		$sql = " select $select from `{$this->tablePrefix}modules` as p1 left join `{$this->tablePrefix}sys_user` as p2 on p1.op_user=p2.id where 1=1 ";
		if(!empty($obj->nid)){
			$sql .= " and p1.nid like '%{$obj->nid}%' ";
		}
		if(!empty($obj->name)){
			$sql .= " and p1.name like '%{$obj->name}%' ";
		}
		if($obj->is_list>-1){
			$sql .= " and p1.is_list='{$obj->is_list}' ";
		}
		if($obj->is_hide>-1){
			$sql .= " and p1.is_hide='{$obj->is_hide}' ";
		}
		$sql .= " order by p1.porder asc ";
		$this->_ssql = $sql.$obj->limit;
		
		return $this->getDataList($select, $sql);
	}
	
	public function getTrees(){
		$obj = new stdClass();
		$obj->table = $this->tablePrefix.'modules';
		return $this->getTreeList($obj);
	}
	
	public function saveTreeNode($data){
		//保存树节点操作		
		$return = new stdClass();	
		//接下来判断 1 类别不能循环 例如 1 下级为2 ，2的下级不可能为1 
		if($data['id']!=0){
			$_p = $this->query(" select * from `{$this->tablePrefix}modules` where id='{$data['id']}' ");
			$p = $_p[0];
		}		
		if($data['pid']!=0){			
			$_o = $this->query(" select * from `{$this->tablePrefix}modules` where id='{$data['pid']}' ");
			$o = $_o[0];	
		}		
		//$o['sorder'] 中不能包含 $data['sorder']
		if($data['id']!=0){
			$pos = strpos($o['sorder'],$p['sorder']);
			if($pos!==false){
				$message[]="上级类别不能为自己的本身节点的下级";
			}
		}
		
		if(count($message)>0){
			$return->state = 0;
			$return->message = $message;
			return $return;
		}
		
		//先保存节点
		$newObj = $this->saveExpend($data);
		
		
		//得到当前节点保存后的值
		if($newObj['pid']==0){
			$newObj['sorder'] = ",0,".$newObj['id'].",";
			$newObj['plevel'] = 1;
			$newObj['porder'] = ",0,".str_pad($newObj['pindex'], 5, "0", STR_PAD_LEFT).",".$newObj['id'].",";
		}else{	
			$newObj['sorder'] = $o['sorder'].$newObj['id']. ",";
			$newObj['plevel'] = intval($o['plevel'])+1;
			$newObj['porder'] = $o['porder'].str_pad($data['pindex'], 5, "0", STR_PAD_LEFT).",".$newObj['id'].","; 
		}
		//print_r($newObj);die();
	
		$newObj = $this->saveExpend($newObj);
		
		//后续操作
		if($data['id']!=0){
			$i = $newObj['plevel']-$p['plevel'];
			$sql = "update ·{$this->tablePrefix}modules` set plevel=plevel+$i,sorder=replace(sorder, '{$p['sorder']}', '{$newObj['sorder']}'),
			porder=replace(porder, '{$p['porder']}', '{$newObj['porder']}') where sorder like '%{$p['sorder']}%' and id != {$newObj['id']}' ";
			$this->query($sql);			
		}
		
		$return->state = 1;
		$return->data = $newObj;
		return $return;
	}
	
	//保存数据操作（新增和更新）
	public function tsave($data){
		if(intval($data['id'])){
			$this->save($data);	
			$id = $data['id'];	
		}else{
			unset($data['id']);
			$id = $this->add($data);
		}
		return $id;	
	}
	
	//保存数据操作（新增和更新）并根据id获取数据
	public function saveExpend($data){
		$id = $this->tsave($data);
		$result = $this->query(" select * from `{$this->tablePrefix}modules` where id='{$id}' ");		
		return $result[0];	 
	}

}