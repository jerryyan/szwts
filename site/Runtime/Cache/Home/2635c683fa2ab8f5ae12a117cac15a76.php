<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php echo ($pageTitle); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?php echo ($pageKeywords); ?>" />
        <meta name="description" content="<?php echo ($pageDes); ?>" />
        <link href="__ROOT__/static/css/global.css" rel="stylesheet" type="text/css" />
        <link href="__ROOT__/static/css/home/style.css" rel="stylesheet" type="text/css" />
        <link href="__ROOT__/static/css/lightbox.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="__ROOT__/static/js/jquery.js?version=1.7.1"></script>
        <script type="text/javascript" src="__ROOT__/static/js/plugins/layer.min.js?version=1.8.4"></script>
        <script type="text/javascript" src="__ROOT__/static/js/common.js"></script>
        <!--百度统计-->
        <script>
            var _hmt = _hmt || [];
            (function () {
                var hm = document.createElement("script");
                hm.src = "//hm.baidu.com/hm.js?2ed270ecd7fe3c439c9998c8f64e38b9";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();
        </script>


        <script type="text/javascript">
            $(function () {
                $("#js_sys_loginout").click(function () {
                    layer.confirm("确认要退出系统吗？", function (index) {
                        location.href = '/Center/Index/loginout';
                    });
                });
                $(".show").hover(
                        function () {
                            var a = $(this).children(".ico").attr("class").split(" ");
                            $(this).children(".ico").addClass(a[1] + "Hover");
                            $(this).children(".none").show();
                        },
                        function () {
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
                    <span class="left_login" style="font-size:13px; float:left;">全国统一电话：400-112-5689&nbsp;&nbsp;网投所交流群：200020786</span>
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
                        <i style="color:#FFF; float:right; margin-right:10px; font-size:12px;"> | </i> <a style="color:fff; float:right; margin-right:10px;" href="javascript:void(0);" onclick="SetHome(this, window.location);">设为首页</a>
                    </span>
                </div>
            </div>
        </div> 

        <div id="top" style="clear:both">
            <div class="top_content">          
                <h1 style="display: block;height: 0;width: 0;overflow: hidden;">网投所</h1>
                <h2><a href="/"><img src="/static/images/home/logo.png" /></a></h2>
                <div class="nav">
                    <ul class="about_nav">
                        <li class="<?php if(($menu == 1)): ?>na_a<?php endif; ?>"><a href="/">首页</a></li>
                        <li class="<?php if(($menu == 2)): ?>na_a<?php endif; ?>"><a href="/Platform.html" >选平台</a></li>
                        <li class="<?php if(($menu == 3)): ?>na_a<?php endif; ?>"><a href="/Invest.html">选标中心</a></li>
                        <li><a href="/Center.html">个人中心</a></li>
                        <li class="<?php if(($menu == 4)): ?>na_a<?php endif; ?>"><a href="/About.html">关于我们</a></li>
                    </ul>
                </div>

            </div>
        </div>
<!--  引入头部   end -->

<div class="ui-dialog" style="height:190px; padding-top:15px;  width: 958px;border:0px; padding-bottom:180px; padding-top:150px; background:#FFF; margin:0 auto; border:1px solid #ccc;">
    <div class="u_left"><img src="/static/images/home/fxx.jpg" /></div>
    <div class="u_right"><span>使用网投所用户登录</span>
        <p><input id="js_platform_to" type="button" value="进入平台" class="wts-b-button"></p>
        <p> <b style="color:#F00;">温馨提示：</b> 通过网投所家进入平台进行投资，可以享受网投所的保障服务 </p>
    </div>    
    <div class="s_y">使用已有<?php echo ($platform_name); ?>账户  <strong><a href="<?php echo ($platform_login_bind_url); ?>">登录</a></strong></div> 
</div>

<!--  引入底部   start -->
<div class="foot" style="width:100%; font-size:14px;">
    <div class="ffoot">
        <a href="/about/index/id/3.html">公司简介</a>
        <a href="/about/index/id/4.html">团队介绍</a>
        <a href="/about/index/id/6.html">联系我们</a>
        <a href="/about/index/id/11.html">网站地图</a>
        <a href="/about/index/id/2.html">使用必读</a>
    </div>              
    <span>Copyright © 2014 www.wangtousuo.com . All Rights Reserved. 版权所有：深圳市伟泰投资发展有限公司 - <a href="http://www.beianbeian.com/search/wangtousuo.com" target="_blank" style="color:#ccc;">粤ICP备14094677号-1</a><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cspan id='cnzz_stat_icon_1254152294'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1254152294%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>  </span>
</div>

<div id="js_sidebar"></div>




<!--  引入底部   end -->

<script type="text/javascript">
$(function(){
	$("#js_platform_to").click(function(){
		location.href = '<?php echo ($platform_reg_bind_url); ?>';
	});
});
</script>

</body>
</html>