<?php if (!defined('THINK_PATH')) exit();?><style>
#real_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="real_edit_panel">
	<div id="real_edit_layout">		
		<div title="实名认证信息" style="padding:10px 20px;">
			<div class="fitem">
				<label>用户名：</label>
				<?php echo ($tempData["username"]); ?>
			</div>
			<div class="fitem">
				<label>真实姓名：</label>
				<?php echo ($tempData["realname"]); ?>
			</div>
			<div class="fitem">
				<label>身份证号码：</label>
				<?php echo ($tempData["card_id"]); ?>
			</div>
			<div class="fitem">
				<label>性别：</label>
				<?php if($tempData["sex"] == 1): ?>男<?php else: ?>女<?php endif; ?>
			</div>
			<div class="fitem">
				<label>身份证正面：</label>
				<img id="imageUploadUrl_1" src="/static/<?php echo (($tempData['card_pic1'])?($tempData['card_pic1']):'upload/no_pic.gif'); ?>" width="80" />
			</div>
			<div class="fitem">
				<label>身份证反面：</label>
				<img id="imageUploadUrl_2" src="/static/<?php echo (($tempData['card_pic2'])?($tempData['card_pic2']):'upload/no_pic.gif'); ?>" width="80" />
			</div>
			<div class="fitem">
				<label>审核状态：</label>
				<?php if($tempData["real_status"] == 0): ?>等待审核
				<?php elseif($tempData["real_status"] == 1): ?>
					审核通过
				<?php elseif($tempData["real_status"] == 2): ?>
					审核失败<?php endif; ?>
			</div>
			
		</div>
		<?php if($tempData["real_status"] == 0): ?><div title="实名审核">
			<div style="padding:10px 20px;">
				<div class="fitem">
					<label>审核状态：</label>
					<input type="radio" name="real_status" value="1" />审核通过&nbsp;&nbsp;&nbsp;
					<input type="radio" name="real_status" value="2" checked />审核不通过
				</div>
				<div class="fitem">
					<label>备注：</label>
					<textarea name="remark" style="width:200px;height:100px;"></textarea>
				</div>
				<div class="fitem">
					<label>&nbsp;</label>
					<font color="#f00">（一旦审核通过将不可再进行修改，请慎重审核）</font>
				</div>
			</div>
			<div style="margin:5px 30px;">
				<input type="hidden" name="user_id" value="<?php echo ($tempData['user_id']); ?>" />
				<a id="verifyRealButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
			</div>
		</div><?php endif; ?>			
	</div>
</div>

<script>
$("#real_edit_layout").tabs();

$("#verifyRealButton").click(function(){
	var obj = {},
		panel = $("#real_edit_panel");
	obj.user_id = panel.find("input[name='user_id']").val();
	obj.real_status = panel.find("input[name='real_status']:checked").val();
	obj.remark = panel.find("textarea[name='remark']").val();
	if(obj.user_id>0 && obj.remark!=""){
		$.post('__URL__/saveByReal', obj, function(data){
			if(data>0){
				alert('操作成功~');
				panel.parent().window('close');
				$("#realname_datagrid").datagrid('reload');
			}else{
				alert('操作失败~');
			}
		});			
	}else{
		alert("提交数据不完整~");
	}
});


</script>