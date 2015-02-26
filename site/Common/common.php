<?php

/**
 * 公共函数
 * @ liuming
 */
//一次性获取表单参数
function getParams() {
    $_q = new stdClass();
    foreach ($_REQUEST as $key => $value) {
        $value = str_replace('/\<\s*script\s*\>.+\<\s*\/\s*script\s*\>/igm', '', $value);
        $value = trim($value);
        switch ($key) {
            default:
                $_q->$key = $value;
            case 'rows':
                $_q->$key = isset($value) ? $value : 20;
            case 'page':
                $_q->$key = isset($value) ? $value : 1;
        }
    }
    if (isset($_q->rows) && isset($_q->page)) {
        $offset = ($_q->page - 1) * $_q->rows;
        $_q->limit = " limit {$offset}, {$_q->rows} ";
    }
    return $_q;
}

//获取完整url地址
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

//导出excel格式表
function exportData($filename, $title, $data) {
    header("Content-type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=" . $filename . ".xls");
    if (is_array($title)) {
        foreach ($title as $key => $value) {
            echo $value . "\t";
        }
    }
    echo "\n";

    if (is_array($data)) {
        foreach ($data as $key => $value) {
            foreach ($value as $_key => $_value) {
                echo $_value . "\t";
            }
            echo "\n";
        }
    }
}

//获取下拉框数据
function _getOptionHtml($list, $pid, $pKey, $textKey) {
    $htmls = array();
    foreach ($list as $k => $v) {
        $selected = "";
        if ($v[$pKey] == $pid)
            $selected = "selected";
        $htmls[] = "<option value='" . $v[$pKey] . "' " . $selected . ">" . $v[$textKey] . "</option>";
    }
    return join("\n", $htmls);
}

/*
 * 获取验证码
 */

function getValicode() {
    $a = range(0, 9);
    $b = array();
    for ($i = 0; $i < 4; $i++) {
        $b[] = array_rand($a);
    }
    $code = join("", $b);
    $_SESSION['captcha'] = $code;
    getAuthImage($code);
}

function getAuthImage($text, $length = 4, $width = 105, $height = 36) {
    $image = imagecreatetruecolor($width, $height);
    // 背景色
    imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));
    // 设定文字随机颜色
    $colorList = array(
        imagecolorallocate($image, 15, 73, 210),
        imagecolorallocate($image, 0, 64, 0)
    );
    //设定文字随机字体
    $fontList = array(
        'static/font/msyhbd.ttf',
        'static/font/simsun.ttc',
        'static/font/arial.ttf'
    );
    $left = 20;
    $top = 15;
    for ($k = 0; $k < $length; $k ++) {
        imagettftext($image, 14, mt_rand(0, 10), ($left * $k) + mt_rand(0, 15), $top + mt_rand(0, 10), $colorList[array_rand($colorList)], $fontList[array_rand($fontList)], mb_substr($text, $k, 1));
    }
    // 添加点点
    for ($k = 0; $k < 20; $k++) {
        imagesetpixel($image, mt_rand() % 50, mt_rand() % 40, $colorList[array_rand($colorList)]);
    }
    // 添加干扰线
    for ($k = 0; $k < 3; $k++) {
        if (mt_rand(0, 1)) {
            // 直线
            imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $colorList[array_rand($colorList)]);
        } else {
            // 弧线
            $w = mt_rand(0, $width);
            $h = mt_rand(0, $height);
            imagearc($image, $width - floor($w / 2), floor($h / 2), $w, $h, mt_rand(90, 180), mt_rand(180, 270), $colorList[array_rand($colorList)]);
        }
    }
    //设置文件头;
    Header("Content-type: image/JPEG");
    //以PNG格式将图像输出到浏览器或文件;
    imagegif($image);
    //销毁一图像,释放与image关联的内存;
    imagedestroy($image);
}

