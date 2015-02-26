<?php
/**
 * 操作日志管理
 * Enter description here ...
 * @author win764
 *
 */
class JournalAction extends MainAction{
	//文件上传日志
	public function upfiles(){
		$this->display();
	}
	//获取文件上传日志列表数据
	public function getUpfilesList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->start = $_q->start_time;
		$obj->end = $_q->end_time;
		$obj->limit = $_q->limit;
		
		$result = D("Upfiles")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//邮件通知日志
	public function email(){
		$this->display();
	}
	//获取邮件通知日志记录
	public function getEmailList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->start = $_q->start_time;
		$obj->end = $_q->end_time;
		$obj->limit = $_q->limit;
		
		$result = D("User_sendemail_log")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
	//短信通知日志
	public function phone(){
		$this->display();
	}
	//获取短信通知日志记录
	public function getPhoneList(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->username = $_q->username;
		$obj->realname = $_q->realname;
		$obj->phone = $_q->phone;
		$obj->start = $_q->start_time;
		$obj->end = $_q->end_time;
		$obj->limit = $_q->limit;
		
		$result = D("Phone_sendlog")->getList($obj);
		$o = (object)$result;
		echo json_encode($o);
	}
}