<?php
class UploadAction extends MainAction {

	//上传图片公共页面
	public function page(){
		$_q = getParams();
		if(!empty($_q->type)){
			$savepath = "";
			switch ($_q->type){
				case 'attestation':
					$savepath = './static/upload/attestation/'.date('Y-m').'/'.date('d').'/';
					break;
				case 'credit':
					$savepath = './static/upload/credit/';
					break;
				case 'avatar':
					$savepath = './static/upload/avatar/'.date('Y-m').'/'.date('d').'/';
					break;
				case 'advert':
					$savepath = './static/upload/advert/'.date('Y-m').'/'.date('d').'/';
					break;
				case 'links':
					$savepath = './static/upload/links/';
					break;
			}
			$tempData = array(
				'id' => $_q->id,
				'type' => $_q->type,
				'savepath' => $savepath
			);
			$this->assign("tempData", $tempData);
		}
		$this->display();
	}
	
	//保存上传的图片到服务器
	public function save(){
		$_q = getParams();
		$id = $_q->id;
		$type = $_q->type;
		$savepath = $_q->savepath;
		$file = $_FILES['file'];
		$name = $file['name'];
		$extension = explode('.', $name);
		import("ORG.Net.UploadFile");
 		$upload = new UploadFile();								// 实例化上传类
		$upload->maxSize  = 500*1024;						// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'jpeg', 'png');		// 设置附件上传类型
		// 设置附件上传目录
		$upload->savePath =  $savepath;
		$result = '<script>';
		$url = __GROUP__.'/Upload';
		$iframe = "<iframe name='iframeUpload' src='".$url."/page/type/".$type."/id/".$id."' width='100px' height='30px' frameborder='no' scrolling='no'></iframe>";
		$info = $upload->uploadOne($file);
		if(!is_array($info)) {// 上传错误提示错误信息
			$result .= 'parent.layer.alert("文件上传失败", 8);';		
		}else{// 上传成功 获取上传文件信息
			$filepath = substr($info[0]['savepath'], 1);
			$filename = $info[0]['savename'];
			$litpic = $filepath.$filename;
			$result .= 'parent.document.getElementById("imageUploadUrl_'.$id.'").src="'.$litpic.'";';
			$result .= 'parent.document.getElementById("imageUploadUrl_'.$id.'").style.display="";';
			$result .= 'parent.document.getElementById("textUploadUrl_'.$id.'").value="'.$litpic.'";';
			//添加文件上传日志记录
			$this->saveUpfiles($info[0]);
			//保存图片路径到数据库
			switch ($type){
					case 'avatar'://保存用户头像
					$user_data = array(
						'user_id' => $this->users['user_id'],
						'avatar' => $litpic
					);
					$this->saveAvatar($user_data);
					break;
			}
		}
		$result .= 'parent.document.getElementById("iframeUploadPanel_'.$id.'").innerHTML="'.$iframe.'";';
		$result .= 'parent.document.getElementsByTagName("iframe")['.($id-1).'].remove();';
		$result .= '</script>';
		echo $result;die();
	}
	
	//添加文件上传日志记录
	private function saveUpfiles($info){
		$filepath = substr($info['savepath'], strpos($info['savepath'], 'upload/'));
		$time = time();
		$ip = get_client_ip();
		$users = $this->users;
		$data = array(
			'name' => GROUP_NAME,
			'code' => __METHOD__,
			'user_id' => $users['user_id'],
			'filename' => $info['savename'],
			'filetype' => $info['extension'],
			'filesize' => $info['size'],
			'fileurl' => $filepath.$info['savename'],
			'addtime' => $time,
			'addip' => $ip,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['user_id']
		);
		$result = M("Upfiles")->add($data);
		return $result;
	}
	
	//保存用户头像
	private function saveAvatar($data){
		if(intval($data['user_id'])>0){
			$user = M("User");
			$data['avatar'] = substr($data['avatar'], strpos($data['avatar'], 'upload/'));
			//如果更换头像则删除之前的图像（不包括默认头像）
			$user_result = $user->find($data['user_id']);
			//更新数据
			$result = $user->save($data);
			if($result>0){
				if(!empty($data['avatar']) && $user_result['avatar']!=$data['avatar']){
					$filename = 'static/'.$user_result['avatar'];
					if(file_exists($filename)){
						$result = unlink($filename);
						//更新文件上传日志记录
						$upfiles_data = array(
							'name' => GROUP_NAME,
							'code' => __METHOD__,
							'status' => 2,
							'updatetime' => $time,
							'updateip' => $ip,
						);
						M("Upfiles")->where(array('fileurl'=>$user_result['avatar']))->save($upfiles_data);	
					}
				}
				//更新文件上传日志记录
				$upfiles_data = array(
					'name' => GROUP_NAME,
					'code' => __METHOD__,
					'status' => 1,
					'updatetime' => $time,
					'updateip' => $ip,
				);
				M("Upfiles")->where(array('fileurl'=>$data['avatar']))->save($upfiles_data);
			}
		}
	}

}