// 生成短信随机码
function getRandCode() {
    $a = range(0, 9);
    $b = array();
    for ($i = 0; $i < 6; $i++) {
        $b[] = array_rand($a);
    }
    return join("", $b);
}

//检测身份证号码的有效性
function validCardNO($cardNo) {
    $curl = curl_init("http://baidu.uqude.com/baidu_mobile_war/idcard/dishi.action?cardNO=" . $cardNo);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
    $info = curl_exec($curl);
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        return 0;
    }
    curl_close($curl);
    return $info;
}

//格式化时间
function get_mktime($mktime) {
    if ($mktime == "")
        return "";
    $dtime = trim(ereg_replace("[ ]{1,}", " ", $mktime));
    $ds = explode(" ", $dtime);
    $ymd = explode("-", $ds[0]);
    if (isset($ds[1]) && $ds[1] != "") {
        $hms = explode(":", $ds[1]);
        $mt = mktime(empty($hms[0]) ? 0 : $hms[0], !isset($hms[1]) ? 0 : $hms[1], !isset($hms[2]) ? 0 : $hms[2], !isset($ymd[1]) ? 0 : $ymd[1], !isset($ymd[2]) ? 0 : $ymd[2], !isset($ymd[0]) ? 0 : $ymd[0]);
    } else {
        $mt = mktime(0, 0, 0, !isset($ymd[1]) ? 0 : $ymd[1], !isset($ymd[2]) ? 0 : $ymd[2], !isset($ymd[0]) ? 0 : $ymd[0]);
    }

    return $mt;
}

/**
 * 将ID转化为URL格式
 *
 * @param Integer $goods_id
 * @param String(eg:goods_vps/goods_hire) $goods_type
 * @return String
 */
function Key2Url($key, $type) {
    return base64_encode($type . $key);
}

/**
 * 将URL格式的字符串转化为ID
 *
 * @param String $str
 * @return Array(goods_type, goods_id)
 */
function Url2Key($key, $type) {
    $key = base64_decode(urldecode($key));
    return explode($type, $key);
}

//显示图片
function getImageUrl($url) {
    $nowtime = time();
    $ExpDate = gmdate("D, d M Y H:i:s", $nowtime + 3600 * 24 * 15); // 设置15天过期	
    header("Expires: $ExpDate GMT");    // Date in the past		
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", $nowtime) . " GMT"); // always modified		
    header("Cache-Control: public"); // HTTP/1.1		
    header("Pragma: Pragma");          // HTTP/1.0		
    $picurl = Url2Key($url, "@imgurl@");
    $pic = $picurl[1];
    $FType = array('jpg', 'gif', 'bmp', 'png');
    if (!in_array(strtolower(substr($pic, -3, 3)), $FType)) {
        echo base64_decode("PGEgaHJlZj0iaHR0cDovL3d3dy5jeWJlcnBvbGljZS5jbi93ZmpiL2h0bWwveHhnZy9pbmRleC5zaHRtbCI+sbG+qc34vq88L2E+o7rQxc+i0tG8x8K8o6E=");
        exit;
    }
    $filepath = dirname(dirname(dirname(__FILE__)));
    $imageUrl = $filepath . '/static/' . $pic;
    //echo $imageUrl;die();
    if (!file_exists($imageUrl)) {
        echo iconv('utf-8', 'gbk', "文件不存在");
        exit;
    }
    $fp = fopen($imageUrl, "r");
    $size = filesize($imageUrl);

    $image = fread($fp, $size);
    header("Content-type: image/JPEG", true);
    echo $image;
}

