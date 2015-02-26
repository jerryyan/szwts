<?php if (!defined('THINK_PATH')) exit();?><div id="upfiles_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	用户名：<input name="username" type="text" /> 
	真实姓名：<input name="realname" type="text" />
	开始时间：<input name="start_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	结束时间：<input name="end_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchUpfilesBtn">搜索</a>
</div>
</div>
<table id="upfiles_datagrid"></table>
</div>

<script>
$("#upfiles_datagrid").datagrid({
	title: '文件上传日志列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getUpfilesList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	columns: [[ 
		{title:'ID', field:'id', width:30, sortable:true},
		{title:'用户名', field:'username', width:30, sortable:true},
		{title:'分组名称', field:'name', width:30, sortable:true},
		{title:'执行方法', field:'code', width:60, sortable:true},
		{title:'文件名称', field:'filename', width:50, sortable:true},
		{title:'文件类型', field:'filetype', width:30, sortable:true},
		{title:'文件大小', field:'filesize', width:30, sortable:true},
		{title:'文件路径', field:'fileurl', width:100, sortable:true},
		{title:'上传状态', field:'status', width:60, sortable:true, formatter:function(val, rec){
			if(val==0)return '未保存';
			if(val==1)return '已保存';
			if(val==2)return '已删除';
		}},
		{title:'添加时间', field:'atime', width:60, sortable:true},
		{title:'添加ip', field:'addip', width:30, sortable:true},
		{title:'更新时间', field:'utime', width:60, sortable:true},
		{title:'更新ip', field:'updateip', width:30, sortable:true},
		{title:'操作员', field:'op_username', width:30, sortable:true}
	]]
});

$("#js_searchUpfilesBtn").click(function(){
	getUpfilesList();
});

function getUpfilesList(){
	var obj = {},panel = $("#upfiles_panel");
		obj.username = panel.find("input[name='username']").val();
		obj.realname = panel.find("input[name='realname']").val();
		obj.start_time = panel.find("input[name='start_time']").val();
		obj.end_time = panel.find("[input[name='end_time']").val();
	$("#upfiles_datagrid").datagrid('load', obj);
}

</script>