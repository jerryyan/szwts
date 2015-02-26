<?php

class MainAction extends Action {

    var $users;
    var $admin_group;

    //权限控制
    public function __construct() {
        parent::__construct();
        $users = $_SESSION['Home_user'];
        $this->users = $users;
        $key = strtolower(MODULE_NAME . '-' . ACTION_NAME);
        $pageTitle = $this->pageTitle($key);
        $this->assign("pageTitle", $pageTitle);
        $pageKeywords = $this->pageKeywords($key);
        $this->assign("pageKeywords", $pageKeywords);
        $pageDes = $this->pageDes($key);
        $this->assign("pageDes", $pageDes);
        $menu = $this->manageMenu();
        $this->assign("menu", $menu);
        $this->assign("users", $users);
        $this->assign("loginPage", 0);
        //网站后台分组名称
        $this->admin_group = C("ADMIN_GROUP");
    }

    //404错误
    public function _empty() {
        header('HTTP/1.1 404 Not Found');
        $this->display("Common/404");
    }

    //网页标题汇总
    protected function pageTitle($key) {
        $array = array(
            'index-index' => '网投所-中国领先的p2p第三方垂直搜索引擎',
            'login-index' => '立即登录-网投所',
            'login-relation' => '关联第三方账户登录',
            'register-index' => '快速注册-网投所',
            'register-verify' => '信息验证',
            'register-active' => '完成注册',
            'findpwd-index' => '找回密码',
            'findpwd-byemail' => '通过邮箱找回密码',
            'findpwd-bymobile' => '通过手机找回密码',
            'findpwd-verify' => '验证信息',
            'findpwd-resetup' => '重置密码',
            'invest-index' => '选标中心-正规个人贷款-网投所',
            'platform-index' => '选平台-网络贷款平台-网投所'
        );
        return $array[$key];
    }

    //网页标题汇总
    protected function pageKeywords($key) {
        $array = array(
            'index-index' => '网投所,p2p贷款平台,p2p投资理财平台,p2p网贷理财,p2p网贷平台,贷款网站,网贷平台,网络借贷,网络投资',
            'login-index' => '网投所,理财产品有哪些',
            'login-relation' => '关联第三方账户登录',
            'register-index' => '网投所,最新理财产品',
            'register-verify' => '信息验证',
            'register-active' => '完成注册',
            'findpwd-index' => '找回密码',
            'findpwd-byemail' => '通过邮箱找回密码',
            'findpwd-bymobile' => '通过手机找回密码',
            'findpwd-verify' => '验证信息',
            'findpwd-resetup' => '重置密码',
            'invest-index' => '网投所,正规个人贷款,小额投资理财,项目贷款,网络信贷,投资理财产品,公司贷款,个人理财产品',
            'platform-index' => '网投所,正规小额贷款公司,小额理财产品排行,网上借贷,网络贷款平台,网络借贷平台,投资理财公司,短期理财产品排行,存钱理财'
        );
        return $array[$key];
    }

    //网页标题汇总
    protected function pageDes($key) {
        $array = array(
            'index-index' => '网投所，网贷投资人的首选交易所，为投资人甄选国内最安全的P2P平台，提供多样化的p2p理财服务，为您的投资收益保驾护航',
            'login-index' => '',
            'login-relation' => '关联第三方账户登录',
            'register-index' => '注册',
            'register-verify' => '信息验证',
            'register-active' => '完成注册',
            'findpwd-index' => '找回密码',
            'findpwd-byemail' => '通过邮箱找回密码',
            'findpwd-bymobile' => '通过手机找回密码',
            'findpwd-verify' => '验证信息',
            'findpwd-resetup' => '重置密码',
            'invest-index' => '在网投所您可找到P2P网贷平台所发布最新、最全的投资项目信息，为您的投资理财提供一站式的垂直搜索服务，让您的理财变得更加方便、快捷',
            'platform-index' => '网投所为您选出最安全的P2P投资理财平台，提供最具行业权威的P2P网贷平台排名与点评，为您的投资理财把好第一关'
        );
        return $array[$key];
    }

