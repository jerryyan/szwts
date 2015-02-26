<?php if (!defined('THINK_PATH')) exit();?><div id="invitation_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	介绍人用户名：<input flag="uname" type="text" /> 
	被邀请人用户名：<input flag="username" type="text" />
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchInvitationBtn">搜索</a>
</div>
</div>
<table id="invitation_datagrid"></table>
</div>

<script>
$("#invitation_datagrid").datagrid({
	title: '邀请会员获奖列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getInvitationList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '审核/查看',
		iconCls: 'icon-edit',
		handler: function(){
			var selected = $("#invitation_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			if(confirm("请谨慎操作，确认要发放邀请奖励吗？")){
				var obj = {};
				obj.user_id = selected.user_id;
				$.get('__URL__/editInvitation', obj, function(data){
					if(data>0){
						alert('操作成功~');
						$("#invitation_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[
		{title:'用户ID', field:'uid', width:30, sortable:true},
		{title:'用户名', field:'uname', width:60, sortable:true},
		{title:'真实姓名', field:'rname', width:60, sortable:true},
		{title:'下线用户ID', field:'user_id', width:60, sortable:true},
		{title:'下线用户名', field:'username', width:60, sortable:true},
		{title:'下线真实姓名', field:'realname', width:60, sortable:true},
		{title:'实名认证', field:'real_status', width:60, sortable:true, formatter:function(val, rec){	
			if(val==1)return '是';
			else return '否';
		}},
		{title:'手机认证', field:'phone_status', width:60, sortable:true, formatter:function(val, rec){	
			if(val==1)return '是';
			else return '否';
		}},
		{title:'邮箱认证', field:'email_status', width:60, sortable:true, formatter:function(val, rec){	
			if(val==1)return '是';
			else return '否';
		}},
		{title:'投资总额', field:'summoney', width:60, sortable:true},
		{title:'注册时间', field:'atime', width:60, sortable:true},		
		{title:'应得提成收入', field:'money', width:60, sortable:true},
		{title:'实际提成收入（已支付）', field:'invite_money', width:80, sortable:true}
	]]
});


$("#js_searchInvitationBtn").bind('click', function(){
	getInvitationList();
});

function getInvitationList(){
	var obj = {};
		obj.uname = $("#invitation_panel").find("input[flag='uname']").val(),
		obj.username = $("#invitation_panel").find("input[flag='username']").val();
	$("#invitation_datagrid").datagrid('load', obj);
}

</script>