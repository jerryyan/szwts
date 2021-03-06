<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网投所后台管理系统</title>
<link rel="stylesheet" type="text/css" href="__ROOT__/static/js/admin/easyui/themes/default/easyui.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/static/js/admin/easyui/themes/icon.css" />
<style type="text/css">
.index_login_message { width:100%; height:35px; background-color:#72a5d2; font-size:12px;line-height:35px;}
.index_main{ background:url(static/images/admin/xt.png) no-repeat  center 200px; height:700px;}
.index_main .shixiang { width:100%; height:35px; line-height:35px; background-color:#72a5d2; color:#FFF;  margin-top:5px;  }
.index_main .shixiang span{ padding-left:10px;}
.index_main td{  height:35px; color:#333; padding-left:10px; font-size:12px;}
.index_main .pp{ padding-left:20px; padding-top:20px; line-height:30px; font-size:12px;}
.index_foot{ width:100%; text-align:center; font-size:12px; height:28px; line-height:28px; background:#508bc3; color:#FFF; margin-top:15px;}
</style>
<script type="text/javascript" src="__ROOT__/static/js/jquery.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/admin/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/admin/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/admin/xheditor/xheditor.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/admin/easyui/datagrid-detailview.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/admin/My97DatePicker/WdatePicker.js"></script>
<script>
window._menu_ = <?php echo ($menu); ?>;
</script>
<script type="text/javascript" src="__ROOT__/static/js/admin/main.js"></script>
</head>

<body class="easyui-layout">
<div region="north" border="false" class="header" style="width:180px;height:10px;padding:0px;"></div>
<div region="west" split="true" title="操作菜单" style="width:170px;">
	<div id="allmenu" class="easyui-accordion" style="width:170px;">
	</div>
</div>

<div region="center" split="true" title="">
	<div id="tt" fit="true" border="false" plain="true">
        <div title="欢迎使用网投所管理后台" style="background-color:#e0f3ff;">
        
		    <div class="index_login_message">
			    <table width="100%" border="0">
				  <tr>
				    <td style="color:#FFF;">
				    &nbsp;登录用户：<?php echo ($tempData['username']); ?>&nbsp;&nbsp;&nbsp;
				    <a href="javascript:void(0);" onclick="javascript:if(confirm('确认退出管理后台吗？'))location.href='__URL__/loginout';" style="color:#fff;">安全退出</a>
					</td>
				  </tr>
				</table>
			</div>
	        <div class="index_main">
				<div class="shixiang"><span> 提醒事项:</span></div>
				<table width="100%" border="0" style="padding-top:40px;">
					<tr>
						<td style="text-align:right;" width="22%">实名认证待审核：</td>
					    <td width="45%"><a href='javascript:void(0)' onclick='addSysTabs("实名认证管理", "__GROUP__/User/realname")'><?php echo ($tempData['realname_num']); ?></a></td>
				 	</tr>
				  	<tr>
				  		<td style="text-align:right;">提现待审核：</td>
					    <td><a href='javascript:void(0)' onclick='addSysTabs("提现管理", "__GROUP__/Account/cash")'><?php echo ($tempData['account_cash_num']); ?></a></td>
				  	</tr>
				  	<tr>
				  		<td style="text-align:right;">今日投资客待还完：</td>
					    <td><a href='javascript:void(0)' onclick='addSysTabs("待还完记录", "__GROUP__/Invest/repay")'><?php echo ($tempData['repay_num']); ?></a></td>
				  	</tr>
				</table>
			
				<div class="pp"></div>
			</div>
			<div class="index_foot">Powered by 网投所后台管理系统  www.wangtousuo.com 2014</div>

        </div>
   </div>
</div>
<script type="text/javascript">
function addSysTabs(sTitle,sUrl){
	var tab=$('#tt').tabs("getTab",sTitle);	
	if(tab==null || tab==undefined){
		$("#tt").tabs("add",{
			title:sTitle,
			closable:true,
			href:sUrl
		});	
	}else{
		$("#tt").tabs('update',{
	        tab: tab,
	        options: {
	        	href:sUrl
	        }
	    });
		$("#tt").tabs("select",sTitle);
	    tab.panel('refresh'); 
	}
}
</script>
</body>
</html>