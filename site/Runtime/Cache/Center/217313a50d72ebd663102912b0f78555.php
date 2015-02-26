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
        <h2>账户提现</h2>	
        
        <div class="inputbox clear">
			<div class="tx_zynr">
				<div class="tx_xnr">
					<form id="cashForms" action="__GROUP__/Cash/submit" method="post">
					<div class="tx_xform">
						<div class="txx_y">
							<span class="y_xm">可用余额：</span>
							<span class="y_mz"><?php echo (($account_result['use_money'])?($account_result['use_money']):0); ?>元</span>
						</div>
				
						<div class="tx_xlk" style="width:640px;">
							<span class="txk_z" style="margin-right:5px;">提现银行：</span>
							<div class="txxl_nwz">
			                    <div id="divselect" class="se_1" style="width:160px;">
									<span tid="0" style="text-align:left;">选择银行</span>
									<input name="selectValue" type="hidden" value="0" />
									<input name="selectText" type="hidden" value="" />
			                        <ul style="width:180px;display:none;"> 
			                           	<?php echo ($tempData['ul_li']); ?>          
			                        </ul>
							    </div>
							</div>
							<div class="yhk_jwz"><a id="js_add_bank" href="javascript:void(0);">添加银行卡</a><a href="__GROUP__/Bankinfo">管理银行卡</a></div>
						</div>
						<div class="clear"></div>
						<div class="txx_e">
							<span>交易密码：</span>
							<div class="mm_k" style="width:360px;">
								<div class="khy_1"></div>
								<input id="paypwd" name="paypwd" type="password" class="khy_2" style="width:160px;" />
								<div class="khy_3"></div>
							</div>
						</div>
						<div class="txx_e">
							<span>提现金额：</span>
							<div class="khy_1"></div>
							<input id="money" name="money" type="text" class="khy_2" style="width:160px;" />
							<div class="khy_3"></div>
							<span style="text-align:left;text-indent:5px;width:200px;"></span>
						</div>
						<div class="txx_e">
							<span>验证码：</span>
							<div class="mm_k">
								<div class="khy_1"></div>
								<input id="valicode" name="valicode" type="text" class="khy_2" style="width:80px;" maxlength="4" />
								<div class="khy_3"></div>
								<div class="yzm_img">
									<img id="valicodeforimage" src="__GROUP__/Index/getValicode" onclick="this.src='__GROUP__/Index/getValicode/' + Math.round(Math.random()*10000)" alt="点击更新验证码" width="105" height="36" />
								</div>
							</div>
						</div>
						<input id="cashBtn" name="cashBtn" type="button" value="" class="tx_qdtj" />
					</div>
					</form>
				</div> 
				

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
	//下拉选择框
	$.DivSelect("#divselect", "se_2", "selectValue", "selectText");
	//新增银行卡
	$("#js_add_bank").click(function(){	
		var real_status = <?php echo (($user_result['real_status'])?($user_result['real_status']):0); ?>;
		if(real_status!=1){
			layer.alert("您还没有通过实名认证，不能添加银行卡号", 8);
			return;
		}
		$.layer({
		    type: 2,
		    maxmin: false,
		    shadeClose: false,
		    title: false,
		    shade: [0.5, 'rgb(255, 255, 255)'],
		    offset: [($(window).height() - 580)/2+'px', ''], //上下垂直居中
		    area: ['620px', '480px'],    
		    iframe: {src: '__GROUP__/Bankinfo/add', scrolling: 'no', frameborder: "no"}
		});		
	});
	//提交提现申请
	$("#cashBtn").click(function(){
		var bank = $("input[name='selectValue']").val();
		if(bank==0 || bank==""){
			layer.alert('请选择提现银行', 8);
			return;
		}
		if(checkPayPwd() && checkMoney() && checkCode()){
			$("#cashForms").submit();
		}
	});
});

function checkPayPwd(){
	var v = $("#paypwd").val(),
		len = str_length($.trim(v));
	if(len==0){
		layer.alert('请输入交易密码', 8);
		return false;
	}else if(len<6 || len>20){
		layer.alert('交易密码格式不正确', 8);
		return false;
	}else{
		return true;
	}
}
function checkMoney(){
	var v = $("#money").val(),
		use_money = <?php echo ($account_result['use_money']); ?>;
	if(v=="" || v==0){	
		layer.alert('请输入提现金额', 8);
		return false;
	}else if(money_patrn.test(v)){
		if(v<10){
			layer.alert('提现金额不在规定的提现范围之内~', 8);
			return false
		}else if(v>use_money){
			layer.alert('提现金额不能大于可用余额', 8);
			return false;
		}else{
			return true;
		}	
	}else{
		layer.alert('提现金额格式不正确', 8);
		return false;
	}
}
function checkCode(){
	var v = $("#valicode").val(),
		len = str_length($.trim(v));
	if(len==0){
		layer.alert('请输入验证码', 8);
		return false;
	}else if(len!=4){
		layer.alert('验证码长度必须为4位', 8);
		return false;
	}else{
		return true;
	}	
}
</script>
</body>
</html>