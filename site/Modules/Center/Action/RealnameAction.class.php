<?php
class RealnameAction extends MainAction {

	//实名认证
	public function index(){
		$user_result = M("User")->field("realname,card_id,card_pic1,card_pic2,card_type,real_status")->find($this->users['user_id']);
		if($user_result['real_status']==1){
			$this->error("您的操作有误", "javascript:history.go(-1)");
			die();
		}
		if($user_result['real_status']==2){
			$this->assign("user_result", $user_result);
		}
		$this->display();
	}
	
	//实名认证（校验实名并保存）
	public function verify(){
		$_q = getParams();	
		$o = new stdClass();
		$o->state = 0;
		$realname_len = mb_strlen($_q->realname, 'utf8');
		$cardid_len = mb_strlen($_q->card_id, 'utf8');
		$card_pic1_len = mb_strlen($_q->card_pic1, 'utf8');
		$card_pic2_len = mb_strlen($_q->card_pic2, 'utf8');
		if($realname_len==0){
			$o->msg = "真实姓名不能为空";
			echo json_encode($o);
			die();
		}
		if($cardid_len!=18){
			$o->msg = "身份证号码格式不正确";
			echo json_encode($o);
			die();
		}
		if($card_pic1_len==0){
			$o->msg = "请上传身份证正面照片";
			echo json_encode($o);
			die();
		}
		if($card_pic2_len==0){
			$o->msg = "请上传身份证反面照片";
			echo json_encode($o);
			die();
		}
		$user = M("User");
		$user_result = $user->where("card_id='%s' and real_status=1", $_q->card_id)->find();
		if(!empty($user_result)){
			$o->msg = "此身份证号码已被绑定";
		}else{
			$card_pic1 = substr($_q->card_pic1, strpos($_q->card_pic1, 'upload/'));
			$card_pic2 = substr($_q->card_pic2, strpos($_q->card_pic2, 'upload/'));
			$sex = (int)substr($_q->card_id, 16, 1);
			$user_data = array(
				'user_id' => $this->users['user_id'],
				'card_type' => 1,
				'realname' => $_q->realname,
				'sex' => $sex%2===0?2:1,
				'birthday' => strtotime(substr($_q->card_id, 6, 8)),
				'card_id' => $_q->card_id,
				'card_pic1' => $card_pic1,
				'card_pic2' => $card_pic2,
				'real_status' => 0
			);
			$result = $user->save($user_data);
			if($result>0){
				//更新文件上传日志记录
				$upfiles_data = array(
					'name' => GROUP_NAME,
					'code' => __METHOD__,
					'user_id' => $this->users['user_id'],
					'status' => 1,
					'updatetime' => $time,
					'updateip' => $ip,
				);
				M("Upfiles")->where("fileurl='%s' or fileurl='%s'", $card_pic1, $card_pic2)->save($upfiles_data);
				$o->state = 1;
				$o->msg = "实名认证信息提交成功";
			}else{
				$o->msg = "操作失败";
			}
		}
		echo json_encode($o);
		die();
	}
	
	//实名认证（查看）
	public function see(){
		$user_result = M("User")->field("realname,sex,card_type,real_status,card_id,card_pic1,card_pic2")->find($this->users['user_id']);
		if($user_result['card_type']==0){
			$this->error("您还未提交实名认证资料", __GROUP__."/Safeinfo");
		}
		if($user_result['real_status']==1){
			$this->error("您的实名已经审核通过", __GROUP__."/Safeinfo");
		}
		$user_result['realname'] = $this->ModifierDisplay($user_result['realname']);
		$user_result['card_id'] = $this->ModifierDisplay($user_result['card_id'], 'card_id');
		$tempData['user_result'] = $user_result;
		$this->assign("tempData", $tempData);
		$this->display();
	}
	
}