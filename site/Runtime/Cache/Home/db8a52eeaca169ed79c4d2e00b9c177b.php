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

<!-- 投资项目 开始-->
<div class="sxxm">
	<div class="sx_zd">
		<h2>平台筛选</h2>
	  	<ul id="js_search" class="sx_ul">
        	<li>
            	<span>安全评级：</span>
               	<a><span class="bx" grade="0">不限</span></a>
				<?php if(is_array($grade_list)): $i = 0; $__LIST__ = $grade_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a><span grade="<?php echo ($v['id']); ?>"><?php echo ($v['name']); ?></span></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </li>
            <li>
                <span>年化收益：</span>
    			<a><span class="bx" rate="0">不限</span></a>
				<a><span rate="1">20%~16%</span></a>
				<a><span rate="2">16%~12%</span></a>
				<a><span rate="3">12%~8%</span></a>
				<a><span rate="4"> 8%以下</span></a>
            </li> 
            <li>
				<span>投资期限：</span>
	    		<a><span class="bx" term="0">不限</span></a>
				<a><span term="1">30天以下</span></a>
			    <a><span term="2">1~3个月</span></a>
				<a><span term="3">3~6个月</span></a>
				<a><span term="4">6~12个月</span></a>
	            <a><span term="5">12个月以上</span></a>
            </li>
		</ul>
	</div>           
</div>

<div class="clear"></div>
<div class="toubiao">
	<div class="t_1">
	   	<ul id="js_sort">
            <li><a class="ms" href="javascript:void(0);" sorttype="0" sortorder="desc">默认排序</a></li>
            <li><a href="javascript:void(0);" sorttype="1" sortorder="desc">收益率<i></i></a></li>
            <li><a href="javascript:void(0);" sorttype="2" sortorder="desc">借款期限<i></i></a></li>
            <li><a href="javascript:void(0);" sorttype="3" sortorder="desc">可投标数<i></i></a></li>
        </ul>
  </div>
    
