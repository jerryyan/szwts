<?php if (!defined('THINK_PATH')) exit();?><div id="links_list_panel" style="height:670px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;"> 
	链接名称：<input name="webname" type="text" />
	类型：
	<select name="type">
		<option value="0">全部</option>
		<option value="1">友情链接</option>
		<option value="2">合作伙伴</option>
	</select>
	状态：
	<select name="status">
			<option value="-1">全部</option>
			<option value="0">显示</option>
			<option value="1">隐藏</option>		
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchLinksBtn">搜索</a>
</div>
</div>
<table id="links_list_datagrid"></table>
</div>

<script>
$("#links_list_datagrid").datagrid({
	title: '网站友情链接操作列表',
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
			$.addWindow($("#links_list_panel"), {
				title: '新增友情链接',
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
			var selected=$("#links_list_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#links_list_panel"), {
				title: '编辑/查看友情链接',
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
			var selected = $("#links_list_datagrid").datagrid("getSelected");
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
						$("#links_list_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[
		{title:'ID', field:'id', width:20, sortable:true},
		{title:'链接类型', field:'type_id', width:30, sortable:true, formatter: function(v, r){
			if(v==1)return '友情链接';
			if(v==2)return '合作伙伴';
		}},	
		{title:'网站名称', field:'webname', width:30, sortable:true},
		{title:'logo', field:'logo', width:60, sortable:true, formatter:function(v, r){
			return '<a href="static/'+v+'" title="'+r.webname+'" target="_blank"><img src="static/'+v+'" height="30" /></a>';
		}},
		{title:'官网链接', field:'weblink', width:80, sortable:true},
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

$("#links_list_panel").find("select[name='type']").change(function(){
	getLinksList();
});

$("#links_list_panel").find("select[name='status']").change(function(){
	getLinksList();
});

$("#js_searchLinksBtn").click(function(){
	getLinksList();
});

function getLinksList(){
	var obj = {},
		panel = $("#links_list_panel");
	obj.webname = panel.find("input[name='webname']").val();
	obj.type = panel.find("select[name='type']").find('option:selected').val();
	obj.status = panel.find("select[name='status']").find('option:selected').val();
	$("#links_list_datagrid").datagrid('load', obj);
}

</script>