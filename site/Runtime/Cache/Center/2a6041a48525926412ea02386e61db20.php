<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>用户管理中心  - 网投所</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="网投所，深圳网投所，网络理财，理财产品，借贷网络平台，抵押贷款，投资理财" />
<meta name="description" content="网投所" />
<link href="__ROOT__/static/css/global.css" rel="stylesheet" type="text/css" />
<link href="__ROOT__/static/css/center/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__ROOT__/static/js/jquery.js?version=1.7.1"></script>
<script type="text/javascript" src="__ROOT__/static/js/plugins/layer.min.js?version=1.8.4"></script>
<script type="text/javascript" src="__ROOT__/static/js/common.js"></script>
<script type="text/javascript">
$(function(){
	$("#js_sys_loginout").click(function(){
		layer.confirm("确认要退出系统吗？", function(index){		
			location.href='/Center/Index/loginout';
		});		
	});
  	$(".show").hover(
	    function(){
	      	var a = $(this).children(".ico").attr("class").split(" ");
	      	$(this).children(".ico").addClass(a[1]+"Hover");
	      	$(this).children(".none").show();
	    },
	    function(){
      		var a = $(this).children(".ico").attr("class").split(" ");
	      	$(this).children(".ico").removeClass(a[2]);
	      	$(this).children(".none").hide();
	    }
	);	
  	$.sideBar("#js_sidebar");
});
</script>
</head>

<body>
<div id="loginbar">
	<div class="login_content">
 		<div class="login_left">
	        <span class="left_login" style="font-size:13px; float:left;">全国统一电话：400-112-5689 </span>
	        <div style="float:left; width:150px;">
	            <div class="top_sina show">
	           		<i class="ico ico_sina"><a href="http://weibo.com/u/5475395913?topnav=1&wvr=6" target="_blank"></a></i>
	                <div class="none">
	                </div>
	            </div>
	            <div class="top_weixin show">
	            	<i class="ico ico_weixin"></i>
	                <div class="none" style="display:none;">
	                	<img src="/static/images/home/top_weixin.png">
	                </div>
	        	</div>
	    	</div>      
		</div>
	    <div class="login_right"> 
	    	<span class="nav_s">
		   		<?php if(($users[user_id] > 0)): ?><a id="js_sys_loginout" href="javascript:void(0);">安全退出</a>
					<a href="/Center.html" style="margin-right:15px;color:#ea813d;"><?php echo ($_SESSION["Home_user"]["username"]); ?></a> 	
		   		<?php else: ?>
		       		<a style="color:#26b2ff;" href="/Login.html">立即登录</a>  <i style="color:#FFF; float:right; margin-right:10px; font-size:12px;">|</i> <a style="color:#ea813d;margin-right:10px;" href="/Register.html">快速注册 </a><?php endif; ?>
				<i style="color:#FFF; float:right; margin-right:10px; font-size:12px;"> | </i> <a style="color:fff; float:right; margin-right:10px;" href="javascript:void(0);" onclick="SetHome(this,window.location);">设为首页</a>
			</span>
		</div>
	</div>
</div>

<div id="top" style="clear:both">
	<div class="top_content">
    	<h2><a href="/"><img src="/static/images/home/logo.png" /></a></h2>
        <div class="nav">
        	<ul class="about_nav">
            	<li><a href="/">首页</a></li>
                <li><a href="/Platform.html" >选平台</a></li>
                <li><a href="/Invest.html">选标中心</a></li>
                <li class="na_a"><a href="/Center.html">个人中心</a></li>
                <li><a href="/About.html">关于我们</a></li>
            </ul>
        </div>
       
    </div>
</div>
<!-- 头部   end -->

<!-- 右侧内容   start -->
<div id="content">

	<!-- 左侧菜单   start -->
	<div class="content_left">
    <ul class="submenu">
        <li><a href="/Center/Safeinfo.html" class="<?php if(($menu == 1)): ?>su_b2<?php endif; ?>">安全信息</a></li>
        <li><a href="/Center/Platform.html" class="<?php if(($menu == 2)): ?>su_b2<?php endif; ?>">平台信息</a></li>
        <li><a href="/Center/Bankinfo.html" class="<?php if(($menu == 3)): ?>su_b2<?php endif; ?>">银行信息</a></li>
        <li><a href="/Center/Myinvest.html" class="<?php if(($menu == 4)): ?>su_b2<?php endif; ?>">投资记录</a></li>
        <li><a href="/Center/Analysis.html" class="<?php if(($menu == 5)): ?>su_b2<?php endif; ?>">投资分析</a></li>
        <li><a href="/Center/Account.html" class="<?php if(($menu == 6)): ?>su_b2<?php endif; ?>">资金记录</a></li>
        <li><a href="/Center/Cash.html" class="<?php if(($menu == 7)): ?>su_b2<?php endif; ?>">提现记录</a></li>
        <li><a href="/Center/Invitation.html" class="<?php if(($menu == 8)): ?>su_b2<?php endif; ?>">推荐统计</a></li>
    </ul>
