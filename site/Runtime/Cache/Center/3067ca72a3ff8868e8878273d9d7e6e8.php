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
  	$(".show").hover(
	    function(){
	      	var a = $(this).children(".ico").attr("class").split(" ");
	      	$(this).children(".ico").addClass(a[1]+"Hover");
	      	$(this).children(".none").show();
	    },
	    function(){
      		var a = $(this).children(".ico").attr("class").split(" ");
	      	$(this).children(".ico").removeClass(a[2]);
	      	$(this).children(".none").hide();
	    }
	);	
  	$.sideBar("#js_sidebar");
});
</script>
</head>

<body>
<div id="loginbar">
	<div class="login_content">
 		<div class="login_left">
	        <span class="left_login" style="font-size:13px; float:left;">全国统一电话：400-112-5689 </span>
	        <div style="float:left; width:150px;">
	            <div class="top_sina show">
	           		<i class="ico ico_sina"><a href="http://weibo.com/u/5475395913?topnav=1&wvr=6" target="_blank"></a></i>
	                <div class="none">
	                </div>
	            </div>
	            <div class="top_weixin show">
	            	<i class="ico ico_weixin"></i>
	                <div class="none" style="display:none;">
	                	<img src="/static/images/home/top_weixin.png">
	                </div>
	        	</div>
	    	</div>      
		</div>
	    <div class="login_right"> 
	    	<span class="nav_s">
		   		<?php if(($users[user_id] > 0)): ?><a id="js_sys_loginout" href="javascript:void(0);">安全退出</a>
					<a href="/Center.html" style="margin-right:15px;color:#ea813d;"><?php echo ($_SESSION["Home_user"]["username"]); ?></a> 	
		   		<?php else: ?>
		       		<a style="color:#26b2ff;" href="/Login.html">立即登录</a>  <i style="color:#FFF; float:right; margin-right:10px; font-size:12px;">|</i> <a style="color:#ea813d;margin-right:10px;" href="/Register.html">快速注册 </a><?php endif; ?>
				<i style="color:#FFF; float:right; margin-right:10px; font-size:12px;"> | </i> <a style="color:fff; float:right; margin-right:10px;" href="javascript:void(0);" onclick="SetHome(this,window.location);">设为首页</a>
			</span>
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
        <div class="rznr">
       	    <p style="font-family:'微软雅黑'; font-size:14px; color:#adadad; margin-left:40px;">为了您的账户安全，请定期更换登录密码，并确保登录密码设置与提现密码不同。</p>
			<div class="form_nr">
				<div class="input_nr">
					<span style="width:90px; text-align:right;">
						<a style=" float:left; color:#F00; height:28px; font:14px '微软雅黑'; padding-top:2px; margin-left:34px;">*</a>原密码
					</span>
					<input id="oldpwd" name="oldpwd" type="password" class="input_text" maxlength="20" />
				</div>
                <span id="js_oldpwd_tips" class="q_text_sj"></span>
				<div class="input_nr">
					<span style="width:90px; text-align:right;">
						<a style=" float:left; color:#F00; height:28px; font:14px '微软雅黑'; padding-top:2px; margin-left:34px;">*</a>新密码
					</span>
					<input id="newpwd" name="newpwd" type="password" class="input_text" maxlength="20" />
				</div>
                <span id="js_newpwd_tips" class="q_text_sj"></span>
                <div class="input_nr">
                	<span style="width:90px; text-align:right;">
                		<a style=" float:left; color:#F00; height:28px; font:14px '微软雅黑'; padding-top:2px; margin-left:22px;">*</a>确认密码
                	</span>
                	<input id="newpwd_confrim" name="newpwd_confrim" type="password" class="input_text" maxlength="20" />
                </div>
                <span id="js_newpwd_confrim_tips" class="q_text_sj"></span>
				<input id="setLoginPwdBtn" type="button" value="" class="input_btn sj_btn" />
				<span id="js_submit_tips" class="q_text_sj"></span>
			</div>
       </div>
       	
  	</div>	
</div>
<!-- 右侧内容   end -->

<div class="clear"></div>

