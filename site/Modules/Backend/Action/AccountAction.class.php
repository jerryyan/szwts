<?php
class AccountAction extends MainAction{
	//客户资金账户列表页面
	public function index(){
		$this->display();
	}
	//获取客户资金账户列表
	public function getAccountList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->start = $_q->start_time;
		$obj->end = $_q->end_time;
		$obj->islock = $_q->islock;
		$obj->limit = $_q->limit;
		$obj->operation = $_q->operation;
		$obj->check = $_q->check;
		
		$result = D("Account")->getAccountList($obj);
		
		//导出excel
		if(!empty($obj->operation)){
			$status = array("正常","冻结");
			$title = array("序号","用户ID","用户名","真实姓名","帐号状态","总余额","可用余额","冻结金额","推荐奖励");
			foreach ($title as $k=>$v){
				$title[$k] = iconv("utf-8", "gb2312", $v);
			}
			foreach ($result['rows'] as $k=>$v){
				foreach ($v as $k2=>$v2){
					if($k2=="islock"){
						$v2 = $status[$v2];
					}
					$v[$k2] = iconv('utf-8', 'gbk', trim($v2));
				}
				$_data[$k] = array(
					$k+1,$v['user_id'],$v['username'],$v['realname'],$v['islock'],$v['total'],$v['use_money'],$v['no_use_money'],$v['recommend_reward']
				);
			}
			exportData(iconv('utf-8', 'gb2312', "客户资金账户信息"),$title,$_data);
			die();
		}
		
