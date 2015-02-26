<?php
class PlatformAction extends MainAction {
	
	// 合作平台列表
	public function index(){
		// 计算总数 
		$cooperation_platform_result = M("Cooperation_platform")->field("count(*) as num")->find();
		$count = $cooperation_platform_result['num'];		
		// 导入分页类 
		import("ORG.Util.Page"); 
		// 实例化分页类 
		$p = new Page($count, 10); 
		// 分页显示输出 
		$page = $p->show(); 
		$user_id = $this->users['user_id'];
		$list = M("Cooperation_platform")->field("id,name")->where("status=0 and is_del=0")->limit("{$p->firstRow},{$p->listRows}")->select();
		$relations = M("Platform_relation")->field("platform_id,relation_name,addtime")->where("user_id='%d'", $user_id)->select();
		foreach ($list as $k=>$v){
			$v['status'] = 0;
			$v['username'] = '';
			$v['type'] = '';
			$v['addtime'] = '';
			foreach ($relations as $k2=>$v2){
				if($v['id']==$v2['platform_id']){
					$v['status'] = 1;
					$v['username'] = $v2['relation_name'];
					$v['type'] = '网投所账户绑定';
					$v['addtime'] = $v2['addtime'];
				}
			}
			$list[$k] = $v;
		}
		$this->assign("page", $page);
		$this->assign("list", $list);
		$tempData['num'] = $count;
		$this->assign("tempData", $tempData);
		$this->display();
	}

}