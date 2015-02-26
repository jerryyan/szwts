<?php
class ArticlesModel extends CommonModel{

	// 更新新闻浏览次数
	public function updateViewNum($obj){
		$sql = " update `{$this->tablePrefix}articles` set click_num=click_num+1 where id='{$obj->id}' ";
		return $this->query($sql);
	}
	
}