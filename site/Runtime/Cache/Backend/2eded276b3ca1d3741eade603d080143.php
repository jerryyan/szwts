<?php if (!defined('THINK_PATH')) exit();?><div id="account_log_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	用户名：<input flag="username" type="text" /> 
	真实姓名：<input flag="realname" type="text" />
	开始时间：<input flag="start_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	结束时间：<input flag="end_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	类型：<select flag="operate_type"><?php echo ($log_options); ?></select>
	用户状态：<select flag="islock">
			<option value="-1">全部</option>
			<option value="0">正常</option>
			<option value="1">冻结</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchAccountLogBtn">搜索</a>
	<a class="easyui-linkbutton" id="js_exportAccountLogBtn">导出excel</a>
</div>
</div>
<table id="account_log_datagrid"></table>
</div>

<script>

$("#account_log_datagrid").datagrid({
	title: '客户资金使用记录',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getAccountLogList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	columns: [[
		{title:'ID', field:'id', width:60, sortable:true},   
		{title:'用户ID', field:'user_id', width:60, sortable:true},
		{title:'用户名', field:'username', width:60, sortable:true},
		{title:'真实姓名', field:'realname', width:60, sortable:true},
		{title:'操作类型', field:'types', width:60, sortable:true},
		{title:'账户总额', field:'total', width:60, sortable:true},		
		{title:'操作金额', field:'money', width:60, sortable:true},
		{title:'可用余额', field:'use_money', width:60, sortable:true},
		{title:'冻结总额', field:'no_use_money', width:60, sortable:true},	
		{title:'操作时间', field:'atime', width:60, sortable:true},
		{title:'操作ip', field:'addip', width:60, sortable:true}
	]]
});

$("#account_log_panel").find("select[flag='operate_type']").change(function(){
	getAccountLogList();
});

$("#account_log_panel").find("select[flag='islock']").change(function(){
	getAccountLogList();
})

$("#js_searchAccountLogBtn").bind('click', function(){
	getAccountLogList();
});

function getAccountLogList(){
	var obj = {},
		panel = $("#account_log_panel");
		obj.username = panel.find("input[flag='username']").val(),
		obj.realname = panel.find("input[flag='realname']").val(),
		obj.start_time = panel.find("input[flag='start_time']").val(),
		obj.end_time = panel.find("[input[flag='end_time']").val(),
		obj.operate_type = panel.find("select[flag='operate_type']").find("option:selected").val(),
		obj.islock = panel.find("select[flag='islock']").find("option:selected").val();
	$("#account_log_datagrid").datagrid('load', obj);
}

$("#js_exportAccountLogBtn").bind('click', function(){
	var panel = $("#account_log_panel"),
		username = panel.find("input[flag='username']").val(),
		realname = panel.find("input[flag='realname']").val(),
		start_time = panel.find("input[flag='start_time']").val(),
		end_time = panel.find("input[flag='end_time']").val(),
		operate_type = panel.find("select[flag='operate_type']").find("option:selected").val(),
		islock = panel.find("select[flag='islock']").find("option:selected").val();
		operation = "export",
		params = [];
	if(username!=""){params.push("username="+username);}
	if(realname!=""){params.push("realname="+realname);}
	if(start_time!=""){params.push("start_time="+start_time);}
	if(end_time!=""){params.push("end_time="+end_time);}
	if(operate_type!=""){params.push("operate_type="+operate_type);}
	if(islock!=""){params.push("islock="+islock);}
	if(operation!=""){params.push("operation="+operation);}
	if(params.length>0){
		params = params.join('&');
	}else{
		params = '';
	}
	location.href = '__URL__/getAccountLogList?'+params;
});

</script>