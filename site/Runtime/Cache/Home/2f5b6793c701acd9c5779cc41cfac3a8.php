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

<!-- 内容区 开始-->
<div id="content">
    <div class="wrapper clearfix">
        <div class="content-left">
            <!-- 面包屑 -->
            <div class="w_crumb"></div>
            <!-- 面包屑结束 -->
            <!-- 搜索框开始 -->
            <div class="searchbox">
                <form name="searchform" action="http://www.touzhijia.com/wenda/question/search.html" method="post">
                    <span class="round"><input autocomplete="off" maxlength="100" placeholder="" class="js-sh-ipt input_key" tabindex="1" name="word" id="search-kw" value=""></span>
                    <span class="button"><input type="button" id="search_btn" class="js-search-bt s_btn" value="搜索答案"></span>
                    <span class="button"><input type="button" id="ask_btn" class="js-ask-bt s_btn" value="我要提问"></span>
                </form>
            </div>
            <!-- 搜索框结束 -->

            <div class="modbox classifymod">
                <div class="title mt10">
                    全部分类
                </div>
                <div>
                <ul class="classifymod-list clearfix">

                    <!--<li><a href="http://www.touzhijia.com/wenda/c-12.html">投之家使用</a><em>(156)</em></li>-->
                    <li><a href="http://www.touzhijia.com/wenda/c-12.html">投之家使用答疑</a></li>

                    <!--<li><a href="http://www.touzhijia.com/wenda/c-13.html">平台业务咨</a><em>(127)</em></li>-->
                    <li><a href="http://www.touzhijia.com/wenda/c-13.html">平台业务咨询</a></li>

                    <!--<li><a href="http://www.touzhijia.com/wenda/c-14.html">理财投资交</a><em>(402)</em></li>-->
                    <li><a href="http://www.touzhijia.com/wenda/c-14.html">理财投资交流</a></li>

                    <!--<li><a href="http://www.touzhijia.com/wenda/c-15.html">p2p其他问</a><em>(137)</em></li>-->
                    <li><a href="http://www.touzhijia.com/wenda/c-15.html">p2p其他问题</a></li>

                </ul>
                </div>
            </div>
            <!--广告位1-->
            <div id="mod-answer-list" class="mod-answer-list mt10">
                <div class="hd">
                    <ul class="tab-card">
                        <li class="on"><span>全部问题</span></li>                    <li class="current_none"><a class="recommand" href="http://www.touzhijia.com/wenda/c-all/6.html">推荐问题</a></li>                    <li class="current_none"><a href="http://www.touzhijia.com/wenda/c-all/1.html"><font color="#ff6600">？</font>待解决</a></li>                    <li class="current_none"><a href="http://www.touzhijia.com/wenda/c-all/2.html"><font color="#1bbf00">√ </font>已解决</a></li>                </ul>
                </div>
                <div class="bd">
                    <div class="cls-qa-table">
                        <table>
                            <tbody>
                                <tr class=""><th class="s0">标题</th><th class="s1">回答/浏览</th><th class="s2">时间</th></tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2158.html" target="_blank" title="用投之家账户投资，能使用平台的VIP吗？">用投之家账户投资，能使用平台的VIP吗？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-12.html" title="投之家使用答疑" class="lei">投之家使用答疑</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>0/70</td>
                                    <td>2015/02/08 08:21</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2157.html" target="_blank" title="充值投之家的资金会出现资金站岗吗？">充值投之家的资金会出现资金站岗吗？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-12.html" title="投之家使用答疑" class="lei">投之家使用答疑</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>1/103</td>
                                    <td>2015/02/07 20:54</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2156.html" target="_blank" title="请问；登陆账号后进不到个人中心，提示获取账户详情异常。什么情况？">请问；登陆账号后进不到个人中心，提示获取账户详情异...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-12.html" title="投之家使用答疑" class="lei">投之家使用答疑</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>0/37</td>
                                    <td>2015/02/07 17:23</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2155.html" target="_blank" title="qq群在哪里。">qq群在哪里。</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-13.html" title="平台业务咨询" class="lei">平台业务咨询</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>1/23</td>
                                    <td>2015/02/07 10:32</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2154.html" target="_blank" title="二级市场老没有。">二级市场老没有。</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-12.html" title="投之家使用答疑" class="lei">投之家使用答疑</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>0/62</td>
                                    <td>2015/02/07 10:29</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2153.html" target="_blank" title="网络投资真的能赚钱吗？">网络投资真的能赚钱吗？</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>2/80</td>
                                    <td>2015/02/06 14:12</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2152.html" target="_blank" title="投资小额个人理财产品是不是比较安全？">投资小额个人理财产品是不是比较安全？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>1/38</td>
                                    <td>2015/02/06 14:09</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2151.html" target="_blank" title="P2P投资理财公司现在可靠吗？">P2P投资理财公司现在可靠吗？</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>3/60</td>
                                    <td>2015/02/06 14:01</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2150.html" target="_blank" title="投之家的二级市场是什么类型的投资理财项目？">投之家的二级市场是什么类型的投资理财项目？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>2/107</td>
                                    <td>2015/02/06 13:58</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2149.html" target="_blank" title="一直都是监管政策，说到现在还不出来，到底还出不出来了？">一直都是监管政策，说到现在还不出来，到底还出不出来...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>2/36</td>
                                    <td>2015/02/06 13:54</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2148.html" target="_blank" title="P2P网贷排名中陆金所是不是算龙头老大？">P2P网贷排名中陆金所是不是算龙头老大？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>2/56</td>
                                    <td>2015/02/06 13:49</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2147.html" target="_blank" title="都说P2P平台的安全性最重要，怎么选择安全的平台，规避风险？">都说P2P平台的安全性最重要，怎么选择安全的平台，规...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-15.html" title="p2p其他问题" class="lei">p2p其他问题</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>3/72</td>
                                    <td>2015/02/06 13:46</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2146.html" target="_blank" title="P2P网贷未来的发展应该是很好的把？听说监管政策要出了。">P2P网贷未来的发展应该是很好的把？听说监管政策要出...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>3/29</td>
                                    <td>2015/02/06 13:43</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2145.html" target="_blank" title="投之家最近新上线的二级市场是什么？">投之家最近新上线的二级市场是什么？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>2/71</td>
                                    <td>2015/02/06 13:37</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2144.html" target="_blank" title="应该从哪几方面看P2P网贷的安全性？">应该从哪几方面看P2P网贷的安全性？</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-15.html" title="p2p其他问题" class="lei">p2p其他问题</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>3/37</td>
                                    <td>2015/02/06 13:36</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2143.html" target="_blank" title="好想达到财务自由啊，求办法？">好想达到财务自由啊，求办法？</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>1/31</td>
                                    <td>2015/02/06 13:31</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2142.html" target="_blank" title="家里一家三口，如何投资理财，而且又不会影响到原来的生活质量？">家里一家三口，如何投资理财，而且又不会影响到原来的...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>2/40</td>
                                    <td>2015/02/06 13:29</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2141.html" target="_blank" title="网贷投资的收益稳不稳？以后是不是会越来越低的？">网贷投资的收益稳不稳？以后是不是会越来越低的？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>2/37</td>
                                    <td>2015/02/06 13:26</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2140.html" target="_blank" title="马云是不是用余额宝的钱是做货币基金的，风险大吗？">马云是不是用余额宝的钱是做货币基金的，风险大吗？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>1/35</td>
                                    <td>2015/02/06 13:24</td>
                                </tr>

                                <tr>
                                    <td class="title">
                                        <div class="tit-full">
                                            <div class="wrap">
                                                <span class="gold">
                                                </span>
                                                <a href="http://www.touzhijia.com/wenda/q-2139.html" target="_blank" title="从来没投资理财的建议，初次P2P理财需要注意什么？">从来没投资理财的建议，初次P2P理财需要注意什么？...</a>&nbsp;<span class="cate">[<a target="_blank" href="http://www.touzhijia.com/wenda/c-14.html" title="理财投资交流" class="lei">理财投资交流</a>]</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>3/38</td>
                                    <td>2015/02/06 13:22</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="pages"><strong>1</strong>
                        <a href="http://www.touzhijia.com/wenda/c-all/all/2.html">2</a>
                        <a href="http://www.touzhijia.com/wenda/c-all/all/3.html">3</a>
                        <a href="http://www.touzhijia.com/wenda/c-all/all/4.html">4</a>
                        <a href="http://www.touzhijia.com/wenda/c-all/all/5.html">5</a>
                        <a href="http://www.touzhijia.com/wenda/c-all/all/6.html">6</a>
                        <a href="http://www.touzhijia.com/wenda/c-all/all/7.html">7</a>
                        <a href="http://www.touzhijia.com/wenda/c-all/all/8.html">8</a>
                        <a class="n" href="http://www.touzhijia.com/wenda/c-all/all/2.html">下一页</a>
                        <a class="n" href="http://www.touzhijia.com/wenda/c-all/all/104.html">最后一页</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="aside-right">
            <!-- 热门标签开始 -->
            <div class="modbox">
                <h3 class="title">热门标签</h3>
                <div class="hot-tags">

                    <a target="_blank" title="费用" href="http://www.touzhijia.com/wenda/question/search/tag:%E8%B4%B9%E7%94%A8.html">费用</a>

                    <a target="_blank" title="理财" href="http://www.touzhijia.com/wenda/question/search/tag:%E7%90%86%E8%B4%A2.html">理财</a>

                    <a target="_blank" title="p2p平台" href="http://www.touzhijia.com/wenda/question/search/tag:p2p%E5%B9%B3%E5%8F%B0.html">p2p平台</a>

                    <a target="_blank" title="新人" href="http://www.touzhijia.com/wenda/question/search/tag:%E6%96%B0%E4%BA%BA.html">新人</a>

                    <a target="_blank" title="陆金所" href="http://www.touzhijia.com/wenda/question/search/tag:%E9%99%86%E9%87%91%E6%89%80.html">陆金所</a>

                    <a target="_blank" title="倒闭" href="http://www.touzhijia.com/wenda/question/search/tag:%E5%80%92%E9%97%AD.html">倒闭</a>

                    <a target="_blank" title="平台排名" href="http://www.touzhijia.com/wenda/question/search/tag:%E5%B9%B3%E5%8F%B0%E6%8E%92%E5%90%8D.html">平台排名</a>

                    <a target="_blank" title="平台数量" href="http://www.touzhijia.com/wenda/question/search/tag:%E5%B9%B3%E5%8F%B0%E6%95%B0%E9%87%8F.html">平台数量</a>

                    <a target="_blank" title="人人贷" href="http://www.touzhijia.com/wenda/question/search/tag:%E4%BA%BA%E4%BA%BA%E8%B4%B7.html">人人贷</a>

                    <a target="_blank" title="标的类型" href="http://www.touzhijia.com/wenda/question/search/tag:%E6%A0%87%E7%9A%84%E7%B1%BB%E5%9E%8B.html">标的类型</a>

                    <a target="_blank" title="风险" href="http://www.touzhijia.com/wenda/question/search/tag:%E9%A3%8E%E9%99%A9.html">风险</a>

                    <a target="_blank" title="网络借贷" href="http://www.touzhijia.com/wenda/question/search/tag:%E7%BD%91%E7%BB%9C%E5%80%9F%E8%B4%B7.html">网络借贷</a>

                    <a target="_blank" title="收益" href="http://www.touzhijia.com/wenda/question/search/tag:%E6%94%B6%E7%9B%8A.html">收益</a>

                </div>
            </div>
            <!-- 热门标签结束 -->

            <!-- 关注问题排行榜 -->
            <div class="modbox mt10">
                <div class="title">一周热点问题</div>
                <ul class="right-list">

                    <li>
                        <em class="n1">1</em>
                        <a title="是国资的平台是不是意味着，得到政府的支持和肯定了？" target="_blank" href="http://www.touzhijia.com/wenda/q-2084.html">是国资的平台是不是意味着，得到政府的支持</a>
                    </li>

                    <li>
                        <em class="n1">2</em>
                        <a title="二级市场一般什么时候发标" target="_blank" href="http://www.touzhijia.com/wenda/q-2087.html">二级市场一般什么时候发标</a>
                    </li>

                    <li>
                        <em class="n1">3</em>
                        <a title="投之家可以用信用卡充值么？" target="_blank" href="http://www.touzhijia.com/wenda/q-2035.html">投之家可以用信用卡充值么？</a>
                    </li>

                    <li>
                        <em class="n2">4</em>
                        <a title="国内的国资的平台多么，有多少家啊？哪一家国资平台比较好点？" target="_blank" href="http://www.touzhijia.com/wenda/q-2083.html">国内的国资的平台多么，有多少家啊？哪一家</a>
                    </li>

                    <li>
                        <em class="n2">5</em>
                        <a title="投之家有APP吗？习惯手机投，用电脑有时候不方便。" target="_blank" href="http://www.touzhijia.com/wenda/q-2086.html">投之家有APP吗？习惯手机投，用电脑有时候</a>
                    </li>

                    <li>
                        <em class="n2">6</em>
                        <a title="P2P平台排名有没有？" target="_blank" href="http://www.touzhijia.com/wenda/q-2044.html">P2P平台排名有没有？</a>
                    </li>

                    <li>
                        <em class="n2">7</em>
                        <a title="都说P2P平台的安全性最重要，怎么选择安全的平台，规避风险？" target="_blank" href="http://www.touzhijia.com/wenda/q-2147.html">都说P2P平台的安全性最重要，怎么选择安全</a>
                    </li>

                    <li>
                        <em class="n2">8</em>
                        <a title="P2P投资理财公司现在可靠吗？" target="_blank" href="http://www.touzhijia.com/wenda/q-2151.html">P2P投资理财公司现在可靠吗？</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<!-- 内容区 结束-->

<div class="clear"></div>


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

</body>
</html>