<?php if (!defined('THINK_PATH')) exit();?><div id="moduels_list_panel" style="height:670px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	模块识别码：<input name="nid" type="text" /> 
	名称：<input name="name" type="text" />
	是否列表：
	<select name="is_list">
			<option value="-1">全部</option>
			<option value="0">否</option>
			<option value="1">是</option>	
	</select>
	是否隐藏：
	<select name="is_hide">
			<option value="-1">全部</option>
			<option value="0">否</option>
			<option value="1">是</option>		
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchModulesBtn">搜索</a>
</div>
</div>
<table id="modules_list_datagrid"></table>
</div>

<script>
$("#modules_list_datagrid").datagrid({
	title: '网站模块操作列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '新增模块',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#moduels_list_panel"), {
				title: '新增网站模块',
				href: '__URL__/add',
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
			var selected=$("#modules_list_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#moduels_list_panel"), {
				title: '编辑网站模块',
				href: '__URL__/edit/id/'+selected.id,
				closable: true,
				minimizable: false,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}, '-', {
		text: '删除',
		iconCls: 'icon-remove',
		handler: function(){
			var selected = $("#modules_list_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			if(confirm("请谨慎操作，确认要删除此条记录吗？")){
				var obj = {};
				obj.id = selected.id;
				$.get('__URL__/delete', obj, function(data){
					if(data>0){
						alert('操作成功~');
						$("#modules_list_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[
		{title:'ID', field:'id', width:20, sortable:true},
		{title:'模块识别码', field:'nid', width:60, sortable:true},
		{title:'模块名称', field:'name', width:60, sortable:true},
		{title:'序号', field:'pindex', width:20, sortable:true},
		{title:'是否为列表', field:'is_list', width:20, sortable:true, formatter: function(v, r){
			if(v==0)return '否';
			if(v==1)return '是';
		}},
		{title:'是否隐藏', field:'is_hide', width:20, sortable:true, formatter: function(v, r){
			if(v==0)return '否';
			if(v==1)return '是';
		}},		
		{title:'新增时间', field:'atime', width:60, sortable:true},
		{title:'新增ip', field:'addip', width:60, sortable:true},
		{title:'更新时间', field:'utime', width:60, sortable:true},
		{title:'更新ip', field:'updateip', width:60, sortable:true},	
		{title:'操作人', field:'op_username', width:20, sortable:true}
	]]
});

$("#moduels_list_panel").find("select[name='is_list']").change(function(){
	getModulesList();
});

$("#moduels_list_panel").find("select[name='is_hide']").change(function(){
	getModulesList();
});

$("#js_searchModulesBtn").click(function(){
	getModulesList();
});

function getModulesList(){
	var obj = {},
		panel = $("#moduels_list_panel");
	obj.nid = panel.find("input[name='nid']").val();
	obj.name = panel.find("input[name='name']").val();
	obj.is_list = panel.find("select[name='is_list']").find('option:selected').val();
	obj.is_hide = panel.find("select[name='is_hide']").find('option:selected').val();
	$("#modules_list_datagrid").datagrid('load', obj);
}

</script>