<?php
class CashAction extends MainAction {
	
	//会员提现记录
	public function index(){
		$account_cash = D("Account_cash");
		$obj = new stdClass();
		$obj->user_id = $this->users['user_id'];
		// 计算总数 
		$count = $account_cash->getTotalRows($obj);
		// 导入分页类 
		import("ORG.Util.Page"); 
		// 实例化分页类 
		$p = new Page($count, 10); 
		// 分页显示输出 
		$page = $p->show(); 
		$obj->limit = " limit {$p->firstRow},{$p->listRows} ";
		$list = $account_cash->getList($obj);
		foreach ($list as $k=>$v){
			$v['account'] = $this->ModifierDisplay($v['account'], 'account');
			$list[$k] = $v;
		}
		$this->assign("page", $page);
		$this->assign("list", $list);
		$tempData['num'] = $count;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	// 取消提现
	public function cancel(){
		$_q = getParams();
		$o = new stdClass();
		$o->state = 0;
		$o->msg = "";
		if(intval($_q->id)>0){
			$account_cash = M("Account_cash");
			$account_cash_result = $account_cash->field("id,total")->where("id='%d' and user_id='%d' and status=0", $_q->id, $this->users['user_id'])->find();
			if(empty($account_cash_result)){
				$o->msg = "您的操作有误";
			}else{
				//改变提现订单状态（取消提现）
				$account_cash_data = array(
					'id' => $account_cash_result['id'],
					'status' => 3
				);
				$result = $account_cash->save($account_cash_data);
				//解冻提现冻结资金
				if($result>0){
					$account = M("Account");
					$account_result = $account->find($this->users['user_id']);
					$money = $account_cash_result['total'];
					$time = time();
					$ip = get_client_ip();
					$account_log = M("Account_log");
					$account_log_data = array(
						'user_id' => $this->users['user_id'],
						'type' => 'cash_cancel',
						'money' => $money,
						'total' => $account_result['total'],
						'use_money' => $account_result['use_money']+$money,
						'no_use_money' => $account_result['no_use_money']-$money,
						'to_user' => 0,
						'addtime' => $time,
						'addip' => $ip,
						'remark' => date('Y-m-d H:i:s').'取消提现'.$money.'元',
						'op_user' => 0
					);
					$account_data = array(
						'user_id' => $account_result['user_id'],
						'use_money' => $account_log_data['use_money'],
						'no_use_money' => $account_log_data['no_use_money']
					);
					$account->save($account_data);
					$account_log->add($account_log_data);
					$o->state = 1;
					$o->msg = "操作成功";
				}
			}
		}else{
			$o->msg = "您的操作有误";
		}
		echo json_encode($o);
		die();
	}
	
	//会员提现
	public function extraction(){
		$tempData['ul_li'] = $this->getBankOptions();
		$account_result = M("Account")->find($this->users['user_id']);
		$user_result = M("User")->field("user_id,real_status")->find($this->users['user_id']);
		$this->assign("tempData", $tempData);
		$this->assign("account_result", $account_result);
		$this->assign("user_result", $user_result);
		$this->display();	
	}
	
	//会员提交提现申请
	public function submit(){
		$_q = getParams();
		$bank = $_q->selectValue;
		if(empty($bank)){
			$this->error("提现银行不能为空", "javascript:history.go(-1);");
			die();
		}
		$paypasswrod = $_q->paypwd;
		if(empty($paypasswrod)){
			$this->error("交易密码不能为空", "javascript:history.go(-1);");
			die();
		}
		$money = $_q->money;
		if($money<10){
			$this->error("提现金额不在规定的提现范围之内~", "javascript:history.go(-1);");
			die();
		}
		$captcha = $_SESSION['captcha'];
		if($captcha!=$_q->valicode){
			$this->error("验证码输入有误", "javascript:history.go(-1);");
			die();
		}
		$account_bank_result = M("Account_bank")->where("id='%d' and user_id='%d'", $bank, $this->users['user_id'])->find();
		if(empty($account_bank_result)){
			$this->error("您的操作有误", "javascript:history.go(-1);");
			die();	
		}
		$user_result = M("User")->field("user_id,paypassword,username,phone")->find($this->users['user_id']);
		if(empty($user_result)){
			$this->error("您的操作有误", "javascript:history.go(-1);");
			die();
		}
		if($user_result['paypassword']!=md5($paypasswrod)){
			$this->error("交易密码输入有误", "javascript:history.go(-1);");
			die();
		}	
		$account_result = M("Account")->where("user_id='%d'", $this->users['user_id'])->find();
		if(empty($account_result)){
			$this->error("您的操作有误", "javascript:history.go(-1);");
			die();
		}
		if($account_result['use_money']<$money){
			$this->error("提现金额不能大于可用余额", "javascript:history.go(-1);");
			die();
		}
		$time = time();
		$ip = get_client_ip();
		$account_cash_data = array(
			'user_id' => $this->users['user_id'],
			'status' => 0,
			'account' => $account_bank_result['account'],
			'bank' => $account_bank_result['bank'],
			'branch' => $account_bank_result['branch'],
			'total' => $money,
			'money' => $money,
			'fee' => 0.00,
			'addtime' => $time,
			'addip' => $ip
		);
		$result = M("Account_cash")->add($account_cash_data);
		if($result>0){
			$account_log_data = array(
				'user_id' => $this->users['user_id'],
				'type' => 'cash_frozen',
				'money' => $money,
				'total' => $account_result['total'],
				'use_money' => $account_result['use_money']-$money,
				'no_use_money' => $account_result['no_use_money']+$money,
				'to_user' => 0,
				'addtime' => $time,
				'addip' => $ip,
				'remark' => date('Y-m-d H:i:s').'申请提现,冻结：'.$money.'元',
				'op_user' => 0
			);
			$account_data = array(
				'user_id' => $account_result['user_id'],
				'use_money' => $account_log_data['use_money'],
				'no_use_money' => $account_log_data['no_use_money']
			);
			M("Account")->save($account_data);
			M("Account_log")->add($account_log_data);
			$this->success("您的提现申请已经提交，我们将在两个工作日内为您审核", __GROUP__."/Cash.html");			
		}else{
			$this->error("提现申请操作失败", "javascript:history.go(-1);");	
		}
	}
	
	//获取银行下拉菜单
	private function getBankOptions(){
		$obj = new stdClass();
		$obj->user_id = $this->users['user_id'];
		$account_bank_result = D("Account_bank")->getList($obj);
		$li = '';
		foreach ($account_bank_result as $v){
			$account_ext = substr($v['account'], -4);
			$li .= '<li tid="'.$v['id'].'">'.$v['name'].'('.$account_ext.')</li>';
		}
		return $li;
	}
}