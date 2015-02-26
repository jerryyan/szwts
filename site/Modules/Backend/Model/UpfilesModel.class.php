<?php
class UpfilesModel extends CommonModel{
	
	//获取平台文件上传日志记录
	public function getList($obj){
		$select = " p1.id,p1.name,p1.status,p1.code,p1.filename,p1.filetype,p1.filesize,p1.fileurl,from_unixtime(p1.addtime) as atime,
		p1.addip,from_unixtime(p1.updatetime) as utime,p1.updateip,p2.username,p2.realname,p3.username as op_username ";
		$sql = " select $select from `{$this->tablePrefix}upfiles` as p1 left join `{$this->tablePrefix}user` as p2 on p1.user_id=p2.user_id 
		left join `{$this->tablePrefix}sys_user` as p3 on p1.op_user=p3.id where 1=1 ";
		if(!empty($obj->username)){
			$sql .= " and p2.username like '%{$obj->username}%' ";
		}
		if(!empty($obj->realname)){
			$sql .= " and p2.realname like '%{$obj->realname}%' ";
		}
		if(!empty($obj->start)){
			$start_time = strtotime($obj->start);
			$sql .= " and p1.addtime>{$start_time} ";
		}
		if(!empty($obj->end)){
			$end_time = strtotime($obj->end);
			$sql .= " and p1.addtime<{$end_time} ";
		}
		$sql .= " order by p1.id desc ";
		$this->_ssql = $sql.$obj->limit;

		return $this->getDataList($select, $sql);
	}

}
?>