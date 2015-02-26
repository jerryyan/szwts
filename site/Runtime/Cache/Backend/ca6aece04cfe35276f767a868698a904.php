<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网投所后台登录管理页</title>
<link href="__ROOT__/static/css/admin/login.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="login">
    <div class="lo_2">
	    <ul class="lo_22">
			<li class="lo_3"><span>账号</span>
				<input id="uname" type="text" class="lo_1" />
				<span id="js_u_Tips"></span>
			</li>
	        <li class="lo_3"><span>密码</span>
	        	<input id="upwd" type="password" class="lo_1" />
	        	<span id="js_p_Tips"></span>
	        </li>
	        <li class="lo_33"><span>验证码</span>
	        	<input id="js_valicode" type="text" class="lo_1" style="width:40px;" /> 
	        	<span id="js_v_Tips"></span>
	        </li>
	        <li class="lo_33">
	        	<a href="javascript:void(0);" title="点击更新验证码"><img id="valicodeforimage" src="__URL__/getvalicode" width="70" height="28" onclick="this.src='__URL__/getvalicode/' + Math.round(Math.random()*10000)" alt="点击更新验证码" /></a>
	        </li>
	    </ul>
	    <div style="margin-left:295px;float:left;margin-top:10px;width:460px;">
	    	<span id="js_login_message" style="float:left;color:#f00;margin-top:5px;"></span>
	    	<input id="js_loginTo" class="lo_4" type="button" style="margin-top:5px;" />
	    </div>
    </div>
</div>

<script type="text/javascript" src="__ROOT__/static/js/jquery.js?version=1.7.1"></script>
<script type="text/javascript">
//定义回车事件,响应登录按钮操作
if(document.addEventListener) {
    document.addEventListener("keypress", fireFoxHandler, true);//Firefox
}else{
    document.attachEvent("onkeypress", ieHandler);
}

function fireFoxHandler(event){
    if (event.keyCode==13){
    	subdata()
    }
}

function ieHandler(event){
    if(event.keyCode==13){
    	subdata()
    }
}
$(function(){
	$("#uname").focusin(function(){
		if($(this).val() == ''){
			$(this).val('');
		}
	}).focusout(function(){
		if($(this).val() == ''){
			$(this).val('');
		}
	});

	$("#uname").blur(function(){
		var u_val = $.trim($(this).val());
		if(u_val.length == 0 || u_val == ''){
			$("#js_u_Tips").css({display:'block',color:'#f00'}).text('用户名不能为空');	
		}else{
			$("#js_u_Tips").hide().text('');
		}
	});

	$("#upwd").blur(function(){
		var p_val = $.trim($(this).val());
		if(p_val.length == 0){
			$("#js_p_Tips").css({display:'block',color:'#f00'}).text('密码不能为空');
		}else{
			$("#js_p_Tips").hide().text('');
		}
	});

	$("#js_valicode").blur(function(){
		var v_val = $.trim($(this).val());
		if(v_val.length<4){
			$("#js_v_Tips").css({display:'block',color:'#f00'}).text('验证码不能少于4位');
		}else{
			$("#js_v_Tips").hide().text('');
		}
	});
	
	$("#js_loginTo").click(function(){
		subdata();
	});
	
});
function subdata(){
	var u_val = $.trim($("#uname").val()),
		p_val = $.trim($("#upwd").val()),
		v_val = $.trim($("#js_valicode").val());
	$("#js_u_Tips, #js_p_Tips, #js_v_Tips, #js_login_message").hide().text('');
	if(u_val.length==0 || u_val==""){
		$("#js_u_Tips").css({display:'block',color:'#f00'}).text('用户名不能为空');
		return false;
	}
	if(p_val.length==0){
		$("#js_p_Tips").css({display:'block',color:'#f00'}).text('密码不能为空');
		return false;
	}
	if(v_val.length<4){
		$("#js_v_Tips").css({display:'block',color:'#f00'}).text('验证码不能少于4位');
		return false;
	}
	var obj = {};
	obj.uname = u_val;
	obj.upwd = p_val;
	obj.valicode = v_val;
	$.post('__URL__/verifylogin', obj, function(data){
		eval("var p="+data);
		$("#js_login_message").show().text(p.msg);
		if(p.state==1){
			location.href = "/Backend";
		}else{
			$("#valicodeforimage").trigger("click");
			return false;
		}
	});
}
</script>
</body>
</html>