		$o = (object)$result;
		echo json_encode($o);
	}
	//客户提现记录页面
	public function cash(){
		$this->display();
	}
	//客户提现列表
	public function getCashList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->start = $_q->start_time;
		$obj->end = $_q->end_time;
		$obj->status = $_q->status;
		$obj->limit = $_q->limit;
		$obj->operation = $_q->operation;

		$result = D("Account")->getCashList($obj);
		
		//导出excel
		if(!empty($obj->operation)){
			$status = array('等待审核','审核通过','审核失败','提现取消');
			$title = array("序号","用户ID","用户名","真实姓名","提现帐号","银行","提现支行","可用余额","提现金额","到账金额","手续费","状态","提交时间","审核时间","审核人");
			foreach ($title as $k=>$v){
				$title[$k] = iconv("utf-8", "gbk", $v);
			}
			foreach ($result['rows'] as $k=>$v){
				foreach ($v as $k2=>$v2){
					if($k2=="status"){
						$v2 = $status[$v2];
					}
					$v[$k2] = iconv('utf-8', 'gbk', trim($v2));
				}
				$_data[$k] = array(
					$k+1,$v['user_id'],$v['username'],$v['realname'],'['.$v['account'].']',$v['name'],
					$v['branch'],$v['use_money'],$v['total'],$v['money'],$v['fee'],$v['status'],$v['atime'],$v['vtime'],$v['realname2']
				);
			}
			exportData(iconv('utf-8', 'gb2312', "客户提现记录"),$title,$_data);
			die();
		}
		
		$o = (object)$result;
		echo json_encode($o);
	}
	//审核与查看客户提现页面
	public function editcash(){
		$_q = getParams();
		if(intval($_q->id)>0){
			$cash_result = D("Account_cash")->getAccountCashOne($_q);
			$this->assign("tempData", $cash_result);
		}
		$this->display();
	}
	//审核客户提现操作
	public function changeCash(){
		$_q = getParams();
		$result = 0;
		$users = $this->users;
		if(intval($_q->id)){
			$time = time();
			$ip = get_client_ip();
			$account_cash_data = array(
				'status' => $_q->status,
				'verify_userid' => $users['id'],
				'verify_remark' => $_q->verify_remark,
				'verify_time' => $time
			);
			$account_cash = M("Account_cash");
			$status = $_q->status;
			$result = $account_cash->where("id='%d' and status=0", $_q->id)->save($account_cash_data);
			if($result>0){
				$account_cash_result = $account_cash->find($_q->id);
				$user_id = $account_cash_result['user_id'];
				$total = $account_cash_result['total'];
				$fee = $account_cash_result['fee'];
				$addtime = $account_cash_result['addtime'];
				$account = M("Account");
				$account_log = M("Account_log");	
				$time = time();
				$ip = get_client_ip();
				$account_result = $account->find($user_id);
				if($status==1){
					$account_log_data = array(
						'user_id' => $user_id,
						'type' => "cash_success",
						'money' => $total,
						'total' => $account_result['total']-$total,
						'use_money' => $account_result['use_money'],
						'no_use_money' => $account_result['no_use_money']-$total,
						'to_user' => 0,
						'addtime' => $time,
						'addip' => $ip,
						'remark' => $_q->verify_remark,
						'op_user' => $users['id']
					);
					$account_data = array(
						'user_id' => $account_result['user_id'],
						'total' => $account_log_data['total'],
						'no_use_money' => $account_log_data['no_use_money']					
					);
					$account->save($account_data);
					$account_log->add($account_log_data);
				}else{
					$type = "cash_false";
					$remark = "审核失败";
					$account_log_data = array(
						'user_id' => $user_id,
						'type' => $type,
						'money' => $total,
						'total' => $account_result['total'],
						'use_money' => $account_result['use_money']+$total,
						'no_use_money' => $account_result['no_use_money']-$total,
						'to_user' => 0,
						'addtime' => $time,
						'addip' => $ip,
						'remark' => $_q->verify_remark,
						'op_user' => $users['id']
					);
					$account_data = array(
						'user_id' => $account_result['user_id'],
						'use_money' => $account_log_data['use_money'],
						'no_use_money' => $account_log_data['no_use_money']					
					);
					$account->save($account_data);
					$account_log->add($account_log_data);
				}
			}
		}
		echo $result;
	}
	//客户资金明细列表页面
	public function log(){
		$obj = new stdClass();
		$linkage_result = A("Linkage")->getCache();
		$operates = $linkage_result['account_type'];
		$options = "<option value='0'>全部</option>";	
		foreach ($operates as $k=>$v){
			$options .= '<option value="'.$v['value'].'">'.$v['name'].'</option>';
		}
		$this->assign('log_options', $options);	
		$this->display();
	}
	//获取客户资金使用记录列表
	public function getAccountLogList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->start = $_q->start_time;
		$obj->end = $_q->end_time;
		$obj->operate_type = $_q->operate_type;
		$obj->islock = $_q->islock;
		$obj->limit = $_q->limit;
		$obj->operation = $_q->operation;
		$account = D("Account");
		$linkage_result = A("Linkage")->getCache();	
		foreach ($linkage_result['account_type'] as $k=>$v){
			$operates[$v['value']] = $v['name'];
		}
		$result = $account->getAccountLogList($obj);
		$rows = $result['rows'];
		
		//导出excel
		if(!empty($obj->operation)){
			$title = array("序号","用户ID","用户名","真实姓名","操作类型","账户总额","操作金额","可用余额","冻结总额","待收总额","操作时间","操作ip");
			foreach ($title as $k=>$v){
				$title[$k] = iconv("utf-8", "gb2312", $v);
			}
			foreach ($rows as $k=>$v){
				$v['types'] = $operates[$v['type']];
				foreach ($v as $k2=>$v2){
					$v[$k2] = iconv('utf-8', 'gbk', trim($v2));
				}
				$_data[$k] = array(
					$k+1,$v['user_id'],$v['username'],$v['realname'],$v['types'],$v['total'],$v['money'],
					$v['use_money'],$v['no_use_money'],$v['collection'],$v['atime'],$v['addip']
				);
			}
			exportData(iconv('utf-8', 'gb2312', "客户资金使用记录"),$title,$_data);
			die();
		}
		foreach ($rows as $k=>$v){
			$rows[$k]['types'] = $operates[$v['type']];	
		}	
		$o = (object)$result;
		$o->rows = $rows;
		echo json_encode($o);
	}
	//会员邀请注册列表页面
	public function invitation(){
		$this->display();
	}
	//获取会员邀请注册列表
	public function getInvitationList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->uname = $_q->uname;
		$obj->username = $_q->username;
		$obj->limit = $_q->limit;
		
		$result = D("Account")->getInvitationList($obj);
		
		$o = (object)$result;
		echo json_encode($o);
	}
	//发放会员邀请奖励
	public function editInvitation(){
		$_q = getParams();
		$uid = $_q->user_id;
		$result = 0;
		if(intval($uid)>0){
			$user_result = D("Account")->getInvitationOne($_q);
			if(!empty($user_result['invite_userid'])){
				$users = $this->users;
				$user_id = $user_result['invite_userid'];
				$username = $user_result['username'];
				$money = C("invitation_money");
				$result = M("User")->save(array('user_id'=>$uid, 'invite_money'=>$money));
				if($result>0){
					$time = time();
					$ip = get_client_ip();
					$account = M("Account");
					$account_log = M("Account_log");
					$account_result = $account->find($user_id);
					$account_log_data = array(
						'user_id' => $user_id,
						'type' => 'recommend_reward',
						'money' => $money,
						'total' => $account_result['total']+$money,
						'use_money' => $account_result['use_money']+$money,
						'no_use_money' => $account_result['no_use_money'],
						'to_user' => 0,
						'addtime' => $time,
						'addip' => $ip,
						'remark' => "邀请好友【".$username."】的奖励结算",
						'op_user' => $users['id']
					);
					$account_data = array(
						'user_id' => $account_result['user_id'],
						'total' => $account_log_data['total'],
						'use_money' => $account_log_data['use_money']					
					);
					$account->save($account_data);
					$account_log->add($account_log_data);
				}
			}
		}
		echo $result;
	}			
}