<?php if (!defined('THINK_PATH')) exit();?><div id="invest_panel" style="height:600px;">
<div style="padding:10px 20px;" class="selectPanel">
<div style="margin-bottom:8px;">
	平台名称：<select flag="platform">
		<?php echo ($options); ?>
	</select>
	用户名：<input flag="username" type="text" /> 
	真实姓名：<input flag="realname" type="text" />
	开始时间：<input flag="start_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	结束时间：<input flag="end_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;"/>
	状态：<select flag="state">
			<option value="-1">全部</option>
			<option value="0">还款中</option>
			<option value="1">已还完</option>
			<option value="2">已逾期</option>
	</select>
	<a class="easyui-linkbutton" iconCls="icon-search" id="js_searchInvestBtn">搜索</a>
	<a class="easyui-linkbutton" id="js_exportInvestBtn">导出excel</a>
</div>
</div>
<table id="invest_datagrid"></table>
</div>

<script>

$("#invest_datagrid").datagrid({
	title: '客户投资列表',
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
		text: '远程获取投资记录',
		iconCls: 'icon-add',
		handler: function(){
			$.addWindow($("#invest_panel"), {
				title: '远程获取投资记录',
				href: '__URL__/add',
				closable: true,
				minimizable: true,
				modal: true,
				width: 300,
				height: 260,
				cache: false
			});
		}
	}],
	columns: [[
		{title:'订单编号', field:'order_id', width:30, sortable:true},
		{title:'平台名称', field:'platform_name', width:60, sortable:true},
		{title:'用户名', field:'username', width:40, sortable:true},
		{title:'真实姓名', field:'realname', width:40, sortable:true},
		{title:'项目名称', field:'project_name', width:80, sortable:true},
		{title:'投资金额', field:'amount', width:60, sortable:true},		
		{title:'待收总额', field:'wait_amount', width:60, sortable:true},
		{title:'投资期限', field:'isday', width:30, sortable:true, formatter:function(val, rec){
			if(val==0)return rec.term+'个月';
			if(val==1)return rec.term+'天';
		}},
		{title:'年化利率', field:'rate', width:50, sortable:true},
		{title:'投资时间', field:'atime', width:80, sortable:true},
                {title:'还款时间', field:'etime', width:80, sortable:true},
		{title:'交易状态', field:'state', width:50, sortable:true, formatter:function(val, rec){
			if(val==0)return '还款中';
			if(val==1)return '<font color="#009900;">已还完</font>';
			if(val==2)return '<font color="#f00;">已逾期</font>';
		}}
	]]
});

$("#invest_panel").find("select[flag='state'],select[flag='platform']").change(function(){
	getInvestList();
});

$("#js_searchInvestBtn").bind('click', function(){
	getInvestList();
});

function getInvestList(){
	var obj = {},
		panel = $("#invest_panel");
		obj.plat_id = panel.find("select[flag='platform']").find("option:selected").val();
		obj.username = panel.find("input[flag='username']").val();
		obj.realname = panel.find("input[flag='realname']").val();
		obj.start_time = panel.find("input[flag='start_time']").val();
		obj.end_time = panel.find("[input[flag='end_time']").val();
		obj.state = panel.find("select[flag='state']").find("option:selected").val();
	$("#invest_datagrid").datagrid('load', obj);
}

$("#js_exportInvestBtn").bind('click', function(){
	var panel = $("#invest_panel"),
		plat_id = panel.find("select[flag='platform']").find("option:selected").val(),
		username = panel.find("input[flag='username']").val(),
		realname = panel.find("input[flag='realname']").val(),
		start_time = panel.find("input[flag='start_time']").val(),
		end_time = panel.find("input[flag='end_time']").val(),
		state = panel.find("select[flag='state']").find("option:selected").val(),
		operation = "export",
		params = [];
	if(plat_id!=""){params.push("plat_id="+plat_id);}
	if(username!=""){params.push("username="+username);}
	if(realname!=""){params.push("realname="+realname);}
	if(start_time!=""){params.push("start_time="+start_time);}
	if(end_time!=""){params.push("end_time="+end_time);}
	if(state!=""){params.push("state="+state);}
	if(operation!=""){params.push("operation="+operation);}
	if(params.length>0){
		params = params.join('&');
	}else{
		params = '';
	}
	location.href = '__URL__/getList?'+params;
});

</script>