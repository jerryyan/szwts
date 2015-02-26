<?php if (!defined('THINK_PATH')) exit();?><style>
#cash_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
</style>
<div id="cash_edit_panel">
	<div id="cash_edit_layout">
		<div title="充值信息查看" style="padding:10px 20px;">
			<div class="fitem">
				<label>用户名：</label>
				<?php echo ($tempData['username']); ?>
			</div>
			<div class="fitem">
				<label>提现银行：</label>
				<?php echo ($tempData['bankname']); ?>
			</div>
			<div class="fitem">
				<label>提现支行：</label>
				<?php echo ($tempData['branch']); ?>
			</div>
			<div class="fitem">
				<label>提现账号：</label>
				<?php echo ($tempData['account']); ?>
			</div>
			<div class="fitem">
				<label>提现金额：</label>
				<?php echo ($tempData['total']); ?>
			</div>
			<div class="fitem">
				<label>到账金额：</label>
				<?php echo ($tempData['money']); ?>
			</div>
			<div class="fitem">
				<label>手续费：</label>
				<?php echo ($tempData['fee']); ?>
			</div>
			<div class="fitem">
				<label>提现时间/IP：</label>
				<?php echo (date("Y-m-d H:i:s",$tempData['addtime'])); ?>/<?php echo ($tempData['addip']); ?>
			</div>		
			<div class="fitem">
				<label>审核人：</label>
				<?php echo ($tempData['verify_username']); ?>
			</div>
			<div class="fitem">
				<label>审核状态：</label>
				<?php if($tempData["status"] == 0): ?>等待审核
				<?php elseif($tempData["status"] == 1): ?>审核通过
				<?php elseif($tempData["status"] == 2): ?>审核失败
				<?php elseif($tempData["status"] == 3): ?>提现取消<?php endif; ?>
			</div>
			<div class="fitem">
				<label>审核时间：</label>
				<?php echo (date("Y-m-d H:i:s",$tempData['verify_time'])); ?>
			</div>	
			<div class="fitem">
				<label>审核人备注：</label>
				<?php echo ($tempData['verify_remark']); ?>
			</div>
		</div>
		<?php if(($tempData["status"] == 0)): ?><div title="提现审核">
			<div style="padding:10px 20px;">
				<div class="fitem">
					<label>审核状态：</label>
					<input type="radio" name="status" value="1" checked />审核通过&nbsp;&nbsp;&nbsp;
					<input type="radio" name="status" value="2" />审核失败&nbsp;&nbsp;&nbsp;					
				</div>
				<div class="fitem">
					<label>提现金额：</label>
					<input type="text" name="money" value="<?php echo ($tempData['total']); ?>" readonly />
				</div>
				<div class="fitem">
					<label>到账金额：</label>
					<input type="text" name="money" value="<?php echo ($tempData['money']); ?>" readonly />
				</div>
				<div class="fitem">
					<label>手续费：</label>
					<input type="text" name="money" value="<?php echo ($tempData['fee']); ?>" readonly />
				</div>
				<div class="fitem">
					<label>备注：</label>
					<textarea name="verify_remark" style="width:200px;height:100px;"></textarea>
				</div>
				<div class="fitem">
					<label>&nbsp;</label>
					<font color="#f00">（一旦审核通过将不可再进行修改，请慎重审核）</font>
				</div>
			</div>
			<div style="margin:5px 30px;">
				<input type="hidden" name="id" value="<?php echo ($tempData['id']); ?>" />
				<a id="saveCashButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
			</div>
		</div><?php endif; ?>
	</div>
</div>

<script>
$("#cash_edit_layout").tabs();

$("#saveCashButton").click(function(){
	var obj = {},
		panel = $("#cash_edit_panel");
	obj.id = panel.find("input[name='id']").val();
	obj.status = panel.find("input[name='status']:checked").val();
	obj.verify_remark = panel.find("textarea[name='verify_remark']").val();
	if(obj.verify_remark!=""){
		$.post('__URL__/changeCash', obj, function(data){
			if(data>0){
				alert('操作成功~');
				panel.parent().window('close');
				$("#cash_datagrid").datagrid('reload');
			}else{
				alert('操作失败~');
			}
		});		
	}else{
		alert('审核时备注不能为空~');
	}
});
</script>