<?php if (!defined('THINK_PATH')) exit();?><style>
#sysuser_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{  margin-bottom:16px; clear:both; }  
.fitem label{  display:inline-block;  width:80px; float:left; }  
.fitem .itemContent{float:left;}
</style>
<div id="sysuser_edit_panel">
	<div id="sysuser_edit_layout">
		<div title="登录管理" style="padding:10px 20px;">
			<div class="fitem">
				<label>用户名：</label>
				<input type="text" name="uname" value="<?php echo ($tempData['username']); ?>" size="20" />
			</div>
			<div class="fitem">
				<label>密码：</label>
				<input type="password" name="upwd" value="" size="20" />
			</div>
			<div class="fitem">
				<label>确认密码：</label>
				<input type="password" name="upwd2" value="" size="20" />
			</div>
			<div class="fitem">
				<label>角色：</label>
				<select name="role">
					<?php echo ($options); ?>
				</select>
			</div>
			<div class="fitem">
				<label>是否锁定：</label>
				是<input type="radio" name="is_locked" value="1" />
				否<input type="radio" name="is_locked" value="0" checked />
			</div>
		</div>
		<div title="基本信息" style="padding:10px 20px;">
			<div class="fitem">
				<label>上传头像：</label>
				<img id="imageUploadUrl_1" src="static/<?php echo (($tempData['avatar'])?($tempData['avatar']):'upload/no_pic.gif'); ?>" width="80" />
				<input id="textUploadUrl_1" type="hidden" value="<?php echo (($tempData['avatar'])?($tempData['avatar']):''); ?>" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/avatar/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_1"></span>
			</div>	
			<div class="fitem">
				<label>昵称：</label>
				<input type="text" name="nname" value="<?php echo ($tempData['nickname']); ?>"  size="16" />
			</div>
			<div class="fitem">
				<label>真实姓名：</label>
				<input type="text" name="fname" value="<?php echo ($tempData['fullname']); ?>"  size="16" />
			</div>
			<div class="fitem">
				<label>手机号码：</label>
				<input type="text" name="phone" value="<?php echo ($tempData['phone']); ?>"  size="16" />
			</div>
			<div class="fitem">
				<label>电子邮箱：</label>
				<input type="text" name="email" value="<?php echo ($tempData['email']); ?>" size="30" />
			</div>
			<div class="fitem">
				<label>qq号码：</label>
				<input type="text" name="qq" value="<?php echo ($tempData['qq']); ?>"  size="16" />
			</div>
		</div>
	</div>
	<div style="margin:5px 30px;">
		<input type="hidden" name="id" value="<?php echo ($tempData['id']); ?>" />
		<a id="editSysUserButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#sysuser_edit_layout").tabs();

$("#sysuser_edit_panel").find("input[name='is_locked'][value='"+<?php echo (($tempData['is_locked'])?($tempData['is_locked']):0); ?>+"']").attr('checked', true);

$("#editSysUserButton").click(function(){
	var obj = {},
		panel = $("#sysuser_edit_panel");
	obj.id = panel.find("input[name='id']").val();
	obj.uname = panel.find("input[name='uname']").val();
	obj.upwd = panel.find("input[name='upwd']").val();
	obj.role = panel.find("select[name='role']").find('option:selected').val();
	obj.email = panel.find("input[name='email']").val();
	obj.is_locked = panel.find("input[name='is_locked']:checked").val();
	obj.avatar = panel.find("#textUploadUrl_1").val();
	obj.nname = panel.find("input[name='nname']").val();
	obj.fname = panel.find("input[name='fname']").val();
	obj.phone = panel.find("input[name='phone']").val();
	obj.qq = panel.find("input[name='qq']").val();
	if(obj.id=="" && obj.uname=="" && obj.upwd=="" && obj.email=="" && obj.phone==""){
		alert("提交数据不完整~");
		return;
	}
	$.post('__URL__/saveUser', obj, function(data){
		if(data>0){
			alert('操作成功~');
			$("#sysuser_edit_panel").parent().window('close');
			$("#sysuser_datagrid").datagrid('reload');
		}else{
			alert('操作失败~');
		}
	});
});
</script>