//获得时间天数
function get_times($data) {
    if (isset($data['time']) && $data['time'] != "") {
        $time = $data['time']; //时间
    } elseif (isset($data['date']) && $data['date'] != "") {
        $time = strtotime($data['date']); //日期
    } else {
        $time = time(); //现在时间
    }
    if (isset($data['type']) && $data['type'] != "") {
        $type = $data['type']; //时间转换类型，有day week month year
    } else {
        $type = "month";
    }
    if (isset($data['num']) && $data['num'] != "") {
        $num = $data['num'];
    } else {
        $num = 1;
    }
    if ($type == "month") {
        $month = date("m", $time);
        $year = date("Y", $time);
        $_result = strtotime("$num month", $time);
        $_month = (int) date("m", $_result);
        if ($month + $num > 12) {
            $_num = $month + $num - 12;
            $year = $year + 1;
        } else {
            $_num = $month + $num;
        }

        if ($_num != $_month) {

            $_result = strtotime("-1 day", strtotime("{$year}-{$_month}-01"));
        }
    } else {
        $_result = strtotime("$num $type", $time);
    }
    if (isset($data['format']) && $data['format'] != "") {
        return date($data['format'], $_result);
    } else {
        return $_result;
    }
}

//计算贷款利息
function EqualInterest($data) {
    $borrow_style = $data['borrow_style'];
    switch ($borrow_style) {
        default:
            return false;
            break;
        case 0:
            return EqualMonth($data);
            break;
        case 1:
            return EqualSeason($data);
            break;
        case 2:
            return EqualEnd($data);
            break;
        case 3:
            return EqualEndMonth($data);
            break;
    }
}

//等额本息法
//贷款本金×月利率×（1+月利率）还款月数/[（1+月利率）还款月数-1] 
//a*[i*(1+i)^n]/[(1+I)^n-1] 
//（a×i－b）×（1＋i）
function EqualMonth($data) {
    if (isset($data['account']) && $data['account'] > 0) {
        $account = $data['account'];
    } else {
        return "";
    }
    if (isset($data['year_apr']) && $data['year_apr'] > 0) {
        $year_apr = $data['year_apr'];
    } else {
        return "";
    }
    if (isset($data['month_times']) && $data['month_times'] > 0) {
        $month_times = $data['month_times'];
    }
    if (isset($data['borrow_time']) && $data['borrow_time'] > 0) {
        $borrow_time = $data['borrow_time'];
    } else {
        $borrow_time = time();
    }
    $month_apr = $year_apr / (12 * 100);
//	if($data['isday']==1){
//		$month_times=$month_times*$data['time_limit_day']/30;
//	}
    if ($data['isday'] == 1) {
        $_li = pow((1 + $month_apr), 1);
    } else {
        $_li = pow((1 + $month_apr), $month_times);
    }
    $repayment = round($account * ($month_apr * $_li) / ($_li - 1), 2);
    $_result = array();
    if (isset($data['type']) && $data['type'] == "all") {
        $_result['repayment_account'] = $repayment * $month_times;
        $_result['monthly_repayment'] = $repayment;
        $_result['month_apr'] = round($month_apr * 100, 2);
    } else {
        //$re_month = date("n",$borrow_time);
        for ($i = 0; $i < $month_times; $i++) {
            if ($i == 0) {
                $interest = round($account * $month_apr, 2);
            } else {
                $_lu = pow((1 + $month_apr), $i);
                $interest = round(($account * $month_apr - $repayment) * $_lu + $repayment, 2);
            }
            if ($data['isday'] == 1) {
                if ($data['type'] != "all") {
                    $_result[$i]['repayment_account'] = round($data['account'] + ($repayment - $data['account']) * $month_times, 2);
                } else {
                    $_result[$i]['repayment_account'] = $repayment;
                }
                $_result[$i]['interest'] = $interest * $month_times;
                $interest = round($interest * $month_times, 2);
            } else {
                $_result[$i]['repayment_account'] = round($repayment, 2);
                $_result[$i]['interest'] = round($interest, 2);
            }
            $_result[$i]['repayment_time'] = get_times(array("time" => $borrow_time, "num" => $i + 1));
            $_result[$i]['interest'] = $interest;
            if ($data['isday'] == 1) {
                $_result[$i]['capital'] = $data['account'];
            } else {
                $_result[$i]['capital'] = $repayment - $interest;
            }
        }
    }
    return $_result;
}

