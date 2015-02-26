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

<!-- banner 开始-->
<div class="index_banner" id="banner_tabs" style="margin-top:-17px;">
    <ul>
        <?php if(is_array($advert_list)): $i = 0; $__LIST__ = $advert_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li style="background:url(/static/<?php echo ($v['pic']); ?>) no-repeat;background-size:cover;background-position:50% 50%;" title="<?php echo ($v['title']); ?>" flag="<?php echo ($v['url']); ?>"></li><?php endforeach; endif; else: echo "" ;endif; ?> 
    </ul>
    <cite>
        <?php if(is_array($advert_list)): $k = 0; $__LIST__ = $advert_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><span class="<?php if(($k == 1)): ?>cur<?php endif; ?>"><?php echo ($k); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
    </cite>
</div>
<!-- banner 结束 -->
<!-- 数据统计 开始 -->
<div class="c_box">
    <div class="c_box_1">
        <div class="c_box_2">
            <span>已撮合成交：</span><strong>￥<?php echo ($tempData['sum_amount']); ?> <b style="font-size:18px; font-weight:normal;">元</b></strong>
            <span>已产生收益：</span><strong>￥<?php echo ($tempData['sum_rate']); ?> <b style="font-size:18px; font-weight:normal;">元</b></strong>
            <span>共服务用户：</span><strong><?php echo ($tempData['sum_reg_num']); ?> <b style="font-size:18px; font-weight:normal;">人</b></strong>
        </div>
        <div class="c_box_3" id="c_box_3">
            <ul>
                <?php if(is_array($user_list)): $i = 0; $__LIST__ = $user_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$users): $mod = ($i % 2 );++$i;?><li>欢迎新注册用户:<strong><?php echo (substr($users["username"],0,3)); ?>**</strong></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div> 
    </div>
</div>
<script>

    var oMarquee0 = document.getElementById("c_box_3"); //滚动对象 
            var iLineHeight0 = 60; //单行高度，像素 
            var iLineCount0 = 20; //实际行数 
            var iScrollAmount0 = 2; //每次滚动高度，像素 

            function run0() {
            oMarquee0.scrollTop += iScrollAmount0;
                    if (oMarquee0.scrollTop == iLineCount0 * iLineHeight0){
            oMarquee0.scrollTop = 0; }
            if (oMarquee0.scrollTop % iLineHeight0 == 0) {
            window.setTimeout("run0()", 4500);
            } else {
            window.setTimeout("run0()", 60);
            }
            }
    oMarquee0.innerHTML += oMarquee0.innerHTML;
            window.setTimeout("run0()", 4500);</script>
<!-- 数据统计 结束 -->


<!-- 热门平台 开始 -->
<div class="r_box">
    <div class="r_bbox">
        <div class="r_box_1" style="height:auto;">
            <div class="r_box_2"><h2>热门平台</h2><span><a href="/Platform/index.html">更多</a></span></div>  
            <?php if(is_array($platform_list)): $i = 0; $__LIST__ = $platform_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="r_box_3">
                    <div class="r_b_img"><a href="/Platform/details/id/<?php echo ($v['id']); ?>.html"><img src="/static/<?php echo ($v['platform_logo']); ?>" /></a></div>
                    <a href="/Platform/details/id/<?php echo ($v['id']); ?>.html">
                        <div class="projectInfo">        
                            <div class="aprInfo">
                                <span class="apr">
                                    <em><?php echo ($v['min_rate']); ?></em>%-<em><?php echo ($v['max_rate']); ?></em>%
                                    <b style="color:#666; font-weight:normal;">预期年化利率</b>
                                </span>
                                <span class="apr">
                                    <em style="font-size:16px; color:#666; text-align:left; font-weight:normal;"><?php echo ($v['min_term']); ?>-<?php echo ($v['max_term']); ?></em>
                                    <b class="a_b">投资期限</b>
                                </span>
                            </div>
                        </div> 
                    </a>

                    <div class="aquan">安全评级：<?php echo ($v['grade_name']); ?></div>         
                    <div class="a_qkk"><?php if($v['max_rate'] == 0): ?><a href="<?php echo ($v['website']); ?>" target="_blank">去理财</a>
                            <?php else: ?>
                            <a href="/Platform/details/id/<?php echo ($v['id']); ?>.html">去理财</a><?php endif; ?></div>  
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>  
    </div>
