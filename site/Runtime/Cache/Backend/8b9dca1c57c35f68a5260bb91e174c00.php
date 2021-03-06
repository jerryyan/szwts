<?php if (!defined('THINK_PATH')) exit();?><style>
#privilege_form_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{  margin-bottom:15px; clear:both; }  
.fitem label{  display:inline-block;  width:70px; float:left; }  
.fitem .itemContent{float:left;}
</style>
<div id="privilege_form_panel">
	<div id="privilege_form_layout">
		<div title="基本信息" style="padding:10px 20px;" id="show_func_list">
			
		</div>
	</div>
	<div style="margin:5px 30px;">
		<input type="hidden" name="id" value="<?php echo ($id); ?>" />
		<a id="savePrivilegeButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
var roleTemp = <?php echo ($tempData); ?>;
var $__funcs__ = [];
var $__plevel__ = 1;

$(function(){
	getTree(roleTemp);
	var obj = $("#show_func_list").find("input[type='checkbox']");
	obj.change(function(){
		var _this = $(this),
			id = _this.attr('id'),
			sorder = _this.attr('sorder'),
			ids = sorder.split(','),
			pid = _this.attr('pid'),
			lens = $("#show_func_list").find("input[pid='"+pid+"']:checked").length;
		if(_this.attr('checked')){
			if(lens>0){
				for(var i=0; i<ids.length; i++){
					$("#role_"+ids[i]).attr('checked', true);
					num = id.split('_')[1];
					if(ids[i]!=num){$("#role_"+ids[i]).attr('disabled', true);}
				}
			}
		}else{
			if(lens==0){
				for(var i=0; i<ids.length; i++){
					$("#role_"+ids[i]).attr('checked', false).attr('disabled', false);
				}
			}
		}		
	});
});

function getTree(data){
	if($__funcs__.length>0){
		$("#show_func_list").append('<div class="fitem">'+printEmpty($__plevel__)+$__funcs__.join("")+'</div>');
		$__funcs__ = [];
	}
	for(var i=0; i<data.length; i++){
		$__plevel__ = data[i].plevel;
		$__funcs__.push('<input type="checkbox" id="role_'+data[i].id+'" pid="'+data[i].pid+'" sorder="'+data[i].sorder+'" value="'+data[i].id+'" '+data[i].select+' '+data[i].disabled+' />'+data[i].name);
		if(data[i].children && data[i].children.length>0){
			getTree(data[i].children);
		}
	}
	if($__funcs__.length>0){
		$("#show_func_list").append('<div class="fitem">'+printEmpty($__plevel__)+$__funcs__.join("")+'</div>');
		$__funcs__ = [];
	}
}

function printEmpty(num){
	var arr = [],
		str = '';
	for(var i=0; i<(num-1)*2; i++){
		arr.push('&nbsp;');
	}
	str = arr.join("");
	return str;
}

$("#savePrivilegeButton").click(function(){
	var obj = $("#show_func_list").find("input[type='checkbox']:checked"),
		array = [],
		o = {},
		panel = $("#privilege_form_panel");
	obj.each(function(v){
		array.push($(this).val());
	});
	o.role = panel.find("input[name='id']").val();
	o.funcs = array.join(',');
	$.post('__URL__/privilegeAdd', o, function(data){
		eval("var p="+data+";");
		alert(p.message);
		$("#privilege_form_panel").parent().window('close');
	});
});
</script>