<!-- 底部   start -->
<div class="foot" style="width:100%; font-size:14px;">
	<div class="ffoot">
		<a href="/about/index/id/3.html">公司简介</a>
		<a href="/about/index/id/4.html">团队介绍</a>
        <a href="/about/index/id/6.html">联系我们</a>
		<a href="/about/index/id/2.html">使用必读</a>
	</div>              
	<span>版权所有：深圳市伟泰投资发展有限公司 - <a href="http://www.beianbeian.com/search/wangtousuo.com" target="_blank" style="color:#ccc;">粤ICP备14094677号-1</a> Copyright © 2014 www.wangtousuo.com . All Rights Reserved.</span>
</div>

<div id="js_sidebar"></div>
<!-- 底部   end -->

<script type="text/javascript">
$(function(){
	$("#oldpwd").focusin(function(){
		$("#js_oldpwd_tips").css({'color':'#666'}).text('请输入原始登录密码');
	}).focusout(function(){
		var _this = $(this),
			v = _this.val();
		checkOldpwd(v);
	});
	$("#newpwd").focusin(function(){
		$("#js_newpwd_tips").css({'color':'#666'}).text('请输入新的登录密码');
	}).focusout(function(){
		var _this = $(this),
			v = _this.val();
		checkNewpwd(v);
	});
	$("#newpwd_confrim").focusin(function(){
		$("#js_newpwd_confrim_tips").css({'color':'#666'}).text('请再次确认新的登录密码');
	}).focusout(function(){
		var _this = $(this),
			v = _this.val();
		checkNewpwdConfirm(v);
	});
	$("#setLoginPwdBtn").click(function(){
		var oldpwd = $("#oldpwd").val(),
			newpwd = $("#newpwd").val(),
			newpwd2 = $("#newpwd_confrim").val();
		if(checkOldpwd(oldpwd) && checkNewpwd(newpwd) && checkNewpwdConfirm(newpwd2)){
			var obj = {};
			obj.oldpwd = oldpwd;
			obj.newpwd = newpwd;
			$.ajax({
				url: '__GROUP__/Loginpwd/verify',
				type: 'post',
				data: obj,
				dataType: 'json',
				beforeSend: function(){
					$("#setLoginPwdBtn").attr('disabled', true);
				},
				success: function(p){
					$("#setLoginPwdBtn").attr('disabled', false);
					$("#js_submit_tips").text(p.msg);
					if(p.state==1){
						location.href = '__GROUP__/Safeinfo';
					}else{
						return false;
					}			
				}
			});
		}
	});
});
function checkOldpwd(v){
	var len = str_length($.trim(v));
	if(len==0){
		$("#js_oldpwd_tips").css({'color':'#f00'}).text('原始密码不能为空');
		return false;
	}else if(len<6){
		$("#js_oldpwd_tips").css({'color':'#f00'}).text('原始密码不能少于6位');
		return false;
	}else if(len>20){
		$("#js_oldpwd_tips").css({'color':'#f00'}).text('原始密码不能大于20位');
		return false;
	}else{
		$("#js_oldpwd_tips").css({'color':'#f00'}).text('');
		return true;
	}
}
function checkNewpwd(v){
	var len = str_length($.trim(v));
	if(len==0){
		$("#js_newpwd_tips").css({'color':'#f00'}).text('新密码不能为空');
		return false;
	}else if(len<6){
		$("#js_newpwd_tips").css({'color':'#f00'}).text('新密码不能少于6位');
		return false;
	}else if(len>20){
		$("#js_newpwd_tips").css({'color':'#f00'}).text('新密码不能大于20位');
		return false;
	}else{
		$("#js_newpwd_tips").css({'color':'#f00'}).text('');
		return true;
	}
}
function checkNewpwdConfirm(v){
	var len = str_length($.trim(v)),
		upwd = $("#newpwd").val();	
	if(len==0){
		$("#js_newpwd_confrim_tips").css({'color':'#f00'}).text('确认密码不能为空');
		return false;
	}else if(len<6){
		$("#js_newpwd_confrim_tips").css({'color':'#f00'}).text('确认密码不能少于6位');
		return false;
	}else if(len>20){
		$("#js_newpwd_confrim_tips").css({'color':'#f00'}).text('确认密码不能大于20位');
		return false;
	}else{
		if(v==upwd){
			$("#js_newpwd_confrim_tips").css({'color':'#f00'}).text('');
			return true;
		}else{
			$("#js_newpwd_confrim_tips").css({'color':'#f00'}).text('两次密码输入不一致');
			return false;
		}
	}
}
</script>
</body>
</html>