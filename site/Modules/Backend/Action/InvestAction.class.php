<?php

class InvestAction extends MainAction {

    //客户投资记录
    public function index() {
        $options = $this->getOptions();
        $this->assign("options", $options);
        $this->display();
    }

    //获取客户投资记录
    public function getList() {
        $_q = getParams();
        $obj = new stdClass();
        $obj->plat_id = $_q->plat_id;
        $obj->username = $_q->username;
        $obj->realname = $_q->realname;
        $obj->start = $_q->start_time;
        $obj->end = $_q->end_time;
        $obj->state = $_q->state;
        $obj->limit = $_q->limit;
        $obj->operation = $_q->operation;

        $result = D("Tender_log")->getList($obj);
        //导出excel
        if (!empty($obj->operation)) {
            $status = array("还款中", "已还完", "已逾期");
            $title = array("序号", "订单编号", "平台名称", "用户名", "真实姓名", "项目名称", "投资金额", "待收总额", "投资期限", "年化利率", "投资时间", "还款时间","交易状态");
            foreach ($title as $k => $v) {
                $title[$k] = iconv("utf-8", "gb2312", $v);
            }
            foreach ($result['rows'] as $k => $v) {
                switch ($v['isday']) {
                    default :
                        $v['term'] .= '月';
                        break;
                    case 1:
                        $v['term'] .= '天';
                        break;
                }
                foreach ($v as $k2 => $v2) {
                    if ($k2 == "state") {
                        $v2 = $status[$v2];
                    }
                    $v[$k2] = iconv('utf-8', 'gbk', trim($v2));
                }
                $_data[$k] = array(
                    $k + 1, $v['order_id'], $v['platform_name'], $v['username'], $v['realname'], $v['project_name'], $v['amount'], $v['wait_amount'], $v['term'], $v['rate'], $v['atime'],$v['etime'], $v['state']
                );
            }
            exportData(iconv('utf-8', 'gb2312', "客户投资记录"), $title, $_data);
            die();
        }

        $o = (object) $result;
        echo json_encode($o);
    }

    //远程获取网投所客户在合作平台的投标记录
    public function add() {
        $this->display();
    }

    //远程获取网投所客户在合作平台的投标记录
    public function getRemoteList() {
        $_q = getParams();
        $platform_result = $this->getPlatformList();
        $tender_log = M("Tender_log");
        $state = 0;
        $querydate = 0;
        if (!empty($_q->querydate)) {
            $querydate = strtotime($_q->querydate);
        }
        foreach ($platform_result as $v) {
            if (!empty($v['interface_tender'])) {
                $time = time();
                $data = array(
                    'partner_id' => $v['code'],
                    'time' => $time,
                    'signkey' => $v['signkey']
                );
                $signStr = "";
                $temp = array();
                foreach ($data as $k3 => $v3) {
                    $temp[] = "$k3=$v3";
                }
                $signStr = implode('&', $temp);
                $sign = md5($signStr);
                $url = $v['interface_tender'];
                $params = 'time=' . $data['time'] . '&sign=' . $sign;
                if ($querydate > 0) {
                    $params .= '&querydate=' . $querydate;
                }
                //请求服务端数据
                $output = http($url, $params);
                $output_list = json_decode($output);
                foreach ($output_list as $v2) {
                    $v2 = (array) $v2;
                    $tender_log_result = $tender_log->field("order_id,state")->where("order_id='%s' and platform_id='%d'", $v2['id'], $v['id'])->find();
                    if (!intval($tender_log_result['order_id'])) {
                        $tender_log_data = array(
                            'order_id' => $v2['id'],
                            'platform_id' => $v['id'],
                            'username' => $v2['username'],
                            'project_name' => $v2['project_name'],
                            'amount' => $v2['amount'],
                            'wait_amount' => $v2['wait_amount'],
                            'rate' => $v2['rate'],
                            'isday' => $v2['isday'],
                            'term' => $v2['term'],
                            'state' => 0,
                            'addtime' => $v2['addtime'],
                            'repaytime' => $v2['repaytime']
                        );
                        $tender_log->add($tender_log_data);
                        $state ++;
                    }
                }
            }
        }
        echo $state;
    }

    //获取客户今日待还款列表
    public function repay() {
        $options = $this->getOptions();
        $this->assign("options", $options);
        $this->display();
    }

    //获取客户今日待还款列表
    public function getRepayList() {
        $_q = getParams();
        $obj = new stdClass();
        $obj->plat_id = $_q->plat_id;
        $obj->username = $_q->username;
        $obj->realname = $_q->realname;
        $obj->limit = $_q->limit;

        $result = D("Tender_log")->getRepayList($obj);
        $o = (object) $result;
        echo json_encode($o);
    }

    //更新客户投资合作平台的投资状态
    public function update() {
        $this->display();
    }

    //远程更新客户投标记录（交易状态）
    public function updateTenderlog() {
        $_q = getParams();
        $platform_result = $this->getPlatformList();
        $tender_log = M("Tender_log");
        $state = 0;
        $querydate = 0;
        if (!empty($_q->querydate)) {
            $querydate = strtotime($_q->querydate);
        }
        foreach ($platform_result as $v) {
            if (!empty($v['interface_update'])) {
                $url = $v['interface_update'];
                $params = '';
                if ($querydate > 0) {
                    $params .= 'querydate=' . $querydate;
                }
                //请求服务端数据
                $output = http($url, $params);
                $output_list = json_decode($output);
                foreach ($output_list as $v2) {
                    $v2 = (array) $v2;
                    if ($v2['state'] == 1) {
                        $result = $tender_log->where("order_id='%s' and platform_id='%d' and state=0 ", $v2['id'], $v['id'])->save(array('state' => 1));
                        if ($result > 0) {
                            $state ++;
                        }
                    }
                }
            }
        }
        echo $state;
    }

    //获取网投所合作平台信息
    private function getPlatformList() {
        $platform_result = M("Cooperation_platform")->field("id,name,code,signkey,interface_tender,interface_update")->select();
        return $platform_result;
    }

    //合作平台下拉列表
    private function getOptions() {
        $list = $this->getPlatformList();
        $options = '<option value="0">全部</option>';
        foreach ($list as $v) {
            $options .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
        }
        return $options;
    }

}
