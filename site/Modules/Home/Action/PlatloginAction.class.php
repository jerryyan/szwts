<?php

class PlatloginAction extends MainAction {

    // 远程登录合作平台
    public function index() {
        $users = $this->users;
        if (!intval($users['user_id'])) {
            $this->error("您还没有登录或登录超时", "javascript:history.go(-1);");
            exit;
        }
        $_q = getParams();
        $platform_id = $_q->id;       
        $invest_id = $_q->invest_id;
        $platform_result = M("Cooperation_platform")->field("id,code,signkey,interface_reg_bind")->find($platform_id);
        $users = $this->users;
        $time_0 = time();
        $data = array(
            'partner_id' => $platform_result['code'],
            'username' => $users['username'],
            'email' => $users['email'],
            'mobile' => $users['phone'],
            'time' => $time_0,
            'signkey' => $platform_result['signkey']
        );
        $signStr = "";
        $temp = array();
        foreach ($data as $k => $v) {
            $temp[] = "$k=$v";
        }
        $signStr = implode('&', $temp);
        $sign = md5($signStr);
        $reg_bind_url = $platform_result['interface_reg_bind'];
        $username = urlencode(base64_encode($users['username']));
        $email = urlencode(base64_encode($users['email']));
        $mobile = urlencode(base64_encode($users['phone']));
        $time = urlencode(base64_encode($time_0));
        $invest_id = urlencode(base64_encode($invest_id));
        $from = urlencode(base64_encode('/Platlogin/relation/id/' . $platform_id));
        if (strpos($reg_bind_url, "?")) {
             $params = '&username=' . $username . '&email=' . $email . '&mobile=' . $mobile . '&time=' . $time . '&invest_id=' . $invest_id . '&return_url=' . $from . '&sign=' . $sign;
        } else {
             $params = '?username=' . $username . '&email=' . $email . '&mobile=' . $mobile . '&time=' . $time . '&invest_id=' . $invest_id . '&return_url=' . $from . '&sign=' . $sign;
        }
      
        // 更新平台浏览次数
        $obj = new stdClass();
        $obj->id = $platform_id;
        D("Cooperation_platform")->updateViewNum($obj);
        $platform_reg_bind_url = empty($reg_bind_url) ? '/' : $reg_bind_url . $params;
        header("Location: " . $platform_reg_bind_url);
    }

    // 弹出窗体
    public function box() {
        $_q = getParams();
        $tempData = array(
            'invest_url' => $_q->invest_url
        );
        $this->assign("tempData", $tempData);
        $this->display();
    }

    // 快捷登录选择
    public function page() {
        $_q = getParams();
        if (!intval($_q->id)) {
            $this->error("操作有误", "javascript:history.go(-1);");
            exit;
        }
        if (!intval($this->users['user_id'])) {
            $this->error("您还没有登录或登录超时", "javascript:history.go(-1);");
            exit;
        }
        $users = M("User")->find($this->users['user_id']);
        if (empty($users['email_status']) || empty($users['phone_status'])) {
            $this->error("您还没有进行手机和邮箱认证", "javascript:history.go(-1);");
            exit;
        }
        $platform_id = $_q->id;
        $platform_id=11;
        $invest_id = urlencode(base64_encode($_q->invest_id));
        $platform_result = M("Cooperation_platform")->field("id,code,name,signkey,interface_reg_bind,interface_login_bind")->find($platform_id);
        $time_0 = time();
        $data = array(
            'partner_id' => $platform_result['code'],
            'username' => $users['username'],
            'email' => $users['email'],
            'mobile' => $users['phone'],
            'time' => $time_0,
            'signkey' => $platform_result['signkey']
        );
        $signStr = "";
        $temp = array();
        foreach ($data as $k => $v) {
            $temp[] = "$k=$v";
        }
        $signStr = implode('&', $temp);
        $sign = md5($signStr);
        $reg_bind_url = $platform_result['interface_reg_bind'];
        $login_bind_url = $platform_result['interface_login_bind'];
        $username = urlencode(base64_encode($users['username']));
        $email = urlencode(base64_encode($users['email']));
        $mobile = urlencode(base64_encode($users['phone']));
        $time = urlencode(base64_encode($time_0));
        $from = urlencode(base64_encode('/Platlogin/relation/id/' . $platform_id));
        if (strpos($reg_bind_url, "?") || strpos($login_bind_url, "?")) {
            $params = '&username=' . $username . '&email=' . $email . '&mobile=' . $mobile . '&time=' . $time . '&invest_id=' . $invest_id . '&return_url=' . $from . '&sign=' . $sign;
        } else {
            $params = '?username=' . $username . '&email=' . $email . '&mobile=' . $mobile . '&time=' . $time . '&invest_id=' . $invest_id . '&return_url=' . $from . '&sign=' . $sign;
        }
        $platform_reg_bind_url = empty($reg_bind_url) ? '/' : $reg_bind_url . $params;
        $platform_login_bind_url = empty($login_bind_url) ? '/' : $login_bind_url . $params;
        $this->assign("platform_reg_bind_url", $platform_reg_bind_url);
        $this->assign("platform_login_bind_url", $platform_login_bind_url);
        $this->assign("pageTitle", '合作平台“' . $platform_result['name'] . '”快捷登录');
        $this->display();
    }

    // 平台回调函数（关联合作平台的注册账号）
    public function relation() {
        Log::write("（参数：" . $_SERVER['QUERY_STRING'] . "）", WEB_LOG_DEBUG);
        $_q = getParams();
        $platform_id = $_q->id;
        $platform_result = M("Cooperation_platform")->field("id,code,signkey")->find($platform_id);
        $data = array(
            'partner_id' => $platform_result['code'],
            'username' => urldecode($_q->username),
            'email' => urldecode($_q->email),
            'mobile' => urldecode($_q->mobile),
            'time' => urldecode($_q->time),
            'signkey' => $platform_result['signkey']
        );
        $signStr = "";
        $temp = array();
        foreach ($data as $k => $v) {
            $temp[] = "$k=$v";
        }
        $signStr = implode('&', $temp);
        $md5Sign = md5($signStr);
        $sign = $_q->sign;
        $obj = new stdClass();
        $obj->state = 0;
        if ($sign == $md5Sign) {
            $o->state = 1;
            $bindname = $_q->bindname;
            if (!empty($bindname)) {
                $user_result = M("User")->field("user_id")->where("username='%s'", $data['username'])->find();
                $platform_relation_result = M("Platform_relation")->where("user_id='%d' and platform_id='%d'", $user_result['user_id'], $platform_id)->find();
                if (empty($platform_relation_result)) {
                    $platform_relation_data = array(
                        'user_id' => $user_result['user_id'],
                        'platform_id' => $platform_id,
                        'relation_name' => $bindname,
                        'addtime' => time(),
                        'addip' => get_client_ip()
                    );
                    M("Platform_relation")->add($platform_relation_data);
                }
            }
        }
        echo json_encode($obj);
    }

}
