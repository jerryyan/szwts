<?php
/**
 * 
 * 数据表树结构及数据保存和列表获取操作类
 * @author liuming
 *
 */
class SyscommonModel extends Model{
	var $_ssql;
	
	function __construct(){
		parent::__construct();
	}
	
	function saveTreeNode($data){
		//保存树节点操作		
		$return = new stdClass();	
		//接下来判断 1 类别不能循环 例如 1 下级为2 ，2的下级不可能为1 
		if($data['id']!=0){
			$_p = $this->query(" select * from `{$this->tablePrefix}sys_function` where id='{$data['id']}' ");
			$p = $_p[0];
		}		
		if($data['pid']!=0){			
			$_o = $this->query(" select * from `{$this->tablePrefix}sys_function` where id='{$data['pid']}' ");
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
			$sql = "update ·{$this->tablePrefix}sys_function` set plevel=plevel+$i,sorder=replace(sorder, '{$p['sorder']}', '{$newObj['sorder']}'),
			porder=replace(porder, '{$p['porder']}', '{$newObj['porder']}') where sorder like '%{$p['sorder']}%' and id != {$newObj['id']}' ";
			$this->query($sql);			
		}
		
		$return->state = 1;
		$return->data = $newObj;
		return $return;
	}
	
	//保存数据操作（新增和更新）
	function tsave($data){
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
	function saveExpend($data){
		$id = $this->tsave($data);
		$result = $this->query(" select * from `{$this->tablePrefix}sys_function` where id='{$id}' ");		
		return $result[0];	 
	}
	
	//获取树状结构表数据
	function getTreeList($obj){
		$where = isset($obj->where)?$obj->where:'';
		$order = isset($obj->order)?$obj->order:'porder asc';
		$sql = " select id,pid,sorder,plevel,name from `{$this->tablePrefix}sys_function` where 1=1 {$where} order by {$order} ";
		return $this->query($sql);
	}
	
	//获取分页数据
	function getPageList($obj){
		$fields = isset($obj->fields)?$obj->fields:" * ";
		$where = isset($obj->where)?$obj->where:"";
		$order = "";
		if(isset($obj->order)){
			$order = " order by {$obj->order} ";
		}
		$limit = isset($obj->limit)?$obj->limit:"";
		$sql = " select {$fields} from `{$obj->table}` {$where} {$order} {$limit} ";
		return $this->query($sql);
	}
}