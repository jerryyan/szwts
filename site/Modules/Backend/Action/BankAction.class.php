<?php
class BankAction extends MainAction {
	
	//会员银行提现账户页面
	public function Index(){
		$options = $this->getBankOptions();
		$this->assign("options", $options);
		$this->display();
	}
	//会员银行提现账户列表
	public function getList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->start = $_q->start_time;
		$obj->end = $_q->end_time;
		$obj->bank = $_q->bank;
		$obj->limit = $_q->limit;
		$result = D("Account_bank")->getList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
	}
	//新增会员提现账户
	public function add(){
		$options = $this->getBankOptions();
		$this->assign("options", $options);
		$this->display();
	}
	//编辑与查看会员提现账户
	public function edit(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$result = D("Account_bank")->getOne($_q);
			$this->assign("tempData", $result);
		}
		$options = $this->getBankOptions();
		$this->assign("options", $options);
		$this->display();
	}
	//保存会员提现账户
	public function save(){
		$_q = getParams();
		$time = time();
		$ip = get_client_ip();
		$users = $this->users;
		$data = array(
			'user_id' => $_q->user_id,
			'account' => $_q->account,
			'bank' => $_q->bank,
			'branch' => $_q->branch,
			'updatetime' => $time,
			'updateip' => $ip,
			'op_user' => $users['id']
		);
		$account_bank = M("Account_bank");
		$result = 0;
		if(intval($_q->id)>0){
			$data['id'] = $_q->id;
			$account_bank_result = $account_bank->where("id!='%d' and user_id='%d' and bank='%d'", $_q->id, $_q->user_id, $_q->bank)->find();
			if(empty($account_bank_result)){
				$account_bank_result = $account_bank->where("id='%d'", $_q->id)->find();
				$result = $account_bank->save($data);
				//修改客户待提现中的银行账户信息
				if($result>0){
					$account_cash_data = array(
						'account' => $_q->account,
						'bank' => $_q->bank,
						'branch' => $_q->branch
					);
					M("Account_cash")->where("user_id='%d' and bank='%d' and status=0", $account_bank_result['user_id'], $account_bank_result['bank'])->save($account_cash_data);
				}
			}
		}else{
			$account_bank_result = $account_bank->where("user_id='%d' and bank='%d'", $_q->user_id, $_q->bank)->find();
			if(empty($account_bank_result)){
				$data['addtime'] = $time;
				$data['addip'] = $ip;
				$result = $account_bank->add($data);
			}
		}
		echo $result;
	}
	//删除会员提现账户
	public function delete(){
		$_q = getParams();
		$result = 0;
		if(intval($_q->id)>0){
			$account_bank = M("Account_bank");
			$account_cash = M("Account_cash");
			$account_bank_result = $account_bank->find($_q->id);
			$account_cash_result = $account_cash->where("user_id='%d' and bank='%d' and status=0", $account_bank_result['user_id'], $account_bank_result['bank'])->find();
			if(empty($account_cash_result)){
				$result = $account_bank->where("id='%d'", $_q->id)->delete();			
			}
		}
		echo $result;
	}
	//获取银行下拉菜单
	private function getBankOptions(){
		$linkage = A("Linkage");
		$obj = new stdClass();				
		$obj->name = 'bank';
		$obj->nid = 'account_bank';
		$obj->id = 0;
		$selects = $linkage->getLinkageHtml($obj);
		return $selects;
	}
}