<div class="tou_lie" style="height: auto; padding-bottom:20px;">
    
	<table width="960" class="tab_sty1">
		<thead>
			<tr>
                <th width="172" align="center" valign="middle">平台名称</th>
                <th width="147" align="center" valign="middle">安全评级</th>
                <th width="154" align="center" valign="middle">利率范围</th>
                <th width="131" align="center" valign="middle">期限范围</th>
                <th width="163" align="center" valign="middle">可投标数</th>
                <th width="165" align="center" valign="middle">详情</th>
			</tr>
		</thead>
        <tbody>
        <?php if(($count != 0)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
				<td align="center" valign="middle"><a href="/Platform/details/id/<?php echo ($v['id']); ?>.html"><?php echo ($v['platform_name']); ?></a></td>
                <td align="center" valign="middle" style="width:100px;">
					<div class="td5-p">
						<span class="js_grade grade gradeBBB"><?php echo ($v['grade_name']); ?></span>
						<ul class="th-icon-ul" style="left:102px;">
							<li><span class="sx">资本充足：</span><span class="sz"><?php echo ($v['config']['capital']); ?></span></li>
							<li><span class="sx">分散度：</span><span class="sz"><?php echo ($v['config']['dispersion']); ?></span></li>
							<li><span class="sx">透明度：</span><span class="sz"><?php echo ($v['config']['transparency']); ?></span></li>
							<li><span class="sx">流动性：</span><span class="sz"><?php echo ($v['config']['mobility']); ?></span></li>
							<li><span class="sx">运营能力：</span><span class="sz"><?php echo ($v['config']['operate']); ?></span></li>
							<li><span class="sx">违约成本：</span><span class="sz"><?php echo ($v['config']['cost']); ?></span></li>
						</ul>
					</div>
				</td>
                <td align="center" valign="middle"><?php echo ($v['min_rate']); ?>% ~ <?php echo ($v['max_rate']); ?>%</td>
                <td align="center" valign="middle"><?php echo ($v['min_term']); ?>~<?php echo ($v['max_term']); ?></td>
                <td align="center" valign="middle">
	                <?php if(($v[sum_num] == 0)): ?>待发布
	                <?php else: ?>
	                	<?php echo ($v['sum_num']); ?>个<?php endif; ?>
                </td>
                <td align="center" valign="middle">
                    
                    <?php if($v['max_rate'] == 0): ?><a class="btn btn_blue" href="<?php echo ($v['website']); ?>" target="_blank"><span>查 看</span></a>
                            <?php else: ?>
                              <a class="btn btn_blue" href="/Platform/details/id/<?php echo ($v['id']); ?>.html" ><span>查 看</span></a><?php endif; ?>
                    
                    
                    <!--<a class="btn btn_blue" href="/Platform/details/id/<?php echo ($v['id']); ?>.html" ><span>查 看</span></a></td>-->
			</tr><?php endforeach; endif; else: echo "" ;endif; ?> 
		<?php else: ?>
			<tr><td colspan="6" class="tdnone">对不起，暂未检索到任何数据。</td></tr><?php endif; ?>        			
		</tbody>
	</table>
    <!-- 分页 开始-->
    <div class="pagelist">
           <?php echo ($page); ?>          
    </div>	
	<div class="clear"></div>
</div>

</div>
<!-- 选标项目 结束-->

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
	$(".js_grade").live('mouseover', function(){
		$(this).parent().find(".th-icon-ul").show();
	});
	$(".js_grade").live('mouseout', function(){
		$(this).parent().find(".th-icon-ul").hide();
	});
	//搜索筛选
	$("#js_search a").live('click', function(){
		var _this = $(this);
		_this.parents("li").find("a span").removeClass("bx");
		_this.find("span").addClass("bx");
		request();
	});
	//排序筛选
	$("#js_sort a").live('click', function(){
		var _this = $(this);
		_this.addClass("ms").parent().siblings().children("a").removeClass("ms");
		_this.parents("ul").find("i").removeClass("i-active-2");
		if(_this.find('i').attr('class')=='i-active'){
			_this.attr({'sortorder':'asc'}).find('i').attr({'class':'i-active-2'});
		}else{
			_this.attr({'sortorder':'desc'}).find('i').attr({'class':'i-active'});
		}
		request();
	});
	//分页筛选
	$(".pagelist a:not('.disabled, .a')").live('click', function(){
		var page = parseInt($(this).attr('page'));
		request(page);
	});
	function request(page){
		var obj = {}, arr = [], page=page==undefined?1:page;
		obj.page = page;
		obj.grade = $("#js_search li").eq(0).find("a span.bx").attr("grade");
		obj.rate = $("#js_search li").eq(1).find("a span.bx").attr("rate");
		obj.term = $("#js_search li").eq(2).find("a span.bx").attr("term");
		obj.sorttype = $("#js_sort li").children(".ms").attr("sorttype");
		obj.sortorder = $("#js_sort li").children(".ms").attr("sortorder");
		$.ajax({
			url: '/Platform/listing',
			type: 'get',
			data: obj,
			dataType: 'json',
			success: function(p){
				//列表数据填充
				var str = '';
				if(p.rows!=null && p.rows.length>0){
					for(var i=0; i<p.rows.length; i++){
						str += '<tr><td align="center" valign="middle"><a href="/Platform/details/id/'+p.rows[i].id+'.html">'+p.rows[i].platform_name+'</a></td>';
						str += '<td align="center" valign="middle" style="width:100px;"><div class="td5-p">';
						str += '<span class="js_grade grade gradeBBB">'+p.rows[i].grade_name+'</span>';
						str += '<ul class="th-icon-ul" style="left:102px;">';
						str += '<li><span class="sx">资本充足：</span><span class="sz">'+p.rows[i].config.capital+'</span></li>';
						str += '<li><span class="sx">分散度：</span><span class="sz">'+p.rows[i].config.dispersion+'</span></li>';
						str += '<li><span class="sx">透明度：</span><span class="sz">'+p.rows[i].config.transparency+'</span></li>';
						str += '<li><span class="sx">流动性：</span><span class="sz">'+p.rows[i].config.mobility+'</span></li>';
						str += '<li><span class="sx">运营能力：</span><span class="sz">'+p.rows[i].config.operate+'</span></li>';
						str += '<li><span class="sx">违约成本：</span><span class="sz">'+p.rows[i].config.cost+'</span></li>';
						str += '</ul></div></td>';
						str += '<td align="center" valign="middle">'+p.rows[i].min_rate+'% ~ '+p.rows[i].max_rate+'%</td>';
			      		str += '<td align="center" valign="middle">'+p.rows[i].min_term+'~'+p.rows[i].max_term+'</td>';
			      		str += '<td align="center" valign="middle">';
			      		if(p.rows[i].sum_num==0){
			      			str += '待发布';
			      		}else{
			      			str += p.rows[i].sum_num+'个';
						}
			      		str += '</td>';
					    str += '<td align="center" valign="middle"><a class="btn btn_blue" href="/Platform/details/id/'+p.rows[i].id+'.html" ><span>查 看</span></a></td>';
					}
				}else{
					str += '<tr><td colspan="6" class="tdnone">对不起，暂未检索到任何数据。</td></tr>';
				}
				$(".tab_sty1").find('tbody').empty().html(str);
				
				//分页数据填充
				var total = p.total,
					rollPage = 4,
					pageNum = 10,
					sumPage = parseInt(Math.ceil(total/pageNum));
				$(".pagelist").empty();
				if (sumPage>1){
					if(page<1){
						page = 1;
					}else{
						page = page;
					}
					if((page+1) > sumPage){
						page = sumPage;
					}
					var pageThemes ='<span class="l">';
					if(page<=1){
						pageThemes += '<a class="pn-prev disabled" page="1"><i><</i><em>上一页</em></a>';
					}else{
						pageThemes += '<a class="pn-prev" page="'+(page-1)+'"><i><</i><em>上一页</em></a>';
					}
					if(sumPage>rollPage){
						if(page < (rollPage/2+1)){
							for (var i=1; i <= rollPage; i++) {
								if(i==page){
									pageThemes += '<a class="a n">'+i+'</a>';
								}else{
									pageThemes += '<a href="javascript:void(0);" page='+i+'>'+i+'</a>';
								}
							}
							pageThemes += '<b class="n_1"> … </b><a class="n" href="javascript:void(0);" page="'+sumPage+'">'+sumPage+'</a>';
						}else if((sumPage-page)<=(rollPage/2)){
							pageThemes += '<a class="n" href="javascript:void(0);" page="1">1</a><b class="n_1"> … </b>';
							for(var i=sumPage-(rollPage-1); i<=sumPage; i++){
								if(i==page){
									pageThemes += '<a class="a n">'+i+'</a>';
								}else{
									pageThemes += '<a class="n" href="javascript:void(0);" page="'+i+'">'+i+'</a>';	
								}
							}
						}else{
							pageThemes += '<a class="n" href="javascript:void(0);" page="1">1</a><b class="n_1"> … </b>';
							for(var i=page-(rollPage/2-1); i<page+rollPage/2; i++){
								if(page==i){
									pageThemes += '<a class="a n">'+i+'</a>';
								}else{
									pageThemes += '<a class="n" href="javascript:void(0);" page="'+i+'">'+i+'</a>';
								}	
							}
							pageThemes += '<b class="n_1"> … </b><a class="n" href="javascript:void(0);" page="'+sumPage+'">'+sumPage+'</a>';
						}
					}else{
						for(var i=1; i<=sumPage; i++){
							if(i==page){
								pageThemes += '<a class="a n">'+i+'</a>';
							}else{
								pageThemes += '<a href="javascript:void(0);" page="'+i+'">'+i+'</a>';
							}
						}
					}
					if(page>=sumPage){
						pageThemes += '<a class="pn-next disabled" page="'+sumPage+'">下一页<i>></i></a>';
					}else{
						pageThemes += '<a class="pn-next" page="'+(page+1)+'">下一页<i>></i></a>';
					}
					pageThemes += '</span>';	
					$(".pagelist").html(pageThemes);
				}
			}
		});
			
	}
});
</script>
</body>
</html>