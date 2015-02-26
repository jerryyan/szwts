<?php if (!defined('THINK_PATH')) exit();?><div id="gallery_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	文件名称：<input name="name" type="text" />
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchGalleryBtn">搜索</a>
</div>
</div>
<table id="gallery_datagrid"></table>
</div>

<script>
$("#gallery_datagrid").datagrid({
	title: '图库列表',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getGalleryList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	toolbar: [{
		text: '删除',
		iconCls: 'icon-remove',
		handler: function(){
			var selected = $("#gallery_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			if(confirm("请谨慎操作，确认要删除此条记录吗？")){
				var obj = {};
				obj.id = selected.id;
				$.get('__URL__/delGallery', obj, function(data){
					if(data>0){
						alert('操作成功~');
						$("#gallery_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[ 
		{title:'ID', field:'id', width:30, sortable:true},
		{title:'名称', field:'name', width:100, sortable:true},
		{title:'类型', field:'extension', width:30, sortable:true},
		{title:'文件大小', field:'filesize', width:30, sortable:true},
		{title:'图片显示', field:'filepath', width:80, sortable:true, formatter:function(val, rec){
			return '<a href="'+val+'" target="_blank"><img src="'+val+'" title="'+rec.filepath+'" height="60" /></a>';
		}},
		{title:'添加时间', field:'atime', width:60, sortable:true},
		{title:'添加ip', field:'addip', width:60, sortable:true},
		{title:'操作员', field:'op_username', width:20, sortable:true}
	]]
});


$("#js_searchGalleryBtn").click(function(){
	getGalleryList();
});

function getGalleryList(){
	var obj = {},panel = $("#gallery_panel");
		obj.name = panel.find("input[name='name']").val();
	$("#gallery_datagrid").datagrid('load', obj);
}

</script>