    // 头部菜单栏样式控制
    protected function manageMenu() {
        $module_name = strtolower(MODULE_NAME);
        $menuArray = array(
            'index',
            'news',
            'platform',
            'invest',
            'about'
        );
        $menu_nums = array(
            'index' => 1,
            'news' => 1,
            'platform' => 2,
            'invest' => 3,
            'about' => 4
        );
        if (in_array($module_name, $menuArray)) {
            return $menu_nums[$module_name];
        }
    }

    //检测每天一个手机的短信发送次数
    protected function checkSendNum($phone) {
        $date = strtotime(date('Y-m-d'));
        $phone_sendlog_result = M("Phone_sendlog")->where(array('phone' => $phone, 'status' => 1, 'send_date' => $date))->select();
        if (!empty($phone_sendlog_result) && count($phone_sendlog_result) >= 3) {
            return 1;
        } else {
            return 0;
        }
    }

    //发送手机短信（单发）
    /*
      protected function sendSmsOne($data) {

      $gwUrl = 'http://api.duanxin.cm/';
      $smsAction = 'action=send';
      $userName = C("SMS_USERNAME");
      $passWord = C("SMS_PASSWORD");

      $phone_data = array(
      'user_id' => empty($data['user_id']) ? 0 : $data['user_id'],
      'phone' => $data['phone'][0],
      'content' => $data['content'],
      'status' => 0,
      'send_date' => strtotime(date('Y-m-d')),
      'addtime' => time(),
      'addip' => get_client_ip()
      );
      $fileurl = $gwUrl . '?' . $smsAction . '&username=' . $userName . '&password=' . $passWord . '&phone=' . $phone_data['phone'] . '&content=' . urlencode($phone_data['content']) . '&encode=utf8';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $fileurl);         //设置url
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);    //设置开启重定向支持
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
      $output = curl_exec($ch);         //执行
      curl_close($ch);
      $info = strip_tags($output);
      if ($info == 100) {
      $phone_data['status'] = 1;
      M("Phone_sendlog")->add($phone_data);
      } else {
      M("Phone_sendlog")->add($phone_data);
      }
      return $info == 100 ? 0 : 1;
      } */


    //易信通发送手机短信（单发）

    protected function sendSmsOne($data) {
        $gwUrl = 'http://119.145.9.12/sendSMS.action';
        $eID = C("SMS_eID");
        $userName = C("SMS_USERNAME");
        $passWord = C("SMS_PASSWORD");

        $phone_data = array(
            'user_id' => empty($data['user_id']) ? 0 : $data['user_id'],
            'phone' => $data['phone'][0],
            'content' => $data['content'],
            'status' => 0,
            'send_date' => strtotime(date('Y-m-d')),
            'addtime' => time(),
            'addip' => get_client_ip()
        );
        $params = "enterpriseID=$eID&loginName=$userName&password=$passWord&content=" . urlencode($phone_data['content']) . "&mobiles={$phone_data['phone']}";
        $data = http($gwUrl, $params, "POST");
        $parser = xml_parser_create();
        xml_parse_into_struct($parser, $data, $values, $index);
        xml_parser_free($parser);
        if ($values[1]['tag'] == "RESULT") {
            $info = $values[1]['value'];
        }      
        if ($info == 0) {
            $phone_data['status'] = 1;
            M("Phone_sendlog")->add($phone_data);
        } else {
            M("Phone_sendlog")->add($phone_data);
        }
        return $info == 0 ? 0 : 1;
    }

