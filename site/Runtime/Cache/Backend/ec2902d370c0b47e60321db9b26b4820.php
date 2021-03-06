<?php if (!defined('THINK_PATH')) exit();?><div id="sysrole_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">

</div>
</div>
<table id="sysrole_datagrid"></table>
</div>

<script>
$("#sysrole_datagrid").datagrid({
	title: '管理员角色列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getRoleList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '新增角色',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#sysrole_panel"), {
				title: '新增角色',
				href: '__URL__/edit',
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}, '-', {
		text: '编辑角色',
		iconCls: 'icon-edit',
		handler: function(){
			var selected=$("#sysrole_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#sysrole_panel"), {
				title: '编辑角色',
				href: '__URL__/edit/id/'+selected.id,
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}, '-', {
		text: '角色权限分配',
		iconCls: 'icon-edit',
		handler: function(){
			var selected=$("#sysrole_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#sysrole_panel"), {
				title: '角色权限分配',
				href: '__URL__/privilege/id/'+selected.id,
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}],
	columns: [[
		{title:'角色ID', field:'id', width:60, sortable:true},
		{title:'角色名称', field:'role_name', width:60, sortable:true},
		{title:'角色描述', field:'role_desc', width:60, sortable:true},
		{title:'是否启用', field:'is_disabled', width:60, sortable:true, formatter: function(v){
			if(v==0)return '已启用';
			if(v==1)return '已禁用';
		}},
		{title:'新增时间', field:'atime', width:60, sortable:true},
		{title:'更新时间', field:'updatetime', width:60, sortable:true},		
		{title:'操作人', field:'op_user', width:60, sortable:true}
	]]
});

</script>