<?php if (!defined('THINK_PATH')) exit();?><div id="cash_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	用户名：<input flag="username" type="text" /> 
	真实姓名：<input flag="realname" type="text" />
	开始时间：<input flag="start_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	结束时间：<input flag="end_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	状态：<select name="cash_status">
			<option value="-1">全部</option>
			<option value="0">等待审核</option>
			<option value="1">审核通过</option>
			<option value="2">审核失败</option>
			<option value="3">提现取消</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchCashBtn">搜索</a>
	<a class="easyui-linkbutton" id="js_exportCashBtn">导出excel</a>
</div>
</div>
<table id="cash_datagrid"></table>
</div>

<script>
$("#cash_datagrid").datagrid({
	title: '客户提现列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getCashList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '提现审核/查看',
		iconCls: 'icon-edit',
		handler: function(){
			var selected=$("#cash_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#cash_panel"), {
				title: '提现审核/查看',
				href: '__URL__/editcash/id/'+selected.id,
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}],
	columns: [[
		{title:'ID', field:'id', width:30, sortable:true},    
		{title:'用户ID', field:'user_id', width:30, sortable:true},
		{title:'用户名', field:'username', width:30, sortable:true},
		{title:'真实姓名', field:'realname', width:30, sortable:true},
		{title:'提现帐号', field:'account', width:70, sortable:true},		
		{title:'银行', field:'name', width:50, sortable:true},	
		{title:'提现支行', field:'branch', width:100, sortable:true},	
		{title:'提现金额', field:'total', width:30, sortable:true},
		{title:'到账金额', field:'money', width:30, sortable:true},
		{title:'手续费', field:'fee', width:20, sortable:true},
		{title:'状态', field:'status', width:30, sortable:true, formatter:function(val, rec){
			if(val==0)return '等待审核';
			if(val==1)return '审核通过';
			if(val==2)return '审核失败';
			if(val==3)return '提现取消';
		}},
		{title:'提现时间', field:'atime', width:60, sortable:true},		
		{title:'审核时间', field:'vtime', width:60, sortable:true},
		{title:'审核人', field:'realname2', width:30, sortable:true}
	]]
});

$("#cash_panel").find("select[name='cash_status']").bind('change', function(){
	getCashList();
});

$("#js_searchCashBtn").bind('click', function(){
	getCashList();
});

function getCashList(){
	var obj = {},
		panel = $("#cash_panel");
	obj.username = panel.find("input[flag='username']").val();
	obj.realname = panel.find("input[flag='realname']").val();
	obj.start_time = panel.find("input[flag='start_time']").val();
	obj.end_time = panel.find("input[flag='end_time']").val();
	obj.utype = panel.find("select[name='utype']").find("option:selected").val();
	obj.status = panel.find("select[name='cash_status']").find("option:selected").val();
	$("#cash_datagrid").datagrid('load', obj);
}

$("#js_exportCashBtn").bind('click', function(){
	var panel = $("#cash_panel"),
		username = panel.find("input[flag='username']").val(),
		realname = panel.find("input[flag='realname']").val(),
		start_time = panel.find("input[flag='start_time']").val(),
		end_time = panel.find("input[flag='end_time']").val(),
		utype = panel.find("select[name='utype']").find("option:selected").val(),
		status = panel.find("select[name='cash_status']").find("option:selected").val(),
		operation = "export",
		params = [];
	if(username!=""){params.push("username="+username);}
	if(realname!=""){params.push("realname="+realname);}
	if(start_time!=""){params.push("start_time="+start_time);}
	if(end_time!=""){params.push("end_time="+end_time);}
	if(utype!=""){params.push("utype="+utype);}
	if(status!=""){params.push("status="+status);}
	if(operation!=""){params.push("operation="+operation);}
	if(params.length>0){
		params = params.join('&');
	}else{
		params = '';
	}
	location.href = '__URL__/getCashList?'+params;
});

</script>