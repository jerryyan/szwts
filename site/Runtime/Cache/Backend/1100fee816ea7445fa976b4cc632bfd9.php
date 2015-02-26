<?php if (!defined('THINK_PATH')) exit();?><div id="email_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	用户名：<input name="username" type="text" /> 
	真实姓名：<input name="realname" type="text" />
	开始时间：<input name="start_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	结束时间：<input name="end_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchEmailBtn">搜索</a>
</div>
</div>
<table id="email_datagrid"></table>
</div>

<script>
$("#email_datagrid").datagrid({
	title: '邮件通知日志列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getEmailList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	columns: [[ 
		{title:'ID', field:'id', width:30, sortable:true},
		{title:'操作模块', field:'module', width:30, sortable:true},
		{title:'用户名', field:'username', width:30, sortable:true},
		{title:'邮件标题', field:'title', width:30, sortable:true},
		{title:'邮箱地址', field:'email', width:60, sortable:true},
		{title:'状态', field:'status', width:60, sortable:true, formatter:function(val, rec){
			if(val==0)return '未发送';
			if(val==1)return '已发送';
		}},
		{title:'添加时间', field:'atime', width:60, sortable:true},
		{title:'添加ip', field:'addip', width:30, sortable:true}
	]]
});

$("#js_searchEmailBtn").click(function(){
	getEmailList();
});

function getEmailList(){
	var obj = {},panel = $("#email_panel");
		obj.username = panel.find("input[name='username']").val();
		obj.realname = panel.find("input[name='realname']").val();
		obj.start_time = panel.find("input[name='start_time']").val();
		obj.end_time = panel.find("[input[name='end_time']").val();
	$("#email_datagrid").datagrid('load', obj);
}

</script>