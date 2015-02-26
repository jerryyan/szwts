<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="__ROOT__/static/js/jquery.js?version=1.7.1"></script>
<script type="text/javascript" src="__ROOT__/static/js/plugins/layer.min.js?version=1.8.4"></script>
</head>
<body>
<form id="upload" method="post" action="__GROUP__/Upload/save" enctype="multipart/form-data">
	<input name="type" type="hidden" value="<?php echo ($tempData['type']); ?>" />
	<input name="id" type="hidden" value="<?php echo ($tempData['id']); ?>" />
	<input name="savepath" type="hidden" value="<?php echo ($tempData['savepath']); ?>" />
	<input id="file" type="file" name="file" style="position:absolute;left:0;top:0;width:101px; text-align:center;height:31px;display:inline-block;overflow:hidden;font-size:12px;opacity:0;filter:alpha(opacity:0);cursor:pointer;" /> 
	<input type="submit" value="上传" style="position:absolute;left:0;top:0;width:95px;border:0px;height:28px;z-index:-1;border-radius:4px;cursor:pointer;background:#129ceb;color:#FFF;" /> 
</form>
<script>
$("#file").change(function(){
	var fileInput = $("#file")[0],
		file = fileInput.files[0],
		name = file.name,
		size = Math.ceil(file.size/1024),
		ext = name.split('.');
	if(ext[1]!='jpg' && ext[1]!='JPG' && ext[1]!='gif' && ext[1]!='GIF' && ext[1]!='png' && ext[1]!='PNG'){
		parent.layer.alert('文件格式不正确，必须为jpg，gif或png类型', 8);
		return;
	}
	if(size>500){
		parent.layer.alert('文件太大，必须小于500KB，请调整大小后再次上传', 8);
		return;
	}
	$("#upload").submit();	
});
</script>
</body>
</html>