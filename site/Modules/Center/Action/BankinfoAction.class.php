<?php
class BankinfoAction extends MainAction {
	
	var $user_result;
	
	//未通过实名认证不能进行操作
	public function __construct(){
		parent::__construct();
		$user_result = M("User")->field("realname,real_status")->find($this->users['user_id']);
		if(empty($user_result['real_status'])){
			$this->error("您还未通过实名认证", __GROUP__.'/Safeinfo');
			die();
		}
		$this->user_result = $user_result;
	}

	//银行卡信息
	public function index(){
		$account_bank = D("Account_bank");
		$obj = new stdClass();
		$obj->user_id = $this->users['user_id'];
		// 计算总数 
		$count = $account_bank->getTotalRows($obj);
		// 导入分页类 
		import("ORG.Util.Page"); 
		// 实例化分页类 
		$p = new Page($count, 10); 
		// 分页显示输出 
		$page = $p->show(); 
		$obj->limit = " limit {$p->firstRow},{$p->listRows} ";
		$list = $account_bank->getList($obj);
		foreach ($list as $k=>$v){
			$v['account_hide'] = $this->ModifierDisplay($v['account'], 'account');
			$list[$k] = $v;
		}
		
		$this->assign("page", $page);
		$this->assign("list", $list);
		$this->display();
	}
	
	//新增银行卡
	public function add(){
		$tempData['ul_li'] = $this->getBankOptions();
		$tempData['realname'] = $this->user_result['realname'];
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
	//修改银行卡信息
	public function modify(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$ul_li = $this->getBankOptions();
			$account_bank_result = M("Account_bank")->find($_q->id);
			$account_bank_result['realname'] = $this->user_result['realname'];
			$account_bank_result['ul_li'] = $ul_li;
			$account_bank_result['account_hide'] = $this->ModifierDisplay($account_bank_result['account'], 'account');
			$linkage_result = M("Linkage")->field("name")->find($account_bank_result['bank']);
			$account_bank_result['bank_name'] = $linkage_result['name'];
			$this->assign("tempData", $account_bank_result);	
		}
		$this->display();
	}
	
	//保存银行卡信息（新增）
	public function save(){
		$_q = getParams();
		$o = new stdClass();
		$o->state = 0;
		$o->msg = "";
		if(empty($_q->bank)){
			$o->msg = "请选择开户银行";
			echo json_encode($o);
			die();
		}
		if(empty($_q->branch)){
			$o->msg = "开户支行不能为空";
			echo json_encode($o);
			die();	
		}
		$account_bank = M("Account_bank");
		$time = time();
		$ip = get_client_ip();
		//修改银行卡
		if(intval($_q->id)>0){
			$bank_data = array(
				'bank' => $_q->bank,
				'branch' => $_q->branch,
				'updatetime' => $time,
				'updateip' => $ip
			);
			$account_bank_result = $account_bank->field("id")->where("user_id='%d' and id!='%d' and bank='%d'", $this->users['user_id'], $_q->id, $_q->bank)->find();
			if(!empty($account_bank_result)){
				$o->msg = "你已经有绑定".$_q->bank_name."的账号";
				echo json_encode($o);
				die();
			}
			$account_bank_result = $account_bank->field("bank")->find($_q->id);
			$result = $account_bank->where("id='%d' and user_id='%d'", $_q->id, $this->users['user_id'])->save($bank_data);
			if($result>0){
				$account_cash_data = array(
					'bank' => $_q->bank,
					'branch' => $_q->branch
				);
				M("Account_cash")->where("user_id='%d' and bank='%d' and status=0", $this->users['user_id'], $account_bank_result['bank'])->save($account_cash_data);
				$o->state = 1;
				$o->msg = "操作成功";
			}else{
				$o->msg = "操作失败";
			}
		}else{//新增银行卡
			$account_len = mb_strlen($_q->account, 'utf-8');
			if($account_len<16 || $account_len>19){
				$o->msg = "银行卡号格式不正确";
				echo json_encode($o);
				die();	
			}
			$account_bank_result = $account_bank->field("id")->where("user_id='%d' and bank='%d'", $this->users['user_id'], $_q->bank)->find();
			if(!empty($account_bank_result)){
				$o->msg = "你已经有绑定".$_q->bank_name."的账号";
				echo json_encode($o);
				die();
			}
			$bank_data = array(
				'user_id' => $this->users['user_id'],
				'bank' => $_q->bank,
				'branch' => $_q->branch,
				'account' => $_q->account,
				'addtime' => $time,
				'addip' => $ip
			);
			$result = $account_bank->add($bank_data);
			if($result>0){
				$o->msg = "操作成功";
				$o->state = 1;
			}else{
				$o->msg = "操作失败";
			}
		}
		echo json_encode($o);
		die();
	}
	
	//删除绑定的银行卡
	public function delete(){
		$_q = getParams();
		$o = new stdClass();
		$o->state = 0;
		$o->msg = "";
		if(intval($_q->id)){
			$account_bank = M("Account_bank");
			$account_bank_result = $account_bank->field("count(1) as num")->where("user_id='%d'", $this->users['user_id'])->find();
			if($account_bank_result['num']==1){
				$o->msg = "至少要保留一个银行提现账户";
				echo json_encode($o);
				exit;
			}
			$account_cash_result = M("Account_cash")->field("group_concat(distinct bank) as bank_ids")->where("user_id='%d'", $this->users['user_id'])->find();
			$cash_bank_ids = 0;
			if(!empty($account_cash_result['bank_ids'])){
				$cash_bank_ids = $account_cash_result['bank_ids'];
			}
			$result = $account_bank->where("id='%d' and user_id='%d' and bank not in(%s)", $_q->id, $this->users['user_id'], $cash_bank_ids)->delete();
			if($result>0){
				$o->state = 1;
				$o->msg = "操作成功";
			}else{
				$o->msg = "操作失败";
			}	
		}else{
			$o->msg = "您的操作有误";
		}
		echo json_encode($o);
		die();
	}
	
	//获取银行下拉菜单
	private function getBankOptions(){
		$linkage = A($this->admin_group."/Linkage");
		$linkage_result = $linkage->getCache();
		$li = '';
		foreach ($linkage_result['account_bank'] as $v){
			$li .= '<li tid="'.$v['id'].'">'.$v['name'].'</li>';
		}
		return $li;
	}
	
}