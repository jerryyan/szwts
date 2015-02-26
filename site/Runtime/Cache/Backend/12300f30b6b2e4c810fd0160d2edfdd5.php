<?php if (!defined('THINK_PATH')) exit();?><style>
#functions_form_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{  margin-bottom:16px; clear:both; }  
.fitem label{  display:inline-block;  width:80px; float:left; }  
.fitem .itemContent{float:left;}
</style>
<div id="functions_form_panel">
	<div id="functions_form_layout">
		<div title="基本信息" style="padding:10px 20px;">
			<div class="fitem">
				<label>操作名称：</label>
				<input type="text" name="func_name" value="<?php echo ($tempData['name']); ?>" size="20" />
			</div>
			<div class="fitem">
				<label>上级节点：</label>
				<select name="func_fid">
					<option value='0'>根节点</option>
					<?php echo ($options); ?>
				</select>
			</div>
			<div class="fitem">
				<label>同级排序：</label>
				<input type="text" name="func_seq" value="<?php echo ($tempData['pindex']); ?>" size="10" />
			</div>
			<div class="fitem">
				<label>是否为菜单：</label>
				是<input type="radio" name="is_func" value="0" />
				否<input type="radio" name="is_func" value="1" checked />
			</div>
			<div class="fitem">
				<label>是否启用：</label>
				是<input type="radio" name="is_disabled" value="0" checked />
				否<input type="radio" name="is_disabled" value="1" />
			</div>
			<div class="fitem">
				<label>分组名称：</label>
				<?php if(($tempData["group_name"] == "")): ?><input type="text" name="group" value="<?php echo ($admin_group); ?>" size="16" />
				<?php else: ?>
				<input type="text" name="group" value="<?php echo ($tempData['group_name']); ?>" size="16" /><?php endif; ?>
			</div>
			<div class="fitem">
				<label>模块名称：</label>
				<input type="text" name="module" value="<?php echo ($tempData['module_name']); ?>"  size="16" />
			</div>
			<div class="fitem">
				<label>方法名称：</label>
				<input type="text" name="method" value="<?php echo ($tempData['method_name']); ?>"  size="16" />
			</div>
		</div>
		<div title="功能描述">
			<div style="padding:5px;">
				<textarea name="func_desc" style="width:550px;height:300px;"><?php echo ($tempData['desc']); ?></textarea>
			</div>			
		</div>
	</div>
	<div style="margin:5px 30px;">
		<input type="hidden" name="func_id" value="<?php echo ($tempData['id']); ?>" />
		<a id="saveFunctionsButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>

$("#functions_form_panel").find("input[name='is_func'][value='"+<?php echo (($tempData['is_function'])?($tempData['is_function']):0); ?>+"']").attr('checked', true);
$("#functions_form_panel").find("input[name='is_disabled'][value='"+<?php echo (($tempData['is_disabled'])?($tempData['is_disabled']):0); ?>+"']").attr('checked', true);

$("#functions_form_layout").tabs();
$.loadEditor($("#functions_form_panel").find("[name='func_desc']"));


$("#saveFunctionsButton").click(function(){
	var obj = {},
		panel = $("#functions_form_panel");
	obj.func_id = panel.find("input[name='func_id']").val();
	obj.func_name = panel.find("input[name='func_name']").val();
	obj.func_fid = panel.find("select[name='func_fid']").find('option:selected').val();
	obj.func_seq = panel.find("input[name='func_seq']").val();
	obj.is_func = panel.find("input[name='is_func']:checked").val();
	obj.is_disabled = panel.find("input[name='is_disabled']:checked").val();
	obj.group = panel.find("input[name='group']").val();
	obj.module = panel.find("input[name='module']").val();
	obj.method = panel.find("input[name='method']").val();
	obj.func_desc = panel.find("textarea[name='func_desc']").val();
	$.post('__URL__/saveFunction', obj, function(data){
		eval("var p="+data+";");
		if(p.state>0){
			alert('操作成功~');
			$("#functions_form_panel").parent().window('close');
			$("#functions_datagrid").datagrid('reload');
		}else{
			alert(p.message);
		}
	});
});
</script>