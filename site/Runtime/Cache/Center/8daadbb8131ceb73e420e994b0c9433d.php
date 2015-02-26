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
});
</script>
</head>

<body>
<div id="loginbar">
  	<div class="login_content">
    	<div class="login_left">
            <span class="left_login" style="font-size:13px;"><a href="/Center/Basicinfo.html">您好，<?php echo ($_SESSION["Home_user"]["username"]); ?></a> 欢迎来到网投所  全国统一电话：400-000-000  
			</span>
 
        </div>
    	<div class="login_right">
    		<?php if(($users[user_id] > 0)): ?><span class="nav_s"><a id="js_sys_loginout" href="javascript:void(0);">安全退出</a></span>
    		<?php else: ?>
        		<span class="nav_s"> <a style="color:#26b2ff;" href="/Login">立即登录</a>  <i style="color:#FFF; float:right; margin-right:10px; font-size:12px;">|</i> <a style="color:#ea813d;margin-right:10px;" href="/Register/index.html">快速注册 </a></span><?php endif; ?>
		</div>
	</div>
</div> 

<div id="top" style="clear:both">
	<div class="top_content">
    	<h2><a href="/"><img src="/static/images/home/logo.png" /></a></h2>
        <div class="nav">
        	<ul class="about_nav">
            	<li><a href="index.html">首页</a></li>
                <li><a href="/Platform.html" >选平台</a></li>
                <li><a href="/Invest.html">选标中心</a></li>
                <li><a href="/Center/Basicinfo.html">个人中心</a></li>
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
        <li><a href="/Center/Safeinfo.html" class="<?php if(($center_menu_num == 1)): ?>su_b2<?php endif; ?>">安全信息</a></li>
        <li><a href="/Center/Fileinfo.html" class="<?php if(($center_menu_num == 2)): ?>su_b2<?php endif; ?>">平台信息</a></li>
        <li><a href="/Center/Bankinfo.html" class="<?php if(($center_menu_num == 3)): ?>su_b2<?php endif; ?>">银行卡信息</a></li>
        <li><a href="/Center/Message.html" class="<?php if(($center_menu_num == 4)): ?>su_b2<?php endif; ?>">投资记录</a></li>
        <li><a href="/Center/Invitation.html" class="<?php if(($center_menu_num == 5)): ?>su_b2<?php endif; ?>">推荐统计</a></li>
        <li><a href="/Center/Integral.html" class="<?php if(($center_menu_num == 6)): ?>su_b2<?php endif; ?>">奖励提现</a></li>
        <li><a href="/Center/Invitation.html" class="<?php if(($center_menu_num == 7)): ?>su_b2<?php endif; ?>">游览历史</a></li>
    </ul>
