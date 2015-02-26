<?php if (!defined('THINK_PATH')) exit();?><div id="platform_relation_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	平台名称：<select flag="platform">
		<?php echo ($options); ?>
	</select>
	用户名：<input flag="username" type="text" /> 
	真实姓名：<input flag="realname" type="text" /> 
	绑定状态：<select flag="status">
		<option value="-1">全部</option>
		<option value="0">未绑定</option>
		<option value="1">已绑定</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchPlatRelationBtn">搜索</a>
</div>
</div>
<table id="platform_relation_datagrid"></table>
</div>

<script>

$("#platform_relation_datagrid").datagrid({
	title: '平台与会员账户绑定记录',
	fit:true,
	nowrap: false,
	striped: true,
	collapsible:false,
	url: '__URL__/getRelationList',
	pagination:true,
	rownumbers:true,
	singleSelect:true,
	fitColumns:true,
	pageSize:20,
	columns: [[
		{title:'平台名称', field:'platname', width:100, sortable:true},
		{title:'用户名', field:'username', width:100, sortable:true},
		{title:'真实姓名', field:'realname', width:100, sortable:true},
		{title:'绑定用户名', field:'relation_name', width:100, sortable:true},
		{title:'绑定状态', field:'status', width:100, sortable:true, formatter:function(val, rec){
			if(val==0)return '未绑定';
			if(val==1)return '<font color="#009900;">已绑定</font>';
		}},
		{title:'账户类型', field:'atype', width:100, sortable:true},
		{title:'绑定时间', field:'atime', width:100, sortable:true}
	]]
});

$("#platform_relation_panel").find("select[flag='platform'],select[flag='status']").change(function(){
	getRelationList();
});

$("#js_searchPlatRelationBtn").bind('click', function(){
	getRelationList();
});

function getRelationList(){
	var obj = {},
		panel = $("#platform_relation_panel");
		obj.plat_id = panel.find("select[flag='platform']").find('option:selected').val();
		obj.username = panel.find("input[flag='username']").val();
		obj.realname = panel.find("input[flag='realname']").val();
		obj.status = panel.find("select[flag='status']").find('option:selected').val();
	$("#platform_relation_datagrid").datagrid('load', obj);
}

</script>