</div>
<!-- 热门结束 开始 -->

<div class="q_box">

    <div class="q_box_1">
        <div class="q_box_box">    
            <div class="q_box_1_left"><h5>收益对比</h5></div>
            <div class="q_box_img" id="js_charts_box"></div>       
        </div>  

        <div class="q_box_1_right">
            <div class="q_box_1_left"><h5>计算器</h5></div>
            <div class="q_right">
                <ul>
                    <li><span class="q_span">投入金额：</span> 
                        <div class="q_input"><input id="js_amount" type="text" class="txt" placeholder="0" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" onkeyup="value = value.replace(/[^\d]/g, '')" />  元 </div>
                    </li>

                    <li><span class="q_span">投入时长：</span> 
                        <div class="q_input"><input id="js_term" style="width:50px;" type="text" class="txt" placeholder="0" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" onkeyup="value = value.replace(/[^\d]/g, '')" />
                            <span style="vertical-align: middle;">
                                <input type="radio" style="margin-top:4px;" checked="checked" value="1" name="time">月
                                <input type="radio" style="margin-top:4px;" value="2" name="time">日
                            </span> 
                        </div>
                    </li>

                    <li><span class="q_span">年化利率：</span> 
                        <div class="q_input"><input id="js_rate" type="text" class="txt" placeholder="0" onbeforepaste="value=/^\d*(\d|(\.\d*))$/.test(value)?value:''" onkeyup="value = /^\d*(\d|(\.\d*))$/.test(value)?value:''" /> ％</div>
                    </li>        

                    <li><span class="q_span">奖励比率：</span> 
                        <div class="q_input"><input id="js_reward" type="text" class="txt" placeholder="0" onbeforepaste="value=/^\d*(\d|(\.\d*))$/.test(value)?value:''" onkeyup="value = /^\d*(\d|(\.\d*))$/.test(value)?value:''" /> ％</div>
                    </li>         

                    <li>
                        <span class="q_span">还款方式：</span> 
                        <div class="q_input">
                            <select id="js_repay_type" class="sel" style="width:120px">
                                <option value="1">到期还本息</option>
                                <option value="2">按月还本息</option>
                                <option value="3">按季还本息</option>
                            </select>
                        </div>
                    </li>                   
                </ul>
                <div class="q_right_x">
                    <a id="js_calculator_ok" class="q_tj" href="javascript:void(0);">计算</a>
                    <a id="js_calculator_cancel" class="q_cz" href="javascript:void(0);">重置</a>
                </div>

                <div class="q_bixi">
                    <p>本息合计: <span id="js_result_sum">0</span> 元</p>
                    <p>利息收入：<span id="js_result_rate">0</span> 元</p>
                </div>
            </div>
        </div>  
    </div>
</div>

<div class="r_box">
    <img class="pingji" src="/static/images/home/pj1.jpg" />
    <!--<div class="r_box_1" style=" margin-bottom:30px; padding-bottom:20px; text-align:center; ">
                <img class="pingji" src="/static/images/home/pj.jpg" />
    </div>   --> 
</div>   

