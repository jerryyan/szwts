<?php
class LinksAction extends MainAction{
	
	//网站链接管理(友情链接和合作伙伴)
	public function index(){
		$this->display();
	}
	//获取网站链接列表数据
	public function getList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->webname = $_q->webname;
		$obj->type_id = $_q->type;
		$obj->status = $_q->status;
		$obj->limit = $_q->limit;
		
		$result = D("Links")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//新增友情链接
	public function add(){
		$this->display();
	}
	//编辑与查看友情链接
	public function edit(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$result = M("Links")->find($_q->id);
			$this->assign("tempData", $result);
		}
		$this->display();
	}
	//保存友情链接
	public function save(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$users = $this->users;
		$links = M("Links");
		$data = array(
			'type_id' => $_q->type,
			'webname' => $_q->webname,
			'logo' => substr($_q->logo, strpos($_q->logo, 'upload/')),
			'weblink' => $_q->weblink,
			'status' => $_q->status,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['id']
		);
		if(intval($_q->id)>0){
			$data['id'] = $_q->id;
			$links_result = $links->find($_q->id);
			$result = $links->save($data);
			if($result>0){
				if($links_result['logo']!=$data['logo']){
					$filename = 'static/'.$links_result['logo'];
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
					M("Upfiles")->where(array('fileurl'=>$links_result['logo']))->save($upfiles_data);
				}
			}
		}else{
			$data['addtime'] = $time;
			$data['addip'] = $ip;
			$result = M("Links")->add($data);
		}
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
			$result = M("Upfiles")->where(array('fileurl'=>$data['logo']))->save($upfiles_data);
		}	
		echo $result;
	}
	//删除友情链接
	public function delete(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->id)>0){
			$links = M("Links");
			$links_result = $links->find($_q->id);
			$result = $links->where(array('id'=>$_q->id))->delete();
			if($result>0){
				$filename = 'static/'.$links_result['logo'];
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
				M("Upfiles")->where(array('fileurl'=>$links_result['logo']))->save($upfiles_data);
			}
		}
		echo $result;
	}
}