<?php
class PlatformAction extends MainAction{
	
	//合作平台列表页面
	public function index(){
		$this->display();
	}
	
	//获取合作平台列表数据
	public function getPlatformList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->name = $_q->name;
		$obj->limit = $_q->limit;
		
		$result = D("Cooperation_platform")->getList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
	}
	
	//新增合作平台
	public function add(){
		$options = $this->getOptions();
		$cooperation_platform_result = M("Cooperation_platform")->field("id,code")->order("id desc")->find();
		$this->assign("options", $options);
		$cooperation_platform_result['code'] = empty($cooperation_platform_result['code'])?1000:$cooperation_platform_result['code']+1;
		$this->assign("tempData", $cooperation_platform_result);
		$this->display();
	}
	
	//编辑合作平台
	public function edit(){
		$_q = getParams();
		$id = $_q->id;
		if(intval($id)){
			$cooperation_platform_result = M("Cooperation_platform")->find($id);
			$this->assign("tempData", $cooperation_platform_result);
		}
		$options = $this->getOptions();
		$this->assign("options", $options);
		$this->display();
	}
	
	//删除合作平台数据
	public function delete(){
		$_q = getParams();
		$id = $_q->id;
		$result = 0;
		if(intval($id)){
			$data = array(
				'id' => $id,
				'is_del' => 1,
				'updatetime' => time(),
				'op_user' => $this->users['id']
			);
			$result = M("Cooperation_platform")->save($data);
		}
		echo $result;
	}
	
	//获取安全评级下拉列表
	private function getOptions(){
		$grade = A("Grade");
		return $grade->getOptions();
	}
	
	//保存新增和编辑后的合作平台数据
	public function save(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$data = array();
		$data['name'] = $_q->name;
		$data['logo'] = substr($_q->logo, strpos($_q->logo, 'upload/'));
		$data['logo_big'] = substr($_q->logo_big, strpos($_q->logo_big, 'upload/'));
		$data['status'] = $_q->status;
		$data['grade'] = $_q->grade;
		$data['website'] = $_q->website;
		$data['injection'] = $_q->injection;
		$data['location'] = $_q->location;
		$data['online_time'] = $_q->online_time;
		$data['icp'] = $_q->icp;
		$data['telephone'] = $_q->telephone;
		$data['email'] = $_q->email;
		$data['management_fee'] = $_q->management_fee;
		$data['vip_fee'] = $_q->vip_fee;
		$data['recharge_fee'] = $_q->recharge_fee;
		$data['cash_fee'] = $_q->cash_fee;
		$data['introduction'] = $_q->introduction;
		$data['interface_list'] = $_q->interface_list;
		$data['interface_count'] = $_q->interface_count;
		$data['interface_charts'] = $_q->interface_charts;
		$data['interface_avg'] = $_q->interface_avg;
		$data['interface_reg_bind'] = $_q->interface_reg_bind;
		$data['interface_login_bind'] = $_q->interface_login_bind;
		$data['interface_tender'] = $_q->interface_tender;
		$data['interface_update'] = $_q->interface_update;
		$data['addtime'] = $time;
		$data['op_user'] = $this->users['id'];
                $data['orderby'] = $_q->orderby;
		$cooperation_platform = M("Cooperation_platform");
		$temp = array();
		if(intval($_q->id)){
			$data['id'] = $_q->id;
			$data['updatetime'] = $time;
			$cooperation_platform_result = $cooperation_platform->field("id,logo,logo_big")->find($data['id']);
			$result = $cooperation_platform->save($data);
			if($result>0){
				if($cooperation_platform_result['logo']!=$data['logo']){
					$filename = 'static/'.$cooperation_platform_result['logo'];
					if(file_exists($filename)){
						unlink($filename);
					}
					$temp[] = "'".$cooperation_platform_result['logo']."'";
				}
				if($cooperation_platform_result['logo_big']!=$data['logo_big']){
					$filename = 'static/'.$cooperation_platform_result['logo_big'];
					if(file_exists($filename)){
						unlink($filename);
					}
					$temp[] = "'".$cooperation_platform_result['logo_big']."'";
				}
				if(count($temp)>0){
					$fileurl = implode(',', $temp);
					//更新文件上传日志记录
					$upfiles_data = array(
						'name' => GROUP_NAME,
						'code' => __METHOD__,
						'status' => 2,
						'updatetime' => $time,
						'updateip' => $ip,
					);
					M("Upfiles")->where("fileurl in(%s)", $fileurl)->save($upfiles_data);
				}
			}
		}else{
			// 生成平台编号
			$data['code'] = date('mdHis');
			// 生成随机密钥
			$data['signkey'] = $this->randomkeys(16);
			$result = $cooperation_platform->add($data);
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
			$result = M("Upfiles")->where("fileurl='%s' or fileurl='%s'", $data['logo'], $data['logo_big'])->save($upfiles_data);
		}
		echo $result;
	}
	
	//平台绑定记录
	public function relation(){
		$options = $this->getPlatOptions();
		$this->assign("options", $options);
		$this->display();
	}
	
	//获取平台绑定的用户信息
	public function getRelationList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->plat_id = $_q->plat_id;
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->status = $_q->status;
		$obj->limit = $_q->limit;
		
		$result = D("Cooperation_platform")->getRelationList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
	}
	
	//获取网投所合作平台信息
	private function getOptionList(){
		$platform_result = M("Cooperation_platform")->field("id,name,code,signkey,interface_tender,interface_update")->select();
		return $platform_result;
	}
	
	//合作平台下拉列表
	private function getPlatOptions(){
		$list = $this->getOptionList();
		$options = '<option value="0">全部</option>';
		foreach ($list as $v){
			$options .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
		}
		return $options;
	}
	
	// 生成随机密钥
	private function randomkeys($length){   
   		$output='';   
   		for ($a = 0; $a<$length; $a++) {   
       		$output .= chr(mt_rand(33, 126));     
    	}   
    	return $output; 
	} 
	
}