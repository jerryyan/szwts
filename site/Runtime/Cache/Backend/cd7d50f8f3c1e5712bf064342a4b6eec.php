<?php if (!defined('THINK_PATH')) exit();?><div id="sysuser_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">

</div>
</div>
<table id="sysuser_datagrid"></table>
</div>

<script>
$("#sysuser_datagrid").datagrid({
	title: '管理员列表',
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
		text: '新增管理员',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#sysuser_panel"), {
				title: '新增管理员',
				href: '__URL__/add',
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}, '-', {
		text: '编辑管理员',
		iconCls: 'icon-edit',
		handler: function(){
			var selected=$("#sysuser_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#sysuser_panel"), {
				title: '编辑管理员',
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
		{title:'用户ID', field:'id', width:20, sortable:true},
		{title:'用户名', field:'username', width:30, sortable:true},
		{title:'角色', field:'role_name', width:30, sortable:true},
		{title:'是否锁定', field:'is_locked', width:20, sortable:true, formatter: function(v){
			if(v==0)return '正常';
			if(v==1)return '已锁定';
		}},
		{title:'邮箱', field:'email', width:80, sortable:true},
		{title:'头像', field:'avatar', width:80, sortable:true, formatter:function(val, rec){
			if(val=="" || val==null)return "<img src='static/upload/no_pic.gif' height='30' />";
			else return "<img src='static/"+val+"' height='30' />";
		}},
		{title:'昵称', field:'nickname', width:30, sortable:true},
		{title:'真实姓名', field:'fullname', width:30, sortable:true},		
		{title:'手机号码', field:'phone', width:30, sortable:true},
		{title:'qq号码', field:'qq', width:30, sortable:true},
		{title:'新增时间', field:'atime', width:60, sortable:true},
		{title:'更新时间', field:'updatetime', width:60, sortable:true},		
		{title:'操作人', field:'op_user', width:20, sortable:true}
	]]
});

</script>