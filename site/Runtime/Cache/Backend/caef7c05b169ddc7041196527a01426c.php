<?php if (!defined('THINK_PATH')) exit();?><style>
#bank_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="bank_edit_panel">
	<div id="bank_edit_layout">
		<div title="银行提现账户" style="padding:10px 20px;">
			<div class="fitem">
				<label>用户名：</label>
				<input name="username" type="text" maxlength="15" size="15" value="<?php echo ($tempData['username']); ?>" disabled />
			</div>
			<div class="fitem">
				<label>所属银行：</label>
				<?php echo ($options); ?>
				<span></span>
			</div>
			<div class="fitem">
				<label>银行账号：</label>
				<input name="account" type="text" size="25" value="<?php echo ($tempData['account']); ?>" />
			</div>	
			<div class="fitem">
				<label>开户支行：</label>
				<input name="branch" type="text" size="35" value="<?php echo ($tempData['branch']); ?>" />
			</div>		
		</div>	
	</div>
	<div style="margin:5px 30px;">
		<input name="id" type="hidden" value="<?php echo ($tempData['id']); ?>" />
		<input name="uid" type="hidden" value="<?php echo ($tempData['user_id']); ?>" />
		<a id="editBankButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#bank_edit_layout").tabs();

$("#bank_edit_panel").find("select[name='bank']").val(<?php echo (($tempData['bank'])?($tempData['bank']):0); ?>);

$("#editBankButton").click(function(){
	var obj = {},
		panel = $("#bank_edit_panel");
	obj.id = panel.find("input[name='id']").val();
	obj.user_id = panel.find("input[name='uid']").val();
	obj.bank = panel.find("select[name='bank']").find('option:selected').val();
	obj.account = panel.find("input[name='account']").val();
	obj.branch = panel.find("input[name='branch']").val();
	if(obj.id>0 && obj.bank>0 && obj.account!="" && obj.location!="" && obj.branch!=""){
		$.post('__URL__/save', obj, function(data){
			if(data>0){
				alert("操作成功~");
				$("#bank_edit_panel").parent().window('close');
				$("#bank_datagrid").datagrid('reload');
			}else{
				alert("操作失败~");
			}
		});
	}else{
		alert("提交数据不完整~");
	}
});

</script>