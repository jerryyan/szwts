<?php
class UserAction extends MainAction{
	
	//用户信息列表页面
	public function Index(){
		$this->display();
	}
	
	//获取用户信息列表
	public function getUserList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->start = $_q->start_time;
		$obj->end = $_q->end_time;
		$obj->email = $_q->email;
		$obj->phone = $_q->phone;
		$obj->islock = $_q->islock;
		$obj->limit = $_q->limit;
		
		$result = D("User")->getUserList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
		
	}
	
	//新增用户页面
	public function add(){
		$this->display();
	}
	
	//编辑用户页面
	public function edit(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$result = M("User")->find($_q->id);
			$this->assign("tempData", $result);
		}
		$this->display();
	}
	
	//检测用户名，邮箱和手机号码
	public function checkUser(){
		$_q = getParams();
		$result = 0;
		if(!empty($_q->username)){
			$where = " username='{$_q->username}' ";
		}
		if(!empty($_q->email)){
			$where = " email='{$_q->email}' ";
		}
		if(!empty($_q->phone)){
			$where = " phone='{$_q->phone}' ";
		}
		if(!empty($_q->card_id)){
			$where = " card_id='{$_q->card_id}' ";
		}
		if(!empty($_q->card_id) && !empty($_q->user_id)){
			$where = " user_id!='{$_q->user_id}' and card_id='{$_q->card_id}' ";
		}	
		if(!empty($where)){
			$user_result = M("User")->where($where)->find();
			$result = empty($user_result['user_id'])?0:$user_result['user_id'];
			echo $result;
			die();
		}	
	}
	
	//更新用户数据时检测邮箱和手机号码
	public function checkUpdateUser(){
		$_q = getParams();
		$result = 0;
		$obj = new stdClass();
		$obj->user_id = $_q->user_id;
		if(!empty($_q->email)){
			$obj->email = $_q->email;
		}
		if(!empty($_q->phone)){
			$obj->phone = $_q->phone;
		}
		$result = D("User")->getOne($obj);
		echo $result;
	}

	//保存用户资料
	public function save(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$data = array();
		$data['email'] = $_q->email;
		$data['phone'] = $_q->phone;
		$data['email_status'] = $_q->email_status;
		$data['phone_status'] = $_q->phone_status;
		$data['scene_status'] = $_q->scene_status;
		$data['uptime'] = $time;
		$data['upip'] = $ip;
		$user = M("User");
		$change = 0;
		if(intval($_q->user_id)){
			$data['user_id'] = $_q->user_id;
			$data['login_num'] = $_q->login_num;
			$data['login_time'] = strtotime(date('Y-m-d'));
			if(!empty($_q->password)){
				$data['password'] = md5(C("front_server_key").$_q->password);
			}
			//判断是否有提交实名
			if(!empty($_q->realname) && !empty($_q->card_id) && !empty($_q->card_pic1) && !empty($_q->card_pic2)){
				$user_result = $user->where("user_id='%d' and card_type=0", $_q->user_id)->find();
				if(!empty($user_result)){
					$sex = (int)substr($_q->card_id, 16, 1);
					$data['realname'] = $_q->realname;
					$data['card_id'] = $_q->card_id;
					$data['sex'] = $sex%2===0?2:1;
					$data['birthday'] = strtotime(substr($_q->card_id, 6, 8));
					$data['card_pic1'] = substr($_q->card_pic1, strpos($_q->card_pic1, 'upload/'));
					$data['card_pic2'] = substr($_q->card_pic2, strpos($_q->card_pic2, 'upload/'));
					$data['card_type'] = 1;
					$change = 1;
				}
			}
			$data['islock'] = $_q->islock;
			$result = $user->save($data);
			if($result>0 && $change==1){
				//更新文件上传日志记录
				$upfiles_data = array(
					'name' => GROUP_NAME,
					'code' => __METHOD__,
					'user_id' => $_q->user_id,
					'status' => 1,
					'updatetime' => $time,
					'updateip' => $ip,
				);
				$result = M("Upfiles")->where("fileurl='%s' or fileurl='%s'", $data['card_pic1'], $data['card_pic2'])->save($upfiles_data);
			}
		}else{
			$data['username'] = $_q->username;
			$data['password'] = md5(C("front_server_key").$_q->password);
			//判断是否有提交实名
			if(!empty($_q->realname) && !empty($_q->card_id) && !empty($_q->card_pic1) && !empty($_q->card_pic2)){
				$sex = (int)substr($_q->card_id, 16, 1);
				$data['realname'] = $_q->realname;
				$data['card_id'] = $_q->card_id;
				$data['sex'] = $sex%2===0?2:1;
				$data['birthday'] = strtotime(substr($_q->card_id, 6, 8));
				$data['card_pic1'] = substr($_q->card_pic1, strpos($_q->card_pic1, 'upload/'));
				$data['card_pic2'] = substr($_q->card_pic2, strpos($_q->card_pic2, 'upload/'));
				$data['card_type'] = 1;
				$change = 1;
			}
			$data['addtime'] = $time;
			$data['addip'] = $ip;
			$result = $user->add($data);
			M("Account")->add(array('user_id'=>$result));
			if($result>0 && $change==1){
				//更新文件上传日志记录
				$upfiles_data = array(
					'name' => GROUP_NAME,
					'code' => __METHOD__,
					'user_id' => $_q->user_id,
					'status' => 1,
					'updatetime' => $time,
					'updateip' => $ip,
				);
				$result = M("Upfiles")->where("fileurl='%s' or fileurl='%s'", $data['card_pic1'], $data['card_pic2'])->save($upfiles_data);
			}
		}
		echo $result;
	}
	
	//获取会员实名信息
	public function realname(){
		$this->display();
	}
	
	//获取会员实名信息列表
	public function getRealList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->status = $_q->status;
		$obj->limit = $_q->limit;
		
		$result = D("User")->getRealList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
	}
	
	//审核与查看实名信息
	public function verify(){
		$_q = getParams();
		if(intval($_q->user_id)){
			$user_result = M("User")->find($_q->user_id);
			$this->assign("tempData", $user_result);
		}
		$this->display();
	}
	
	//保存实名审核记录
	public function saveByReal(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->user_id)){
			$time = time();
			$ip = get_client_ip();
			$user_data = array(
				'user_id' => $_q->user_id,
				'real_status' => $_q->real_status,
				'uptime' => $time
			);
			$result = M("User")->save($user_data);
		}
		echo $result;
	}
	
}