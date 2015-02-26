<?php
class ArticlesAction extends MainAction{
	
	//网站列表页文章管理
	public function index(){
		$obj = new stdClass();
		$obj->modules_id = 0;
		$options = $this->getModulesOptions($obj);
		$this->assign("options", $options);
		$this->display();
	}
	//获取网站列表页文章数据
	public function getList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->title = $_q->title;
		$obj->modules_id = $_q->modules_id;
		$obj->status = $_q->status;
		$obj->limit = $_q->limit;
		
		$result = D("Articles")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//新增文章
	public function add(){
		$obj = new stdClass();
		$obj->modules_id = 0;
		$options = $this->getModulesOptions($obj);
		$this->assign("options", $options);
		$this->display();
	}
	//编辑与查看文章
	public function edit(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$articles_result = M("Articles")->find($_q->id);
			$obj = new stdClass();
			$obj->modules_id = $articles_result['modules_id'];
			$options = $this->getModulesOptions($obj);
			$articles_result['options'] = $options;
			$this->assign("tempData", $articles_result);
		}
		$this->display();
	}
	//保存文章
	public function save(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$users = $this->users;
		$data = array(
			'modules_id' => $_q->modules_id,
			'title' => $_q->title,
			'author' => $_q->author,
			'source' => $_q->source,
			'link' => $_q->link,
			'thumbnail' => empty($_q->thumbnail)?'':substr($_q->thumbnail, strpos($_q->thumbnail, 'upload/')),
			'summary' => $_q->summary,
			'content' => stripslashes($_q->content),
			'status' => $_q->status,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['id']
		);
		$articles = M("Articles");
		if(intval($_q->id)>0){
			$data['id'] = $_q->id;
			$articles_result = M("Articles")->find($_q->id);	
			if(!empty($articles_result['content'])){
				//获取文本编辑器中的所有图片
				preg_match_all("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")/", $data['content'],$match);
				$new_arr_0 = array_unique($match[3]);
				preg_match_all("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")/", $articles_result['content'],$match);
				$new_arr_1 = array_unique($match[3]);
				$filter_arr = array_intersect($new_arr_0, $new_arr_1);
				foreach ($new_arr_1 as $v){
					if(!in_array($v, $filter_arr)){
						M("gallery")->where(array('filepath'=>$v))->delete();
						if(file_exists($v)){
							unlink($v);
						}
					}
				}
			}
			$result = $articles->save($data);
			if($result>0){
				// 更新缩略图上传状态
				if(!empty($data['thumbnail']) && $articles_result['thumbnail']!=$data['thumbnail']){
					$filename = 'static/'.$articles_result['thumbnail'];
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
					M("Upfiles")->where(array('fileurl'=>$articles_result['thumbnail']))->save($upfiles_data);
				}
			}
		}else{
			$data['addtime'] = $time;
			$data['addip'] = $ip;
			$result = $articles->add($data);
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
			M("Upfiles")->where(array('fileurl'=>$data['thumbnail']))->save($upfiles_data);
		}
		echo $result;
	}
	//删除文章
	public function delete(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->id)>0){
			$articles = M("Articles");
			$articles_result = $articles->find($_q->id);
			$result = $articles->where(array('id'=>$_q->id))->delete();
			if($result>0){
				//获取文本编辑器中的所有图片
				preg_match_all("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")/", $articles_result['content'],$match);
				$new_arr = array_unique($match[3]);
				if(count($new_arr)>0){
					foreach ($new_arr as $v){
						M("Gallery")->where(array('filepath'=>$v))->delete();
						if(file_exists($v)){
							unlink($v);
						}
					}
				}
			}
		}
		echo $result;
	}
	//获取网站列表模块
	private function getModulesOptions($obj){
		$modules_result = M("Modules")->where(array('is_list'=>1))->select();
		$options = '<select name="modules_id"><option value="0">--请选择--</option>';
		foreach ($modules_result as $v){
			$selected = '';
			if($v['id']==$obj->modules_id){
				$selected = 'selected="selected"';
			}
			$options .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
		}
		$options .= "</select>";
		return $options;
	}
}