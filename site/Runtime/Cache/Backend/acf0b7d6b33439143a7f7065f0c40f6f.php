<?php if (!defined('THINK_PATH')) exit();?><style>
#user_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="user_edit_panel">
	<div id="user_edit_layout">
		<div title="用户注册信息" style="padding:10px 20px;">
			<div class="fitem">
				<label>用户名：</label>
				<?php echo ($tempData["username"]); ?>
				<span></span>
			</div>
			<div class="fitem">
				<label>密码：</label>
				<input name="password" type="password" maxlength="20" flag="0" />
				<span></span>
			</div>
			<div class="fitem">
				<label>确认密码：</label>
				<input name="password2" type="password" maxlength="20" flag="0" />
				<span></span>
			</div>
			<div class="fitem">
				<label>状态：</label>
				<input name="islock" type="radio" value='0' checked />正常&nbsp;&nbsp;&nbsp;
				<input name="islock" type="radio" value='1' />冻结
			</div>
			<div class="fitem">
				<label>邮箱：</label>
				<input name="email" type="text" flag="0" value="<?php echo ($tempData['email']); ?>" />
				<span></span>
			</div>	
			<div class="fitem">
				<label>手机号码：</label>
				<input name="phone" type="text" maxlength="11" flag="0" value="<?php echo ($tempData['phone']); ?>" />
				<span></span>
			</div>
			<div class="fitem">
				<label>邮箱认证：</label>
				<input name="email_status" type="radio" value='1' checked />是&nbsp;&nbsp;&nbsp;
				<input name="email_status" type="radio" value='0' />否	
			</div>
			<div class="fitem">
				<label>手机认证：</label>
				<input name="phone_status" type="radio" value='1' checked />是&nbsp;&nbsp;&nbsp;
				<input name="phone_status" type="radio" value='0' />否
			</div>
			<div class="fitem">
				<label>登陆错误次数：</label>
				<input name="login_num" type="text" value="<?php echo ($tempData['login_num']); ?>" /> <font color="#f00">大于3时表示账户当天登陆已被锁定，输入0即解锁账户</font>
			</div>
		</div>
		
		<div title="实名认证" style="padding:10px 20px;">
		<?php if($tempData["card_type"] == 1): ?><div class="fitem">
				<label>真实姓名：</label>
				<?php echo ($tempData["realname"]); ?>
				<span></span>
			</div>
			<div class="fitem">
				<label>身份证号码：</label>
				<?php echo ($tempData["card_id"]); ?>
				<span></span>
			</div>
			<div class="fitem">
				<label>性别：</label>
				<?php if($tempData["sex"] == 1): ?>男<?php else: ?>女<?php endif; ?>
				<span></span>
			</div>
			<div class="fitem">
				<label>身份证正面：</label>
				<img id="imageUploadUrl_1" src="/static/<?php echo (($tempData['card_pic1'])?($tempData['card_pic1']):'upload/no_pic.gif'); ?>" width="80" />
			</div>
			<div class="fitem">
				<label>身份证反面：</label>
				<img id="imageUploadUrl_2" src="/static/<?php echo (($tempData['card_pic2'])?($tempData['card_pic2']):'upload/no_pic.gif'); ?>" width="80" />
			</div>
		<?php else: ?>
			<div class="fitem">
				<label>真实姓名：</label>
				<input name="realname" type="text" />
				<span></span>
			</div>
			<div class="fitem">
				<label>身份证号码：</label>
				<input name="card_id" type="text" maxlength="18" />
				<span></span>
			</div>
			<div class="fitem">
				<label>身份证正面：</label>
				<img id="imageUploadUrl_1" src="/static/upload/no_pic.gif" width="80" />
			    <input id="textUploadUrl_1" type="hidden" value="" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/attestation/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_1"></span>
			</div>
			<div class="fitem">
				<label>身份证反面：</label>
				<img id="imageUploadUrl_2" src="/static/upload/no_pic.gif" width="80" />
			    <input id="textUploadUrl_2" type="hidden" value="" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/attestation/id/2" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_2"></span>
			</div><?php endif; ?>
		</div>			
	</div>
	<div style="margin:5px 30px;">
		<a id="editUserButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#user_edit_layout").tabs();

var update_user_id = <?php echo ($tempData['user_id']); ?>,
	islock = <?php echo ($tempData['islock']); ?>,
	email_status = <?php echo (($tempData['email_status'])?($tempData['email_status']):0); ?>,
	phone_status = <?php echo (($tempData['phone_status'])?($tempData['phone_status']):0); ?>;

$("#user_edit_panel").find("input[name='islock'][value='"+islock+"']").attr("checked", true);
$("#user_edit_panel").find("input[name='email_status'][value='"+email_status+"']").attr("checked", true);
$("#user_edit_panel").find("input[name='phone_status'][value='"+phone_status+"']").attr("checked", true);

