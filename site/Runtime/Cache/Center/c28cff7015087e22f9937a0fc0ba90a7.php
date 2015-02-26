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
    	<h2>投资记录</h2>
	    <div class="tj_a1">
	        <span>您累计投资了<strong style="color:#0baf07"><?php echo (($tempData['sum_amount'])?($tempData['sum_amount']):0); ?></strong> 元</span>	        
	        <span>网投所帮您赚了 <strong style="color:#f00"><?php echo (($tempData['sum_rate'])?($tempData['sum_rate']):0); ?></strong> 元</span>	        
	        <span>您当前的投资年化收益率为: <strong style="color:#ff00d8"><?php echo (($tempData['rate_now'])?($tempData['rate_now']):0); ?></strong> %</span>
	        <span>您的收益是宝宝的 <strong style="color:#d58c00;"><?php echo (($tempData['compare'])?($tempData['compare']):0); ?></strong> 倍!</span>
		</div>
        <div class="czjl_nr">
            <form action="__GROUP__/Myinvest/index.html" method="post" class="mx_form">
                <div class="mx_y">
                    <span>投资时间:</span>
                    <input type="text" name="start" class="mx_dc" onclick="WdatePicker({skin:'default'});" value="<?php echo (($tempData['start'])?($tempData['start']):''); ?>" />
                    &nbsp;到&nbsp;
                    <input type="text" name="end" class="mx_dc" onclick="WdatePicker({skin:'default'});" value="<?php echo (($tempData[end])?($tempData[end]):''); ?>" />
                </div>
                <div class="mx_e" style="margin-left:10px;">
                    <div id="divselect" class="se_1" style="width:130px; float:left; ">
                      	<span tid="<?php echo (($tempData['selectValue'])?($tempData['selectValue']):'0'); ?>"><?php echo (($tempData['selectText'])?($tempData['selectText']):'所有记录'); ?></span>
						<input name="selectValue" type="hidden" value="<?php echo (($tempData['selectValue'])?($tempData['selectValue']):'0'); ?>" />
						<input name="selectText" type="hidden" value="<?php echo (($tempData['selectText'])?($tempData['selectText']):'所有记录'); ?>" />
                        <ul style="width:150px; height:110px; top:25px; display:none;"> 
                       		<?php if(($tempData[selectValue] != "")): ?><li tid='-1'>所有记录</li><?php endif; ?>
                        	<li tid='0'>还款中</li>
                        	<li tid='1'>已还完</li>
                        	<li tid='2'>已逾期</li>
                       	</ul>
                    </div>
                </div>
                <input style=" position:absolute; margin-left:80px; margin-top:2px;" type="submit" name="search" value="" class="mx_btn" />
            </form>
        </div>
		<div class="clear"></div>    
		<div class="scxx_bg">
			<table border="0" align="left">
				<tr class="tr_01"> 	 	 
					<td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">订单号</td>  
                    <td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">平台名称</td>
                    <td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">项目名称</td>
                    <td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">投资金额</td>
                    <td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">投资期限</td>
                    <td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">投资时间</td>
                    <td class="t_3" height="40" align="center" valign="middle" bgcolor="#ececec">交易状态</td>
				</tr>
				<?php if(($count > 0)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="tr_01"> 	 	 
					<td class="t_2" align="center" valign="middle"><?php echo ($v['order_id']); ?></td>
                    <td class="t_2" align="center" valign="middle"><?php echo ($v['platform_name']); ?></td>
                    <td class="t_2" align="center" valign="middle"><?php echo ($v['project_name']); ?></td>
                    <td class="t_2" align="center" valign="middle"><?php echo ($v['amount']); ?></td>
                    <td class="t_2" align="center" valign="middle">
                    <?php if(($v[isday] == 1)): echo ($v['term']); ?>天
                    <?php else: ?>
                    <?php echo ($v['term']); ?>个月<?php endif; ?>
                    </td>
                    <td class="t_2" align="center" valign="middle"><?php echo (date('Y-m-d', $v['addtime'])); ?></td>
                    <td class="t_2" align="center" valign="middle">
					<?php if(($v[state] == 0)): ?>还款中
					<?php elseif(($v[state] == 1)): ?>
						已还完
					<?php elseif(($v[state] == 1)): ?>
						已逾期<?php endif; ?>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php else: ?>
				<tr class="tr_01"><td class="t_2" colspan="7">暂无数据</td></tr><?php endif; ?>	 	 	 	 	 	 	
			</table>
		</div>
		<div class="pagelist">
			<?php echo ($page); ?>
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

<script type="text/javascript" src="__ROOT__/static/js/admin/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
$(function(){
	$.DivSelect("#divselect", "se_2", "selectValue", "selectText");
});
</script>
</body>
</html>