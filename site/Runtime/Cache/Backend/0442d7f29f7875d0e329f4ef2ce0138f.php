<?php if (!defined('THINK_PATH')) exit();?><style>
#links_form_add_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{  margin-bottom:16px; clear:both; }  
.fitem label{  display:inline-block;  width:80px; float:left; }  
.fitem .itemContent{float:left;}
</style>
<div id="links_form_add_panel">
	<div id="links_form_add_layout">
		<div title="基本信息" style="padding:10px 20px;">
			<div class="fitem">
				<label>网站名称：</label>
				<input type="text" name="webname" value="" size="20" />
			</div>
			<div class="fitem">
				<label>类型：</label>
				<select name="type">
					<option value="1">友情链接</option>
					<option value="2">合作伙伴</option>
				</select>
			</div>
			<div class="fitem">
				<label>网站LOGO：</label>
				<img id="imageUploadUrl_1" src="static/upload/no_pic.gif" width="80" />
				<input id="textUploadUrl_1" type="hidden" value="" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/links/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_1"></span>
			</div>
			<div class="fitem">
				<label>官网链接：</label>
				<input type="text" name="weblink" value="" size="40" />
			</div>
			<div class="fitem">
				<label>状态：</label>
				<input type="radio" name="status" value="0" checked />显示&nbsp;&nbsp;&nbsp;
				<input type="radio" name="status" value="1" />隐藏
			</div>
		</div>
	</div>
	<div style="margin:5px 30px;">
		<a id="addLinksButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#links_form_add_layout").tabs();

$("#addLinksButton").click(function(){
	var obj = {},
		panel = $("#links_form_add_panel");
	obj.webname = panel.find("input[name='webname']").val();
	obj.type = panel.find("select[name='type']").find('option:selected').val();
	obj.logo = panel.find("#textUploadUrl_1").val();
	obj.weblink = panel.find("input[name='weblink']").val();
	obj.status = panel.find("input[name='status']:checked").val();
	if(obj.webname!="" && obj.logo!="" && obj.weblink!=""){
		$.post('__URL__/save', obj, function(data){
			if(data>0){
				alert('操作成功~');
				$("#links_form_add_panel").parent().window('close');
				$("#links_list_datagrid").datagrid('reload');
			}else{
				alert('操作失败~');
			}
		});
	}else{
		alert('提交数据不完整~');
	}
});
</script>