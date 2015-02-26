<?php
class SysfunctionAction extends MainAction{
	
	public function index(){
		$this->display();
	}
	
	public function getFunctionList(){
		$_q = getParams();
		$obj = new stdClass();
		$where = " where 1=1 ";
		if(!empty($_q->name)){
			$where .= " and name like '%{$_q->name}%' ";
		}
		if($_q->is_function>-1){
			$where .= " and is_function='{$_q->is_function}' ";
		}
		if($_q->is_disabled>-1){
			$where .= " and is_disabled='{$_q->is_disabled}' ";
		}
		if(!empty($_q->module)){
			$where .= " and module_name='{$_q->module}' ";
		}
		if(!empty($_q->method)){
			$where .= " and method_name='{$_q->method}' ";
		}
		$obj->where = $where;
		$obj->limit = $_q->limit;
		
		$result = D("Sys_function")->getFunctionList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
	}
	
	public function edit(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->id = 0;
		$obj->pid = 0;
		$Sys_function = D("Sys_function");
		if(intval($_q->id)>0){
			$obj->id = $_q->id;
			$data = $Sys_function->getOne($obj);
			$obj->pid = $data['pid'];
			$this->assign('tempData', $data);
		}
		$list = $Sys_function->getTreeList($obj);
		foreach ($list as $k=>$v){
			$list[$k]['name'] = str_repeat('&nbsp;&nbsp;', $v['plevel']).$v['name'];
		}
		$_htmlOptions = _getOptionHtml($list, $obj->pid, 'id', 'name');
		$this->assign('options', $_htmlOptions);
		$this->assign('admin_group', C("ADMIN_GROUP"));
		$this->display();
	}
	
	public function saveFunction(){
		$users = $this->users;
		$_q = getParams();
		$data['id'] = 0;
		$data['pid'] = $_q->func_fid;
		$data['name'] = $_q->func_name;
		$data['pindex'] = $_q->func_seq;
		$data['is_function'] = $_q->is_func;
		$data['is_disabled'] = $_q->is_disabled;
		$data['desc'] = $_q->func_desc;
		$data['group_name'] = $_q->group;
		$data['module_name'] = $_q->module;
		$data['method_name'] = $_q->method;
		$data['op_user'] = $users['id'];
		if(intval($_q->func_id)>0){
			$data['id'] = $_q->func_id;
		}else{
			$data['addtime'] = time();
		}
		$result = D("Sys_function")->saveTreeNode($data);
		echo json_encode($result);
	}
}