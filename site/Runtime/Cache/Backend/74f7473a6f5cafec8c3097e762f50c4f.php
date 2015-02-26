<?php if (!defined('THINK_PATH')) exit();?><style>
#linkage_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="linkage_edit_panel">
	<div id="linkage_edit_layout">
		<div title="联动数据" style="padding:10px 20px;">
			<div class="fitem">
				<label>联动名称：</label>
				<input name="id" type="hidden" value="<?php echo ($tempData['id']); ?>" />
				<input name="name" type="text" value="<?php echo ($tempData['name']); ?>" />
			</div>
			<div class="fitem">
				<label>联动值：</label>
				<input name="value" type="text" value="<?php echo ($tempData['value']); ?>" />
			</div>
			<div class="fitem">
				<label>操作类型：</label>
				<select name="type_id">
					<?php echo ($tempData['options']); ?>
				</select>
			</div>
			<div id="uploadimg" class="fitem" style="display:none;">
				<label>附加图片：</label>
				<img id="imageUploadUrl_1" src="static/<?php echo (($tempData['pic'])?($tempData['pic']):'upload/no_pic.gif'); ?>" width="80" />
				<input id="textUploadUrl_1" type="hidden" value="<?php echo (($tempData['pic'])?($tempData['pic']):''); ?>" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/bank/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_1"></span>
			</div>
			<div class="fitem">
				<label>状态：</label>
				<input name="status" type="radio" value="1" />显示&nbsp;&nbsp;&nbsp;
				<input name="status" type="radio" value="0" />隐藏
			</div>	
		</div>	
	</div>
	<div style="margin:5px 30px;">
		<a id="editLinkageButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#linkage_edit_layout").tabs();

$("#linkage_edit_panel").find("select[name='type_id']").val(<?php echo (($tempData['type_id'])?($tempData['type_id']):0); ?>);
$("#linkage_edit_panel").find("input[name='status'][value='<?php echo (($tempData['status'])?($tempData['status']):0); ?>']").attr('checked', true);

if(<?php echo (($tempData['type_id'])?($tempData['type_id']):0); ?>==1){
	$("#uploadimg").show();
}else{
	$("#uploadimg").hide();
}

$("select[name='type_id']").change(function(){
	var _this = $(this);
	if(_this.val()==25){
		$("#uploadimg").show();
	}else{
		$("#uploadimg").hide();
	}
});

$("#editLinkageButton").click(function(){
	var obj = {},
		panel = $("#linkage_edit_panel");
	obj.id = panel.find("input[name='id']").val();
	obj.name = panel.find("input[name='name']").val();
	obj.value = panel.find("input[name='value']").val();
	obj.type_id = panel.find("select[name='type_id']").find('option:selected').val();
	obj.status = panel.find("input[name='status']:checked").val();
	if(obj.type_id==25){
		obj.pic = $("#textUploadUrl_1").val();
	}
	if(obj.id>0 && obj.name!="" && obj.value!="" && obj.type_id>0 && obj.status!=""){
		if(obj.type_id==25 && obj.pic==""){
			alert("提交数据不完整~");
			return;
		}
		$.post('__URL__/save', obj, function(data){
			if(data>0){
				alert("操作成功~");
				$("#linkage_edit_panel").parent().window('close');
				$("#linkage_datagrid").datagrid('reload');
			}else{
				alert("操作失败~");
			}
		});
	}else{
		alert("提交数据不完整~");
	}
});

</script>