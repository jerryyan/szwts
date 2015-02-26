<?php
class GradeAction extends MainAction{

	//安全评级
	public function index(){
		$this->display();
	}
	
	//获取安全评级列表数据
	public function getGradeList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->name = $_q->name;
		$obj->limit = $_q->limit;
		$result = D("Grade")->getList($obj);
		
		foreach ($result['rows'] as $k=>$v){
			$result['rows'][$k]['config'] = unserialize($v['config']);
		}
		
		$o = (object)$result;
		echo json_encode($o);
	}
	
	//新增安全评级等级
	public function add(){
		$this->display();
	}
	
	//编辑安全评级等级
	public function edit(){
		$_q = getParams();
		$id = $_q->id;
		if(intval($id)){
			$grade_result = M("Grade")->find($id);
			$grade_result['config'] = unserialize($grade_result['config']);
			$this->assign("tempData", $grade_result);
		}
		$this->display();
	}
	
	//保存数据
	public function save(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$data = array();
		$data['name'] = $_q->name;
		if(!empty($_q->logo)){
			$data['logo'] = substr($_q->logo, strpos($_q->logo, 'upload/'));
		}
		$data['status'] = $_q->status;
		$config = array(
			'capital' => $_q->capital,
			'dispersion' => $_q->dispersion,
			'transparency' => $_q->transparency,
			'mobility' => $_q->mobility,
			'operate' => $_q->operate,
			'cost' => $_q->cost
		);
		$data['config'] = serialize($config);
		$data['addtime'] = $time;
		$data['op_user'] = $this->users['id'];
		$grade = M("Grade");
		if(intval($_q->id)){
			$data['id'] = $_q->id;
			$data['updatetime'] = $time;
			$grade_result = $grade->field('id,logo')->find($_q->id);
			$result = $grade->save($data);
			if($result>0 && !empty($data['logo'])){
				if($grade_result['logo']!=$data['logo']){
					$filename = 'static/'.$grade_result['logo'];
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
					M("Upfiles")->where(array('fileurl'=>$grade_result['logo']))->save($upfiles_data);
				}
			}
		}else{
			$result = $grade->add($data);
		}
		if($result>0 && !empty($data['logo'])){
			//更新文件上传日志记录
			$upfiles_data = array(
				'name' => GROUP_NAME,
				'code' => __METHOD__,
				'status' => 1,
				'updatetime' => $time,
				'updateip' => $ip,
			);
			$result = M("Upfiles")->where("fileurl='%s'", $data['logo'])->save($upfiles_data);
		}
		echo $result;
	}
	
	//获取安全评级生成下拉框
	public function getOptions(){
		$result = M("Grade")->select();
		$options = '';
		$options .= '<option value="0">--请选择--</option>';
		foreach ($result as $v){
			$options .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
		}
		return $options;
	}
	
}