<?php if (!defined('THINK_PATH')) exit();?><style>
#articles_form_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{  margin-bottom:16px; clear:both; }  
.fitem label{  display:inline-block;  width:80px; float:left; }  
.fitem .itemContent{float:left;}
</style>
<div id="articles_form_edit_panel">
	<div id="articles_form_edit_layout">
		<div title="文章基本信息（1）" style="padding:10px 20px;">
			<div class="fitem">
				<label>所属模块：</label>
				<?php echo ($tempData['options']); ?>
			</div>
			<div class="fitem">
				<label>文章标题：</label>
				<input type="text" name="title" value="<?php echo ($tempData['title']); ?>" size="35" />
			</div>
			<div class="fitem">
				<label>缩略图：</label>
				<img id="imageUploadUrl_1" src="static/<?php echo (($tempData['thumbnail'])?($tempData['thumbnail']):'upload/no_pic.gif'); ?>" width="80" />
				<input id="textUploadUrl_1" type="hidden" value="<?php echo (($tempData['thumbnail'])?($tempData['thumbnail']):''); ?>" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/articles/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_1"></span>
			</div>
			<div class="fitem">
				<label>状态：</label>
				<input type="radio" name="status" value="0" checked />显示&nbsp;&nbsp;&nbsp;
				<input type="radio" name="status" value="1" />隐藏
			</div>
			<div class="fitem">
				<label>摘要：</label>
				<textarea name="summary" cols="30" rows="4"><?php echo ($tempData['summary']); ?></textarea>
			</div>
		</div>
		<div title="文章基本信息（2）" style="padding:10px 20px;">
			<div class="fitem">
				<label>作者：</label>
				<input type="text" name="author" value="<?php echo ($tempData['author']); ?>" size="10" />
			</div>
			<div class="fitem">
				<label>文章来源：</label>
				<input type="text" name="source" value="<?php echo ($tempData['source']); ?>" size="20" />
			</div>
			<div class="fitem">
				<label>原文链接：</label>
				<input type="text" name="link" value="<?php echo ($tempData['link']); ?>" size="45" />
			</div>
		</div>
		<div title="文章内容">
			<div style="padding:5px;">
				<textarea name="content" style="width:550px;height:300px;"><?php echo ($tempData['content']); ?></textarea>
			</div>			
		</div>
	</div>
	<div style="margin:5px 30px;">
		<input name="id" type="hidden" value="<?php echo ($tempData['id']); ?>" />
		<a id="editArticlesButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#articles_form_edit_layout").tabs();
$("#articles_form_edit_panel").find("[name='content']").xheditor({upLinkUrl:'',upLinkExt:"zip,rar,txt",upMultiple:'1',upImgUrl:'__GROUP__/Upload/saveImage',upImgExt:"jpg,jpeg,gif,png",upFlashUrl:'',upFlashExt:"swf",upMediaUrl:'',upMediaExt:"wmv,avi,wma,mp3,mid"});
$("#articles_form_edit_panel").find("input[name='status'][value='"+<?php echo (($tempData['status'])?($tempData['status']):0); ?>+"']").attr("checked", true);

$("#editArticlesButton").click(function(){
	var obj = {},
		panel = $("#articles_form_edit_panel");
	obj.id = panel.find("input[name='id']").val();
	obj.modules_id = panel.find("select[name='modules_id']").find('option:selected').val();
	obj.title = panel.find("input[name='title']").val();
	obj.author = panel.find("input[name='author']").val();
	obj.source = panel.find("input[name='source']").val();
	obj.link = panel.find("input[name='link']").val();
	obj.status = panel.find("input[name='status']:checked").val();
	obj.thumbnail = panel.find("#textUploadUrl_1").val();
	obj.summary = panel.find("textarea[name='summary']").val();
	obj.content = panel.find("textarea[name='content']").val();
	if(obj.id>0 && obj.modules_id>0 && obj.title!="" && obj.summary!="" && obj.content!=""){
		$.post('__URL__/save', obj, function(data){
			if(data>0){
				alert('操作成功~');
				$("#articles_form_edit_panel").parent().window('close');
				$("#articles_list_datagrid").datagrid('reload');
			}else{
				alert('操作失败~');
			}
		});
	}else{
		alert('提交数据不完整~');
	}
});
</script>