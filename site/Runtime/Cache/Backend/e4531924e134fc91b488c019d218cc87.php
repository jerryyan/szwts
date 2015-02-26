<?php if (!defined('THINK_PATH')) exit();?><style>
#repay_update_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="repay_update_panel">
	<div id="repay_update_layout">
		<div title="更新条件" style="padding:10px 20px;">
			<div class="fitem">
				<label>更新日期：</label>
				<input name="querydate" type="text" maxlength="15" size="15" class="date mr20 Wdate" onclick="WdatePicker();" />
			</div>			
		</div>
	</div>
	<div style="margin:5px 30px;">
		<a id="updateRepayButton" class="easyui-linkbutton" iconCls="icon-save">远程更新</a> 
	</div>
</div>

<script>
$("#repay_update_layout").tabs();
$("#updateRepayButton").click(function(){
	var obj = {},
		panel = $("#repay_update_panel");
	obj.querydate = $.trim(panel.find("input[name='querydate']").val());
	$.get('__URL__/updateTenderlog', obj, function(data){
		if(data>0){
			var obj = {},panel = $("#repay_update_panel");
			obj.plat_id = panel.find("select[flag='platform']").find("option:selected").val();
			obj.username = panel.find("input[flag='username']").val();
			obj.realname = panel.find("input[flag='realname']").val();
			$("#invest_repay_datagrid").datagrid('load', obj);	
			$("#repay_update_panel").parent().window('close');
		}else{
			alert("暂时没有获取到任何数据");
		}
	});
});

</script>