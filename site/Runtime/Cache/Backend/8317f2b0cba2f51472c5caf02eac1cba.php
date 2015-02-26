<?php if (!defined('THINK_PATH')) exit();?><div id="functions_panel" style="height:670px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	名称：<input name="name" type="text" /> 
	控制器：<input name="module" type="text" />
	方法：<input name="method" type="text" />
	菜单/功能点：<select name="is_function">
			<option value="-1">全部</option>
			<option value="0">菜单</option>
			<option value="1">功能点</option>
	</select>
	是否启用：<select name="is_disabled">
			<option value="-1">全部</option>
			<option value="0">启用</option>
			<option value="1">禁用</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchSysFunctionBtn">搜索</a>
</div>
</div>
<table id="functions_datagrid"></table>
</div>

<script>
$("#functions_datagrid").datagrid({
	title: '管理员操作列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getFunctionList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '新增模块',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#functions_panel"), {
				title: '新增功能',
				href: '__URL__/edit',
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}, '-', {
		text: '编辑模块',
		iconCls: 'icon-edit',
		handler: function(){
			var selected=$("#functions_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#functions_panel"), {
				title: '编辑功能',
				href: '__URL__/edit/id/'+selected.id,
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}],
	columns: [[
		{title:'操作列表ID', field:'id', width:60, sortable:true},
		{title:'操作列表父ID', field:'pid', width:60, sortable:true},
		{title:'操作名称', field:'name', width:60, sortable:true},
		{title:'序号', field:'pindex', width:60, sortable:true},
		{title:'是否为菜单', field:'is_function', width:60, sortable:true, formatter: function(v){
			if(v==0)return '菜单';
			if(v==1)return '功能点';
		}},
		{title:'是否启用', field:'is_disabled', width:60, sortable:true, formatter: function(v){
			if(v==0)return '已启用';
			if(v==1)return '已禁用';
		}},		
		{title:'描述', field:'desc', width:60, sortable:true},
		{title:'模块名称', field:'module_name', width:60, sortable:true},
		{title:'方法名称', field:'method_name', width:60, sortable:true},
		{title:'新增时间', field:'atime', width:60, sortable:true},
		{title:'更新时间', field:'updatetime', width:60, sortable:true},		
		{title:'操作人', field:'op_user', width:60, sortable:true}
	]]
});

$("#functions_panel").find("select[name='is_function']").change(function(){
	getFunctionList();
});

$("#functions_panel").find("select[name='is_disabled']").change(function(){
	getFunctionList();
});

$("#js_searchSysFunctionBtn").click(function(){
	getFunctionList();
});

function getFunctionList(){
	var obj = {},
		panel = $("#functions_panel");
	obj.name = panel.find("input[name='name']").val();
	obj.is_function = panel.find("select[name='is_function']").find('option:selected').val();
	obj.is_disabled = panel.find("select[name='is_disabled']").find('option:selected').val();
	obj.action = panel.find("input[name='module']").val();
	obj.method = panel.find("input[name='method']").val();
	$("#functions_datagrid").datagrid('load', obj);
}

</script>