$("#user_edit_panel").find("input[name='password']").blur(function(){
	var _this = $(this),
		password = _this.val();
		_this.next().text("").hide();
	if(password!=""){
		if(password.length<6 || password.length>20){
			_this.next().text("密码不能少于6位").show();
		}else{
			_this.attr("flag", 0);
			$("#user_edit_panel").find("input[name='password2']").attr("flag", 1);
		}
	}else{
		_this.next().text("请输入密码").show();
	}
});

$("#user_edit_panel").find("input[name='password2']").blur(function(){
	var _this = $(this),
		password = $("#user_edit_panel").find("input[name='password']").val(),
		password2 = _this.val();
		_this.next().text("").hide();
	if(password2!=""){
		if(password2!=password){
			_this.next().text("两次密码输入不一致").show();
		}else{
			_this.attr("flag", 0);
		}
	}else{
		_this.next().text("确认密码不能为空").show();
	}
});

$("#user_edit_panel").find("input[name='email']").blur(function(){
	var _this = $(this),
		email = _this.val();
		_this.next().text("").hide();
		_this.attr("flag", 1);
	if(email!=""){
		if(/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/.test(email)){
			$.get('__URL__/checkUpdateUser', {"user_id":update_user_id,"email":email}, function(data){
				if(data>0){
					_this.next().text("邮箱地址已经存在").show();
				}else{
					_this.attr("flag", 0);
				}
			});
		}else{
			_this.next().text("邮箱地址格式不正确").show();
		}
	}else{
		_this.next().text("请输入邮箱地址").show();
	}
});

$("#user_edit_panel").find("input[name='phone']").blur(function(){
	var _this = $(this),
		phone = $(this).val();
		_this.next().text("").hide();
		_this.attr("flag", 1);
	if(phone!=""){
		if(/^(?:13\d|14\d|15\d|17\d|18\d)-?\d{5}(\d{3}|\*{3})$/.test(phone)){
			$.get('__URL__/checkUpdateUser', {"user_id":update_user_id,"phone":phone}, function(data){
				if(data>0){
					_this.next().text("手机号码已经存在").show();
				}else{
					_this.attr("flag", 0);
				}
			});		
		}else{
			_this.next().text("手机号码格式不正确").show();
		}
	}else{
		_this.next().text("请输入手机号码").show();
	}
});


$("#user_edit_panel").find("input[name='card_id']").blur(function(){
	var _this = $(this),
		panel = $("#user_add_panel"),
		card_id = _this.val();
		_this.next().text("").hide();		
	if(card_id!=""){
		if(/^(\d{17}X|\d{17}x|\d{18})$/.test(card_id)){
			$.get('__URL__/checkUser', {"card_id":card_id,"user_id":update_user_id}, function(data){
				if(data>0){
					_this.val('');
					_this.next().text("身份证号码已经存在").show();
				}
			});
		}else{
			_this.val('');
			_this.next().text("身份证号码格式不正确").show();
		}
	}else{
		_this.val('');
		_this.next().text("请输入身份证号码").show();
	}
});


$("#editUserButton").click(function(){
	var obj = {}, 
		panel = $("#user_edit_panel"),
		forms = panel.find("input[type='text'], input[type='password']"),
		error = 0;
	forms.each(function(){
		var _this = $(this),
			flag = _this.attr("flag");
		if(flag==1){
			error = 1;
		}
	});
	if(error==1){
		alert('提交信息不完整~');
		return;
	}
	obj.user_id = update_user_id;
	obj.username = panel.find("input[name='username']").val();
	obj.password = panel.find("input[name='password']").val();
	obj.islock = panel.find("input[name='islock']:checked").val();
	obj.email = panel.find("input[name='email']").val();
	obj.phone = panel.find("input[name='phone']").val();
	obj.email_status = panel.find("input[name='email_status']:checked").val();
	obj.phone_status = panel.find("input[name='phone_status']:checked").val();
	obj.scene_status = panel.find("input[name='scene_status']:checked").val();
	obj.login_num = panel.find("input[name='login_num']").val();
	obj.realname = panel.find("input[name='realname']").val();
	obj.card_id = panel.find("input[name='card_id']").val();
	obj.card_pic1 = panel.find("#textUploadUrl_1").val();
	obj.card_pic2 = panel.find("#textUploadUrl_2").val();
	$.post('__URL__/save', obj, function(data){
		if(data>0){
			alert('操作成功~');
			panel.parent().window('close');
			$("#user_datagrid").datagrid('reload');
		}else{
			alert('操作失败~');
		}
	});	
});


</script>