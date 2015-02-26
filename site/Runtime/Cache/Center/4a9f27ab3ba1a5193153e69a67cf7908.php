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
        <div class="img_kj">
        	<img src="/static/images/center/bdsj_img2.jpg" width="700" height="33" />
        </div>
        <div class="text_yx">
        	<a style="margin-left:135px; color:#666;">验证手机号码</a>
        	<a style=" margin-left:53px; color:#666;">重设提现密码</a> 
        	<a style="margin-left:70px; color:#666;">成功</a>
        </div>
	    <div class="rznr">
			<div class="form_nr">
			    <div class="input_nr" style="margin-bottom:20px;">
			    	<span style="width:138px; text-align:right;">
			    		<a style=" float:left; color:#F00; height:28px; font:14px '微软雅黑'; padding-top:2px; margin-left:28px;">*</a>输入新提现密码
			    	</span>
			    	<input id="paypwd" name="paypwd" type="password" class="input_text" maxlength="20" />
			    </div>
			    <span id="js_paypwd_tips" class="q_text_sj"></span>
	          	<div class="input_nr">
	          		<span style="width:138px; text-align:right;">
	          			<a style=" float:left; color:#F00; height:28px; font:14px '微软雅黑'; padding-top:2px;">*</a>再次输入新提现密码
	          		</span>
	          		<input id="paypwd_confrim" name="paypwd_confrim" type="password" class="input_text" maxlength="20" />
	          	</div>
	          	<span id="js_paypwd_confrim_tips" class="q_text_sj"></span>
	            <div class="clear"></div>
	            <input id="resetPayPwdBtn" name="resetPayPwdBtn" type="button" value="" class="yzsj_xb sjyz_btn" />
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
	$("#paypwd").focusin(function(){
		$("#js_paypwd_tips").css({'color':'#666'}).text('请输入要设置的提现密码');
	}).focusout(function(){
		var _this = $(this),
			v = _this.val();
		checkPaypwd(v);
	});
	$("#paypwd_confrim").focusin(function(){
		$("#js_paypwd_confrim_tips").css({'color':'#666'}).text('请再次确认提现密码');
	}).focusout(function(){
		var _this = $(this),
			v = _this.val();
		checkPaypwdConfirm(v);
	});
	$("#resetPayPwdBtn").click(function(){
		var paypwd = $("#paypwd").val(),
			paypwd2 = $("#paypwd_confrim").val();
		if(checkPaypwd(paypwd) && checkPaypwdConfirm(paypwd2)){
			var obj = {};
			obj.paypwd = paypwd;
			$.ajax({
				url: '__GROUP__/Paypwd/verify',
				type: 'post',
				data: obj,
				dataType: 'json',
				beforeSend: function(){
					$("#resetPayPwdBtn").attr('disabled', true);
				},
				success: function(p){
					$("#resetPayPwdBtn").attr('disabled', false);
					$("#js_submit_tips").text(p.msg);
					if(p.state==1){
						location.href = '__GROUP__/Paypwd/findfinish';
					}else{
						return false;
					}			
				}
			});
		}
	});
});
function checkPaypwd(v){
	var len = str_length($.trim(v));
	if(len==0){
		$("#js_paypwd_tips").css({'color':'#f00'}).text('提现密码不能为空');
		return false;
	}else if(len<6){
		$("#js_paypwd_tips").css({'color':'#f00'}).text('提现密码不能少于6位');
		return false;
	}else if(len>20){
		$("#js_paypwd_tips").css({'color':'#f00'}).text('提现密码不能大于20位');
		return false;
	}else{
		$("#js_paypwd_tips").css({'color':'#f00'}).text('');
		return true;
	}
}
function checkPaypwdConfirm(v){
	var len = str_length($.trim(v)),
		upwd = $("#paypwd").val();	
	if(len==0){
		$("#js_paypwd_confrim_tips").css({'color':'#f00'}).text('确认密码不能为空');
		return false;
	}else if(len<6){
		$("#js_paypwd_confrim_tips").css({'color':'#f00'}).text('确认密码不能少于6位');
		return false;
	}else if(len>20){
		$("#js_paypwd_confrim_tips").css({'color':'#f00'}).text('确认密码不能大于20位');
		return false;
	}else{
		if(v==upwd){
			$("#js_paypwd_confrim_tips").css({'color':'#f00'}).text('');
			return true;
		}else{
			$("#js_paypwd_confrim_tips").css({'color':'#f00'}).text('两次密码输入不一致');
			return false;
		}
	}
}
</script>
</body>
</html>