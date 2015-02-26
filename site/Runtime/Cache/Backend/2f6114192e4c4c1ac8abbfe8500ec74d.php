<?php if (!defined('THINK_PATH')) exit();?><style>
#linkage_type_add_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="linkage_type_add_panel">
	<div id="linkage_type_add_layout">
		<div title="操作类型" style="padding:10px 20px;">
			<div class="fitem">
				<label>类型名称：</label>
				<input name="name" type="text" />
			</div>
			<div class="fitem">
				<label>类型代码：</label>
				<input name="nid" type="text" />
			</div>	
		</div>	
	</div>
	<div style="margin:5px 30px;">
		<a id="addLinkageTypeButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#linkage_type_add_layout").tabs();

$("#addLinkageTypeButton").click(function(){
	var obj = {},
		panel = $("#linkage_type_add_panel");
	obj.name = panel.find("input[name='name']").val();
	obj.nid = panel.find("input[name='nid']").val();
	if(obj.name!="" && obj.nid!=""){
		$.post('__URL__/saveType', obj, function(data){
			if(data>0){
				alert("操作成功~");
				$("#linkage_type_add_panel").parent().window('close');
				$("#linkage_type_datagrid").datagrid('reload');
			}else{
				alert("操作失败~");
			}
		});
	}else{
		alert("提交数据不完整~");
	}
});

</script>