<div class="r_box">
    <div class="r_box_1">
        <div class="r_box_2"><h2>资讯中心</h2></div>

        <div class="new_left">
            <div class="new_left_title">
                <div id="bg" class="xixi1">
                    <div class="tab1 js_tabs" flag="0" onclick="location.href = '/News/index/id/7.html'">投资攻略</div>
                    <div class="tab2 js_tabs" flag="1" onclick="location.href = '/News/index/id/8.html'">行业动态</div>
                    <div class="tab2 js_tabs" flag="2" onclick="location.href = '/News/index/id/10.html'">专家点评</div>
                </div>
            </div>
            <div id="js_tab_1">    
                <div class="new_left_topList">	
                    <ul>
                        <?php if(is_array($articles_list_1)): $k = 0; $__LIST__ = $articles_list_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k; if(($k == 1)): ?><li class="new_le_box">
                                    <div class="new_left_firstImg">
                                        <a href="/News/details/id/<?php echo ($v['id']); ?>.html"><img width="110" height="90" src="/static/<?php echo ($v['thumbnail']); ?>" alt="<?php echo ($v['title']); ?>" /></a>
                                    </div>
                                    <div class="new_left_firstTitle">
                                        <h2><a href="/News/details/id/<?php echo ($v['id']); ?>.html" title="<?php echo ($v['title']); ?>"><?php echo (mb_substr($v['title'],0,17,'utf-8')); ?></a></h2>
                                        <span><?php echo (mb_substr($v['summary'],0,68,'utf-8')); ?><a style="color:#dc0a0a;" href="/News/details/id/<?php echo ($v['id']); ?>.html">[点击查看]</a></span>
                                    </div>
                                </li>
                                <?php else: ?>
                                <li class="news_p"><span><?php echo (date('Y-m-d', $v['addtime'])); ?></span><a href="/News/details/id/<?php echo ($v['id']); ?>.html" title="<?php echo ($v['title']); ?>"><?php echo (mb_substr($v['title'],0,23,'utf-8')); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>		  
                    <p><a href="/News/index/id/<?php echo ($articles_list_1[0]['modules_id']); ?>.html">更多>></a></p>
                </div>
            </div>
            <div id="js_tab_2" style="display:none;">
                <div class="new_left_topList">
                    <ul>
                        <?php if(is_array($articles_list_2)): $k = 0; $__LIST__ = $articles_list_2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k; if(($k == 1)): ?><li class="new_le_box">
                                    <div class="new_left_firstImg">
                                        <a href="/News/details/id/<?php echo ($v['id']); ?>.html"><img width="110" height="90" src="/static/<?php echo ($v['thumbnail']); ?>" alt="<?php echo ($v['title']); ?>" /></a>
                                    </div>
                                    <div class="new_left_firstTitle">
                                        <h2><a href="/News/details/id/<?php echo ($v['id']); ?>.html" title="<?php echo ($v['title']); ?>"><?php echo (mb_substr($v['title'],0,17,'utf-8')); ?></a></h2>
                                        <span><?php echo (mb_substr($v['summary'],0,68,'utf-8')); ?><a style="color:#dc0a0a;" href="/News/details/id/<?php echo ($v['id']); ?>.html">[点击查看]</a></span>
                                    </div>
                                </li>
                                <?php else: ?>
                                <li class="news_p"><span><?php echo (date('Y-m-d', $v['addtime'])); ?></span><a href="/News/details/id/<?php echo ($v['id']); ?>.html" title="<?php echo ($v['title']); ?>"><?php echo (mb_substr($v['title'],0,23,'utf-8')); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>	
                    <p><a href="/News/index/id/<?php echo ($articles_list_2[0]['modules_id']); ?>.html">更多>></a></p>
                </div>
            </div>
            <div id="js_tab_3" style="display:none;">
                <div class="new_left_topList">
                    <ul>
                        <?php if(is_array($articles_list_3)): $k = 0; $__LIST__ = $articles_list_3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k; if(($k == 1)): ?><li class="new_le_box">
                                    <div class="new_left_firstImg">
                                        <a href="/News/details/id/<?php echo ($v['id']); ?>.html"><img width="110" height="90" src="/static/<?php echo ($v['thumbnail']); ?>" alt="<?php echo ($v['title']); ?>" /></a>
                                    </div>
                                    <div class="new_left_firstTitle">
                                        <h2><a href="/News/details/id/<?php echo ($v['id']); ?>.html" title="<?php echo ($v['title']); ?>"><?php echo (mb_substr($v['title'],0,17,'utf-8')); ?></a></h2>
                                        <span><?php echo (mb_substr($v['summary'],0,68,'utf-8')); ?><a style="color:#dc0a0a;" href="/News/details/id/<?php echo ($v['id']); ?>.html">[点击查看]</a></span>
                                    </div>
                                </li>
                                <?php else: ?>
                                <li class="news_p"><span><?php echo (date('Y-m-d', $v['addtime'])); ?></span><a href="/News/details/id/<?php echo ($v['id']); ?>.html" title="<?php echo ($v['title']); ?>"><?php echo (mb_substr($v['title'],0,23,'utf-8')); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>	
                    <p><a href="/News/index/id/<?php echo ($articles_list_3[0]['modules_id']); ?>.html">更多>></a></p>
                </div>
            </div>
        </div>

        <div class="new_left">
            <div class="new_left_title">最新公告</div>
            <div class="new_left_topList">
                <ul>
                    <?php if(is_array($articles_list_4)): $i = 0; $__LIST__ = $articles_list_4;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="news_p"><span><?php echo (date('Y-m-d', $v['addtime'])); ?></span><a href="/News/details/id/<?php echo ($v['id']); ?>.html" title="<?php echo ($v['title']); ?>"><?php echo (mb_substr($v['title'],0,23,'utf-8')); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>	
                <p><a href="/News/index/id/<?php echo ($articles_list_4[0]['modules_id']); ?>.html">更多>></a></p>
            </div>
        </div>    
    </div>   

