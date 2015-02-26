<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ($pageTitle); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?php echo ($pageKeywords); ?>" />
        <meta name="description" content="<?php echo ($pageDes); ?>" />
        <link href="__ROOT__/static/css/home/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="__ROOT__/static/js/jquery.js?version=1.7.1"></script>
        <script type="text/javascript" src="__ROOT__/static/js/plugins/layer.min.js?version=1.8.4"></script>
    </head>
    <body>
        <div class="logo">
            <div class="logo_01">
                <a href="/"><img src="/static/images/home/logo_dl.png"/></a>
                <span>
                    <?php if(($loginPage == 1)): ?>没有网投所账号？ <a style="color:#F00;" href="/Register.html">立即注册</a>
                        <?php else: ?> 
                        已有网投所账号？ <a style="color:#F00;" href="/Login.html">立即登录</a><?php endif; ?>
                </span>
            </div>
        </div>

<!--  引入头部   end -->

<!-- 注册开始 -->
<div class="l_center cr" style=" margin-top:90px;border-top:0px; height:420px;">
    <div class="cen_y">
    	<div class="cen_t1"></div>
    </div>
    
	<div class="l_center_01" style="height:auto;">
	    <div class="sy">
		    <div class="sji_r"><span>使用手机验证</span></div>
		    <div class="yx_r"><span>使用邮箱验证</span></div>
    	</div>
		<div class="cen_tt" id="" style="display:block;">
	        <ul class="ul_li" style="padding-top:10px; width:380px; padding-left:90px; background:none;"> 	
	            <li>
	            	<span class="ul_span">手  机：</span>
	            	<div class="c_li_1" style="width:160px;">
	            		<input id="phone" name="phone" style="width:150px;" type="text" maxlength="11" />
	            	</div>      
	            </li>
	            <li>
	            	<span class="ul_span">验证码：</span>
	            	<div class="c_li_1" style="width:95px;"><input id="smscode" name="smscode" style="width:80px;" type="text" maxlength="6" /></div>
	            	<p class="m_1">
	            		<input id="sendCode" style="background:url('/static/images/home/login/dx.jpg') no-repeat; width:86px; height:34px; border:0;" type="button" />
	            		<span id="send_code_status" class="ul_span3"></span>
	            	</p>
	            	<span id="js_verifyphone_tips" style="float:left; width:500px; margin-left:124px; line-height:25px; height:25px; color:#ff0000;"></span>
	            </li>       
	            <li class="l_denglu" style="margin-top:20px;">
	            	<input id="verifyPhone" style="cursor:pointer; background:url(/static/images/home/login/yz.png) no-repeat; width:188px; height:37px;" type="button" />
	            </li> 
	        </ul>
	        <ul class="ul_li" style="padding-top:10px; width:380px;padding-left:50px; background:none;">
	            <li>
	            	<span class="ul_span">邮  箱：</span>
	            	<div class="c_li_1" style="width:220px;">
	            		<input id="email" name="email" style="width:210px;" type="text" maxlength="50" />
	            	</div>
	            	<span id="js_verifyemail_tips" style="float:left; width:500px; margin-left:124px; line-height:25px; height:25px; color:#ff0000;"></span>
	            </li>
	            <li class="l_denglu" style="margin-top:20px;">
	            	<input id="verifyEmail" style="cursor:pointer; background:url(/static/images/home/login/yz.png) no-repeat; width:188px; height:37px;" type="button" />
	            </li>       
	        </ul>	        
	    </div>
	</div> 
</div>
<!-- 注册结束 -->

<!--  引入底部   start -->
<div class="foot" style="width:100%; font-size:14px;">
	<div class="ffoot">
		<a href="/About.html" />使用必读</a>
		<a href="#" />专家顾问</a>
		<a href="#" />团队介绍</a>
		<a href="#" />联系方式</a>
		<a href="#" />云金融</a>
		<a href="#" />友情连接</a>
	</div>              
	<span>版权所有：深圳市伟泰投资发展有限公司 - <a href="http://www.beianbeian.com/search/wangtousuo.com" target="_blank" style="color:#ccc;">粤ICP备14094677号-1</a> Copyright © 2014 www.wangtousuo.com . All Rights Reserved.</span>
</div>

       
<!--  引入底部   end -->

