<?php if (!defined('THINK_PATH')) exit();?><div id="advert_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	标题：<input name="title" type="text" />
	模块：
	<select name="type_id">
		<?php echo ($options); ?>
	</select> 
	状态：
	<select name="status">
		<option value="-1">--请选择--</option>
		<option value="0">隐藏</option>
		<option value="1">显示</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchAdvertBtn">搜索</a>
</div>
</div>
<table id="advert_datagrid"></table>
</div>

<script>
$("#advert_datagrid").datagrid({
	title: '广告图片列表',
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
			$.addWindow($("#advert_panel"), {
				title: '新增广告图片',
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
			var selected = $("#advert_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#advert_panel"), {
				title: '修改广告图片信息',
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
			var selected = $("#advert_datagrid").datagrid("getSelected");
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
						$("#advert_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[ 
		{title:'ID', field:'id', width:30, sortable:true},
		{title:'标题', field:'title', width:100, sortable:true},
		{title:'所属模块', field:'modules', width:30, sortable:true},
		{title:'模块名称', field:'modules_name', width:30, sortable:true},
		{title:'图片', field:'pic', width:120, sortable:true, formatter:function(val, rec){
			return '<a href="static/'+val+'" title="'+rec.title+'" target="_blank"><img src="static/'+val+'" height="60" /></a>';
		}},
		{title:'显示位置', field:'position', width:30, sortable:true},
		{title:'状态', field:'status', width:20, sortable:true, formatter:function(val, rec){
			if(val==0)return "隐藏";
			if(val==1)return "显示";
		}},
		{title:'排序', field:'order', width:20, sortable:true},
		{title:'添加时间', field:'atime', width:60, sortable:true},
		{title:'添加ip', field:'addip', width:60, sortable:true},
		{title:'更新时间', field:'utime', width:60, sortable:true},
		{title:'更新ip', field:'updateip', width:60, sortable:true},
		{title:'操作员', field:'op_username', width:20, sortable:true}
	]]
});

$("#advert_panel").find("select[name='type_id']").change(function(){
	getAdvertList();
});

$("#advert_panel").find("select[name='status']").change(function(){
	getAdvertList();
});

$("#js_searchAdvertBtn").click(function(){
	getAdvertList();
});

function getAdvertList(){
	var obj = {},panel = $("#advert_panel");
		obj.title = panel.find("input[name='title']").val();
		obj.type_id = panel.find("select[name='type_id']").find("option:selected").val();
		obj.status = panel.find("select[name='status']").find("option:selected").val();
	$("#advert_datagrid").datagrid('load', obj);
}

</script>