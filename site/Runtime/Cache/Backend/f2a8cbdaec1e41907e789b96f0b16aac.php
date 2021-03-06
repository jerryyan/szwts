<?php if (!defined('THINK_PATH')) exit();?><style>
#bank_add_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="bank_add_panel">
	<div id="bank_add_layout">
		<div title="银行提现账户" style="padding:10px 20px;">
			<div class="fitem">
				<label>用户名：</label>
				<input id="bank_uid" name="bank_uid" type="hidden" value="0" />
				<input name="username" type="text" maxlength="15" size="15" />
			</div>
			<div class="fitem">
				<label>所属银行：</label>
				<?php echo ($options); ?>
				<span></span>
			</div>
			<div class="fitem">
				<label>银行账号：</label>
				<input name="account" type="text" size="25" />
			</div>				
			<div class="fitem">
				<label>开户行：</label>
				<input name="branch" type="text" size="35" />
			</div>		
		</div>	
	</div>
	<div style="margin:5px 30px;">
		<a id="addBankButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#bank_add_layout").tabs();

$("#bank_add_panel").find("input[name='username']").change(function(){
	var obj = {},
		_this = $(this);
		obj.username = _this.val();
	$.get('__GROUP__/User/checkUser', obj, function(data){
		if(data>0){
			$("#bank_uid").val(data);
		}else{
			alert("没有这个用户名");
			_this.val("");
			$("#bank_uid").val(0);
		}
	});
});

$("#addBankButton").click(function(){
	var obj = {},
		panel = $("#bank_add_panel");
	obj.user_id = $("#bank_uid").val();
	obj.bank = panel.find("select[name='bank']").find('option:selected').val();
	obj.account = panel.find("input[name='account']").val();
	obj.branch = panel.find("input[name='branch']").val();
	if(obj.user_id>0 && obj.bank>0 && obj.account!="" && obj.location!="" && obj.branch!=""){
		$.post('__URL__/save', obj, function(data){
			if(data>0){
				alert("操作成功~");
				$("#bank_add_panel").parent().window('close');
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