//按季等额本息法
function EqualSeason($data) {
    //借款的月数
    if (isset($data['month_times']) && $data['month_times'] > 0) {
        $month_times = $data['month_times'];
    }
    //按季还款必须是季的倍数
    if ($month_times % 3 != 0) {
        return false;
    }
    //借款的总金额
    if (isset($data['account']) && $data['account'] > 0) {
        $account = $data['account'];
    } else {
        return "";
    }
    //借款的年利率
    if (isset($data['year_apr']) && $data['year_apr'] > 0) {
        $year_apr = $data['year_apr'];
    } else {
        return "";
    }
    //借款的时间
    if (isset($data['borrow_time']) && $data['borrow_time'] > 0) {
        $borrow_time = $data['borrow_time'];
    } else {
        $borrow_time = time();
    }
    //月利率
    $month_apr = $year_apr / (12 * 100);
    //得到总季数
    $_season = $month_times / 3;
    //每季应还的本金
    $_season_money = round($account / $_season, 2);
    //$re_month = date("n",$borrow_time);
    $_yes_account = 0;
    $repayment_account = 0; //总还款额
    for ($i = 0; $i < $month_times; $i++) {
        $repay = $account - $_yes_account; //应还的金额		
        $interest = round($repay * $month_apr, 2); //利息等于应还金额乘月利率
        $repayment_account = $repayment_account + $interest; //总还款额+利息
        $capital = 0;
        if ($i % 3 == 2) {
            $capital = $_season_money; //本金只在第三个月还，本金等于借款金额除季度
            $_yes_account = $_yes_account + $capital;
            $repay = $account - $_yes_account;
            $repayment_account = $repayment_account + $capital; //总还款额+本金
        }
        $_result[$i]['repayment_account'] = $interest + $capital;
        $_result[$i]['repayment_time'] = get_times(array("time" => $borrow_time, "num" => $i + 1));
        $_result[$i]['interest'] = $interest;
        $_result[$i]['capital'] = $capital;
    }
    if (isset($data['type']) && $data['type'] == "all") {
        $_resul['repayment_account'] = $repayment_account;
        $_resul['monthly_repayment'] = round($repayment_account / $_season, 2);
        $_resul['month_apr'] = round($month_apr * 100, 2);
        return $_resul;
    } else {
        return $_result;
    }
}

//到期付款
function EqualEnd($data) {
    //借款的月数
    if (isset($data['month_times']) && $data['month_times'] > 0) {
        $month_times = $data['month_times'];
    }
    //借款的总金额
    if (isset($data['account']) && $data['account'] > 0) {
        $account = $data['account'];
    } else {
        return "";
    }
    //借款的年利率
    if (isset($data['year_apr']) && $data['year_apr'] > 0) {
        $year_apr = $data['year_apr'];
    } else {
        return "";
    }
    //借款的时间
    if (isset($data['borrow_time']) && $data['borrow_time'] > 0) {
        $borrow_time = $data['borrow_time'];
    } else {
        $borrow_time = time();
    }
    //月利率
    $month_apr = $year_apr / (12 * 100);
    $interest = $month_apr * $month_times * $account;
    if (isset($data['type']) && $data['type'] == "all") {
        $_resul['repayment_account'] = $account + $interest;
        $_resul['monthly_repayment'] = $account + $interest;
        $_resul['month_apr'] = $month_apr;
        return $_resul;
    } else {
        $_result[0]['repayment_account'] = $account + $interest;
        $_result[0]['repayment_time'] = get_times(array("time" => $borrow_time, "num" => $month_times));
        $_result[0]['interest'] = $interest;
        $_result[0]['capital'] = $account;
        return $_result;
    }
}

