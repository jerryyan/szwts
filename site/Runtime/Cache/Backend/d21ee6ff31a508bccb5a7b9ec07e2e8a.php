<?php if (!defined('THINK_PATH')) exit();?><div id="linkage_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	名称：<input name="name" type="text" /> 
	操作类型：<select name="type_id"><?php echo ($options); ?></select>
	状态：
	<select name="status">
		<option value="-1">--请选择--</option>
		<option value="0">隐藏</option>
		<option value="1">显示</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchLinkageBtn">搜索</a>
</div>
</div>
<table id="linkage_datagrid"></table>
</div>

<script>
$("#linkage_datagrid").datagrid({
	title: '操作类型联动列表',
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
			$.addWindow($("#linkage_panel"), {
				title: '新增类型联动',
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
			var selected = $("#linkage_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#linkage_panel"), {
				title: '编辑/查看类型联动',
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
			var selected = $("#linkage_datagrid").datagrid("getSelected");
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
						$("#linkage_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}, '-', {
		text: '设置缓存',
		iconCls: 'icon-add',
		handler: function(){
			$.get('__URL__/setCache', {}, function(data){
				if(data>0){
					alert('操作成功~');
					$("#linkage_datagrid").datagrid('reload');
				}else{
					alert('操作失败~');
				}
			});
		}
	}],
	columns: [[ 
		{title:'ID', field:'id', width:30, sortable:true},
		{title:'类型名称', field:'type_name', width:60, sortable:true},
		{title:'联动名称', field:'name', width:60, sortable:true},
		{title:'联动值', field:'value', width:60, sortable:true},
		{title:'状态', field:'status', width:60, sortable:true, formatter:function(val, rec){
			if(val==0)return '隐藏';
			if(val==1)return '显示';
		}},
		{title:'添加时间', field:'atime', width:60, sortable:true},
		{title:'添加ip', field:'addip', width:60, sortable:true},
		{title:'更新时间', field:'utime', width:60, sortable:true},
		{title:'更新ip', field:'updateip', width:60, sortable:true},
		{title:'操作员', field:'op_username', width:60, sortable:true}
	]]
});

$("#linkage_panel").find("select[name='type_id']").change(function(){
	getLinkageList();
});

$("#linkage_panel").find("select[name='status']").change(function(){
	getLinkageList();
});

$("#js_searchLinkageBtn").click(function(){
	getLinkageList();
});

function getLinkageList(){
	var obj = {},panel = $("#linkage_panel");
		obj.name = panel.find("input[name='name']").val();
		obj.type_id = panel.find("select[name='type_id']").find('option:selected').val();
		obj.status = panel.find("select[name='status']").find('option:selected').val();
	$("#linkage_datagrid").datagrid('load', obj);
}

</script>