<?php

return array(
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => 'localhost', // 服务器地址
    'DB_NAME' => 'szwts', // 数据库名
    'DB_USER' => 'szwtsuser', // 用户名
    'DB_PWD' => 'szwts2014!.mysq1@', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'wts_', // 数据库表前缀
    'APP_GROUP_LIST' => 'Home,Center,Backend', // 项目分组
    'DEFAULT_GROUP' => 'Home',
    'APP_GROUP_MODE' => 1,
    'SHOW_PAGE_TRACE' => 0,
    'URL_CASE_INSENSITIVE' => 1, // url不区分大小写
    'DEFAULT_TIMEZONE' => 'Asia/Shanghai',
    'DEFAULT_FILTER' => 'trim,htmlspecialchars', // 系统获取变量的过滤方法，先trim再htmlspecialchars
    'PAGE_SIZE' => 20,
    //'APP_STATUS' => 'debug',
    'URL_HTML_SUFFIX' => '.html',
    'URL_MODEL' => 2,
    //自定义配置信息
    'ADMIN_GROUP' => 'Backend', //网站后台分组名称
    'FRONT_SERVER_KEY' => 'wangtousuo.com.2014!', //种子码（前台）
    'INVITATION_MONEY' => 30, //推荐奖励
    'BAOBAO_RATE' => 4.376, //宝宝们的收益
    'HUOQI_RATE' => 3.5, //银行活期利率
    'SMS_eID' => '16196', //短信发送账号   
    'SMS_USERNAME' => 'admin', //短信发送账号
    'SMS_PASSWORD' => md5('htkj0209'), //短信发送密码
    'PLATFORM_HOTLINE' => '400-112-5689'       //平台热线电话
);
?>
