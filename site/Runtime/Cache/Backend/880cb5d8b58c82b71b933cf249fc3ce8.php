<?php if (!defined('THINK_PATH')) exit();?><div id="articles_list_panel" style="height:670px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;"> 
	标题：<input name="title" type="text" />
	是否列表：<?php echo ($options); ?>	
	状态：
	<select name="status">
			<option value="-1">全部</option>
			<option value="0">显示</option>
			<option value="1">隐藏</option>		
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchArticlesBtn">搜索</a>
</div>
</div>
<table id="articles_list_datagrid"></table>
</div>

<script>
$("#articles_list_datagrid").datagrid({
	title: '网站文章操作列表',
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
		text: '新增',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#articles_list_panel"), {
				title: '新增网站文章',
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
			var selected=$("#articles_list_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#articles_list_panel"), {
				title: '编辑/查看网站文章',
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
			var selected = $("#articles_list_datagrid").datagrid("getSelected");
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
						$("#articles_list_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[
		{title:'ID', field:'id', width:20, sortable:true},
		{title:'模块名称', field:'modules_name', width:30, sortable:true},
		{title:'标题', field:'title', width:100, sortable:true},
		{title:'文章来源', field:'source', width:30, sortable:true},
		{title:'状态', field:'status', width:20, sortable:true, formatter: function(v, r){
			if(v==0)return '显示';
			if(v==1)return '隐藏';
		}},		
		{title:'新增时间', field:'atime', width:60, sortable:true},
		{title:'新增ip', field:'addip', width:60, sortable:true},
		{title:'更新时间', field:'utime', width:60, sortable:true},
		{title:'更新ip', field:'updateip', width:60, sortable:true},	
		{title:'操作人', field:'op_username', width:20, sortable:true}
	]]
});

$("#articles_list_panel").find("select[name='modules_id']").change(function(){
	getArticlesList();
});

$("#articles_list_panel").find("select[name='status']").change(function(){
	getArticlesList();
});

$("#js_searchArticlesBtn").click(function(){
	getArticlesList();
});

function getArticlesList(){
	var obj = {},
		panel = $("#articles_list_panel");
	obj.title = panel.find("input[name='title']").val();
	obj.modules_id = panel.find("select[name='modules_id']").find('option:selected').val();
	obj.status = panel.find("select[name='status']").find('option:selected').val();
	$("#articles_list_datagrid").datagrid('load', obj);
}

</script>