//到期还本，按月付息
function EqualEndMonth($data) {
    //借款的月数
    if (isset($data['month_times']) && $data['month_times'] > 0) {
        $month_times = $data['month_times'];
    }
    //借款的总金额
    if (isset($data['account']) && $data['account'] > 0) {
        $account = $data['account'];
    } else {
        return "";
    }
    //借款的年利率
    if (isset($data['year_apr']) && $data['year_apr'] > 0) {
        $year_apr = $data['year_apr'];
    } else {
        return "";
    }
    //借款的时间
    if (isset($data['borrow_time']) && $data['borrow_time'] > 0) {
        $borrow_time = $data['borrow_time'];
    } else {
        $borrow_time = time();
    }
    //月利率
    $month_apr = $year_apr / (12 * 100);
    //$re_month = date("n",$borrow_time);
    $_yes_account = 0;
    $repayment_account = 0; //总还款额
    $interest = round($account * $month_apr, 2); //利息等于应还金额乘月利率
    for ($i = 0; $i < $month_times; $i++) {
        $capital = 0;
        if ($i + 1 == $month_times) {
            $capital = $account; //本金只在第三个月还，本金等于借款金额除季度
        }
        $_result[$i]['repayment_account'] = $interest + $capital;
        $_result[$i]['repayment_time'] = get_times(array("time" => $borrow_time, "num" => $i + 1));
        $_result[$i]['interest'] = $interest;
        $_result[$i]['capital'] = $capital;
    }
    if (isset($data['type']) && $data['type'] == "all") {
        $_resul['repayment_account'] = $account + $interest * $month_times;
        $_resul['monthly_repayment'] = $interest;
        $_resul['month_apr'] = round($month_apr * 100, 2);
        return $_resul;
    } else {
        return $_result;
    }
}

//计算逾期利息
function getLateInterest($data) {
    $late_rate = $data['late_rate'];
    $now_time = get_mktime(date("Y-m-d", time()));
    $repayment_time = get_mktime(date("Y-m-d", $data['repay_time']));
    $late_days = ($now_time - $repayment_time) / (60 * 60 * 24);
    $_late_days = explode(".", $late_days);
    $late_days = ($_late_days[0] < 0) ? 0 : $_late_days[0];
    $late_interest = round($data['capital'] * $late_rate * $late_days, 2);
    if ($late_days == 0)
        $late_interest = 0;
    return array("late_days" => $late_days, "late_interest" => $late_interest);
}

//金额转换（小写转换为大写）
function moneyToUpper($num) {
    $c1 = "零壹贰叁肆伍陆柒捌玖";
    $c2 = "分角元拾佰仟万拾佰仟亿";
    //精确到分后面就不要了，所以只留两个小数位
    $num = round($num, 2);
    //将数字转化为整数
    $num = $num * 100;
    if (strlen($num) > 10) {
        return "金额太大，请检查";
    }
    $i = 0;
    $c = "";
    while (1) {
        if ($i == 0) {
            //获取最后一位数字
            $n = substr($num, strlen($num) - 1, 1);
        } else {
            $n = $num % 10;
        }
        //每次将最后一位数字转化为中文
        $p1 = substr($c1, 3 * $n, 3);
        $p2 = substr($c2, 3 * $i, 3);
        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
            $c = $p1 . $p2 . $c;
        } else {
            $c = $p1 . $c;
        }
        $i = $i + 1;
        //去掉数字最后一位了
        $num = $num / 10;
        $num = (int) $num;
        //结束循环
        if ($num == 0) {
            break;
        }
    }
    $j = 0;
    $slen = strlen($c);
    while ($j < $slen) {
        //utf8一个汉字相当3个字符
        $m = substr($c, $j, 6);
        //处理数字中很多0的情况,每次循环去掉一个汉字“零”
        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
            $left = substr($c, 0, $j);
            $right = substr($c, $j + 3);
            $c = $left . $right;
            $j = $j - 3;
            $slen = $slen - 3;
        }
        $j = $j + 3;
    }
    //这个是为了去掉类似23.0中最后一个“零”字
    if (substr($c, strlen($c) - 3, 3) == '零') {
        $c = substr($c, 0, strlen($c) - 3);
    }
    //将处理的汉字加上“整”
    if (empty($c)) {
        return "零元整";
    } else {
        return $c . "整";
    }
}

