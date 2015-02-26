<?php
class MainAction extends Action{
	var $users, 
		$route = array(),
		$menus;
	public function __construct(){
		parent::__construct();
		//禁止各大搜索引擎收录后台地址
		if(preg_match("/(Googlebot|Msnbot|YodaoBot|Sosospider|baiduspider|360spider|google|baidu|yahoo|sogou|bing|coodir|soso|youdao|zhongsou|slurp|ia_archiver|scooter|spider|webcrawler|OutfoxBot)/i", $_SERVER['HTTP_USER_AGENT'])){	 
		    header('HTTP/1.1 403 Forbidden');
		    exit;
		}
		$users = $_SESSION['Admin_user'];
		$route = strtolower(GROUP_NAME."-".MODULE_NAME."-".ACTION_NAME);
		$this->route = array(
			'backend-sysuser-login',
			'backend-sysuser-getvalicode',
			'backend-sysuser-verifylogin'
		);
		if(empty($users)){
			if(!in_array($route, $this->route)){
				$this->redirect("Backend/Sysuser/login");
				die();
			}
		}
		$this->users = $users;
		$this->getUserPrivilege($users['role_id']);	
		$this->route[] = 'backend-index-index';
		$this->route[] = 'backend-index-loginout';
		if(!empty($users) && !in_array($route, $this->route)){
			echo '您没有此功能的访问权限~';
			die();
		}
		@ini_set("memory_limit", "128M");
	}
	
	//404错误
	public function _empty(){
		header('HTTP/1.1 404 Not Found');
		$this->display("Common/404");
	}
	
	//获取后台管理权限
	private function getUserPrivilege($role_id){
		$list = D("Sys_privilege")->getUserPrivilege($role_id);   
		$tree = array();
		foreach ($list as $v){
			if(!empty($v['module_name']) && !empty($v['method_name'])){
				$this->route[] = strtolower($v['group_name']."-".$v['module_name']."-".$v['method_name']);
			}
			if($v['is_function']==0){
				$o = new stdClass();
				$o->id = $v['id'];
				$o->name = $v['name'];
				$o->pid = $v['pid'];
				$o->group_name = $v['group_name'];
				$o->module_name = $v['module_name'];
				$o->method_name = $v['method_name'];
				$tree[] = $o;
			}
		}
		
		$_list = array();
		$root = new stdClass();
		$root->id = 0;
		$root->name = '根目录';
		$_list[$root->id] = $root;
		foreach ($tree as $v){
			$_o = $_list[$v->pid];
			if(!isset($_o->children))$_o->children = array();
			$_v = $v;
			$_v->text = $v->name;
			$_v->title = $v->name;
			$_v->attributes = new stdClass();
			$_v->attributes->title = "";
			if(!empty($v->module_name) && !empty($v->method_name)){
				$_v->attributes->title = $v->group_name."/".$v->module_name."/".$v->method_name;
			}
			$_o->children[] = $_v;
			$_list[$v->id] = $_v;
		}
//                echo "<pre>";
//		print_r($_list[0]->children);die();
		$this->menus = json_encode($_list[0]->children);
	}
	
	//发送手机短信（单发）
	protected function sendSmsOne($data){		
		$gwUrl = 'http://api.duanxin.cm/';
		$smsAction = 'action=send';
		$userName = C("SMS_USERNAME");	
		$passWord = C("SMS_PASSWORD");	
		
		$phone_data = array(
			'user_id' => empty($data['user_id'])?0:$data['user_id'],
			'phone' => $data['phone'][0],
			'content' => $data['content'],
			'status' => 0,
			'send_date' => strtotime(date('Y-m-d')),
			'addtime' => time(),
			'addip' => get_client_ip()
		);
		$fileurl = $gwUrl.'?'.$smsAction.'&username='.$userName.'&password='.$passWord.'&phone='.$phone_data['phone'].'&content='.urlencode($phone_data['content']).'&encode=utf8';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $fileurl);        	//设置url
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   	//设置开启重定向支持
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$output = curl_exec($ch);  							//执行
		curl_close($ch);
		$info = strip_tags($output);
		if($info==100){
			$phone_data['status'] = 1;
			M("Phone_sendlog")->add($phone_data);
		}else{
			M("Phone_sendlog")->add($phone_data);
		}
		return $info==100?0:1;
	}
	
}