<?php if (!defined('THINK_PATH')) exit();?><div id="grade_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	等级名称：<input flag="name" type="text" /> 
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchGradeBtn">搜索</a>
</div>
</div>
<table id="grade_datagrid"></table>
</div>

<script>

$("#grade_datagrid").datagrid({
	title: '平台安全评级列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getGradeList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '新增评级',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#grade_panel"), {
				title: '新增评级',
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
			var selected = $("#grade_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#grade_panel"), {
				title: '编辑/查看评级信息',
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
			var selected = $("#grade_datagrid").datagrid("getSelected");
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
						$("#grade_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[
		{title:'ID', field:'id', width:60, sortable:true},
		{title:'评级名称', field:'name', width:60, sortable:true},
		{title:'logo', field:'logo', width:60, sortable:true, formatter:function(val, rec){
			if(val==''){return '<img src="static/upload/no_pic.gif" height="30" />';}
			else{return '<img src="static/'+rec.logo+'" height="30" />';}
		}},
		{title:'资本充足', field:'capital', width:60, sortable:true, formatter:function(val, rec){
			return rec.config['capital'];
		}},
		{title:'分散度', field:'dispersion', width:60, sortable:true, formatter:function(val, rec){
			return rec.config['dispersion'];
		}},
		{title:'透明度', field:'transparency', width:60, sortable:true, formatter:function(val, rec){
			return rec.config['transparency'];
		}},		
		{title:'流动性', field:'mobility', width:60, sortable:true, formatter:function(val, rec){
			return rec.config['mobility'];
		}},
		{title:'运营能力', field:'operate', width:60, sortable:true, formatter:function(val, rec){
			return rec.config['operate'];
		}},
		{title:'违约成本', field:'cost', width:60, sortable:true, formatter:function(val, rec){
			return rec.config['cost'];
		}},
		{title:'状态', field:'status', width:60, sortable:true, formatter:function(val, rec){
			if(val==0)return '显示';
			if(val==1)return '隐藏';
		}},
		{title:'是否删除', field:'is_del', width:60, sortable:true, formatter:function(val, rec){
			if(val==0)return '否';
			if(val==1)return '是';
		}},		
		{title:'新增时间', field:'atime', width:60, sortable:true},
		{title:'更新时间', field:'utime', width:60, sortable:true},
		{title:'操作人', field:'op_username', width:60, sortable:true}
	]]
});

$("#js_searchGradeBtn").bind('click', function(){
	getPlatformList();
});

function getPlatformList(){
	var obj = {},
		panel = $("#grade_panel");
		obj.name = panel.find("input[flag='name']").val();
	$("#grade_datagrid").datagrid('load', obj);
}

</script>