<?php if (!defined('THINK_PATH')) exit();?><div id="user_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	用户名：<input flag="username" type="text" /> 
	真实姓名：<input flag="realname" type="text" />
	开始时间：<input flag="start_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	结束时间：<input flag="end_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	邮箱：<input flag="email" type="text" />
	手机：<input flag="phone" type="text" />
	状态：<select flag="status">
			<option value="-1">全部</option>
			<option value="0">正常</option>
			<option value="1">冻结</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchUserBtn">搜索</a>
</div>
</div>
<table id="user_datagrid"></table>
</div>

<script>
$("#user_datagrid").datagrid({
	title: '注册用户信息',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getUserList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '新增用户',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#user_panel"), {
				title: '新增用户',
				href: '__URL__/add',
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}, '-', {
		text: '编辑/查看',
		iconCls: 'icon-edit',
		handler: function(){
			var selected = $("#user_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#user_panel"), {
				title: '注册信息',
				href: '__URL__/edit/id/'+selected.user_id,
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}],
	columns: [[ 
		{title:'用户ID', field:'user_id', width:30, sortable:true},
		{title:'用户名', field:'username', width:60, sortable:true},
		{title:'真实姓名', field:'realname', width:60, sortable:true},
		{title:'性别', field:'sex', width:30, sortable:true, formatter:function(val, rec){
			if(val==1)return '男';		
			if(val==2)return '女';
		}},
		{title:'邮箱', field:'email', width:80, sortable:true},
		{title:'手机', field:'phone', width:60, sortable:true},		
		{title:'身份证', field:'card_id', width:80, sortable:true},
		{title:'注册时间', field:'atime', width:60, sortable:true},
		{title:'最后登录时间', field:'ltime', width:60, sortable:true},		
		{title:'最后登录ip', field:'lastip', width:60, sortable:true},
		{title:'更新时间', field:'last_modify_time', width:60, sortable:true},
		{title:'状态', field:'islock', width:30, sortable:true, formatter:function(val, rec){
			if(val==1)return '冻结';		
			if(val==0)return '正常';
		}}
	]]
});

$("#user_panel").find("select[flag='utype']").change(function(){
	getUserList();
});

$("#user_panel").find("select[flag='status']").change(function(){
	getUserList();
});

$("#user_panel").find("#js_searchUserBtn").bind('click', function(){
	getUserList();
});

function getUserList(){
	var obj = {},panel = $("#user_panel");
		obj.username = panel.find("input[flag='username']").val(),
		obj.realname = panel.find("input[flag='realname']").val(),
		obj.start_time = panel.find("input[flag='start_time']").val(),
		obj.end_time = panel.find("[input[flag='end_time']").val(),
		obj.email = panel.find("[input[flag='email']").val(),
		obj.phone = panel.find("[input[flag='phone']").val(),
		obj.utype = panel.find("select[flag='utype']").find("option:selected").val(),
		obj.islock = panel.find("select[flag='status']").find("option:selected").val();
	$("#user_datagrid").datagrid('load', obj);
}

</script>