    //发送邮件
    protected function sendEmailOne($data) {
        $user_sendemail_log_data = array(
            'module' => $data['module'], //操作模块
            'user_id' => isset($data['user_id']) ? $data['user_id'] : 0,
            'email' => $data['email'], //邮件发送的邮箱
            'title' => isset($data['title']) ? $data['title'] : '系统信息', //邮件发送的标题	
            'msg' => isset($data['msg']) ? $data['msg'] : '系统信息', //邮件发送的内容
            'addtime' => isset($data['addtime']) ? $data['addtime'] : time(),
            'addip' => isset($data['addip']) ? $data['addip'] : get_client_ip()
        );
        include("./mail/phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->AddAddress($user_sendemail_log_data['email']);

        $body = eregi_replace("[\]", '', $user_sendemail_log_data['msg']);
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP();
        # 必填，SMTP服务器是否需要验证，true为需要，false为不需要      	
        $mail->SMTPAuth = true;
        # 必填，设置SMTP服务器
        $mail->Host = 'smtp.exmail.qq.com';
        # 必填，开通SMTP服务的邮箱；任意一个163邮箱均可
        $mail->Username = 'smile@wdzx.com';
        # 必填， 以上邮箱对应的密码
        $mail->Password = 'wdzx573412';
        # 必填，发件人Email
        $mail->From = 'smile@wdzx.com';
        # 必填，发件人昵称或姓名
        $mail->FromName = '网投所';
        # 必填，邮件标题（主题）
        $mail->Subject = $user_sendemail_log_data['title'];
        # 可选，纯文本形势下用户看到的内容
        $mail->AltBody = "";
        # 自动换行的字数
        $mail->WordWrap = 50;
        $mail->MsgHTML($body);
        # 回复邮箱地址
        $mail->AddReplyTo($mail->From, $mail->FromName);
        $mail->IsHTML(true);
        $state = 0;
        if ($mail->Send()) {
            $state = 1;
        }
        $user_sendemail_log_data['status'] = $state;
        M("User_sendemail_log")->add($user_sendemail_log_data);
        return $state;
    }

    //发送手机短信（验证码）
    protected function sendSms($obj) {
        $o = new stdClass();
        $o->state = 0;
        $o->msg = "";
        switch ($obj->type) {
            default://无需绑定手机号码
                $phone = $obj->phone;
                $phone_len = mb_strlen($phone, 'utf-8');
                if ($phone_len != 11) {
                    $o->msg = '手机号码格式不正确';
                    return $o;
                }
                $user_result = M("User")->field("user_id")->where("phone='%s' and phone_status=1", $phone)->find();
                if (!empty($user_result)) {
                    $o->msg = "此手机号码已被占用";
                    return $o;
                }
                break;
            case 1://需要绑定手机号码
                $user_result = M("User")->field("phone")->where("user_id='%d' and phone_status=1", $this->users['user_id'])->find();
                if (!empty($user_result)) {
                    $phone = $user_result['phone'];
                } else {
                    $o->msg = '请先绑定手机号码';
                    return $o;
                }
                break;
            case 2://无需绑定手机号码（更换手机）
                $phone = $obj->phone;
                $phone_len = mb_strlen($phone, 'utf-8');
                if ($phone_len != 11) {
                    $o->msg = '手机号码格式不正确';
                    return $o;
                }
                $user_result = M("User")->field("user_id")->where("phone='%s' and phone_status=1", $phone)->find();
                if (!empty($user_result)) {
                    if ($this->users['user_id'] != $user_result['user_id']) {
                        $o->msg = "此手机号码已被占用";
                        return $o;
                    } else {
                        $o->msg = "新手机号码不能和原有手机号码一致";
                        return $o;
                    }
                }
                break;
        }
        $check = $this->checkSendNum($phone);
        if ($check > 0) {
            $o->msg = '您的操作次数已到，如有疑问请联系客服';
            return $o;
        }
        $code = getRandCode();
        $sessionKey = empty($obj->sessionKey) ? 'PhoneCode' : $obj->sessionKey;
        $_SESSION[$sessionKey] = $code;
        $phone_array = array(0 => $phone);
        $content = "您于" . date('m月d日 H:i') . $obj->oprate . "，验证码：" . $code . "。" . $obj->tips . "【网投所】";
        $smsContent = array('user_id' => $this->users['user_id'], 'phone' => $phone_array, 'content' => $content);
        $send_status = $this->sendSmsOne($smsContent);
        if ($send_status == 0) {
            $o->state = 1;
            $o->msg = '手机短信发送成功';
        } else {
            $o->msg = '手机短信发送失败';
        }
        return $o;
    }

    //发送电子邮件
    protected function sendMail($obj) {
        $o = new stdClass();
        $o->state = 0;
        if (!empty($obj->email)) {
            $user = M("User");
            $email = $obj->email;
            switch ($obj->check) {
                default:
                    $user_result = $user->where("email='%s' and email_status=1", $email)->find();
                    break;
                case 'old_email':
                    $user_result = null;
                    break;
                case 'new_email':
                    $user_result = $user->where("user_id!='%s' and email='%s' and email_status=1", $this->users['user_id'], $email)->find();
                    break;
            }
            if (!empty($user_result)) {
                $o->msg = "此邮箱地址已被占用";
                return $o;
            }
            $key = C("front_server_key");
            $user_data = array(
                'user_id' => $this->users['user_id'],
                'temp_email' => $email,
                'token' => md5($key . $this->users['username'] . time()),
                'token_exptime' => time() + 60 * 60 * 24,
                'token_verify_status' => 0
            );
            $user->save($user_data);
            $email_data = array(
                'username' => $this->users['username'],
                'code' => $user_data['token'],
                'module' => MODULE_NAME,
                'type' => $obj->type,
                'check' => $obj->check
            );
            $content = getMailInfo($email_data);
            $send_mail_data = array(
                'module' => MODULE_NAME,
                'user_id' => $this->users['user_id'],
                'email' => $email,
                'title' => '邮箱验证',
                'msg' => $content,
                'addtime' => time(),
                'addip' => get_client_ip()
            );
            $state = $this->sendEmailOne($send_mail_data);
            if ($state > 0) {
                $o->state = 1;
                $o->msg = '邮件发送成功，请查看你的邮件信息';
            } else {
                $o->msg = '邮件发送失败，请联系网站管理员';
            }
        } else {
            $o->msg = '提交数据不完整';
        }
        return $o;
    }

    //字符串二次处理
    protected function ModifierDisplay($a = '', $b = '') {
        $a = trim($a);
        $b = trim($b);
        $len = strlen($a);
        $result = "";
        if ($len < 1) {
            $result = '';
        } else {
            if (empty($b)) {
                if ($len >= 2) {
                    $len = mb_strlen($a, 'utf-8');
                    $i = intval($len / 2);
                    $result = mb_substr($a, 0, $i, 'utf-8') . str_pad('', ($len - $i), '*', STR_PAD_RIGHT);
                } else {
                    $result = $a;
                }
            } else {
                switch ($b) {
                    case 'name':
                        if ($len == 4) {
                            $result = mb_substr($a, 0, $len - 3, 'utf-8') . "*";
                        } else {
                            $result = mb_substr($a, 0, $len - 4, 'utf-8') . "*";
                        }
                        break;
                    case 'username':
                        $result = mb_substr($a, 0, 2, 'utf-8') . "**";
                        break;
                    case 'card_id':
                        $result = substr($a, 0, 3) . '***' . substr($a, 6, 4) . '********';
                        break;
                    case 'phone':
                        $result = substr($a, 0, 3) . '****' . substr($a, 7, 4);
                        break;
                    case 'email':
                        $suffix = mb_substr($a, strpos($a, '@'));
                        $str = mb_substr($a, 0, strpos($a, '@'));
                        $len = mb_strlen($str, 'utf-8');
                        $i = intval($len / 3);
                        $result = mb_substr($str, 0, $i, 'utf-8') . str_pad('', $i, '*', STR_PAD_RIGHT) . mb_substr($str, $i * 2, $len - 2 * $i, 'utf-8') . $suffix;
                        break;
                    case 'account':
                        $left = substr($a, 0, 6);
                        $right = substr($a, 6, $len - 6);
                        $result = $left . str_pad(substr($a, -4), strlen($right), '*', STR_PAD_LEFT);
                        break;
                }
            }
        }
        return $result;
    }

}
