<?php if (!defined('THINK_PATH')) exit();?><div id="bank_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	用户名：<input name="username" type="text" /> 
	真实姓名：<input name="realname" type="text" />
	银行名称：<?php echo ($options); ?>
	开始时间：<input name="start_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	结束时间：<input name="end_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchBankBtn">搜索</a>
</div>
</div>
<table id="bank_datagrid"></table>
</div>

<script>
$("#bank_datagrid").datagrid({
	title: '会员银行账户列表',
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
		text: '新增提现账户',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#bank_panel"), {
				title: '新增银行提现账户',
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
			var selected = $("#bank_datagrid").datagrid("getSelected");
			if(!selected){
				$.messager.alert('系统提示','请选择操作项');
				return false;
			}
			$.addWindow($("#bank_panel"), {
				title: '编辑/查看银行提现账户',
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
			var selected = $("#bank_datagrid").datagrid("getSelected");
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
						$("#bank_datagrid").datagrid('reload');
					}else{
						alert('操作失败~');
					}
				});		
			}
		}
	}],
	columns: [[ 
		{title:'ID', field:'id', width:30, sortable:true},
		{title:'用户名', field:'username', width:30, sortable:true},
		{title:'真实姓名', field:'realname', width:30, sortable:true},
		{title:'银行名称', field:'bank_name', width:50, sortable:true},
		{title:'开户支行', field:'branch', width:100, sortable:true},
		{title:'银行卡号', field:'account', width:70, sortable:true},
		{title:'添加时间', field:'atime', width:50, sortable:true},
		{title:'添加ip', field:'addip', width:60, sortable:true},
		{title:'更新时间', field:'utime', width:50, sortable:true},
		{title:'更新ip', field:'updateip', width:60, sortable:true},
		{title:'操作员', field:'op_username', width:20, sortable:true}
	]]
});

$("#bank_panel").find("select[name='bank']").change(function(){
	getBankList();
});

$("#js_searchBankBtn").click(function(){
	getBankList();
});

function getBankList(){
	var obj = {},panel = $("#bank_panel");
		obj.username = panel.find("input[name='username']").val();
		obj.realname = panel.find("input[name='realname']").val();
		obj.start_time = panel.find("input[name='start_time']").val();
		obj.end_time = panel.find("[input[name='end_time']").val();
		obj.bank = panel.find("select[name='bank']").find('option:selected').val();
	$("#bank_datagrid").datagrid('load', obj);
}

</script>