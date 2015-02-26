<?php if (!defined('THINK_PATH')) exit();?><style>
#advert_modules_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="advert_modules_edit_panel">
	<div id="advert_modules_edit_layout">
		<div title="广告模块" style="padding:10px 20px;">
			<div class="fitem">
				<label>模块：</label>
				<input name="modules" type="text" value="<?php echo ($tempData['modules']); ?>" />
			</div>
			<div class="fitem">
				<label>模块名称：</label>
				<input name="modules_name" type="text" value="<?php echo ($tempData['modules_name']); ?>" />
			</div>	
			<div class="fitem">
				<label>状态：</label>
				<input name="status" type="radio" value="1" />显示&nbsp;&nbsp;&nbsp;
				<input name="status" type="radio" value="0" />隐藏
			</div>			
		</div>	
	</div>
	<div style="margin:5px 30px;">
		<input name="id" type="hidden" value="<?php echo ($tempData['id']); ?>" />
		<a id="editAdvertModulesButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#advert_modules_edit_layout").tabs();

$("#advert_modules_edit_panel").find("input[name='status'][value='<?php echo (($tempData['status'])?($tempData['status']):0); ?>']").attr('checked', true);

$("#editAdvertModulesButton").click(function(){
	var obj = {},
		panel = $("#advert_modules_edit_panel");
	obj.id = panel.find("input[name='id']").val();
	obj.modules = panel.find("input[name='modules']").val();
	obj.modules_name = panel.find("input[name='modules_name']").val();
	obj.status = panel.find("input[name='status']:checked").val();
	if(obj.id>0 && obj.modules!="" && obj.modules_name!=""){
		$.post('__URL__/savemodules', obj, function(data){
			if(data>0){
				alert("操作成功~");
				$("#advert_modules_edit_panel").parent().window('close');
				$("#advert_modules_datagrid").datagrid('reload');
			}else{
				alert("操作失败~");
			}
		});
	}else{
		alert("提交数据不完整~");
	}
});

</script>