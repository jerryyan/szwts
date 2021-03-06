<?php if (!defined('THINK_PATH')) exit();?><style>
#articles_form_add_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{  margin-bottom:16px; clear:both; }  
.fitem label{  display:inline-block;  width:80px; float:left; }  
.fitem .itemContent{float:left;}
</style>
<div id="articles_form_add_panel">
	<div id="articles_form_add_layout">
		<div title="文章基本信息（1）" style="padding:10px 20px;">
			<div class="fitem">
				<label>所属模块：</label>
				<?php echo ($options); ?>
			</div>
			<div class="fitem">
				<label>文章标题：</label>
				<input type="text" name="title" value="" size="35" />
			</div>
			<div class="fitem">
				<label>缩略图：</label>
				<img id="imageUploadUrl_1" src="static/upload/no_pic.gif" width="80" />
				<input id="textUploadUrl_1" type="hidden" value="" />
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
				<textarea name="summary" cols="30" rows="4"></textarea>
			</div>
		</div>
		<div title="文章基本信息（2）" style="padding:10px 20px;">
			<div class="fitem">
				<label>作者：</label>
				<input type="text" name="author" value="" size="10" />
			</div>
			<div class="fitem">
				<label>文章来源：</label>
				<input type="text" name="source" value="" size="20" />
			</div>
			<div class="fitem">
				<label>原文链接：</label>
				<input type="text" name="link" value="" size="45" />
			</div>
		</div>
		<div title="文章内容">
			<div style="padding:5px;">
				<textarea name="content" style="width:550px;height:300px;"></textarea>
			</div>			
		</div>
	</div>
	<div style="margin:5px 30px;">
		<a id="addArticlesButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#articles_form_add_layout").tabs();
$("#articles_form_add_panel").find("[name='content']").xheditor({upLinkUrl:'',upLinkExt:"zip,rar,txt",upMultiple:'1',upImgUrl:'__GROUP__/Upload/saveImage',upImgExt:"jpg,jpeg,gif,png",upFlashUrl:'',upFlashExt:"swf",upMediaUrl:'',upMediaExt:"wmv,avi,wma,mp3,mid"});

$("#addArticlesButton").click(function(){
	var obj = {},
		panel = $("#articles_form_add_panel");
	obj.modules_id = panel.find("select[name='modules_id']").find('option:selected').val();
	obj.title = panel.find("input[name='title']").val();
	obj.author = panel.find("input[name='author']").val();
	obj.source = panel.find("input[name='source']").val();
	obj.link = panel.find("input[name='link']").val();
	obj.status = panel.find("input[name='status']:checked").val();
	obj.thumbnail = panel.find("#textUploadUrl_1").val();
	obj.summary = panel.find("textarea[name='summary']").val();
	obj.content = panel.find("textarea[name='content']").val();
	if(obj.modules_id>0 && obj.title!="" && obj.summary!="" && obj.content!=""){
		$.post('__URL__/save', obj, function(data){
			if(data>0){
				alert('操作成功~');
				$("#articles_form_add_panel").parent().window('close');
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