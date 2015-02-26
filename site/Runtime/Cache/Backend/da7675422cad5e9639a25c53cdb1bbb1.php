<?php if (!defined('THINK_PATH')) exit();?><style>
#user_add_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;}  
.fitem label{  display:inline-block;  width:88px; float:left; text-align:right;}  
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="user_add_panel">
	<div id="user_add_layout">
		<div title="用户基本信息" style="padding:10px 20px;">
			<div class="fitem">
				<label>用户名：</label>
				<input name="username" type="text" maxlength="15" flag="1" />
				<span></span>
			</div>
			<div class="fitem">
				<label>密码：</label>
				<input name="password" type="password" maxlength="20" flag="1" />
				<span></span>
			</div>
			<div class="fitem">
				<label>确认密码：</label>
				<input name="password2" type="password" maxlength="20" flag="1" />
				<span></span>
			</div>
			<div class="fitem">
				<label>邮箱：</label>
				<input name="email" type="text" flag="1" />
				<span></span>
			</div>	
			<div class="fitem">
				<label>手机号码：</label>
				<input name="phone" type="text" maxlength="11" flag="1" />
				<span></span>
			</div>
			<div class="fitem">
				<label>邮箱认证：</label>
				<input name="email_status" type="radio" value='1' />是&nbsp;&nbsp;&nbsp;
				<input name="email_status" type="radio" value='0' checked />否	
			</div>
			<div class="fitem">
				<label>手机认证：</label>
				<input name="phone_status" type="radio" value='1' />是&nbsp;&nbsp;&nbsp;
				<input name="phone_status" type="radio" value='0' checked />否
			</div>	
		</div>	
		<div title="实名认证"  style="padding:10px 20px;">
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
			</div>
		</div>	
	</div>
	<div style="margin:5px 30px;">
		<a id="addUserButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#user_add_layout").tabs();

$("#user_add_panel").find("input[name='username']").blur(function(){
	var _this = $(this),
		username = _this.val();
		_this.next().text("").hide();
		_this.attr("flag", 1);
	if(username.length>3 && username.length<16){
		$.get('__URL__/checkUser', {"username":username}, function(data){
			if(data>0){
				_this.next().text("用户名已经存在").show();
			}else{
				_this.attr("flag", 0);
			}
		});		
	}else{
		_this.next().text("请输入用户名").show();
	}
});

$("#user_add_panel").find("input[name='password']").blur(function(){
	var _this = $(this),
		password = _this.val();
		_this.next().text("").hide();
		_this.attr("flag", 1);
	if(password!=""){
		if(password.length<6 || password.length>20){
			_this.next().text("密码不能少于6位").show();
		}else{
			_this.attr("flag", 0);
		}
	}else{
		_this.next().text("请输入密码").show();
	}
});

$("#user_add_panel").find("input[name='password2']").blur(function(){
	var _this = $(this),
		password = $("#user_add_panel").find("input[name='password']").val(),
		password2 = _this.val();
		_this.next().text("").hide();
		_this.attr("flag", 1);
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

$("#user_add_panel").find("input[name='email']").blur(function(){
	var _this = $(this),
		email = _this.val();
		_this.next().text("").hide();
		_this.attr("flag", 1);
	if(email!=""){
		if(/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/.test(email)){
			$.get('__URL__/checkUser', {"email":email}, function(data){
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

$("#user_add_panel").find("input[name='phone']").blur(function(){
	var _this = $(this),
		phone = $(this).val();
		_this.next().text("").hide();
		_this.attr("flag", 1);
	if(phone!=""){
		if(/^(?:13\d|14\d|15\d|17\d|18\d)-?\d{5}(\d{3}|\*{3})$/.test(phone)){
			$.get('__URL__/checkUser', {"phone":phone}, function(data){
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


$("#user_add_panel").find("input[name='card_id']").blur(function(){
	var _this = $(this),
		panel = $("#user_add_panel"),
		card_id = _this.val();
		_this.next().text("").hide();
	if(card_id!=""){
		if(/^(\d{17}X|\d{17}x|\d{18})$/.test(card_id)){
			$.get('__URL__/checkUser', {"card_id":card_id}, function(data){
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

$("#addUserButton").click(function(){
	var obj = {},
		panel = $("#user_add_panel"),
		forms = panel.find("input[type='text'], input[type='password']"),
		error = 0;
	forms.each(function(){
		var _this = $(this),
			name = _this.attr("name"),
			flag = _this.attr("flag");
		if(flag==1){
			error = 1;
		}
	});
	if(error==1){
		alert('提交信息不完整~');
		return;
	}
	obj.username = panel.find("input[name='username']").val();
	obj.password = panel.find("input[name='password']").val();
	obj.email = panel.find("input[name='email']").val();
	obj.phone = panel.find("input[name='phone']").val();
	obj.email_status = panel.find("input[name='email_status']:checked").val();
	obj.phone_status = panel.find("input[name='phone_status']:checked").val();
	obj.scene_status = panel.find("input[name='scene_status']:checked").val();
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