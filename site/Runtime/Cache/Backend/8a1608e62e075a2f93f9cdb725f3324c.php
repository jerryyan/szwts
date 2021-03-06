<?php if (!defined('THINK_PATH')) exit();?><style>
#sysrole_form_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{  margin-bottom:15px; clear:both; }  
.fitem label{  display:inline-block;  width:70px; float:left; }  
.fitem .itemContent{float:left;}
</style>
<div id="sysrole_form_panel">
	<div id="sysrole_form_layout">
		<div title="基本信息" style="padding:10px 20px;">
			<div class="fitem">
				<label>角色名称：</label>
				<input type="text" name="name" value="<?php echo ($tempData['role_name']); ?>" size="20" />
			</div>
			<div class="fitem">
				<label>是否启用：</label>
				是<input type="radio" name="is_disabled" value="0" checked />
				否<input type="radio" name="is_disabled" value="1" />
			</div>
			<div class="fitem">
				<label>角色描述：</label>
				<textarea name="desc" style="width:400px;height:230px;"><?php echo ($tempData['role_desc']); ?></textarea>		
			</div>
		</div>
	</div>
	<div style="margin:5px 30px;">
		<input type="hidden" name="id" value="<?php echo ($tempData['id']); ?>" />
		<a id="saveSysRoleButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
var is_disabled = '<?php echo ($tempData['is_disabled']); ?>';
$("#sysrole_form_panel").find("input[name='is_disabled'][value='"+is_disabled+"']").attr('checked', true);

$.loadEditor($("#sysrole_form_panel").find("[name='desc']"));

$("#saveSysRoleButton").click(function(){
	var obj = {},
		panel = $("#sysrole_form_panel");
	obj.id = panel.find("input[name='id']").val();
	obj.name = panel.find("input[name='name']").val();
	obj.is_disabled = panel.find("input[name='is_disabled']:checked").val();
	obj.desc = panel.find("textarea[name='desc']").val();
	$.post('__URL__/saveRole', obj, function(data){
		if(data>0){
			alert('操作成功~');
			$("#sysrole_form_panel").parent().window('close');
			$("#sysrole_datagrid").datagrid('reload');
		}else{
			alert('操作失败~');
		}
	});
});
</script>