//数组相加（键值相同）
function array_add($a, $b) {
    //根据键名获取两个数组的交集
    $arr = array_intersect_key($a, $b);
    //遍历第二个数组，如果键名不存在与第一个数组，将数组元素增加到第一个数组
    foreach ($b as $key => $value) {
        if (!array_key_exists($key, $a)) {
            $a[$key] = $value;
        }
    }
    //计算键名相同的数组元素的和，并且替换原数组中相同键名所对应的元素值
    foreach ($arr as $key => $value) {
        $a[$key] = $a[$key] + $b[$key];
    }
    //返回相加后的数组
    return $a;
}

//获取用户注册邮件内容
function getMailInfo($data) {
    $webname = '网投所';
    $module = $data['module'];
    $code = $data['code'];
    $type = $data['type'];
    $check = empty($data['check']) ? 'email' : $data['check'];
    switch ($type) {
        default:
            $username = $data['username'];
            $url = "http://" . $_SERVER['HTTP_HOST'] . __GROUP__ . "/{$module}/active/check/{$check}/code/{$code}";
            $body = '<p>亲爱的会员' . $username . '：</p><p>您于' . date('m月d日  H:i') . '申请验证邮箱，点击以下链接，即可完成安全验证：<a href="' . $url . '" target="_blank">' . $url . '</a></p><p>您也可以将链接复制到浏览器地址栏访问。</p><p>为保障您的帐号安全，请在24小时内点击该链接。若您没有申请过验证邮箱 ，请您忽略此邮件 ，由此给您带来的不便请谅解。</p>';
            break;
        case 1:
            $body = '<p>亲爱的会员：</p><p>您好，您在' . $webname . '网站申请找回密码，操作的验证码为：' . $code . '</p><p>为保障您的帐号安全性，验证码有效期为30分钟，验证成功后自动失效。</p>';
            break;
    }
    $footer = '<p>' . $webname . '开发团队</p><p style="margin-top:20px;"><hr /></p><p>注：此邮件由系统自动发送，请勿回复</p><p>如果您有任何疑问，请联系客服，电话：400-112-5689</p>';
    $subject = $body . $footer;
    return $subject;
}

/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数（GET时为字符串）
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function http($url, $params, $method = 'GET', $header = array(), $array = false) {
    if (empty($url)) {
        return array();
    }
    $opts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER => $header
    );
    /* 根据请求类型设置特定参数 */
    $params = $array ? http_build_query($params) : $params;
    switch (strtoupper($method)) {
        case 'GET':
            if (strpos($url, "?")) {
                $opts[CURLOPT_URL] = empty($params) ? $url : $url . '&' . $params;
            } else {
                $opts[CURLOPT_URL] = empty($params) ? $url : $url . '?' . $params;
            }
            break;
        case 'POST':
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) {
        $query_url = empty($params) ? $url : $url . '?' . $params;
        $error = empty($query_url) ? $error : " 请求地址：" . $query_url;
        Log::write($error);
        return array();
        //throw new Exception('请求发生错误：' . $error);
    }
    if (preg_match('/^\xEF\xBB\xBF/', $data)) {
        $data = substr($data, 3);
    }
    return $data;
}

//查找字符串中的数字
function findNum($str = '') {
    $str = trim($str);
    if (empty($str)) {
        return '';
    }
    $result = '';
    for ($i = 0; $i < strlen($str); $i++) {
        if (is_numeric($str[$i])) {
            $result .= $str[$i];
        }
    }
    return $result;
}
