<?php
class AdvertAction extends MainAction{
	//广告图片管理
	public function index(){
		$options = $this->getAdvertModules(0);
		$this->assign("options", $options);
		$this->display();
	}
	//获取广告图片列表
	public function getList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->title = $_q->title;
		$obj->type_id = $_q->type_id;
		$obj->status = $_q->status;
		$obj->limit = $_q->limit;
		
		$result = D("Advert")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//获取广告图片模块
	private function getAdvertModules($id){
		$advert_type_result = M("Advert_modules")->select();
		$options = '<option value="0">--请选择--</option>';
		foreach ($advert_type_result as $v){
			$selected = "";
			if(!empty($id) && $v['id']==$id){
				$selected = " selected=selected ";
			}
			$options .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['modules_name'].'</option>';
		}
		return $options;
	}
	//添加广告图片
	public function add(){
		$options = $this->getAdvertModules(0);
		$this->assign("options", $options);
		$this->display();
	}
	//编辑与查看广告图片
	public function edit(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$advert_result = M("Advert")->find($_q->id);
			$advert_result['options'] = $this->getAdvertModules($advert_result['type_id']);
			$this->assign("tempData", $advert_result);
		}
		$this->display();
	}
	//保存广告图片数据
	public function save(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$users = $this->users;
		$advert = M("Advert");
		$data = array(
			'title' => $_q->title,
			'url' => $_q->url,
			'pic' => substr($_q->pic, strpos($_q->pic, 'upload/')),
			'type_id' => $_q->type_id,
			'position' => $_q->position,
			'status' => $_q->status,
			'order' => $_q->order,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['id']
		);
		if(intval($_q->id)>0){
			$data['id'] = $_q->id;
			//如果更新后的图片和之前不一样，则删除之前的图片
			$advert_result = $advert->find($_q->id);
			//更新广告图片信息	
			$result = M("Advert")->save($data);
			if($result>0){
				if(!empty($data['pic']) && $advert_result['pic']!=$data['pic']){
					$filename = 'static/'.$advert_result['pic'];
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
					M("Upfiles")->where(array('fileurl'=>$advert_result['pic']))->save($upfiles_data);
				}
			}
		}else{
			$data['addtime'] = $time;
			$data['addip'] = $ip;
			$result = M("Advert")->add($data);
		}
		if($result>0){
			//更新文件上传日志记录
			$upfiles_data = array(
				'name' => GROUP_NAME,
				'code' => __METHOD__,
				'status' => 1,
				'updatetime' => $time,
				'updateip' => $ip,
			);
			M("Upfiles")->where(array('fileurl'=>$data['pic']))->save($upfiles_data);
		}
		echo $result;
	}
	//删除轮播广告
	public function delete(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->id)>0){
			$advert = M("Advert");
			$advert_result = $advert->find($_q->id);
			$result = $advert->where(array('id'=>$_q->id))->delete();
			if($result>0){
				$filename = 'static/'.$advert_result['pic'];
				if(file_exists($filename)){
					unlink($filename);
				}
				//更新文件上传日志记录
				$upfiles_data = array(
					'name' => GROUP_NAME,
					'code' => __METHOD__,
					'status' => 2,
					'updatetime' => time(),
					'updateip' => get_client_ip(),
				);
				M("Upfiles")->where(array('fileurl'=>$advert_result['pic']))->save($upfiles_data);
			}
		}
		echo $result;
	}
	//广告模块管理
	public function modules(){
		$this->display();
	}
	//获取广告模块列表
	public function getModulesList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->status = $_q->status;
		$obj->limit = $_q->limit;
		
		$result = D("Advert_modules")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//添加广告模块
	public function addmodules(){
		$this->display();
	}
	//编辑与查看广告模块
	public function editmodules(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$advert_modules_result = M("Advert_modules")->find($_q->id);
			$this->assign("tempData", $advert_modules_result);
		}
		$this->display();
	}
	//保存广告模块
	public function savemodules(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$users = $this->users;
		$advert_modules = M("advert_modules");
		$data = array(
			'modules' => $_q->modules,
			'modules_name' => $_q->modules_name,
			'status' => $_q->status,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['id']
		);
		if(intval($_q->id)>0){
			$data['id'] = $_q->id;
			$result = $advert_modules->save($data);
		}else{
			$data['addtime'] = $time;
			$data['addip'] = $ip;
			$result = $advert_modules->add($data);
		}
		echo $result;
	}
	//图库管理列表
	public function gallery(){
		$this->display();
	}
	//获取图库列表数据
	public function getGalleryList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->name = $_q->name;
		$obj->limit = $_q->limit;
		
		$result = D("Gallery")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//删除图库记录
	public function delGallery(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->id)>0){
			$gallery = M("Gallery");
			$gallery_result = $gallery->find($_q->id);
			if(!empty($gallery_result) && $gallery_result['id']>0){
				$filename = $gallery_result['filepath'];
				$result = $gallery->where(array('id'=>$_q->id))->delete();
				if($result>0){
					if(file_exists($filename)){
						unlink($filename);
					}
				}
			}
		}
		echo $result;
	}
}