</div>
	<!-- 左侧菜单   end -->
 
	<div class="content_right">
        <h2>佣金提现</h2>	
    	<div class="zq_bg">
	       	<div class="yaoqing">
	           <textarea class="yao_1" cols="40" rows="3" id="inviteText">http://www.wangtousuo.com/Register/index/u/<?php echo ($invite_userid); ?></textarea> 
			   <input id="copyText" class="fuzhi" type="button" value="复制邀请链接" />
	        </div>
	   	  	<div class="yaoqing">
	               <p>【推荐奖励】已推荐人数：<strong style="color:#900; font-size:18px;"><?php echo ($tempData['num']); ?> </strong> 人，获得奖励：<strong style="color:#090; font-size:18px;"><?php echo ($tempData['sum_money']); ?> </strong>元</p>
	               <p>【投资奖励】<strong style="color:#090; font-size:18px;">0</strong> 元</p>
	               <p>【提现金额】提现申请中金额数：<strong style="color:#f66; font-size:18px;"><?php echo ($tempData['no_use_money']); ?> </strong>元，已经提现成功金额：<strong style="color:#C06; font-size:18px;"><?php echo (($tempData['cash_money'])?($tempData['cash_money']):0); ?> </strong>元，现拥有可提现金额：<strong style="color:#ff6600; font-size:18px;"><?php echo ($tempData['use_money']); ?> </strong>元</p>
	               <p> 成功推荐1人并在活动期间有投资行为产生奖励15元，单笔提现金额不能低于10元<a href="__GROUP__/Cash/extraction.html"><input class="fuzhi_1" style="margin-right:12px;" type="button" value="奖励提现" /></a></p>
	       	</div>
      	</div>
		<div class="scxx_bg" style="margin-left:10px;">
       	  	<table width="730" border="0" cellspacing="0" cellpadding="0" style=" font-size:12px; font-family: Arial; width:732px; text-align:center;">
    	  		<tr class="tr_01">
           	  		<td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">注册人名称</td>
	               	<td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">手机认证</td>
               	  	<td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">邮箱认证</td>
               	  	<td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">身份证认证</td>
               	  	<td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">是否投资</td>
               	  	<td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">奖励（元）</td>
	               	<td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">注册时间</td>
	           	</tr>
	           	<?php if(($tempData[num] > 0)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="tr_01">
            	  	 <td class="t_2" align="center"><?php echo ($v["username"]); ?></td>
	               	 <td class="t_2" align="center">
						<?php if(($v[phone_status] == 1)): ?>已认证
						<?php else: ?>
							未认证<?php endif; ?>
					 </td>
	               	 <td class="t_2" align="center">
	               		<?php if(($v[email_status] == 1)): ?>已认证
						<?php else: ?>
							未认证<?php endif; ?>
	               	 </td>
	               	 <td class="t_2" align="center">
	               		<?php if(($v[real_status] == 1)): ?>已认证
						<?php else: ?>
							未认证<?php endif; ?>
					 </td>
	               	 <td class="t_2" align="center">
	               		<?php if(($v[is_tender] == 1)): ?>已投资
						<?php else: ?>
							未投资<?php endif; ?>	               	 	
					 </td>
	               	 <td class="t_2" align="center"><?php echo ($v["invite_money"]); ?></td>
	               	 <td class="t_2" align="center"><?php echo (date('Y-m-d H:i:s', $v["addtime"])); ?></td>
	           	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	           	<?php else: ?>
	           	<tr class="tr_01">
					<td class="t_2" colspan="7">暂无数据</td>
				</tr><?php endif; ?>
           	</table>
            </div>
                      
   	  		<div style="width:730px; margin-left:10px;  border:1px solid #d3d4d6; padding:10px 0; text-align:center; border-top:none;">
          		<div class="last_list">
					<?php echo ($page); ?>
                </div>    
          	</div> 
  
    </div>
    
</div>
<!-- 右侧内容   end -->

<div class="clear"></div>

<!-- 底部   start -->
<div class="foot" style="width:100%; font-size:14px;">
	<div class="ffoot">
		<a href="/about/index/id/3.html">公司简介</a>
		<a href="/about/index/id/4.html">团队介绍</a>
        <a href="/about/index/id/6.html">联系我们</a>
		<a href="/about/index/id/2.html">使用必读</a>
	</div>              
	<span>版权所有：深圳市伟泰投资发展有限公司 - <a href="http://www.beianbeian.com/search/wangtousuo.com" target="_blank" style="color:#ccc;">粤ICP备14094677号-1</a> Copyright © 2014 www.wangtousuo.com . All Rights Reserved.</span>
</div>

<div id="js_sidebar"></div>
<!-- 底部   end -->

<script type="text/javascript">
$(function(){
	$("#copyText").click(function(){
		var Url2 = document.getElementById("inviteText"); 
		if (document.all){
		   	window.clipboardData.setData("text", Url2.innerText)
		   	layer.alert("邀请好友注册链接已经复制成功，您可以使用Ctrl+V粘贴发送给好友", 1);
			Url2.select(); // 选择对象 
		}else{
			alert("此功能只能在IE上有效\n\n您可以使用Ctrl+C进行复制", 8);
			Url2.select(); // 选择对象 
		}
	});
});
</script>
</body>
</html>