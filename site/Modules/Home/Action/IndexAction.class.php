<?php

class IndexAction extends MainAction {

    public function index() {
        //首页banner显示
        $advert_moduls_result = M("Advert_modules")->field("id")->where("modules='%s' and status=1", strtolower(MODULE_NAME))->find();
        $advert_type_id = empty($advert_moduls_result['id']) ? 0 : $advert_moduls_result['id'];
        $advert_result = M("Advert")->where("type_id='%d' and status=1 and position='top'", $advert_type_id)->order("`order` asc")->select();
        $this->assign("advert_list", $advert_result);
        //收益，注册人数统计
        $tender_log_result = M("Tender_log")->field("sum(amount) as sum_amount,sum(wait_amount)-sum(amount) as sum_rate")->find();
        $user_result = M("User")->field("count(*) as sum_reg_num")->find();
        $sum_amount = empty($tender_log_result['sum_amount']) ? 0 : round($tender_log_result['sum_amount'], 2);
        $sum_rate = empty($tender_log_result['sum_rate']) ? 0 : round($tender_log_result['sum_rate'], 2);
        $sum_reg_num = empty($user_result['sum_reg_num']) ? 0 : $user_result['sum_reg_num']; 

        $tempData = array(
            'sum_amount' => $sum_amount,
            'sum_rate' => $sum_rate,
            'sum_reg_num' => $sum_reg_num+703
        );

        $this->assign("tempData", $tempData);
        //最新注册用户
        $user_list = M("User")->field("username")->order('addtime desc')->limit(20)->select();
        $this->assign("user_list", $user_list);
        //热门平台
        $obj = new stdClass();
        $obj->order = " orderby asc,p1.click_num desc ";
        $obj->limit = "8";
        $hot_platform = D("Cooperation_platform")->getList($obj);
        $obj->platform_list = $hot_platform;
        $platform_list = $this->getOne($obj);
        $this->assign("platform_list", $platform_list);

        $modules = M("Modules");
        $articles = M("Articles");
        //统计图表
        $charts = $this->getcharts();
        $this->assign("categories", json_encode($charts['categories']));
        $this->assign("data", json_encode($charts['data']));
        $this->assign("avg", $charts['avg']);
        //投资攻略
        $modules_result = $modules->field("id")->where("nid='raiders' and is_hide=0 and is_list=1")->find();
        $modules_id = empty($modules_result['id']) ? 0 : $modules_result['id'];
        $articles_result = $articles->field("id,modules_id,title,summary,thumbnail,addtime")->where("modules_id='%d' and status=0", $modules_id)->order("id desc")->limit(5)->select();
        $this->assign("articles_list_1", $articles_result);
        //企业动态
        $modules_result = $modules->field("id")->where("nid='dynamic' and is_hide=0 and is_list=1")->find();
        $modules_id = empty($modules_result['id']) ? 0 : $modules_result['id'];
        $articles_result = $articles->field("id,modules_id,title,summary,thumbnail,addtime")->where("modules_id='%d' and status=0", $modules_id)->order("id desc")->limit(5)->select();
        $this->assign("articles_list_2", $articles_result);
        //专家点评
        $modules_result = $modules->field("id")->where("nid='comments' and is_hide=0 and is_list=1")->find();
        $modules_id = empty($modules_result['id']) ? 0 : $modules_result['id'];
        $articles_result = $articles->field("id,modules_id,title,summary,thumbnail,addtime")->where("modules_id='%d' and status=0", $modules_id)->order("id desc")->limit(5)->select();
        $this->assign("articles_list_3", $articles_result);
        //网址公告
        $modules_result = $modules->field("id")->where("nid='notice' and is_hide=0 and is_list=1")->find();
        $modules_id = empty($modules_result['id']) ? 0 : $modules_result['id'];
        $articles_result = $articles->field("id,modules_id,title,addtime")->where("modules_id='%d' and status=0", $modules_id)->order("id desc")->limit(7)->select();
        $this->assign("articles_list_4", $articles_result);
        //合作伙伴
        $links_list = M("Links")->field("webname,logo,weblink")->where("type_id=2 and status=0")->order("id desc")->select();
        $this->assign("links_list", $links_list);    
        $this->display();
    }

    //获取合作平台服务端数据（借款标利率，期限及在投标数量）
    private function getOne($obj) {
        $platform_list = S("index_platform_result");
        if (empty($platform_list)) {
            $platform_list = $obj->platform_list;
            // 请求服务端获取标的列表
            foreach ($platform_list as $k => $v) {
                $v['min_rate'] = 0;
                $v['max_rate'] = 0;
                $v['min_term'] = '0月';
                $v['max_term'] = '0月';
                if (!empty($v['interface_count'])) {
                    $fileurl = $v['interface_count'];
                    // 请求服务端数据
                    $output = http($fileurl, '');
                    $output_list = json_decode($output, true);
                    // 拼接数组	
                    $v['min_rate'] = empty($output_list['min_rate']) ? 0 : is_int($output_list['min_rate']) ? $output_list['min_rate'] : round($output_list['min_rate'], 1);
                    $v['max_rate'] = empty($output_list['max_rate']) ? 0 : is_int($output_list['max_rate']) ? $output_list['max_rate'] : round($output_list['max_rate'], 1);
                    $v['min_term'] = empty($output_list['min_term']) ? '0月' : $output_list['min_term'];
                    $v['max_term'] = empty($output_list['max_term']) ? '0月' : $output_list['max_term'];
                }
                $platform_list[$k] = $v;
            }
            // 设置图标数据缓存时间为24小时
            S("index_platform_result", $platform_list, 30);
        }
        $list = $platform_list;
        return $list;
    }

    // 获取首页收益图表数据
    private function getcharts() {
        $index_charts = S("index_charts");
        if (empty($index_charts)) {
            $platform_list = M("Cooperation_platform")->field("id,interface_avg")->where("status=0 and is_del=0")->order("click_num desc")->select();
            $max = array();
            $min = array();
            $avg = array();
            foreach ($platform_list as $v) {
                if (!empty($v['interface_avg'])) {
                    $fileurl = $v['interface_avg'];
                    // 请求服务端数据
                    $result = http($fileurl, '');
                    $output = json_decode($result, true);
                    $max[] = $output['max_rate'];
                    $min[] = $output['min_rate'];
                    $avg[] = $output['avg_rate'];
                }
            }
            $max_rate = max($max);
            $min_rate = min($min);
            $max_rate = is_int($max_rate) ? $max_rate : round($max_rate, 1);
            $min_rate = is_int($min_rate) ? $min_rate : round($min_rate, 1);
            $count = count($platform_list);
            $avg_rate = round(array_sum($avg) / $count, 2);
            $hot_avg_array = array_slice($avg, 0, 8);
            $hot_avg_rate = round(array_sum($hot_avg_array) / $count, 2);
            $index_charts = array(
                'categories' => array('网投所最高收益', '网投所稳健平台', '网投所人气平台', '余额宝平均收益', '银行定存收益'),
                'data' => array(
                    array('y' => $max_rate, 'color' => '#5dc9e5'),
                    array('y' => $min_rate, 'color' => '#5dc9e5'),
                    array('y' => floatval($hot_avg_rate), 'color' => '#5dc9e5'),
                    array('y' => C("BAOBAO_RATE"), 'color' => '#999'),
                    array('y' => C("HUOQI_RATE"), 'color' => '#999')
                ),
                'avg' => $avg_rate
            );
            // 设置图标数据缓存时间为24小时
            S("index_charts", $index_charts, 30);
        }
        return $index_charts;
    }

}