</div>

<div class="r_box">
    <div class="r_box_1" style="margin-bottom:20px;">
        <div class="r_box_2"><h2>合作伙伴</h2><span><!--<a href="">更多</a>--></span></div>
        <div class="r_box_huoban">
            <ul>
                <?php if(is_array($links_list)): $i = 0; $__LIST__ = $links_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($v['weblink']); ?>" target="_blank" rel="nofollow"><img src="/static/<?php echo ($v['logo']); ?>" alt="<?php echo ($v['webname']); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>    
     
</div>

<script>
            window.setInterval(aclose, 10000);
            function aclose() {
            $("#fla").fadeOut();
            }
</script>
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

<script type="text/javascript" src="__ROOT__/static/js/home/jcarousellite_index.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/plugins/highcharts.js"></script>
<script type="text/javascript">

            (function(){
            if (!Function.prototype.bind){
            Function.prototype.bind = function(obj){
            var owner = this, args = Array.prototype.slice.call(arguments), callobj = Array.prototype.shift.call(args);
                    return function(e){e = e || top.window.event || window.event; owner.apply(callobj, args.concat([e])); };
            };
            }
            $("#banner_tabs").find('ul li').bind('click', function(){
            var _this = $(this);
                    location.href = _this.attr('flag');
            });
                    // 计算器
                    $('#js_calculator_ok').click(function(){
            $('#js_result_sum').text('0');
                    $('#js_result_rate').text('0');
                    var amount = parseInt($('#js_amount').val()),
                    term = parseInt($('#js_term').val()),
                    rate = $('#js_rate').val(),
                    reward = $('#js_reward').val(),
                    repay_type = $('#js_repay_type').find('option:selected').val();
                    if ($('#js_amount').val() == '' || amount == 0){
            layer.alert('请输入投资金额', 8);
                    return false;
            }
            if ($('#js_term').val() == '' || term == 0){
            layer.alert('请输入投入期限', 8);
                    return false;
            }
            if ($('#js_rate').val() == ''){
            layer.alert('请输入年化利率', 8);
                    return false;
            }
            if (parseInt(reward) >= 100){
            layer.alert('奖励比率不能超过100', 8);
                    $('#js_reward').val('');
                    return false;
            }
            if ($('#js_repay_type').val() == ''){
            layer.alert('请选择还款方式', 8);
                    return false;
            }

            var result = 0, time = $("input:radio[name='time']:checked").val();
                    if (time == '1'){
            switch (repay_type){
            case '1':
                    result = calculator(amount, term, rate, reward, 1);
                    break;
                    case '2':
                    result = calculator(amount, term, rate, reward, 2);
                    break;
                    case '3':
                    result = calculator(amount, term, rate, reward, 3);
                    break;
            }
            } else{
            result = calculator(amount, term, rate, reward, 4);
            }
            $('#js_result_sum').text(result.toFixed(2));
                    $('#js_result_rate').text((result - amount).toFixed(2));
            });
                    // 重置
                    $('#js_calculator_cancel').click(function(){
            $('#js_amount').val('');
                    $('#js_term').val('');
                    $('#js_rate').val('');
                    $('#js_reward').val('');
                    $('#js_repay_type').val('0');
                    $('#js_result_sum').text('0');
                    $('#js_result_rate').text('0');
            });
                    // 刷新页面重新定义初始值
                    $('#js_amount').val($('#js_amount').attr('placeholder'));
                    $('#js_term').val($('#js_term').attr('placeholder'));
                    $('#js_rate').val($('#js_rate').attr('placeholder'));
                    $('#js_reward').val($('#js_reward').attr('placeholder'));
                    $('#js_calculator_cacel').click();
                    $('#js_amount').val('');
                    $('#js_term').val('');
                    $('#js_rate').val('');
                    $('#js_reward').val('');
                    //选项卡切换
                    $(".js_tabs").bind("mouseover", function(){
            var _this = $(this);
                    if (_this.attr('flag') == 0){
            $("#js_tab_1").show();
                    $("#js_tab_2").hide();
                    $("#js_tab_3").hide();
                    $(".js_tabs").eq(0).removeClass('tab2').addClass('tab1');
                    $(".js_tabs").eq(1).removeClass('tab1').addClass('tab2');
                    $(".js_tabs").eq(2).removeClass('tab1').addClass('tab2');
            } else if (_this.attr('flag') == 1){
            $("#js_tab_1").hide();
                    $("#js_tab_2").show();
                    $("#js_tab_3").hide();
                    $(".js_tabs").eq(0).removeClass('tab1').addClass('tab2');
                    $(".js_tabs").eq(1).removeClass('tab2').addClass('tab1');
                    $(".js_tabs").eq(2).removeClass('tab1').addClass('tab2');
            } else{
            $("#js_tab_1").hide();
                    $("#js_tab_2").hide();
                    $("#js_tab_3").show();
                    $(".js_tabs").eq(0).removeClass('tab1').addClass('tab2');
                    $(".js_tabs").eq(1).removeClass('tab1').addClass('tab2');
                    $(".js_tabs").eq(2).removeClass('tab2').addClass('tab1');
            }
            });
                    var colors = Highcharts.getOptions().colors,
                    categories = <?php echo ($categories); ?>,
                    data = <?php echo ($data); ?>;
                    $('#js_charts_box').highcharts({
            chart: {
            type: 'column',
                    height: 330
            },
                    title: {
                    text: ''
                    },
                    subtitle: {
                    text: ''
                    },
                    xAxis: {
                    categories: categories
                    },
                    yAxis: {
                    title: {
                    text: '单位(%)'
                    },
                            plotLines:[{
                            label:{
                            text:'投资人平均收益<?php echo ($avg); ?>%',
                                    align:'right',
                                    x: - 15,
                                    y: - 5
                            },
                                    color:'#5dc9e5',
                                    dashStyle:'dash',
                                    value:<?php echo ($avg); ?>,
                                    width:2
                            }]
                    },
                    plotOptions: {
                    column: {
                    cursor: 'pointer',
                            dataLabels: {
                            enabled: true,
                                    color: colors[0],
                                    style: {
                                    fontWeight: 'bold'
                                    },
                                    formatter: function() {
                                    return this.y + '%';
                                    }
                            }
                    }
                    },
                    tooltip: {
                    formatter: function() {
                    s = this.x + ':<b>' + this.y + '% </b>';
                            return s;
                    }
                    },
                    series: [{
                    name: '收益对比',
                            data: data,
                            color: 'white'
                    }],
                    credits: {
                    enabled: false
                    },
                    legend: {
                    enabled: false
                    }
            });
            })();
            var banner_tabs = function(id){
            this.ctn = document.getElementById(id);
                    this.adLis = null;
                    this.btns = null;
                    this.animStep = 0.2; //动画速度0.1～0.9
                    this.switchSpeed = 6; //自动播放间隔(s)
                    this.defOpacity = 1;
                    this.tmpOpacity = 1;
                    this.crtIndex = 0;
                    this.crtLi = null;
                    this.adLength = 0;
                    this.timerAnim = null;
                    this.timerSwitch = null;
                    this.init();
            };
            banner_tabs.prototype = {
            fnAnim:function(toIndex){
            if (this.timerAnim){window.clearTimeout(this.timerAnim); }
            if (this.tmpOpacity <= 0){
            this.crtLi.style.opacity = this.tmpOpacity = this.defOpacity;
                    this.crtLi.style.filter = 'Alpha(Opacity=' + this.defOpacity * 100 + ')';
                    this.crtLi.style.zIndex = 0;
                    this.crtIndex = toIndex;
                    return;
            }
            this.crtLi.style.opacity = this.tmpOpacity = this.tmpOpacity - this.animStep;
                    this.crtLi.style.filter = 'Alpha(Opacity=' + this.tmpOpacity * 100 + ')';
                    this.timerAnim = window.setTimeout(this.fnAnim.bind(this, toIndex), 50);
            },
                    fnNextIndex:function(){
                    return (this.crtIndex >= this.adLength - 1)?0:this.crtIndex + 1;
                    },
                    fnSwitch:function(toIndex){
                    if (this.crtIndex == toIndex){return; }
                    this.crtLi = this.adLis[this.crtIndex];
                            for (var i = 0; i < this.adLength; i++){
                    this.adLis[i].style.zIndex = 0;
                    }
                    this.crtLi.style.zIndex = 2;
                            this.adLis[toIndex].style.zIndex = 1;
                            for (var i = 0; i < this.adLength; i++){
                    this.btns[i].className = '';
                    }
                    this.btns[toIndex].className = 'cur'
                            this.fnAnim(toIndex);
                    },
                    fnAutoPlay:function(){
                    this.fnSwitch(this.fnNextIndex());
                    },
                    fnPlay:function(){
                    this.timerSwitch = window.setInterval(this.fnAutoPlay.bind(this), this.switchSpeed * 1000);
                    },
                    fnStopPlay:function(){
                    window.clearTimeout(this.timerSwitch);
                    },
                    init:function(){
                    this.adLis = this.ctn.getElementsByTagName('li');
                            this.btns = this.ctn.getElementsByTagName('cite')[0].getElementsByTagName('span');
                            this.adLength = this.adLis.length;
                            for (var i = 0, l = this.btns.length; i < l; i++){
                    with ({i:i}){
                    this.btns[i].index = i;
                            this.btns[i].onclick = this.fnSwitch.bind(this, i);
                            this.btns[i].onclick = this.fnSwitch.bind(this, i);
                    }
                    }
                    this.adLis[this.crtIndex].style.zIndex = 2;
                            this.fnPlay();
                            this.ctn.onmouseover = this.fnStopPlay.bind(this);
                            this.ctn.onmouseout = this.fnPlay.bind(this);
                    }
            };
            var player1 = new banner_tabs('banner_tabs');
            function calculator(amount, term, rate, reward, type){
            var result = 0;
                    switch (type){
            case 1:// 到期还本息（按月计算）
                    result = amount * (1 + (rate / 100) * (term / 12)) + amount * (reward / 100);
                    break;
                    case 2:// 按月份还本息
                    rate = rate / (100 * 12);
                    result = (amount * rate * Math.pow((1 + rate), term)) / (Math.pow((1 + rate), term) - 1) * term + amount * (reward / 100);
                    break;
                    case 3:// 按季度还本息
                    var size = term / 3;
                    // 月利率
                    rate = rate / (100 * 12);
                    for (var i = 0; i < size; i++){
            // 前两个月还款利息
            var rateA = amount * (1 - ((3 * i) / term)) * rate * 2;
                    // 最后一个月还款金
                    var capital = amount * (1 - ((3 * i) / term)) * rate + (3 / term) * amount;
                    result += rateA + capital;
            }
            result += amount * (reward / 100);
                    break;
                    case 4:// 到期还本息（按天计算）
                    result = amount * (1 + (rate / 100) * (term / 365)) + amount * (reward / 100);
                    break;
            }
            return result;
            }
</script>

</body>
</html>