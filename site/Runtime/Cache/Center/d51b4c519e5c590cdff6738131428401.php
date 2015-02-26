<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>用户管理中心  - 网投所</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="网投所，深圳网投所，网络理财，理财产品，借贷网络平台，抵押贷款，投资理财" />
<meta name="description" content="网投所" />
<link href="__ROOT__/static/css/global.css" rel="stylesheet" type="text/css" />
<link href="__ROOT__/static/css/center/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__ROOT__/static/js/jquery.js?version=1.7.1"></script>
<script type="text/javascript" src="__ROOT__/static/js/plugins/layer.min.js?version=1.8.4"></script>
<script type="text/javascript" src="__ROOT__/static/js/common.js"></script>
<script type="text/javascript">
$(function(){
	$("#js_sys_loginout").click(function(){
		layer.confirm("确认要退出系统吗？", function(index){		
			location.href='/Center/Index/loginout';
		});		
	});
});
</script>
</head>

<body>
<div id="loginbar">
  	<div class="login_content">
    	<div class="login_left">
            <span class="left_login" style="font-size:13px;">全国统一电话：400-0481-168 </span>
        </div>
    	<div class="login_right">
    		<?php if(($users[user_id] > 0)): ?><span class="nav_s">
					<a id="js_sys_loginout" href="javascript:void(0);">安全退出</a>
					<a href="/Center.html" style="margin-right:15px;color:#ea813d;"><?php echo ($_SESSION["Home_user"]["username"]); ?></a> 
				</span>
    		<?php else: ?>
        		<span class="nav_s"> <a style="color:#26b2ff;" href="/Login.html">立即登录</a>  <i style="color:#FFF; float:right; margin-right:10px; font-size:12px;">|</i> <a style="color:#ea813d;margin-right:10px;" href="/Register.html">快速注册 </a></span><?php endif; ?>
		</div>
	</div>
</div> 

<div id="top" style="clear:both">
	<div class="top_content">
    	<h2><a href="/"><img src="/static/images/home/logo.png" /></a></h2>
        <div class="nav">
        	<ul class="about_nav">
            	<li><a href="/">首页</a></li>
                <li><a href="/Platform.html" >选平台</a></li>
                <li><a href="/Invest.html">选标中心</a></li>
                <li class="na_a"><a href="/Center.html">个人中心</a></li>
                <li><a href="/About.html">关于我们</a></li>
            </ul>
        </div>
       
    </div>
</div>
<!-- 头部   end -->

<!-- 右侧内容   start -->
<div id="content">

	<!-- 左侧菜单   start -->
	<div class="content_left">
    <ul class="submenu">
        <li><a href="/Center/Safeinfo.html" class="<?php if(($menu == 1)): ?>su_b2<?php endif; ?>">安全信息</a></li>
        <li><a href="/Center/Platform.html" class="<?php if(($menu == 2)): ?>su_b2<?php endif; ?>">平台信息</a></li>
        <li><a href="/Center/Bankinfo.html" class="<?php if(($menu == 3)): ?>su_b2<?php endif; ?>">银行信息</a></li>
        <li><a href="/Center/Myinvest.html" class="<?php if(($menu == 4)): ?>su_b2<?php endif; ?>">投资记录</a></li>
        <li><a href="/Center/Analysis.html" class="<?php if(($menu == 5)): ?>su_b2<?php endif; ?>">投资分析</a></li>
        <li><a href="/Center/Account.html" class="<?php if(($menu == 6)): ?>su_b2<?php endif; ?>">资金记录</a></li>
        <li><a href="/Center/Cash.html" class="<?php if(($menu == 7)): ?>su_b2<?php endif; ?>">提现记录</a></li>
        <li><a href="/Center/Invitation.html" class="<?php if(($menu == 8)): ?>su_b2<?php endif; ?>">推荐统计</a></li>
    </ul>
</div>
	<!-- 左侧菜单   end -->
	
	<div class="content_right">
	
        <h2>安全信息</h2> 
        <div class="img_kj">
        	<img src="/static/images/center/bdyx_img.jpg" width="700" height="33" />
        </div>
        <div class="text_yx">
        	<a style="margin-left:135px; color:#666;">验证当前邮箱</a>
        	<a style=" margin-left:53px; color:#666;">填写新邮箱</a> 
        	<a style="margin-left:65px; color:#666;">验证新邮箱</a> 
        	<a style="margin-left:80px; color:#666;">成功</a>
        </div>     
        <div class="bdyx_dy">
			<div class="bz_y"><p>请到邮箱<a style="color:#ff0103;"><?php echo ($tempData['user_result']['email_hide']); ?></a>查收确认邮件，单击相应链接完成验证（24小时内有效）</p></div>
       		<div class="bz_e">
            	<p>未收到邮件？</p>
                <p>请先检查是否在垃圾邮件中</p>
                <p>10分钟内未收到验证邮件，请点击<input class="input_text_a" id="reSendEmail"></p>
            </div>
        </div>         		
       	
  	</div>	
</div>
<!-- 右侧内容   end -->

<div class="clear"></div>

<!-- 底部   start -->
<div class="foot" style="width:100%; font-size:14px;">
	<div class="ffoot">
           <a href="#"/>使用必读</a>
           <a href="#"/>专家顾问</a>
            <a href="#"/>团队介绍</a>
            <a href="#"/>联系方式</a>
            <a href="#"/>云金融</a>
            <a href="#"/>有情连接</a>
 </div>       
           
   <span>2014 深圳网投所有限公司 备案号7848235   Copyright © 2014 www.wangtousuo.com . All Rights Reserved.</span>

</div>

<!-- 底部   end -->

<script type="text/javascript">
$(function(){
	$("#reSendEmail").click(function(){
		var obj = {};
		obj.check = "old_email";
		$.ajax({
			url: '__GROUP__/Email/sendEmail',
			type: 'post',
			data: obj,
			dataType: 'json',
			beforeSend: function(){
				$("#reSendEmail").attr('disabled', true);
			},
			success: function(p){
				$("#reSendEmail").attr('disabled', false);
				alert(p.msg);			
			}
		});
	});
});
</script>
</body>
</html>