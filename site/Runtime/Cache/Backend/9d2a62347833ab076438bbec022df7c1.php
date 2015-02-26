<?php if (!defined('THINK_PATH')) exit();?><style>
#grade_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="grade_edit_panel">
	<div id="grade_edit_layout">
		<div title="评级基本信息(1)" style="padding:10px 20px;">
			<div class="fitem">
				<label>评级名称：</label>
				<input name="id" type="hidden" value="<?php echo (($tempData['id'])?($tempData['id']):0); ?>" />
				<input name="name" type="text" maxlength="15" size="15" value="<?php echo ($tempData['name']); ?>" />
			</div>
			<div class="fitem">
				<label>logo：</label>
				<img id="imageUploadUrl_1" src="static/<?php echo (($tempData['logo'])?($tempData['logo']):'upload/no_pic.gif'); ?>" width="80" />
				<input id="textUploadUrl_1" type="hidden" value="<?php echo (($tempData['logo'])?($tempData['logo']):''); ?>" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/grade/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_1"></span>
			</div>
			<div class="fitem">
				<label>状态：</label>
				<input name="status" type="radio" value='0' checked />显示&nbsp;&nbsp;&nbsp;
				<input name="status" type="radio" value='1'  />隐藏	
			</div>	
		</div>
		<div title="评级基本信息(2)" style="padding:10px 20px;">			
			<div class="fitem">
				<label>资本充足：</label>
				<input name="capital" type="text" size="28" value="<?php echo ($tempData['config']['capital']); ?>" />
			</div>
			<div class="fitem">
				<label>分散度：</label>
				<input name="dispersion" type="text" size="28" value="<?php echo ($tempData['config']['dispersion']); ?>" />
			</div>
			<div class="fitem">
				<label>透明度：</label>
				<input name="transparency" type="text" size="28" value="<?php echo ($tempData['config']['transparency']); ?>" />
			</div>
			<div class="fitem">
				<label>流动性：</label>
				<input name="mobility" type="text" size="28" value="<?php echo ($tempData['config']['mobility']); ?>" />
			</div>
			<div class="fitem">
				<label>运营能力：</label>
				<input name="operate" type="text" size="28" value="<?php echo ($tempData['config']['operate']); ?>" />
			</div>
			<div class="fitem">
				<label>违约成本：</label>
				<input name="cost" type="text" size="28" value="<?php echo ($tempData['config']['cost']); ?>" />
			</div>
		</div>
	</div>
	<div style="margin:5px 30px;">
		<a id="editGradeButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#grade_edit_layout").tabs();
$.loadEditor($("#grade_edit_panel").find("[name='introduction']"));

$("#editGradeButton").click(function(){
	var obj = {},
		panel = $("#grade_edit_panel");
	obj.id = $.trim(panel.find("input[name='id']").val());
	obj.name = $.trim(panel.find("input[name='name']").val());
	obj.logo = $.trim(panel.find("input[id='textUploadUrl_1']").val());
	obj.status = panel.find("input[name='status']:checked").val();
	obj.capital = $.trim(panel.find("input[name='capital']").val());
	obj.dispersion = $.trim(panel.find("input[name='dispersion']").val());
	obj.transparency = $.trim(panel.find("input[name='transparency']").val());
	obj.mobility = $.trim(panel.find("input[name='mobility']").val());
	obj.operate = $.trim(panel.find("input[name='operate']").val());
	obj.cost = $.trim(panel.find("input[name='cost']").val());
	if(obj.name==""){
		alert("名称不能为空");
		return;
	}
	if(obj.capital==""){
		alert("资金充足度不能为空");
		return;
	}
	if(obj.dispersion==""){
		alert("分散度不能为空");
		return;
	}
	if(obj.transparency==""){
		alert("透明度不能为空");
		return;
	}
	if(obj.mobility==""){
		alert("流动性不能为空");
		return;
	}
	if(obj.operate==""){
		alert("运营能力不能为空");
		return;
	}
	if(obj.cost==""){
		alert("违约成本不能为空");
		return;
	}
	$.post('__URL__/save', obj, function(data){
		if(data>0){
			alert("操作成功~");
			$("#grade_edit_panel").parent().window('close');
			$("#grade_datagrid").datagrid('reload');
		}else{
			alert("操作失败~");
		}
	});
});

</script>