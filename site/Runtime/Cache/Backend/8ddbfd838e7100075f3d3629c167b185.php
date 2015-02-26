<?php if (!defined('THINK_PATH')) exit();?><style>
#modules_form_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{  margin-bottom:16px; clear:both; }  
.fitem label{  display:inline-block;  width:80px; float:left; }  
.fitem .itemContent{float:left;}
</style>
<div id="modules_form_edit_panel">
	<div id="modules_form_edit_layout">
		<div title="模块基本信息" style="padding:10px 20px;">
			<div class="fitem">
				<label>模块识别码：</label>
				<input type="text" name="nid" value="<?php echo ($tempData['nid']); ?>" size="20" />
			</div>
			<div class="fitem">
				<label>模块名称：</label>
				<input type="text" name="name" value="<?php echo ($tempData['name']); ?>" size="20" />
			</div>
			<div class="fitem">
				<label>上级节点：</label>
				<select name="pid">
					<option value='0'>根节点</option>
					<?php echo ($options); ?>
				</select>
			</div>
			<div class="fitem">
				<label>同级排序：</label>
				<input type="text" name="pindex" value="<?php echo ($tempData['pindex']); ?>" size="10" />
			</div>
			<div class="fitem">
				<label>是否为列表：</label>
				是<input type="radio" name="is_list" value="1" />
				否<input type="radio" name="is_list" value="0" checked />
			</div>
			<div class="fitem">
				<label>是否隐藏：</label>
				是<input type="radio" name="is_hide" value="1" />
				否<input type="radio" name="is_hide" value="0" checked />
			</div>
		</div>
		<div title="模块内容">
			<div style="padding:5px;">
				<textarea name="content" style="width:550px;height:300px;"><?php echo ($tempData['content']); ?></textarea>
			</div>			
		</div>
	</div>
	<div style="margin:5px 30px;">
		<input type="hidden" name="id" value="<?php echo ($tempData['id']); ?>" />
		<a id="editModulesButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>

$("#modules_form_edit_panel").find("input[name='is_list'][value='"+<?php echo (($tempData['is_list'])?($tempData['is_list']):0); ?>+"']").attr('checked', true);
$("#modules_form_edit_panel").find("input[name='is_hide'][value='"+<?php echo (($tempData['is_hide'])?($tempData['is_hide']):0); ?>+"']").attr('checked', true);

$("#modules_form_edit_layout").tabs();
$("#modules_form_edit_panel").find("[name='content']").xheditor({upLinkUrl:'',upLinkExt:"zip,rar,txt",upMultiple:'1',upImgUrl:'__GROUP__/Upload/saveImage',upImgExt:"jpg,jpeg,gif,png",upFlashUrl:'',upFlashExt:"swf",upMediaUrl:'',upMediaExt:"wmv,avi,wma,mp3,mid"});


$("#editModulesButton").click(function(){
	var obj = {},
		panel = $("#modules_form_edit_panel");
	obj.id = panel.find("input[name='id']").val();
	obj.nid = panel.find("input[name='nid']").val();
	obj.name = panel.find("input[name='name']").val();
	obj.pid = panel.find("select[name='pid']").find('option:selected').val();
	obj.pindex = panel.find("input[name='pindex']").val();
	obj.is_list = panel.find("input[name='is_list']:checked").val();
	obj.is_hide = panel.find("input[name='is_hide']:checked").val();
	obj.content = panel.find("textarea[name='content']").val();
	if(obj.id>0 && obj.nid!="" && obj.name!="" && obj.pindex!=""){
		$.post('__URL__/save', obj, function(data){
			eval("var p="+data+";");
			if(p.state>0){
				alert('操作成功~');
				$("#modules_form_edit_panel").parent().window('close');
				$("#modules_list_datagrid").datagrid('reload');
			}else{
				alert(p.message);
			}
		});
	}else{
		alert('提交数据不完整~');
	}
});
</script>