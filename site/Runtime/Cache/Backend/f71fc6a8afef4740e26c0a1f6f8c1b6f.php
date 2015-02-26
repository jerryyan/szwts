<?php if (!defined('THINK_PATH')) exit();?><div id="accounts_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	用户名：<input flag="username" type="text" /> 
	真实姓名：<input flag="realname" type="text" />
	开始时间：<input flag="start_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	结束时间：<input flag="end_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	用户状态：<select flag="islock">
			<option value="-1">全部</option>
			<option value="0">正常</option>
			<option value="1">冻结</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchAccountBtn">搜索</a>
	<a class="easyui-linkbutton" id="js_exportAccountBtn">导出excel</a>
</div>
</div>
<table id="account_datagrid"></table>
</div>

<script>

$("#account_datagrid").datagrid({
	title: '客户资金列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getAccountList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	columns: [[
		{title:'用户ID', field:'user_id', width:60, sortable:true},
		{title:'用户名', field:'username', width:60, sortable:true},
		{title:'真实姓名', field:'realname', width:60, sortable:true},
		{title:'帐号状态', field:'islock', width:60, sortable:true, formatter:function(val, rec){
			if(val==0)return '正常';
			if(val==1)return '冻结';
		}},
		{title:'总余额', field:'total', width:60, sortable:true},
		{title:'可用余额', field:'use_money', width:60, sortable:true},		
		{title:'冻结金额', field:'no_use_money', width:60, sortable:true},
		{title:'提现总额', field:'cash_success', width:60, sortable:true},
		{title:'推荐奖励', field:'invite_reward', width:60, sortable:true}
	]]
});

$("#accounts_panel").find("select[flag='islock']").change(function(){
	getAccountList();
})

$("#js_searchAccountBtn").bind('click', function(){
	getAccountList();
});

function getAccountList(){
	var obj = {},
		panel = $("#accounts_panel");
		obj.username = panel.find("input[flag='username']").val(),
		obj.realname = panel.find("input[flag='realname']").val(),
		obj.start_time = panel.find("input[flag='start_time']").val(),
		obj.end_time = panel.find("[input[flag='end_time']").val(),
		obj.islock = panel.find("select[flag='islock']").find("option:selected").val();
	$("#account_datagrid").datagrid('load', obj);
}

$("#js_checkAccountBtn").bind('click', function(){
	var obj = {};
	obj.check = 1;
	$("#account_datagrid").datagrid('load', obj);
});

$("#js_exportAccountBtn").bind('click', function(){
	var panel = $("#accounts_panel"),
		username = panel.find("input[flag='username']").val(),
		realname = panel.find("input[flag='realname']").val(),
		start_time = panel.find("input[flag='start_time']").val(),
		end_time = panel.find("input[flag='end_time']").val(),
		islock = panel.find("select[flag='islock']").find("option:selected").val(),
		operation = "export",
		params = [];
	if(username!=""){params.push("username="+username);}
	if(realname!=""){params.push("realname="+realname);}
	if(start_time!=""){params.push("start_time="+start_time);}
	if(end_time!=""){params.push("end_time="+end_time);}
	if(islock!=""){params.push("islock="+islock);}
	if(operation!=""){params.push("operation="+operation);}
	if(params.length>0){
		params = params.join('&');
	}else{
		params = '';
	}
	location.href = '__URL__/getAccountList?'+params;
});

</script>