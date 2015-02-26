<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ($pageTitle); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?php echo ($pageKeywords); ?>" />
        <meta name="description" content="<?php echo ($pageDes); ?>" />
        <link href="__ROOT__/static/css/home/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="__ROOT__/static/js/jquery.js?version=1.7.1"></script>
        <script type="text/javascript" src="__ROOT__/static/js/plugins/layer.min.js?version=1.8.4"></script>
    </head>
    <body>
        <div class="logo">
            <div class="logo_01">
                <a href="/"><img src="/static/images/home/logo_dl.png"/></a>
                <span>
                    <?php if(($loginPage == 1)): ?>没有网投所账号？ <a style="color:#F00;" href="/Register.html">立即注册</a>
                        <?php else: ?> 
                        已有网投所账号？ <a style="color:#F00;" href="/Login.html">立即登录</a><?php endif; ?>
                </span>
            </div>
        </div>

<!--  引入头部   end -->

<!-- 登录开始 -->
<div class="l_center cr">
	<div class="l_center_01">
        <ul class="ul_li">
			<li style="height:80px; padding-left:90px;">
				<h3 class="c_h3">使用网投所账户登陆</h3>
			</li>
            <li>
            	<span class="ul_span">用户名</span>
            	<div class="c_li_1">
<!--            		<input id="oauth_id" name="oauth_id" type="hidden" value="0" />
-->            		<input id="uname_l" name="uname_l" type="text" placeholder="用户名/邮箱/手机" maxlength="30" />
            	</div>			              
            	<span id="js_uname_l_tips" class="input_tips"></span>
            </li>
            <li>
            	<span class="ul_span">密  码</span>
            	<div class="c_li_1">
            		<input id="upwd_l" name="upwd_l" type="password" maxlength="20" oncopy="return false" onpaste="return false" placeholder="密码" />
            	</div>
            	<span id="js_upwd_l_tips" class="input_tips"></span>
            </li>
            <li>
            	<span class="ul_span">验证码</span>
            	<div class="c_li_1" style="width:140px;">
            		<input id="valicode_l" name="valicode_l" style="width:130px;" type="text" maxlength="4" placeholder="验证码" />
            	</div>
            	<p class="m_1"><img id="valicodeforimage_l" src="__URL__/getvalicode" onclick="this.src='__URL__/getvalicode/' + Math.round(Math.random()*10000)" alt="点击更新验证码" width="105" height="36" /></p>
            	<span id="js_valicode_l_tips" class="input_tips"></span>
            </li>
            <li class="l_denglu1">
            	<input id="loginTo" name="loginTo" type="button" value="登录" style="cursor:pointer;" />
                
            	<span class="d_s"> 没有网投所账号？<a style="margin-right:15px;" href="/Register.html">前往注册>></a>  <a href="/Findpwd.html">忘记密码</a></span>
            </li>
			<!--<li style="margin-top:30px;">
				<span class="ul_span" style="margin-top:23px;">第三方账号登录</span>
				<div class="w_b">
					<p><a href="__URL__/oauth"><img src="/static/images/home/login/qq.jpg" width="138" height="37" /></a></p>
           			<p style="margin-left:30px;"><a href="__URL__/oauth/type/1"><img src="/static/images/home/login/wb.jpg" width="138" height="37" /></a></p>
                </div>
			</li> -->
		</ul>
	</div>
</div>
<!-- 登录结束 -->

<!--  引入底部   start -->
<div class="foot" style="width:100%; font-size:14px;">
	<div class="ffoot">
		<a href="/About.html" />使用必读</a>
		<a href="#" />专家顾问</a>
		<a href="#" />团队介绍</a>
		<a href="#" />联系方式</a>
		<a href="#" />云金融</a>
		<a href="#" />友情连接</a>
	</div>              
	<span>版权所有：深圳市伟泰投资发展有限公司 - <a href="http://www.beianbeian.com/search/wangtousuo.com" target="_blank" style="color:#ccc;">粤ICP备14094677号-1</a> Copyright © 2014 www.wangtousuo.com . All Rights Reserved.</span>
</div>

       
<!--  引入底部   end -->

<script type="text/javascript" src="__ROOT__/static/js/home/login.js"></script>
<script type="text/javascript">
//定义回车事件,响应登录按钮操作
if(document.addEventListener) {
    document.addEventListener("keypress", fireFoxHandler, true);//Firefox
}else{
    document.attachEvent("onkeypress", ieHandler);
}

function fireFoxHandler(event){
    if (event.keyCode==13){
    	subdata()
    }
}

function ieHandler(event){
    if(event.keyCode==13){
    	subdata()
    }
}
</script>
</body>
</html>