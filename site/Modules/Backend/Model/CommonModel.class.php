<?php
class CommonModel extends Model{
	var $_ssql;
	
	function __construct(){
		parent::__construct();
	}
	
	function getDataList($select, $sql){
		$result = $this->query($this->_ssql);
		$this->_ssql = str_replace($select, "count(*) as num", $sql);
		$counts = $this->query($this->_ssql);
		
		return array('rows'=>$result,'total'=>$counts[0]['num']);
	}
	
	//获取树状结构表数据
	function getTreeList($obj){
		$where = isset($obj->where)?$obj->where:'';
		$order = isset($obj->order)?$obj->order:'porder asc';
		$sql = " select id,pid,sorder,plevel,name from `{$obj->table}` where 1=1 {$where} order by {$order} ";
		return $this->query($sql);
	}

}

?>