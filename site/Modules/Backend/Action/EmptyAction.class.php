<?php
class EmptyAction extends Action{
	
	//404错误
	public function _empty(){
		header('HTTP/1.1 404 Not Found');
		$this->display("Common/404");
	}
	
}