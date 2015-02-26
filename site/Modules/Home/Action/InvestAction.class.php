<?php
class InvestAction extends MainAction {

	//借款标列表
	public function index(){
		//获取合作平台数据
		$obj = new stdClass();
		$platform_list = D("Cooperation_platform")->getList($obj);
		//获取安全评级数据
		$grade_list = $this->getGradeList();
		// 获取列表数据
		$obj->platform_list = $platform_list;
		$obj->sortorder = 'desc';
		$list = $this->getList($obj);
		// 计算总数 
		$count = count($list);
		// 导入分页类 
		import("ORG.Util.Page"); 
		// 实例化分页类 
		$p = new Page($count, 10);
		$list = array_slice($list, $p->firstRow,$p->listRows);
		// 分页显示输出 
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign("list", $list);
		// 数据输出				
		$this->assign("grade_list", $grade_list);
		$this->assign("platform_list", $platform_list);
		$this->assign("count", $count);
		$this->display();
	}
	
	// 借款标列表（筛选及排序）
	public function listing(){
		$_q = getParams();
		$grade = empty($_q->grade)?0:$_q->grade;							//安全评级
		$rate = empty($_q->rate)?0:$_q->rate;								//年化收益
		$term = empty($_q->term)?0:$_q->term;								//投资期限
		$from = empty($_q->from)?0:$_q->from;								//标的来源
		$sorttype = empty($_q->sorttype)?0:$_q->sorttype;					//排序类型（1默认按发布时间，2收益率，3借款期限，4投标进度）
		$sortorder = empty($_q->sortorder)?'desc':$_q->sortorder;			//排序方式（asc升序，desc降序）
		$page = empty($_q->page)?1:$_q->page;
		// 获取合作平台数据
		$obj = new stdClass();
		$obj->id = $from;
		$obj->grade = $grade;
		$platform_list = D("Cooperation_platform")->getList($obj);
		// 请求服务端获取数据
		$obj->platform_list = $platform_list;
		$obj->rate = $rate;
		$obj->term = $term;
		$obj->sorttype = $sorttype;
		$obj->sortorder = $sortorder;
		$list = $this->getList($obj);
		$count = count($list);
		$pageNum = 10;
		$firstRow = ($page-1)*$pageNum;
		$list = array_slice($list, $firstRow, $pageNum);
		$data = array(
			'total' => $count,
			'rows' => $list
		);
		echo json_encode($data);
	}
	
	// 请求服务端获取在投标列表
	private function getList($obj){
		$platform_list = $obj->platform_list;
		$rate = $obj->rate;
		$term = $obj->term;
		$sorttype = $obj->sorttype;
		$sortorder = $obj->sortorder;
		//请求服务端获取标的列表
		$params = "";
		/*if(intval($rate)){
			$params .= 'rate='.$rate;
		}
		if(intval($term)){
			$params .= '&term='.$term;
		}*/		
		$users = $this->users;//登录用户信息
		$platforms = $this->getRelationPlat();//用户绑定的平台记录
		$list = array();
		foreach ($platform_list as $k=>$v){
			if(!empty($v['interface_list'])){
				$output = S("investList_".$v['id']);
				if(empty($output)){
					$fileurl = $v['interface_list'];
					//请求服务端数据
					$output = http($fileurl, $params);
					// 设置在投标数据缓存时间为1分钟
					S("investList_".$v['id'], $output, 30);				
				}
				$is_bind = 0;
				if(in_array($v['id'], $platforms)){
					$is_bind = 1;
				}
				if(!empty($output)){
					$output_list = json_decode($output);
					foreach ($output_list as $k2=>$v2){
						$v2 = (array)$v2;
						$v2['platform_id'] = $v['id'];
						$v2['platform_name'] = $v['platform_name'];
						$v2['platform_logo'] = $v['platform_logo'];
						$v2['grade_name'] = $v['grade_name'];
						$v2['config'] = unserialize($v['config']);
						$v2['is_login'] = empty($users['user_id'])?0:1;
						$v2['is_mail'] = $users['email_status'];
						$v2['is_mobile'] = $users['phone_status'];
						$v2['is_bind'] = $is_bind;
						$output_list[$k2] = $v2;
					}
				}
				$list = array_merge($list, $output_list);
			}	
		}	
		//数组排序
		$retime_array = array();						
		$rate_array = array();
		$term_array = array();
		$speed_array = array();
		foreach ($list as $k=>$v){
			if(!empty($rate)){
				if($rate==1 && ($v['interest_rate']>20 || $v['interest_rate']<16)){
					unset($list[$k]);
					continue;
				}
				if($rate==2 && ($v['interest_rate']>16 || $v['interest_rate']<12)){
					unset($list[$k]);
					continue;
				}
				if($rate==3 && ($v['interest_rate']>12 || $v['interest_rate']<8)){
					unset($list[$k]);
					continue;
				}
				if($rate==4 && ($v['interest_rate']>8)){
					unset($list[$k]);
					continue;
				}
			}
			if(!empty($term)){
				if($term==1 && ($v['isday']==0 || $v['term']>30)){
					unset($list[$k]);
					continue;
				}
				if($term>1 && $v['isday']==1){
					unset($list[$k]);
					continue;
				}
				if($term==2 && ($v['term']<1 || $v['term']>3)){
					unset($list[$k]);
					continue;
				}
				if($term==3 && ($v['term']<3 || $v['term']>6)){
					unset($list[$k]);
					continue;
				}
				if($term==4 && ($v['term']<6 || $v['term']>12)){
					unset($list[$k]);
					continue;
				}
				if($term==5 && $v['term']<12){
					unset($list[$k]);
					continue;
				}
			}
			$retime_array[] = $v['retime'];
			$rate_array[] = $v['interest_rate'];
			if($v['isday']==1){
				$term_array[] = $v['term'];
			}else{
				$term_array[] = $v['term']*30;
			}
			$speed_array[] = $v['speed'];
		}
		switch ($sorttype){
			default:
				$args = $retime_array;
				break;
			case 1:
				$args = $rate_array;
				break;
			case 2:
				$args = $term_array;
				break;
			case 3:
				$args = $speed_array;
				break;
		}
		if($sortorder=='desc'){
			$_sort = SORT_DESC;
		}else{
			$_sort = SORT_ASC;
		}
		array_multisort($args, $_sort, $list);
		return $list;
	}
	
	//获取安全评级数据
	private function getGradeList(){
		$grade_result = M("Grade")->field("id,name")->where("status=0 and is_del=0")->select();
		return $grade_result;
	}

	//获取登录用户绑定的平台记录
	private function getRelationPlat(){
		$platforms = array();
		if(!empty($this->users)){
			$Platform_relation = M("Platform_relation");
	    	$platform_relation_result = $Platform_relation->field("platform_id")->where("user_id='%d'", $this->users['user_id'])->select();
	    	foreach($platform_relation_result as $v){
	    		$platforms[] = $v['platform_id'];
	    	}
		}
		return $platforms;
	}
	
}