<?php
class SysuserAction extends MainAction{
	//后台登录界面
	public function login(){
		$this->display();
	}
	//获取验证码
	public function getValicode(){
		getValicode();	
	}
	//验证后台用户的登录操作
	public function verifylogin(){
		$_q = getParams();
		$o = new stdClass();
		$o->state = 0;
		$o->msg = "";
		$valicode = $_SESSION['captcha'];
		if($valicode != $_q->valicode){
			$o->msg = "验证码不正确";
			echo json_encode($o);
			exit;
		}
		$sys_user = M("Sys_user");
		$username = $_q->uname;
		$password = md5($_q->upwd.C('server_key'));
		$sys_user_result = $sys_user->where("username='%s' and password='%s'", $username, $password)->find();
		$time = strtotime(date('Y-m-d'));
		if(empty($sys_user_result)){
			//判断输入的用户名，邮箱或密码是否存在，存在则记录错误次数
			$result = $sys_user->where("username='%s'", $username)->find();		
			if(!empty($result['id'])){
				$sys_user_data['id'] = $result['id'];
				if($time>$result['login_time']){
					$sys_user_data['login_num'] = 1;				
				}else{
					if($result['login_num']>3){
						$o->msg = "此账号当天连续输入错误3次，已被锁定";
						echo json_encode($o);
						exit;
					}
					$sys_user_data['login_num'] = $result['login_num']+1;
				}
				$sys_user_data['login_time'] = $time;
				$sys_user->save($sys_user_data);
			}
			$o->msg = "用户名或密码不正确，当天连续输入错误3次账号将被锁定";
			echo json_encode($o);
			exit;
		}
		if($sys_user_result['is_locked']>0){
			$o->msg = "您的帐号已被冻结";
			echo json_encode($o);
			exit;
		}
		if($sys_user_result['login_num']>3 && $time==$sys_user_result['login_time']){
			$o->msg = "此账号当天连续输入错误3次，已被锁定";
			echo json_encode($o);
			exit;
		}
		$sys_user_data = array(
			'id' => $sys_user_result['id'],
			'login_num' => 0
		);
		$sys_user->save($sys_user_data);
		$o->state = 1;
		$o->msg = "登录成功";
		$_SESSION["Admin_user"] = $sys_user_result;
		echo json_encode($o);
		exit;
	}
	//系统后台用户管理页面
	public function index(){
		$this->display();
	}
	//获取后台管理用户列表
	public function getUserList(){
		$_q = getParams();
		$obj = new stdClass();
		$users = $this->users;
		$obj->login_role = $users['role_id'];
		$obj->id = $users['id'];
		$obj->limit = $_q->limit;
		$result = D("Sys_user")->getList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
	}
	//新增后台管理员
	public function add(){
		$obj = new stdClass();
		$obj->id = 0;
		$obj->role_id = 0;
		$obj->login_role = $this->users['id'];
		$Sys_user = D("Sys_user");
		$options = $Sys_user->getRoleList($obj);	
		$this->assign("options", $options);
		$this->display();
	}
	//编辑后台管理员信息
	public function edit(){
		$_q = getParams();	
		if(intval($_q->id)){
			$obj = new stdClass();
			$Sys_user = D("Sys_user");
			$obj->id = $_q->id;
			$sys_user_data = $Sys_user->getOne($obj);
			$obj->role_id = $sys_user_data['role_id'];
			$obj->login_role = $this->users['role_id'];
			$options = $Sys_user->getRoleList($obj);	
			$this->assign("options", $options);
			$this->assign('tempData', $sys_user_data);
		}
		$this->display();
	}
	//保存新增或更新后的管理员数据
	public function saveUser(){
		$time = time();
		$ip = get_client_ip();
		$users = $this->users;
		$_q = getParams();
		$data['username'] = $_q->uname;
		empty($_q->upwd) or $data['password'] = md5($_q->upwd.C('server_key'));
		$data['role_id'] = $_q->role;
		$data['email'] = $_q->email;
		$data['is_locked'] = $_q->is_locked;
		if(!empty($_q->avatar)){$data['avatar'] = substr($_q->avatar, strpos($_q->avatar, 'upload/'));}
		$data['nickname'] = $_q->nname;
		$data['fullname'] = $_q->fname;
		$data['phone'] = $_q->phone;
		$data['qq'] = $_q->qq;
		$data['op_user'] = $users['id'];
		$sys_user = M("Sys_user");
		if(intval($_q->id)>0){
			$data['id'] = $_q->id;
			//如果更换头像则删除之前的图像（不包括默认头像）
			$sys_user_result = $sys_user->find($_q->id);
			//更新数据
			$result = $sys_user->save($data);
			if($result>0){
				if(!empty($data['avatar']) && $sys_user_result['avatar']!=$data['avatar']){
					$filename = 'static/'.$sys_user_result['avatar'];
					if(file_exists($filename)){
						unlink($filename);
						//更新文件上传日志记录
						$upfiles_data = array(
							'name' => GROUP_NAME,
							'code' => __METHOD__,
							'status' => 2,
							'updatetime' => $time,
							'updateip' => $ip,
						);
						M("Upfiles")->where(array('fileurl'=>$sys_user_result['avatar']))->save($upfiles_data);	
					}
				}
			}
		}else{
			//新增数据
			$data['addtime'] = $time;
			$result = $sys_user->add($data);
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
			M("Upfiles")->where(array('fileurl'=>$data['avatar']))->save($upfiles_data);
		}
		echo $result;
	}
}