</div>
	<!-- 左侧菜单   end -->
	
	<div class="content_right">
	    <div class="message_title"><span>个人基础信息</span></div>
		<div class="message_content">
			<div class="left_img"><img id="imageUploadUrl_1" src="/static/<?php echo (($tempData['user_result']['avatar'])?($tempData['user_result']['avatar']):'images/center/message_img.jpg'); ?>" width="98" height="98" />          
            	<div style="margin-top:15px;">
            		<input id="textUploadUrl_1" type="hidden" />
					<iframe name="iframeUpload" src="__GROUP__/Upload/page/type/avatar/id/1" width="100px" height="30px" frameborder="no" scrolling="no"></iframe>
					<span id="iframeUploadPanel_1"></span>
            	</div>           
            </div>
            <div class="right_text">
                <ul class="me_center">
                    <li>
                    	<span class="left_me">
                    		<a style="margin-left:18px;height:19px; padding-top:3px; float:left; font:14px '微软雅黑'; color:#F00;">*</a>用户名</span>
                    	<span class="center_me"><?php echo ($tempData['user_result']['username']); ?></span>
                    </li>
                    <li>
                    	<span class="left_me"><a style=" height:19px; padding-top:3px; float:left; font:14px '微软雅黑'; color:#F00; margin-left:2px;">*</a>真实姓名</span>
                    	<span class="center_me"><?php echo (($tempData['user_result']['realname'])?($tempData['user_result']['realname']):""); ?></span>
                    	<span class="right_me">
                    		
           	            <?php if(($tempData["user_result"]["real_status"] == 1)): ?><a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_icon.jpg" width="16" height="16" /></a>已认证
                    	<?php else: ?>
                    		<?php if(($tempData["user_result"]["card_type"] == 1)): ?><a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_hicon.jpg" width="16" height="16" /></a>
                    			<a href="__GROUP__/Realname/see" style=" color:#f95e57;">审核中</a>
                    		<?php else: ?>
                    			<a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_hicon.jpg" width="16" height="16" /></a>
                    			<a href="__GROUP__/Realname" style=" color:#f95e57;">去认证</a><?php endif; endif; ?>
                    	
                    	</span>
                    </li>
                    <li>
                    	<span class="left_me"><a style=" height:19px; padding-top:3px; float:left; font:14px '微软雅黑'; color:#F00; margin-left:2px;">*</a>身份证号</span>
                    	<span class="center_me"><?php echo (($tempData['user_result']['card_id'])?($tempData['user_result']['card_id']):""); ?></span>
                    	<span class="right_me">
                    	
           	            <?php if(($tempData["user_result"]["real_status"] == 1)): ?><a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_icon.jpg" width="16" height="16" /></a>已认证
                    	<?php else: ?>
                    		<?php if(($tempData["user_result"]["card_type"] == 1)): ?><a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_hicon.jpg" width="16" height="16" /></a>
                    			<a href="__GROUP__/Realname/see" style=" color:#f95e57;">审核中</a>
                    		<?php else: ?>
                    	    	<a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_hicon.jpg" width="16" height="16" /></a>
                    			<a href="__GROUP__/Realname" style=" color:#f95e57;">去认证</a><?php endif; endif; ?>
                    	                 
                    	</span>
                    </li>
                    <li>
                    	<span class="left_me"><a style=" height:19px; padding-top:3px; float:left; font:14px '微软雅黑'; color:#F00; margin-left:2px;">*</a>手机号码</span>
                    	<span class="center_me"><?php echo (($tempData['user_result']['phone'])?($tempData['user_result']['phone']):""); ?></span>
                    	<span class="right_me">
                    	
                    	<?php if(($tempData["user_result"]["phone_status"] == 1)): ?><a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_icon.jpg" width="16" height="16" /></a>已绑定
                    	<?php else: ?>
                    	    <a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_hicon.jpg" width="16" height="16" /></a>
                    		<a href="#" style=" color:#f95e57;">去认证</a><?php endif; ?>
                    	
                    	</span>
                    </li>
                    <li>
                    	<span class="left_me"><a style=" height:19px; padding-top:3px; float:left; font:14px '微软雅黑'; color:#F00; margin-left:2px;">*</a>邮箱地址</span>
                    	<span class="center_me"><?php echo (($tempData['user_result']['email'])?($tempData['user_result']['email']):""); ?></span>
                    	<span class="right_me">
                    	
                   		<?php if(($tempData["user_result"]["email_status"] == 1)): ?><a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_icon.jpg" width="16" height="16" /></a>已绑定
                    	<?php else: ?>
                    	    <a style="float:left; margin:4px 4px 0 0; height:18px;"><img src="/static/images/center/me_hicon.jpg" width="16" height="16" /></a>
                    		<a href="#" style=" color:#f95e57;">去认证</a><?php endif; ?>
                    	
                    	</span>
                    </li>
                </ul>              
            </div>
        </div>
  	</div>	
</div>
<!-- 右侧内容   end -->

<div class="clear"></div>

<!-- 底部   start -->
<div class="foot" style="width:100%; font-size:14px;">
	<div class="ffoot">
           <a href="#"/>使用必读</a>
           <a href="#"/>专家顾问</a>
            <a href="#"/>团队介绍</a>
            <a href="#"/>联系方式</a>
            <a href="#"/>云金融</a>
            <a href="#"/>有情连接</a>
 </div>       
           
   <span>2014 深圳网投所有限公司 备案号7848235   Copyright © 2014 www.wangtousuo.com . All Rights Reserved.</span>

</div>

       
<div class="quickBox" style="display:none;">
	<div id="chatOnline" class="chatOnline">
		<a class="icon" href="javascript:void(0);">在线客服</a>
		<span class="onlineList" style="display: none;">
			<i class="arrow"></i>
			<i class="onlines">
				<strong>在线客服</strong>
				<?php if(is_array($kefuList)): $i = 0; $__LIST__ = $kefuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($v["qq"]); ?>&site=qq&menu=yes"><?php echo ($v["username"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
			</i>
		</span>
	</div>
	<a class="qrcode" href="javascript:void(0);">
		<em class="icon">微信号</em>
		<span>
			<i class="arrow"></i>
			<img alt="中源资本微信公众号" src="http://www.zyzib.com/static/images/center/wx1.jpg">
		</span>
	</a>
	<a id="goTop" class="goTop" href="javascript:void(0);">顶部</a>
</div>
<script type="text/javascript">
$(function(){
	$("#chatOnline").hover(function(){
		$(".onlineList").stop(false, true).show("fast");
	},function(){
		$(".onlineList").stop(false, true).hide("fast");
	});
    //当点击跳转链接后，回到页面顶部位置
    $("#goTop").click(function(){
	    $('body,html').animate({scrollTop:0},500);
	    return false;
    });
});
</script>

<!-- 底部   end -->

</body>
</html>