<script type="text/javascript" src="__ROOT__/static/js/common.js"></script>
<script type="text/javascript">
$(function(){
	//手机号码格式检测
	$("#phone").focusin(function(){
		$("#js_verifyphone_tips").css({'color':'#999'}).text('建议使用常用的手机号码').show();
	}).focusout(function(){
		var v = $(this).val();
		checkPhone(v);
	});
	//手机号码格式检测
	$("#email").focusin(function(){
		$("#js_verifyemail_tips").css({'color':'#999'}).text('建议使用常用的邮箱地址').show();
	}).focusout(function(){
		var v = $(this).val();
		checkEmail(v);
	});
	//发送手机短信
	$("#sendCode").click(function(){
		var obj = $("#phone"),
			v = obj.val();
		if(checkPhone(v)){
			$.ajax({
				url: '/Register/sendcode',
				type: 'get',
				data: "phone="+v,
				dataType: 'json',
				beforeSend: function(){
					$("#sendCode").css({background:'none repeat scroll 0 0 #999'}).attr('disabled', true).val('发送中');
					$("#phone").attr('disabled', true);
				},
				success: function(p){
					$("#sendCode").css({background:'url("/static/images/home/login/dx.jpg") no-repeat'}).attr('disabled', false).val('');
					$("#phone").attr('disabled', false);
					if(p.state>0){
						layer.alert(p.msg, 1);
						send.start();
					}else{
						layer.alert(p.msg, 8);
						return false;
					}
				}
			});
		}	
	});
	//验证手机短信验证码格式
	$("#smscode").focusin(function(){
		$("#js_verifyphone_tips").css({'color':'#999'}).text('验证码长度必须为6位').show();
	}).focusout(function(){
		var v = $(this).val();
		checkCode(v);
	});
	//验证手机号码机短信验证码
	$("#verifyPhone").click(function(){
		var obj = {};
		obj.phone = $("#phone").val();
		obj.code = $("#smscode").val();
		$("#js_verifyphone_tips").css({'color':'#f00'}).text('').hide();
		if(checkPhone(obj.phone) && checkCode(obj.code)){
			$.ajax({
				url: '/Register/verifybymobile',
				type: 'get',
				data: obj,
				dataType: 'json',
				beforeSend: function(){
					$("#verifyPhone").css({background:'none repeat scroll 0 0 #999'}).attr('disabled', true).val('校验中');
				},
				success: function(p){
					$("#verifyPhone").css({background:'url("/static/images/home/login/yz.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0)'}).attr('disabled', false).val('');
					$("#js_verifyphone_tips").css({'color':'#f00'}).text(p.msg).show();
					if(p.state>0){
						layer.alert(p.msg, 1);
						location.href = '/Center';
					}else{
						layer.alert(p.msg, 8);
						return false;
					}	
				}
			});
		}
	});
	//验证电子邮箱
	$("#verifyEmail").click(function(){
		var obj = {};
		obj.email = $("#email").val();
		if(checkEmail(obj.email)){
			$.ajax({
				url: '/Register/verifybyemail',
				type: 'get',
				data: obj,
				dataType: 'json',
				beforeSend: function(){
					$("#verifyEmail").css({background:'none repeat scroll 0 0 #999'}).attr('disabled', true).val('校验中');
				},
				success: function(p){
					$("#verifyEmail").css({background:'url("/static/images/home/login/yz.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0)'}).attr('disabled', false).val('');
					$("#js_verifyemail_tips").css({'color':'#f00'}).text(p.msg).show();
				}
			});
		}
	});
});
//检测手机号码是否合法
function checkPhone(v){
	var phone = $.trim(v),
		len = phone.length;	
	$("#js_verifyphone_tips").text('').hide();
	if(len==0){
		$("#js_verifyphone_tips").css({'color':'#f00'}).text('请输入手机号码').show();
		return false;
	}else{
		if(phone_patrn.test(phone)){
			return true;
		}else{
			$("#js_verifyphone_tips").css({'color':'#f00'}).text('手机号码格式不正确').show();
			return false;
		}
	}
}
//检测短信验证码是否合法
function checkCode(v){
	var code = $.trim(v),
		len = code.length;
	if(len==0){
		$("#js_verifyphone_tips").css({'color':'#f00'}).text('请输入手机验证码').show();
		return false;
	}else if(len<6){
		$("#js_verifyphone_tips").css({'color':'#f00'}).text('验证码长度必须为6位').show();
		return false;
	}else{
		$("#js_verifyphone_tips").css({'color':'#f00'}).text('').hide();
		return true;
	}
}
//检测电子邮箱地址是否合法
function checkEmail(v){
	var email = $.trim(v),
		len = email.length;
	$("#js_verifyemail_tips").css({'color':'#f00'}).text('').hide();
	if(len==0){
		$("#js_verifyemail_tips").css({'color':'#f00'}).text('请输入邮箱地址').show();
		return false;
	}else{
		if(email_patrn.test(email)){
			return true;
		}else{
			$("#js_verifyemail_tips").css({'color':'#f00'}).text('邮箱地址格式不正确').show();
			return false;
		}
	}
}
</script>
</body>
</html>