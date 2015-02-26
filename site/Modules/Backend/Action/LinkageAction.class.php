<?php
class LinkageAction extends MainAction{
	//平台用户操作类型列表
	public function type(){
		$this->display();
	}
	//获取平台操作类型列表
	public function getTypeList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->name = $_q->name;
		$obj->nid = $_q->nid;
		$obj->limit = $_q->limit;
		
		$result = D("Linkage_type")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//添加操作类型
	public function addtype(){
		$this->display();
	}
	//编辑与查看操作类型
	public function edittype(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$result = M("Linkage_type")->find($_q->id);
			$this->assign("tempData", $result);
		}
		$this->display();
	}
	//保存操作类型
	public function saveType(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$users = $this->users;
		$linkage_type = M("Linkage_type");
		$data = array(
			'name' => $_q->name,
			'nid' => $_q->nid,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['id']
		);
		if(intval($_q->id)>0){
			$data['id'] = $_q->id;
			$result = $linkage_type->save($data);
		}else{
			$data['addtime'] = $time;
			$data['addip'] = $ip;
			$result = $linkage_type->add($data);
		}
		echo $result;
	}
	//删除操作类型
	public function delType(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->id)>0){
			$linkage_result = M("Linkage")->where(array('type_id'=>$_q->id))->find();
			if(empty($linkage_result['id'])){
				$result = M("Linkage_type")->where(array('id'=>$_q->id))->delete();
			}
		}
		echo $result;
	}
	//操作类型联动列表页面
	public function index(){
		$options = $this->getTypeOptions();
		$this->assign('options', $options);
		$this->display();
	}
	//获取操作类型联动列表数据
	public function getList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->type_id = $_q->type_id;
		$obj->name = $_q->name;
		$obj->status = $_q->status;
		$obj->limit = $_q->limit;
		
		$result = D("Linkage")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//新增操作类型联动数据
	public function add(){
		$options = $this->getTypeOptions();
		$this->assign("options", $options);
		$this->display();
	}
	//编辑与查看操作类型联动数据
	public function edit(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$tempData = M("Linkage")->find($_q->id);
		}
		$options = $this->getTypeOptions();
		$tempData['options'] = $options;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	//保存操作类型联动数据
	public function save(){
		$_q = getParams();
		$users = $this->users;
		$time = time();
		$ip = get_client_ip();
		$linkage = M("Linkage");
		$data = array(
			'name' => $_q->name,
			'value' => $_q->value,
			'type_id' => $_q->type_id,
			'status' => $_q->status,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['id']
		);
		if(!empty($_q->pic)){
			$data['pic'] = substr($_q->pic, strpos($_q->pic, 'upload/'));
		}
		if(intval($_q->id)>0){
			$data['id'] = $_q->id;
			$linkage_result = $linkage->find($_q->id);
			$result = $linkage->save($data);
			if($result>0){
				if($linkage_result['pic']!=$data['pic']){
					$filename = 'static/'.$linkage_result['pic'];
					if(file_exists($filename)){
						unlink($filename);
					}
					//更新文件上传日志记录
					$upfiles_data = array(
						'name' => GROUP_NAME,
						'code' => __METHOD__,
						'status' => 2,
						'updatetime' => $time,
						'updateip' => $ip,
					);
					M("Upfiles")->where(array('fileurl'=>$linkage_result['pic']))->save($upfiles_data);
				}
			}
		}else{
			$data['addtime'] = $time;
			$data['addip'] = $ip;
			$result = $linkage->add($data);
			if($result>0){
				//更新文件上传日志记录
				$upfiles_data = array(
					'name' => GROUP_NAME,
					'code' => __METHOD__,
					'user_id' => 0,
					'status' => 1,
					'updatetime' => $time,
					'updateip' => $ip,
				);
				M("Upfiles")->where(array('fileurl'=>$data['pic']))->save($upfiles_data);
			}
		}
		echo $result;
	}
	//删除操作类型联动数据
	public function delete(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->id)>0){
			$result = M("Linkage")->where(array('id'=>$_q->id))->delete();
		}
		echo $result;
	}
	//获取操作类型生成下拉框
	private function getTypeOptions(){
		$result = M("Linkage_type")->select();
		$options = '';
		$options .= '<option value="0">--请选择--</option>';
		foreach ($result as $v){
			$options .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
		}
		return $options;
	}
	//设置和更新所有操作选项（缓存）
	public function setCache(){
		$filepath = APP_PATH.'/Runtime/Data/linkage.php';
		if(file_exists($filepath)){
			unlink($filepath);
		}
		$result = D(GROUP_NAME."/Linkage")->getCache();
		$linkage = array();
		foreach ($result as $k=>$v){
			$key = $v['nid'];
			$linkage[$key][] = array(
				'id'=>$v['id'],
				'name'=>$v['name'],
				'value'=>$v['value']
			);
		}
		F("linkage", $linkage);
		echo 1;
	}
	//设置和获取用户的所有操作选项（缓存）
	public function getCache(){
		$linkage = F("linkage");
		if(empty($linkage)){
			$result = D(GROUP_NAME."/Linkage")->getCache();
			$linkage = array();
			foreach ($result as $k=>$v){
				$key = $v['nid'];
				$linkage[$key][] = array(
					'id'=>$v['id'],
					'name'=>$v['name'],
					'value'=>$v['value']
				);
			}
			F("linkage", $linkage);
		}
		return $linkage;
	}
	//获取用户操作选项下拉菜单
	public function getLinkageHtml($obj){
		$linkage = $this->getCache();
		$name = $obj->name;
		$nid = $obj->nid;//联动的类型
		$id = $obj->id;//表单的值
		$result = $linkage[$nid];
		$display =  "<select name='$name'>";
		$display .= "<option value='0'>--请选择--</option>";
		foreach ($result as $key => $value){
			$val = $value['id'];
			if ($id==$val){
				$display .=  "<option value='".$val."' selected>".$value['name']."</option>";
			}else{
				$display .=  "<option value='".$val."'>".$value['name']."</option>";
			}	
		}	
		$display .=  "</select>";	
		return $display;
	}
	
}