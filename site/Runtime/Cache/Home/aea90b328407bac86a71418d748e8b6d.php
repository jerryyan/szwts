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

<!-- 注册开始 -->
<div class="l_center cr" style=" margin-top:90px;border-top:0px; height:420px;">

    <div class="cen_y">
        <div class="cen_t" style="display:block;"></div>
        <div class="cen_t1" style="display:none;"></div>
        <div class="cen_t2" style="display:none;"></div>
    </div>

    <div class="l_center_01" style="height:auto;">
        <div class="cen_tt" style="display:block;">
            <ul class="ul_li" style="padding-top:50px; width:950px; margin-top:0px; padding-left:1px; background:url(/static/images/home/login/fx.jpg) no-repeat right;">
                <li style="width:850px;">
                    <span class="ul_span">用户名:</span>
                    <div class="c_li_1">
                        <input id="invite_userid" name="invite_userid" type="hidden" value="<?php echo (($invite_userid)?($invite_userid):0); ?>" />
                        <input id="oauth_id" name="oauth_id" type="hidden" value="0" />
                        <input id="uname" name="uname" type="text" maxlength="16" />
                    </div>
                    <span id="js_uname_tips" class="ul_span3"></span>
                </li>
                <li style="width:850px;">
                    <span class="ul_span">密  码:</span>
                    <div class="c_li_1"><input id="upwd" name="upwd" type="password" oncopy="return false" onpaste="return false" maxlength="20" /></div>
                    <span id="js_upwd_tips" class="ul_span3"></span>
                </li>
                <li style="width:850px;">
                    <span class="ul_span">确认密码:</span>
                    <div class="c_li_1"><input id="upwd_confirm" name="upwd_confirm" type="password" oncopy="return false" onpaste="return false" maxlength="20" /></div>
                    <span id="js_upwd_confirm_tips" class="ul_span3"></span>
                </li>
<!--                <li style="width:850px;">
                    <span class="ul_span">验证码:</span>
                    <div class="c_li_1" style="width:140px;"><input id="valicode" name="valicode" type="text" style="width:130px;" maxlength="4" /></div>
                    <p class="m_1"><img id="valicodeforimage" src="/Login/getvalicode" onclick="this.src = '/Login/getvalicode/' + Math.round(Math.random() * 10000)" alt="点击更新验证码" width="105" height="36" /></p>
                    <span id="js_valicode_tips" class="ul_span3"></span>

                </li>-->
                <li>
                    <span class="ul_span">手  机：</span>
                    <div class="c_li_1" >
                        <input id="phone" name="phone" style="width:150px;" type="text" maxlength="11" />
                        <span id="sendinfo" style="color: red;"></span>
                    </div>      
                </li>
                <li>
                    <span class="ul_span">验证码：</span>
                    <div class="c_li_1" style="width:95px;"><input id="smscode" name="smscode" style="width:80px;" type="text" maxlength="6" /></div>
                    <p class="m_1">
                        <input id="sendCode" style="background:url('/static/images/home/login/dx.jpg') no-repeat; width:86px; height:34px; border:0;" type="button" />
                        <span id="send_code_status" class="ul_span3"></span>
                    </p>
                    <span id="js_verifyphone_tips" style="float:left; width:500px; margin-left:124px; line-height:25px; height:25px; color:#ff0000;"></span>
                </li>      

                <li style="margin-left:125px;height:35px;margin-top:10px;color:#666; display:inline;">
                    <input id="check_confirm" name="check_confirm" type="checkbox" checked style="margin-left:5px;" /> 
                    点击注册即同意网投所<a id="js_open_agreement" style="color:#f00;" href="javascript:void(0);">《用户协议》</a>
                </li>
                <li class="l_denglu">
                    <input id="registerTo" name="registerTo" type="button" style="cursor:pointer;" />
                    <span id="js_submit_tips" class="ul_span3" style="margin-left:45px;margin-top:5px;width:305px; "></span>
                </li>
            </ul>  
        </div>
    </div> 
</div>
<!-- 注册结束 -->

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

<script type="text/javascript" src="__ROOT__/static/js/common.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/home/register.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/plugins/layer.min.js?version=1.8.4"></script>
<script type="text/javascript">
                        $(function () {
                            $("#js_open_agreement").click(function () {
                                $.layer({
                                    type: 2,
                                    border: [0],
                                    title: false,
                                    shadeClose: false,
                                    closeBtn: false,
                                    iframe: {src: '__GROUP__/Register/agreement'},
                                    area: ['560px', '500px']
                                });
                            });
                   
                        });
</script>
</body>
</html>