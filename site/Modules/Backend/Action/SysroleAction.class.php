<?php
class SysroleAction extends MainAction{
	
	public function index(){
		$this->display();
	}
	
	public function getRoleList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->limit = $_q->limit;
		
		$result = D("Sys_role")->getRoleList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
	}
	
	public function edit(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->id = 0;
		if(intval($_q->id)){
			$obj->id = $_q->id;
			$data = D("Sys_role")->getOne($obj);
			$this->assign('tempData', $data);
		}
		$this->display();
	}
	
	public function saveRole(){
		$users = $this->users;
		$_q = getParams();
		$data['id'] = 0;
		if(intval($_q->id)){
			$data['id'] = $_q->id;
		}
		$data['role_name'] = $_q->name;
		$data['role_desc'] = $_q->desc;
		$data['is_disabled'] = $_q->is_disabled;
		$data['addtime'] = time();
		$data['op_user'] = $users['id'];
		$Sys_role = M("Sys_role");
		if($data['id']>0){
			$result = $Sys_role->save($data);
		}else{
			$result = $Sys_role->add($data);	
		}
		echo $result;
	}
	
	public function privilege(){
		$_q = getParams();
		$obj = new stdClass();
		$Sys_function = 
		$_arr = D("Sys_function")->getFunctionTree($obj);
		
		$obj->role_id = intval($_q->id);
		$selects = D("Sys_privilege")->getSelected($obj);
		
		$_list = array();
		$root = new stdClass();
		$root->id = 0;
		$root->pid = 0;
		$root->name = '根目录';
		$root->plevel = 0;
		$_list[$root->id] = $root;
		
		$re = array();
		$array = array();
		foreach ($_arr as $v){
			$o = new stdClass();
			$o->id = $v['id'];
			$o->pid = $v['pid'];
			$o->sorder = $v['sorder'];
			$o->plevel = $v['plevel'];
			$o->name = $v['name'];
			$re[] = $o;
			if(in_array($v['id'], $selects)){
				$array[] = $v['pid'];
			}
		}
		
		foreach ($re as $v){
			$_o = $_list[$v->pid];
			if(!isset($_o->children))$_o->children = array();
			$_v = $v;
			$_v->select = '';
			$_v->disabled = '';
			if(in_array($_v->id, $selects)){
				$_v->select = 'checked="checked"';
				if(in_array($v->id, $array)){
					$_v->disabled = 'disabled="disabled"';
				}
			}
			$_o->children[] = $_v;
			$_list[$v->id] = $_v;
		}
		$this->assign('id', intval($_q->id));
		$this->assign('tempData', json_encode($_list[0]->children));

		$this->display();
	}
	
	public function privilegeAdd(){
		$users = $this->users;
		$_q = getParams();
		$funcs = array();
		if(!empty($_q->funcs) && is_string($_q->funcs)){
			$funcs = explode(',', $_q->funcs);
		}
		$Sys_privilege = M("Sys_privilege");
		$result = $Sys_privilege->where(array('role_id'=>intval($_q->role)))->delete();
		if(count($funcs)>0){
			$data = array();			
			foreach ($funcs as $v){
				$data[] = array(
					'role_id'=>$_q->role,
					'function_id'=>$v,
					'addtime'=>time(),
					'op_user'=>$users['id']
				);
			}
			if(count($data)>0){
				$result = $Sys_privilege->addAll($data);
			}
		}
		$o = new stdClass();
		$o->state = $result;
		if($o->state>0){
			$o->message = '操作成功！';
		}else{
			$o->message = '操作失败！';
		}
		echo json_encode($o);
	}
}