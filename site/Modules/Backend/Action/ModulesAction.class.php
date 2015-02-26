<?php
class ModulesAction extends MainAction{
	
	//网站模块列表页面
	public function Index(){
		$this->display();
	}
	//获取网站模块数据
	public function getList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->name = $_q->name;
		$obj->nid = $_q->nid;
		$obj->is_list = $_q->is_list;
		$obj->is_hide = $_q->is_hide;
		$obj->limit = $_q->limit;
		
		$result = D("Modules")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//新增网站模块页面
	public function add(){
		$obj = new stdClass();
		$obj->pid = 0;
		$options = $this->getOptions($obj);
		$this->assign('options', $options);
		$this->display();
	}
	//编辑与查看网站模块页面
	public function edit(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->pid = 0;
		if(intval($_q->id)){
			$obj->id = $_q->id;
			$modules_result = M("Modules")->find($obj->id);
			$modules_content_result = M("Modules_content")->find($obj->id);
			$obj->pid = $modules_result['pid'];
			$modules_result['content'] = $modules_content_result['content'];
			$this->assign('tempData', $modules_result);
		}
		$options = $this->getOptions($obj);
		$this->assign("options", $options);
		$this->display();
	}
	//保存网站模块数据
	public function save(){
		$users = $this->users;
		$time = time();
		$ip = get_client_ip();
		$_q = getParams();
		$data['id'] = 0;
		$data['nid'] = $_q->nid;
		$data['name'] = $_q->name;
		$data['pid'] = $_q->pid;
		$data['pindex'] = $_q->pindex;
		$data['is_list'] = $_q->is_list;
		$data['is_hide'] = $_q->is_hide;
		$data['updatetime'] = $time;
		$data['updateip'] = $ip;
		$data['op_user'] = $users['id'];
		if(intval($_q->id)){
			$data['id'] = $_q->id;
		}else{
			$data['addtime'] = $time;
			$data['addip'] = $ip;
		}
		$result = D("Modules")->saveTreeNode($data);
		$modules_content_data = array(
			'content' => stripcslashes($_q->content)
		);
		if(intval($_q->id)){
			$modules_content_data['modules_id'] = $_q->id;
			$modules_content_result = M("Modules_content")->find($_q->id);
			if(!empty($modules_content_result)){	
				if(!empty($modules_content_result['content'])){
					//获取文本编辑器中的所有图片
					preg_match_all("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")/", $modules_content_data['content'],$match);
					$new_arr_0 = array_unique($match[3]);
					preg_match_all("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")/", $modules_content_result['content'],$match);
					$new_arr_1 = array_unique($match[3]);
					$filter_arr = array_intersect($new_arr_0, $new_arr_1);
					foreach ($new_arr_1 as $v){
						if(!in_array($v, $filter_arr)){
							$v = substr($v, 1);
							M("Gallery")->where(array('filepath'=>$v))->delete();
							if(file_exists($v)){
								unlink($v);
							}
						}
					}
				}
				M("Modules_content")->save($modules_content_data);	
			}else{
				M("Modules_content")->add($modules_content_data);
			}	
		}
		echo json_encode($result);
	}
	//删除网站模块数据
	public function delete(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->id)){
			$modules = M("Modules");
			//没有下级分类才可以删除
			$modules_result = $modules->field("id")->where("pid='%d'", $_q->id)->find();
			if(empty($modules_result) && empty($modules_result['id'])){
				$result = $modules->where(array('id'=>$_q->id))->delete();
				if($result>0){
					$modules_content = M("Modules_content");
					$modules_content_result = $modules_content->find($_q->id);
					$modules_content->where(array('modules_id'=>$_q->id))->delete();
					//获取文本编辑器中的所有图片
					preg_match_all("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")/", $modules_content_result['content'],$match);
					$new_arr = array_unique($match[3]);
					if(count($new_arr)>0){
						foreach ($new_arr as $v){
							$v = substr($v, 1);
							M("Gallery")->where(array('filepath'=>$v))->delete();
							if(file_exists($v)){
								unlink($v);
							}
						}
					}
				}
			}
		}
		echo $result;
	}
	//获取网站模块等级下拉菜单
	private function getOptions($obj){
		$list = D("Modules")->getTrees();
		foreach ($list as $k=>$v){
			$list[$k]['name'] = str_repeat('&nbsp;&nbsp;', $v['plevel']).$v['name'];
		}
		$_htmlOptions = _getOptionHtml($list, $obj->pid, 'id', 'name');
		return $_htmlOptions;
	}
}