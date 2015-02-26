<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>个人中心-个人投资理财-网投所</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="网投所,创业融资,个人理财计划,个人投资理财" />
<meta name="description" content="网投所是国领先的P2P网贷平台垂直搜索引擎，为现有的网贷平台提供P2P网贷平台排名，评级服务等；为投资者提供优质的投资理财产品！" />
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
        <h2>安全信息</h2>	
        
        <!-- 昵称   start --> 
        <div class="zh_nr">
        	<div class="ggys nc">昵称</div> <span>已设置</span> <a style="float:right; color:#c7c7c9;"><?php echo ($tempData['user_result']['username']); ?></a>
        </div>
        <!-- 昵称   end -->
        
		<!-- 实名认证 start --> 
		<?php if(($tempData["user_result"]["real_status"] == 1)): ?><div class="zh_nr">
	        	<div class="ggys rz">实名认证</div> 
	        	<span><?php echo ($tempData['user_result']['card_id']); ?></span> 
	        	<a href="javascript:void(0);" style="float:right;"><?php echo ($tempData['user_result']['realname']); ?></a>
	        </div>
        <?php else: ?>
        	<?php if(($tempData["user_result"]["card_type"] == 1) and ($tempData["user_result"]["real_status"] == 0)): ?><div class="zh_nr">
		        	<div class="ggys rz">实名认证</div> 
		        	<span style="color:#ff0103;">审核中</span> <a href="__GROUP__/Realname/see.html" style="float:right; color:#ff0103;">查看</a>
		      	</div>	
        	<?php elseif(($tempData["user_result"]["card_type"] == 1) and ($tempData["user_result"]["real_status"] == 2)): ?>  
		        <div class="zh_nr">
		        	<div class="ggys rz">实名认证</div> 
		        	<span style="color:#ff0103;">审核失败</span> <a href="__GROUP__/Realname.html" style="float:right; color:#ff0103;">重新认证</a>
		      	</div>
		    <?php else: ?>
		    	<div class="zh_nr">
		        	<div class="ggys rz">实名认证</div> 
		        	<span style="color:#ff0103;">未认证</span> <a href="__GROUP__/Realname.html" style="float:right; color:#ff0103;">认证</a>
		      	</div><?php endif; endif; ?>
        <!-- 实名认证    end --> 
        
        <!-- 登录密码   start -->
   	  	<div class="zh_nr">
        	<div class="ggys mm">登录密码</div> <span>已设置</span> 
        	<a href="__GROUP__/Loginpwd/modify.html" style="float:right; color:#ff0103;">修改</a>
      	</div>

        <!-- 登录密码   end -->
        
        <!-- 邮箱   start -->    
        <?php if(($tempData["user_result"]["email_status"] == 1)): ?><div class="zh_nr">
	        	<div class="ggys yx">绑定邮箱</div> <span><?php echo ($tempData['user_result']['email']); ?></span> 
	        	<a href="__GROUP__/Email/rebind.html" style="float:right; color:#ff0103;">修改</a>
	      	</div>
      	<?php else: ?>
      		<div class="zh_nr">
	        	<div class="ggys yx">绑定邮箱</div> <span style="color:#ff0103;">未设置</span> 
	        	<a href="__GROUP__/Email/bind.html" style="float:right; color:#ff0103;">设置</a>
	      	</div><?php endif; ?>     
      	<!-- 邮箱   end--> 
      	
      	<!-- 手机   start -->
      	<?php if(($tempData["user_result"]["phone_status"] == 1)): ?><div class="zh_nr">
	        	<div class="ggys sj">绑定手机</div> <span><?php echo ($tempData['user_result']['phone']); ?></span> 
	        	<a href="__GROUP__/Mobile/rebind.html" style="float:right; color:#ff0103;">修改</a>
	      	</div>
      	<?php else: ?>
      		<div class="zh_nr">
	        	<div class="ggys sj">绑定手机</div> <span style="color:#ff0103;">未设置</span> 
	        	<a href="__GROUP__/Mobile/bind.html" style="float:right; color:#ff0103;">设置</a>
	      	</div><?php endif; ?>
      	<!-- 手机   end -->
      	
      	<!-- 提现密码   start -->
      	<?php if(($tempData["user_result"]["paypassword"] != "")): ?><div class="zh_nr">
	        	<div class="ggys txmm">提现密码</div> <span>已设置</span> 
	        	<div style="float:right; height:20px; display:block; color:#cbcbcb; font-family:'微软雅黑'; font-size:10px;">
	        		<a href="__GROUP__/Paypwd/modify.html" style="color:#ff0103;font-size:12px;margin-right:0px;">修改</a>&nbsp;|&nbsp;<a href="__GROUP__/Paypwd/find.html" style="color:#ff0103;font-size:12px;">找回</a>
	        	</div>
	        </div>
        <?php else: ?>
        	<div class="zh_nr">
	        	<div class="ggys txmm">提现密码</div> <span style="color:#ff0103;">未设置</span> 
	        	<a href="__GROUP__/Paypwd/setup.html" style="float:right; color:#ff0103;">设置</a>
	        </div><?php endif; ?>
      	<!-- 提现密码   end -->
        
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

</body>
</html>