/**
 * 登陆
 */
$(function(){
	$("#uname_l").focusin(function(){
		$("#js_uname_l_tips").css({display:'block',color:'#999'}).text('请输入用户名');
	}).focusout(function(){
		var u_val = $.trim($(this).val());
		if(u_val.length == 0 || u_val == ''){
			$("#js_uname_l_tips").css({display:'block',color:'#f00'}).text('用户名不能为空');	
		}else{
			$("#js_uname_l_tips").hide().text('');
		}
	});
	$("#upwd_l").focusin(function(){
		$("#js_upwd_l_tips").css({display:'block',color:'#999'}).text('请输入密码');
	}).focusout(function(){
		var p_val = $.trim($(this).val());
		if(p_val.length == 0){
			$("#js_upwd_l_tips").css({display:'block',color:'#f00'}).text('密码不能为空');
		}else{
			$("#js_upwd_l_tips").hide().text('');
		}
	});
	$("#valicode_l").focusin(function(){
		$("#js_valicode_l_tips").css({display:'block',color:'#999'}).text('请输入验证码');
	}).focusout(function(){
		var v_val = $.trim($(this).val());
		if(v_val.length<4){
			$("#js_valicode_l_tips").css({display:'block',color:'#f00'}).text('验证码不能少于4位');
		}else{
			$("#js_valicode_l_tips").hide().text('');
		}
	});
	$("#loginTo").click(function(){
		subdata();
	});
});

function subdata(){
	var o_uid = $.trim($("#oauth_id").val()),
		u_val = $.trim($("#uname_l").val()),
		p_val = $.trim($("#upwd_l").val()),
		v_val = $.trim($("#valicode_l").val());
	$("#js_uname_l_tips, #js_upwd_l_tips, #js_valicode_l_tips").hide().text('');
	if(u_val.length==0 || u_val==""){
		$("#js_uname_l_tips").css({display:'block',color:'#f00'}).text('用户名不能为空');
		return false;
	}
	if(p_val.length==0){
		$("#js_upwd_l_tips").css({display:'block',color:'#f00'}).text('密码不能为空');
		return false;
	}
	if(v_val.length<4){
		$("#js_valicode_l_tips").css({display:'block',color:'#f00'}).text('验证码不能少于4位');
		return false;
	}
	var obj = {};
	obj.oid = o_uid;
	obj.uname = u_val;
	obj.upwd = p_val;
	obj.valicode = v_val;
	$.post('/Login/verify', obj, function(data){
		eval("var p="+data);
		$("#js_valicode_l_tips").css({display:'block',color:'#f00'}).show().text(p.msg);	
		if(p.state==1){
			$("#uname_l,#upwd_l,#valicode_l").val('');
			$("#js_valicode_l_tips").attr('id', 'js_submit_tips')
			location.href = "/Center.html";
		}else{
			$("#valicodeforimage_l").trigger("click");
			return false;
		}
	});
}