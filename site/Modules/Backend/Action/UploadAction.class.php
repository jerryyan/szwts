<?php
class UploadAction extends MainAction {

	//上传图片公共页面
	public function page(){
		$_q = getParams();
		if(!empty($_q->type)){
			$savepath = "";
			switch ($_q->type){
				case 'platform':
					$savepath = './static/upload/platform/'.date('Y-m').'/'.date('d').'/';
					break;
				case 'grade':
					$savepath = './static/upload/grade/';
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
				case 'bank':
					$savepath = './static/upload/bank/';
					break;
				case 'articles':
					$savepath = './static/upload/articles/'.date('Y-m').'/'.date('d').'/';
					break;
			}
			$tempData = array(
				'type' => $_q->type,
				'savepath' => $savepath,
				'id' => $_q->id
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
			$result .= 'alert("文件上传失败");';		
		}else{// 上传成功 获取上传文件信息
			$filepath = substr($info[0]['savepath'], 1);
			$filename = $info[0]['savename'];
			$litpic = $filepath.$filename;
			$result .= 'parent.document.getElementById("imageUploadUrl_'.$id.'").src="'.$litpic.'";';
			$result .= 'parent.document.getElementById("imageUploadUrl_'.$id.'").style.display="";';
			$result .= 'parent.document.getElementById("textUploadUrl_'.$id.'").value="'.$litpic.'";';
			//添加文件上传日志记录
			$this->saveUpfiles($info[0]);
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
			'filename' => $info['savename'],
			'filetype' => $info['extension'],
			'filesize' => $info['size'],
			'fileurl' => $filepath.$info['savename'],
			'addtime' => $time,
			'addip' => $ip,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['id']
		);
		$result = M("Upfiles")->add($data);
		return $result;
	}
	//文本编辑器图片上传
	public function saveImage(){
		$inputName = 'filedata';//表单文件域name
		$attachDir = 'static/upload/xheditor';//上传文件保存路径，结尾不要带/
		$dirType = 1;//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
		$maxAttachSize = 512000;//最大上传大小，默认是500KB
		//$upExt = 'txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';//上传扩展名
		$upExt = 'jpg,jpeg,gif,png';//上传扩展名
		$msgType = 2;//返回上传参数的格式：1，只返回url，2，返回参数数组

		$err = "";
		$msg = "''";
		$tempPath = $attachDir.'/'.date("YmdHis").mt_rand(10000,99999).'.tmp';
		$localName = '';
		//HTML5上传
		if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])&&preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)){
			file_put_contents($tempPath, file_get_contents("php://input"));
			$localName = urldecode($info[2]);
		}else{//标准表单式上传
			$upfile = @$_FILES[$inputName];
			if(!isset($upfile)){
				$err = '文件域的name错误';
			}elseif(!empty($upfile['error'])){
				switch($upfile['error']){
					case '1':
						$err = '文件大小超过了php.ini定义的upload_max_filesize值';
						break;
					case '2':
						$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
						break;
					case '3':
						$err = '文件上传不完全';
						break;
					case '4':
						$err = '无文件上传';
						break;
					case '6':
						$err = '缺少临时文件夹';
						break;
					case '7':
						$err = '写文件失败';
						break;
					case '8':
						$err = '上传被其它扩展中断';
						break;
					case '999':
					default:
						$err = '无有效错误代码';
						break;
				}
			}elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none'){
				$err = '无文件上传';
			}else{
				move_uploaded_file($upfile['tmp_name'], $tempPath);
				$localName = $upfile['name'];
			}
		}	
		if($err==''){
			$fileInfo = pathinfo($localName);
			$extension = $fileInfo['extension'];
			if(preg_match('/^('.str_replace(',','|',$upExt).')$/i', $extension)){
				$bytes = filesize($tempPath);
				if($bytes > $maxAttachSize){
					$err = '请不要上传大小超过'.($maxAttachSize/1024).'KB的文件';
				}else{
					switch($dirType){
						case 1: $attachSubDir = 'day_'.date('ymd'); break;
						case 2: $attachSubDir = 'month_'.date('ym'); break;
						case 3: $attachSubDir = 'ext_'.$extension; break;
					}
					$attachDir = $attachDir.'/'.$attachSubDir;
					if(!is_dir($attachDir)){
						@mkdir($attachDir, 0777);
						@fclose(fopen($attachDir.'/index.htm', 'w'));
					}
					PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
					$newFilename = date("YmdHis").mt_rand(1000,9999).'.'.$extension;
					$targetPath = $attachDir.'/'.$newFilename;
					
					rename($tempPath,$targetPath);
					@chmod($targetPath,0755);
					$targetPath = $this->jsonString($targetPath);
					//保存上传的图片信息入数据库
					$gallery = M("Gallery");
					$gallery_data = array(
						'name' => $newFilename,
						'extension' => $extension,
						'filesize' => $bytes,
						'filepath' => stripslashes($targetPath),
						'addtime' => time(),
						'addip' => get_client_ip(),
						'op_user' => $this->users['id']
					);
					$id = $gallery->add($gallery_data);
					if($msgType==1){
						$msg = "'$targetPath'";
					}else{ 
						$msg = "{'url':'/".$targetPath."','localname':'".$this->jsonString($localName)."','id':'$id'}";//id参数固定不变，仅供演示，实际项目中可以是数据库ID
					}
				}
			}
			else $err = '上传文件扩展名必需为：'.$upExt;
		
			@unlink($tempPath);
		}
		
		echo "{'err':'".$this->jsonString($err)."','msg':".$msg."}";
	}
	private function jsonString($str){
		return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
	}
}