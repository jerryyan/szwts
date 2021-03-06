<?php if (!defined('THINK_PATH')) exit();?><style>
#advert_add_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="advert_add_panel">
	<div id="advert_add_layout">
		<div title="广告图片" style="padding:10px 20px;">
			<div class="fitem">
				<label>标题：</label>
				<input name="title" type="text" />
			</div>
			<div class="fitem">
				<label>所属模块：</label>
				<select name="type_id">
					<?php echo ($options); ?>
				</select>
			</div>
			<div class="fitem">
				<label>图片：</label>
				<img id="imageUploadUrl_1" src="static/upload/no_pic.gif" width="80" />
				<input id="textUploadUrl_1" type="hidden" value="" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/advert/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_1"></span>
			</div>	
			<div class="fitem">
				<label>显示位置：</label>
				<select name="position">
					<option value="top">顶部</option>
					<option value="middle">中部</option>
					<option value="bottom">底部</option>
					<option value="left">左部</option>
					<option value="right">右部</option>
				</select>
			</div>	
			<div class="fitem">
				<label>链接地址：</label>
				<input name="url" type="text" size="12" />
			</div>		
			<div class="fitem">
				<label>排序：</label>
				<input name="order" type="text" value="1" />
			</div>
			<div class="fitem">
				<label>状态：</label>
				<input name="status" type="radio" value="1" checked />显示&nbsp;&nbsp;&nbsp;
				<input name="status" type="radio" value="0" />隐藏
			</div>			
		</div>	
	</div>
	<div style="margin:5px 30px;">
		<a id="addAdvertButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#advert_add_layout").tabs();

$("#addAdvertButton").click(function(){
	var obj = {},
		panel = $("#advert_add_panel");
	obj.title = panel.find("input[name='title']").val();
	obj.type_id = panel.find("select[name='type_id']").find('option:selected').val();
	obj.pic = panel.find("#textUploadUrl_1").val();
	obj.position = panel.find("select[name='position']").find('option:selected').val();
	obj.url = panel.find("input[name='url']").val();
	obj.order = panel.find("input[name='order']").val();
	obj.status = panel.find("input[name='status']:checked").val();
	if(obj.title!="" && obj.type_id>0 && obj.pic!="" && obj.url!="" && obj.order!=""){
		$.post('__URL__/save', obj, function(data){
			if(data>0){
				alert("操作成功~");
				$("#advert_add_panel").parent().window('close');
				$("#advert_datagrid").datagrid('reload');
			}else{
				alert("操作失败~");
			}
		});
	}else{
		alert("提交数据不完整~");
	}
});

</script>