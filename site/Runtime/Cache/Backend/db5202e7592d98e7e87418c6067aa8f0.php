<?php if (!defined('THINK_PATH')) exit();?><style>
#platform_edit_panel{margin:0;}  
.ftitle{font-size:14px;  font-weight:bold;  color:#666;  padding:5px 0;  margin-bottom:10px;  border-bottom:1px solid #ccc;  }  
.fitem{ width:100%; margin-bottom:15px; clear:both; float:left;} 
.fitem_2{ width:100%; margin-bottom:15px; clear:both; float:left;} 
.fitem label{display:inline-block; width:88px;float:left; text-align:right;} 
.fitem_2 label{display:inline-block; width:128px;float:left; text-align:right;} 
.fitem .itemContent{float:left;}
.fitem span{color:#f00;}
</style>
<div id="platform_edit_panel">
	<div id="platform_edit_layout">
		<div title="平台基本信息(1)" style="padding:10px 20px;">
                    <div class="fitem">
				<label>平台排序：</label>				
				<input name="orderby" type="text"  value="<?php echo ($tempData['orderby']); ?>" />
			</div>
			<div class="fitem">
				<label>平台名称：</label>
				<input name="id" type="hidden" value="<?php echo (($tempData['id'])?($tempData['id']):0); ?>" />
				<input name="name" type="text" maxlength="15" size="15" value="<?php echo ($tempData['name']); ?>" />
			</div>
			<div class="fitem">
				<label>安全评级：</label>
				<select name="grade">
					<?php echo ($options); ?>
				</select>
				<span></span>
			</div>
			<div class="fitem">
				<label>logo（小图）：</label>
				<img id="imageUploadUrl_1" src="static/<?php echo (($tempData['logo'])?($tempData['logo']):'upload/no_pic.gif'); ?>" width="80" />
				<input id="textUploadUrl_1" type="hidden" value="<?php echo (($tempData['logo'])?($tempData['logo']):''); ?>" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/platform/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_1"></span>
			</div>	
			<div class="fitem">
				<label>logo(大图)：</label>
				<img id="imageUploadUrl_2" src="static/<?php echo (($tempData['logo_big'])?($tempData['logo_big']):'upload/no_pic.gif'); ?>" width="80" />
				<input id="textUploadUrl_2" type="hidden" value="<?php echo (($tempData['logo_big'])?($tempData['logo_big']):''); ?>" />
				<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/platform/id/2" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
				<span id="iframeUploadPanel_2"></span>
			</div>
			<div class="fitem">
				<label>状态：</label>
				<input name="status" type="radio" value='0' checked />显示&nbsp;&nbsp;&nbsp;
				<input name="status" type="radio" value='1'  />隐藏	
			</div>		
		</div>
		<div title="平台基本信息(2)" style="padding:10px 20px;">
			<div class="fitem">
				<label>官方网址：</label>
				<input name="website" type="text" size="35" value="<?php echo ($tempData['website']); ?>" />
			</div>
			<div class="fitem">
				<label>注册资金：</label>
				<input name="injection" type="text" size="25" value="<?php echo ($tempData['injection']); ?>" />
			</div>
			<div class="fitem">
				<label>所在地区：</label>
				<input name="location" type="text" size="20" value="<?php echo ($tempData['location']); ?>" />
			</div>
			<div class="fitem">
				<label>上线时间：</label>
				<input name="online_time" type="text" class="date mr20 Wdate" onclick="WdatePicker();" style="color:#666;" value="<?php echo ($tempData['online_time']); ?>" />
			</div>
			<div class="fitem">
				<label>ICP备案：</label>
				<input name="icp" type="text" size="25" value="<?php echo ($tempData['icp']); ?>" />
			</div>
			<div class="fitem">
				<label>联系电话：</label>
				<input name="telephone" type="text" size="15" value="<?php echo ($tempData['telephone']); ?>" />
			</div>
			<div class="fitem">
				<label>服务邮箱：</label>
				<input name="email" type="text" size="25" value="<?php echo ($tempData['email']); ?>" />
			</div>
		</div>
		<div title="平台管理费用" style="padding:10px 20px;">
			<div class="fitem">
				<label>管理费：</label>
				<input name="management_fee" type="text" size="35" value="<?php echo ($tempData['management_fee']); ?>" />
			</div>
			<div class="fitem">
				<label>vip费：</label>
				<input name="vip_fee" type="text" size="30" value="<?php echo ($tempData['vip_fee']); ?>" />
			</div>
			<div class="fitem">
				<label>充值费：</label>
				<input name="recharge_fee" type="text" size="38" value="<?php echo ($tempData['recharge_fee']); ?>" />
			</div>
			<div class="fitem">
				<label>提现费：</label>
				<input name="cash_fee" type="text" size="45" value="<?php echo ($tempData['cash_fee']); ?>" />
			</div>
		</div>
		<div title="公司简介" style="padding:10px 20px;">
			<div style="padding:5px;">
				<textarea name="introduction" style="width:500px;height:300px;"><?php echo ($tempData['introduction']); ?></textarea>
			</div>
		</div>
		<div title="数据请求接口" style="padding:10px 20px;">
			<div class="fitem_2">
				<label>在投标列表：</label>
				<input name="interface_list" type="text" size="55" value="<?php echo ($tempData['interface_list']); ?>" />
			</div>
			<div class="fitem_2">
				<label>在投数,利率及期限：</label>
				<input name="interface_count" type="text" size="55" value="<?php echo ($tempData['interface_count']); ?>" />
			</div>
			<div class="fitem_2">
				<label>图表统计：</label>
				<input name="interface_charts" type="text" size="55" value="<?php echo ($tempData['interface_charts']); ?>" />
			</div>
			<div class="fitem_2">
				<label>最低,最高及平均收益：</label>
				<input name="interface_avg" type="text" size="55" value="<?php echo ($tempData['interface_avg']); ?>" />
			</div>
			<div class="fitem_2">
				<label>注册绑定账户：</label>
				<input name="interface_reg_bind" type="text" size="55" value="<?php echo ($tempData['interface_reg_bind']); ?>" />
			</div>
			<div class="fitem_2">
				<label>绑定现有账户：</label>
				<input name="interface_login_bind" type="text" size="55" value="<?php echo ($tempData['interface_login_bind']); ?>" />
			</div>
			<div class="fitem_2">
				<label>客户投资记录：</label>
				<input name="interface_tender" type="text" size="55" value="<?php echo ($tempData['interface_tender']); ?>" />
			</div>
			<div class="fitem_2">
				<label>更新交易状态：</label>
				<input name="interface_update" type="text" size="55" value="<?php echo ($tempData['interface_update']); ?>" />
			</div>
		</div>
	</div>
	<div style="margin:5px 30px;">
		<a id="editPlatformButton" class="easyui-linkbutton" iconCls="icon-save">保存</a> 
	</div>
</div>

<script>
$("#platform_edit_layout").tabs();
$.loadEditor($("#platform_edit_panel").find("[name='introduction']"));
$("#platform_edit_panel").find("input[name='status'][value='<?php echo (($tempData[status])?($tempData[status]):0); ?>']").attr('checked', true);
$("#platform_edit_panel").find("select[name='grade']").val(<?php echo (($tempData['grade'])?($tempData['grade']):0); ?>);

$("#editPlatformButton").click(function(){
	var obj = {},
		panel = $("#platform_edit_panel");
        obj.orderby = panel.find("input[name='orderby']").val();
	obj.id = panel.find("input[name='id']").val();
	obj.name = $.trim(panel.find("input[name='name']").val());
	obj.code = $.trim(panel.find("input[name='code']").val());
	obj.grade = panel.find("select[name='grade']").find('option:selected').val();
	obj.logo = $.trim(panel.find("input[id='textUploadUrl_1']").val());
	obj.logo_big = $.trim(panel.find("input[id='textUploadUrl_2']").val());
	obj.status = panel.find("input[name='status']:checked").val();
	obj.website = $.trim(panel.find("input[name='website']").val());
	obj.injection = $.trim(panel.find("input[name='injection']").val());
	obj.location = $.trim(panel.find("input[name='location']").val());
	obj.online_time = panel.find("input[name='online_time']").val();
	obj.icp = $.trim(panel.find("input[name='icp']").val());
	obj.telephone = $.trim(panel.find("input[name='telephone']").val());
	obj.email = $.trim(panel.find("input[name='email']").val());
	obj.management_fee = $.trim(panel.find("input[name='management_fee']").val());
	obj.vip_fee = $.trim(panel.find("input[name='vip_fee']").val());
	obj.recharge_fee = $.trim(panel.find("input[name='recharge_fee']").val());
	obj.cash_fee = $.trim(panel.find("input[name='cash_fee']").val());
	obj.introduction = $.trim(panel.find("textarea[name='introduction']").val());
	obj.interface_list = $.trim(panel.find("input[name='interface_list']").val());
	obj.interface_count = $.trim(panel.find("input[name='interface_count']").val());
	obj.interface_charts = $.trim(panel.find("input[name='interface_charts']").val());
	obj.interface_avg = $.trim(panel.find("input[name='interface_avg']").val());
	obj.interface_reg_bind = $.trim(panel.find("input[name='interface_reg_bind']").val());
	obj.interface_login_bind = $.trim(panel.find("input[name='interface_login_bind']").val());
	obj.interface_tender = $.trim(panel.find("input[name='interface_tender']").val());
	obj.interface_update = $.trim(panel.find("input[name='interface_update']").val());
	if(obj.name==""){
		alert("名称不能为空");
		return;
	}
	if(obj.grade=="" || obj.grade==0){
		alert("安全评级不能为空");
		return;
	}
	if(obj.logo==""){
		alert("请上传平台logo图标（小图）");
		return;
	}
	if(obj.logo_big==""){
		alert("请上传平台logo图标（大图）");
		return;
	}
	if(obj.website==""){
		alert("官网地址不能为空");
		return;
	}
	if(obj.injection==""){
		alert("注册资金不能为空");
		return;
	}
	if(obj.location==""){
		alert("所在地区不能为空");
		return;
	}
	if(obj.online_time==""){
		alert("上线时间不能为空");
		return;
	}
	if(obj.icp==""){
		alert("ICP备案信息不能为空");
		return;
	}
	if(obj.telephone==""){
		alert("联系方式不能为空");
		return;
	}
	if(obj.email==""){
		alert("服务邮箱不能为空");
		return;
	}
	if(obj.management_fee==""){
		alert("管理费收费标准不能为空");
		return;
	}
	if(obj.vip_fee==""){
		alert("VIP收费标准不能为空");
		return;
	}
	if(obj.recharge_fee==""){
		alert("充值费不能为空");
		return;
	}
	if(obj.cash_fee==""){
		alert("提现费不能为空");
		return;
	}
	if(obj.introduction==""){
		alert("公司简介不能为空");
		return;
	}
	$.post('__URL__/save', obj, function(data){
		if(data>0){
			alert("操作成功~");
			$("#platform_edit_panel").parent().window('close');
			$("#platform_datagrid").datagrid('reload');
		}else{
			alert("操作失败~");
		}
	});
});

</script>