<?php
class PlatformAction extends MainAction {

	//合作平台列表
	public function index(){
		$grade = empty($_q->grade)?0:$_q->grade;							//安全评级
		$rate = empty($_q->rate)?0:$_q->rate;								//年化收益
		$term = empty($_q->term)?0:$_q->term;								//投资期限
		$sorttype = empty($_q->sorttype)?0:$_q->sorttype;					//排序类型（1默认按发布时间，2收益率，3借款期限，4投标进度）
		$sortorder = empty($_q->sortorder)?'desc':$_q->sortorder;			//排序方式（asc升序，desc降序）
		$page = empty($_q->page)?1:$_q->page;
		//获取合作平台数据
		$obj = new stdClass();
		$platform_list = D("Cooperation_platform")->getList($obj);
		//获取安全评级数据
		$grade_list = $this->getGradeList();
		// 获取列表数据
		$obj->platform_list = $platform_list;
		$obj->sortorder = 'desc';
		$list = $this->getCount($obj);
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
		$this->assign("count", $count);
		$this->display();
	}
	
	// 合作平台列表（筛选及排序）
	public function listing(){
		$_q = getParams();
		$grade = empty($_q->grade)?0:$_q->grade;							//安全评级
		$rate = empty($_q->rate)?0:$_q->rate;								//年化收益
		$term = empty($_q->term)?0:$_q->term;								//投资期限
		$sorttype = empty($_q->sorttype)?0:$_q->sorttype;					//排序类型（1默认按发布时间，2收益率，3借款期限，4可投标数）
		$sortorder = empty($_q->sortorder)?'desc':$_q->sortorder;			//排序方式（asc升序，desc降序）
		$page = empty($_q->page)?1:$_q->page;
		// 获取合作平台数据
		$obj = new stdClass();
		$obj->grade = $grade;
		$platform_list = D("Cooperation_platform")->getList($obj);
		// 请求服务端获取数据
		$obj->platform_list = $platform_list;
		$obj->rate = $rate;
		$obj->term = $term;
		$obj->sorttype = $sorttype;
		$obj->sortorder = $sortorder;
		$list = $this->getCount($obj);
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
	
	
	// 合作平台详情
	public function details(){
		$_q = getParams();
		if(!intval($_q->id)){
			$this->error("您的操作有误", "javascript:history.go(-1);");
			exit;
		}
		$obj = new stdClass();
		$obj->id = $_q->id;
		$platform_result = D("Cooperation_platform")->getOne($obj);
		if(empty($platform_result)){
			$this->error("您的操作有误", "javascript:history.go(-1);");
			exit;	
		}
		/*$charts = array(
			'type_charts' => array(array('name'=>'抵押标', 'y'=>534), array('name'=>'信用标', 'y'=>653), array('name'=>'净值标', 'y'=>895)),
			'term_charts' => array(
				array('name'=>'30天以内', 'y'=>55), 
				array('name'=>'一月到三月', 'y'=>956),
				array('name'=>'三月到六月', 'y'=>897),
				array('name'=>'六月到十二月', 'y'=>654),
				array('name'=>'十二月以上', 'y'=>552)
			),
			'amount_charts' => array(
				array('name'=>'5w以下', 'y'=>36), 
				array('name'=>'5w-15w', 'y'=>55), 
				array('name'=>'15w-30w', 'y'=>88), 
				array('name'=>'30w-50w', 'y'=>98), 
				array('name'=>'50w-100w', 'y'=>32), 
				array('name'=>'100w以上', 'y'=>10)
			),
			'trading_charts' => array(
				'categories' => array('10月17日','10月24日','10月31日','11月7日','1月14日','11月21日','11月28日','12月05日'),
				'amounts' => array(23050000.02, 53050000.33, 33050000.65, 43050000.25, 68050000.89, 63050000.36, 13050000.78, 53050000.69)
			),
			'rate_charts' => array(
				'categories' => array('工商贷', '网投所收录平台', '余额宝'),
				'Averages' => array(15.68, 17.88, 4.12)
			)
		);
		$charts_json = json_encode($charts);*/
		
		// 数据获取（缓存中如果存在则取缓存数据，否则请求服务端获取数据）
		$obj->interface_charts = $platform_result['interface_charts'];
		$obj->name = $platform_result['name'];
		$charts_json = $this->getCharts($obj);
		$this->assign("charstJson", $charts_json);
		
		// 获取平台正在投标的借款
		$obj->platform_list = $platform_result;
		$obj->sortorder = 'desc';
		$list = $this->getList($obj);
		// 计算总数 
		$count = count($list);
		// 导入分页类 
		import("ORG.Util.Page"); 
		// 实例化分页类 
		$p = new Page($count, 10);
		$list = array_slice($list, $p->firstRow, $p->listRows);
		// 分页显示输出 
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign("list", $list);
		// 平台数据输出
		$this->assign("count", $count);
		$this->assign("data", $platform_result);
		$this->assign("pageTitle", '合作平台 -'.$platform_result['name']);
		// 更新平台浏览次数
		D("Cooperation_platform")->updateViewNum($obj);
		
		$this->display();
	}
	
	// 获取指定合作平台在投标列表
	public function invest(){
		$_q = getParams();
		$obj = new stdClass();
		$obj->id = $_q->id;
		$obj->platform_list = D("Cooperation_platform")->getOne($obj);
		$obj->sorttype = $_q->sorttype;
		$obj->sortorder = $_q->sortorder;
		$list = $this->getList($obj);
		$count = count($list);
		$pageNum = 10;
		$page = empty($_q->page)?1:$_q->page;
		$firstRow = ($page-1)*$pageNum;
		$list = array_slice($list, $firstRow, $pageNum);
		$data = array(
			'total' => $count,
			'rows' => $list
		);
		echo json_encode($data);
	}
	
	// 获取合作平台服务端数据（借款标利率，期限及在投标数量）
	private function getCount($obj){
		$platform_list = $obj->platform_list;
		$rate = $obj->rate;
		$term = $obj->term;
		$sorttype = $obj->sorttype;
		$sortorder = $obj->sortorder;
		// 请求服务端获取标的列表
		foreach ($platform_list as $k=>$v){
			$fileurl = $v['interface_count'];
			// 请求服务端数据
			$output = http($fileurl, '');
			$output_list = json_decode($output, true);
			// 拼接数组	
			$v['min_rate'] = empty($output_list['min_rate'])?0:is_int($output_list['min_rate'])?$output_list['min_rate']:round($output_list['min_rate'], 1);
			$v['max_rate'] = empty($output_list['max_rate'])?0:is_int($output_list['max_rate'])?$output_list['max_rate']:round($output_list['max_rate'], 1);
			$v['min_term'] = empty($output_list['min_term'])?'0月':$output_list['min_term'];
			$v['max_term'] = empty($output_list['max_term'])?'0月':$output_list['max_term'];
			$v['sum_num'] = empty($output_list['sum_num'])?0:$output_list['sum_num'];
			$v['config'] = unserialize($v['config']);
			$platform_list[$k] = $v;	
		}
		$list = $platform_list;
		if(!empty($rate) || !empty($term)){	
			foreach ($list as $k=>$v){
				if(!empty($rate)){
					switch ($rate){
						case 1:						
							if(($v['min_rate']<16 && $v['max_rate']<16) || ($v['min_rate']>20 && $v['max_rate']>20)){
								unset($list[$k]);
							}	
							break;
						case 2:
							if(($v['min_rate']<12 && $v['max_rate']<12) || ($v['min_rate']>16 && $v['max_rate']>16)){
								unset($list[$k]);
							}
							break;
						case 3:
							if(($v['min_rate']<8 && $v['max_rate']<8) || ($v['min_rate']>12 && $v['max_rate']>12)){
								unset($list[$k]);
							}
							break;
						case 4:
							if($v['min_rate']>8 && $v['max_rate']>8){
								unset($list[$k]);
							}					
							break;
					}
				}
				if(!empty($term)){
					if(strpos($v['min_term'], '月')>0){
						$min_term = findNum($v['min_term']);//mb_substr($v['min_term'], 0, -1, 'utf-8');
						$min_term = $min_term*30;
					}else{
						$min_term = findNum($v['min_term']);//mb_substr($v['min_term'], 0, -1, 'utf-8');
					}
					if(strpos($v['max_term'], '月')>0){
						$max_term = findNum($v['max_term']);//mb_substr($v['max_term'], 0, -1, 'utf-8');
						$max_term = $max_term*30;					
					}else{
						$max_term = findNum($v['max_term']);//mb_substr($v['max_term'], 0, -1, 'utf-8');
					}
					switch ($term){
						case 1:
							if($min_term>30){
								unset($list[$k]);
							}	
							break;
						case 2:
							if(($min_term<30 && $max_term<30) || ($min_term>90 && $max_term>90)){
								unset($list[$k]);
							}
							break;
						case 3:
							if(($min_term<90 && $max_term<90) || ($min_term>180 && $max_term>180)){
								unset($list[$k]);
							}
							break;
						case 4:
							if(($min_term<180 && $max_term<180) || ($min_term>360 && $max_term>360)){
								unset($list[$k]);
							}
							break;
						case 5:
							if($min_term<360 && $max_term<360){
								unset($list[$k]);
							}	
							break;
					}				
				}
			}
		}
		//数组排序
		$platform_array = array();						
		$max_rate_array = array();
		$min_rate_array = array();
		$min_term_array = array();
		$max_term_array = array();
		$num_array = array();
		foreach ($list as $v){
			$platform_array[] = $v['id'];
			$max_rate_array[] = $v['max_rate'];
			$min_rate_array[] = $v['min_rate'];
			$min_term_array[] = $v['min_term'];
			$max_term_array[] = $v['max_term'];
			$num_array[] = $v['sum_num'];
		}
		switch ($sorttype){
			default:
				$args = $platform_array;
				break;
			case 1:
				if($sortorder=='desc'){
					$args = $max_rate_array;
				}else{
					$args = $min_rate_array;
				}
				break;
			case 2:
				if($sortorder=='desc'){
					$args = $max_term_array;
				}else{
					$args = $min_term_array;
				}
				break;
			case 3:
				$args = $num_array;
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
	
	// 请求服务端获取在投标列表
	private function getList($obj){
		$platform_list = $obj->platform_list;
		$sorttype = $obj->sorttype;
		$sortorder = $obj->sortorder;
		// 请求服务端获取在投标的列表
		$list = array();
		if(!empty($platform_list['interface_list'])){
			$users = $this->users;//登录用户信息
			$fileurl = $platform_list['interface_list'];
			if(!empty($fileurl)){
				$output = S("investList_".$platform_list['id']);
				if(empty($output)){
					// 请求服务器获取在投标数据
					$output = http($fileurl, '');
					// 设置在投标数据缓存时间为1分钟
					S("investList_".$platform_list['id'], $output, 30);
				}
				$is_bind = $this->getIsBind($platform_list['id']);//获取用户在平台的绑定状态
				$output_list = json_decode($output);
				foreach ($output_list as $k2=>$v2){
					$v2 = (array)$v2;
					$v2['platform_id'] = $platform_list['id'];
					$v2['platform_name'] = $platform_list['name'];
					$v2['is_login'] = empty($users['user_id'])?0:1;
					$v2['is_mail'] = $users['email_status'];
					$v2['is_mobile'] = $users['phone_status'];
					$v2['is_bind'] = $is_bind;
					$output_list[$k2] = $v2;
				}
				$list = $output_list;
			}
		}		
		//数组排序
		$retime_array = array();						
		$rate_array = array();
		$term_array = array();
		$speed_array = array();
		foreach ($list as $v){
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
	
	// 获取平台详细页数据图表
	private function getCharts($obj){
		$charts_json = S("chartsJson_".$obj->id);
		if(empty($charts_json)){
			if(!empty($obj->interface_charts)){
				// 获取平台图标统计数据
				$fileurl = $obj->interface_charts;
				// 请求服务端数据
				$output = http($fileurl, '');
				$charts = array();
				if(!empty($output)){
					$output_list = json_decode($output, true);
					$avgs = $this->getAvgRate($obj);
					$charts = array(
						'type_charts' => $output_list['type_charts'],
						'term_charts' => $output_list['term_charts'],
						'amount_charts' => $output_list['amount_charts'],
						'trading_charts' => $output_list['trading_charts'],
						'rate_charts' => array(
							'categories' => array($obj->name, '网投所收录平台', '余额宝'),
							'Averages' => array(floatval($avgs['avg']), $avgs['sum_avg'], C("BAOBAO_RATE"))
						)
					);
					$charts_json = json_encode($charts);
					// 设置图标数据缓存时间为12小时
					S("chartsJson_".$obj->id, $charts_json, 30);
				}
			}
		}
		return $charts_json;	
	}
	
	// 获取平台平均收益
	private function getAvgRate($obj){
		$platform_list = M("Cooperation_platform")->field("id,interface_avg")->where("status=0 and is_del=0")->select();
		$avg = array();
		$this_avg = array();
		foreach ($platform_list as $v){
			if(!empty($v['interface_avg'])){
				$fileurl = $v['interface_avg'];
				// 请求服务端数据
				$result = http($fileurl, '');
				$output = json_decode($result, true);
				$avg[] = $output['avg_rate'];
				$this_avg[$v['id']] = $output['avg_rate'];
			}
		}
		$count = count($platform_list);
		$sum_avg = array_sum($avg)/$count;
		return array(
			'sum_avg' => $sum_avg,
			'avg' => $this_avg[$obj->id]
		);
		
	}
	
	//获取登录用户在指定平台的绑定状态
	private function getIsBind($plat_id){
		$is_bind = 0;
		if(!empty($this->users)){
			$Platform_relation = M("Platform_relation");
	    	$platform_relation_result = $Platform_relation->field("platform_id")->where("user_id='%d' and platform_id='%d'", $this->users['user_id'], $plat_id)->find();
	    	$is_bind = empty($platform_relation_result['platform_id'])?0:1;
		}
		return $is_bind;
	}
		
	//获取安全评级数据
	private function getGradeList(){
		$grade_result = M("Grade")->field("id,name")->where("status=0 and is_del=0")->select();
		return $grade_result;
	}

}