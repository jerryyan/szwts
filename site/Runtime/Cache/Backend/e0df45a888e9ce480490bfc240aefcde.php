<?php if (!defined('THINK_PATH')) exit();?><div id="platform_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	平台名称：<input flag="name" type="text" /> 
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchPlatformBtn">搜索</a>
</div>
</div>
<table id="platform_datagrid"></table>
</div>

<script>

$("#platform_datagrid").datagrid({
	title: '合作平台列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getPlatformList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '新增合作平台',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#platform_panel"), {
				title: '新增合作平台',
				href: '__URL__/add',
				closable: true,
				minimizable: true,
				modal: true,
				width: 600,
				cache: false
			});
		}
	}, '-', {
		text: '编辑/查看',
		iconCls: 'icon-edit',
		handler: function(){
			var selected = $("#platform_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#platform_panel"), {
				title: '编辑/查看平台信息',
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
			var selected = $("#platform_datagrid").datagrid("getSelected");
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
						$("#platform_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[
                {title:'排序', field:'orderby', width:20, sortable:true},
		{title:'ID', field:'id', width:20, sortable:true},
		{title:'平台名称', field:'name', width:50, sortable:true},
		{title:'平台编号', field:'code', width:60, sortable:true},
		{title:'通信密钥', field:'signkey', width:60, sortable:true},
		{title:'logo', field:'logo', width:100, sortable:true, formatter:function(val, rec){
			return '<img src="static/'+rec.logo+'" height="30" />';
		}},
		{title:'安全评级', field:'grade_name', width:40, sortable:true},
		{title:'官方网址', field:'website', width:100, sortable:true},
		{title:'注册资金', field:'injection', width:40, sortable:true},
		{title:'所在地区', field:'location', width:50, sortable:true},		
		{title:'上线时间', field:'online_time', width:50, sortable:true},
		{title:'ICP备案', field:'icp', width:80, sortable:true},
		{title:'联系电话', field:'telephone', width:60, sortable:true},
		{title:'服务邮箱', field:'email', width:60, sortable:true},
		{title:'状态', field:'status', width:30, sortable:true, formatter:function(val, rec){
			if(val==0)return '显示';
			if(val==1)return '隐藏';
		}},
		{title:'新增时间', field:'atime', width:60, sortable:true},
		{title:'更新时间', field:'utime', width:60, sortable:true},
		{title:'操作人', field:'op_username', width:50, sortable:true}
	]]
});

$("#js_searchPlatformBtn").bind('click', function(){
	getPlatformList();
});

function getPlatformList(){
	var obj = {},
		panel = $("#platform_panel");
		obj.name = panel.find("input[flag='name']").val();
	$("#platform_datagrid").datagrid('load', obj);
}

</script>