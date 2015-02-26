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
            <span class="left_login" style="font-size:13px;"><a href="/Center/Basicinfo.html">您好，<?php echo ($_SESSION["Home_user"]["username"]); ?></a> <i style="margin-left:6px; margin-right:6px;">欢迎来到网投所</i> 全国统一电话：400-000-000  
			</span>
 
        </div>
    	<div class="login_right">
    		<?php if(($users[user_id] > 0)): ?><span class="nav_s"><a id="js_sys_loginout" href="javascript:void(0);">安全退出</a></span>
    		<?php else: ?>
        		<span class="nav_s"> <a style="color:#26b2ff;" href="/Login">立即登录</a>  <i style="color:#FFF; float:right; margin-right:10px; font-size:12px;">|</i> <a style="color:#ea813d;margin-right:10px;" href="/Register/index.html">快速注册 </a></span><?php endif; ?>
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
        <div class="img_kj"><img src="/static/images/center/bdyx_e.jpg" width="700" height="33" /></div>
        <div class="text_yx">
        	<a style="margin-left:145px; color:#666;">验证手机</a>
        	<a style=" margin-left:78px; color:#666;">填写邮箱</a> 
        	<a style="margin-left:72px; color:#666;">验证新邮箱</a> 
        	<a style="margin-left:80px; color:#666;">成功</a>
        </div>       		
        <div class="rznr">
       	    <p style="width:700px; text-align:center; font-family:'微软雅黑'; font-size:14px; color:#adadad; margin-top:20px;">
       	  		原电子邮箱验证通过，请填写您的新电子邮箱，我们将会向该邮箱发送验证链接，请注意查收
       	    </p>
		  	<form id="newEmailForms" action="__GROUP__/Email/verifynewbymobile" method="post" class="form_nr">
			  <div class="input_nr">
			  	<span style="width:90px; text-align:right;">
			  		<a style="float:left; color:#F00; height:28px; font:14px '微软雅黑'; padding-top:2px; margin-left:8px;">*</a>填写新邮箱
			  	</span>
			  	<input id="code" name="code" type="hidden" value="<?php echo ($tempData['code']); ?>" />
			  	<input id="card_id" name="card_id" type="hidden" value="<?php echo ($tempData['card_id']); ?>" />
			  	<input id="newemail" name="newemail" type="text" class="input_text" />
			  </div>
				<span id="js_newemail_tips" class="q_text_yx"></span>
			  	<input id="newEmailBtn" type="button" value="" class="yzsj_xb yx_btn" />
			</form>
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

       
<div class="quickBox" style="display:none;">
	<div id="chatOnline" class="chatOnline">
		<a class="icon" href="javascript:void(0);">在线客服</a>
		<span class="onlineList" style="display: none;">
			<i class="arrow"></i>
			<i class="onlines">
				<strong>在线客服</strong>
				<?php if(is_array($kefuList)): $i = 0; $__LIST__ = $kefuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($v["qq"]); ?>&site=qq&menu=yes"><?php echo ($v["username"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
			</i>
		</span>
	</div>
	<a class="qrcode" href="javascript:void(0);">
		<em class="icon">微信号</em>
		<span>
			<i class="arrow"></i>
			<img alt="中源资本微信公众号" src="http://www.zyzib.com/static/images/center/wx1.jpg">
		</span>
	</a>
	<a id="goTop" class="goTop" href="javascript:void(0);">顶部</a>
</div>
<script type="text/javascript">
$(function(){
	$("#chatOnline").hover(function(){
		$(".onlineList").stop(false, true).show("fast");
	},function(){
		$(".onlineList").stop(false, true).hide("fast");
	});
    //当点击跳转链接后，回到页面顶部位置
    $("#goTop").click(function(){
	    $('body,html').animate({scrollTop:0},500);
	    return false;
    });
});
</script>

<!-- 底部   end -->

<script type="text/javascript">
$(function(){
	$("#newemail").focusin(function(){
		$("#js_newemail_tips").css({'color':'#666'}).text('请输入要绑定的邮箱地址');
	}).focusout(function(){
		var _this = $(this),
			v = _this.val();
		checkEmail(v);
	});
	$("#newEmailBtn").click(function(){
		var email = $("#newemail").val();
		if(checkEmail(email)){
			$("#newEmailForms").submit();
			$("#newEmailBtn").attr("disabled", true);
		}
	});
});
function checkEmail(v){
	var len = str_length($.trim(v));
	if(len==0){
		$("#js_newemail_tips").css({'color':'#f00'}).text('邮箱地址不能为空');
		return false;
	}else if(!email_patrn.test(v)){
		$("#js_newemail_tips").css({'color':'#f00'}).text('邮箱地址格式不正确');
		return false;
	}else{
		$("#js_newemail_tips").text('');
		return true;
	}
}
</script>
</body>
</html>