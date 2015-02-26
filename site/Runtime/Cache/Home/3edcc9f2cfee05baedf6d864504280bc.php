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
<div class="main_box">
<div class="mm_box">
    <div class="mai_box_left">
        <div class="m_box_img">
            <img title="<?php echo ($data['name']); ?>" alt="<?php echo ($data['name']); ?>" class="logo_img" src="/static/<?php echo ($data['logo_big']); ?>">
        </div>
        <div class="m_box_x">
                <div class="m_box_1">
                	<label class="til">基本信息</label>
                </div>               
                <div>
                    <label class="info_til">平台名称：</label>
                    <label class="info_con_1"><?php echo ($data['name']); ?></label>
                </div>                              
                <div>
                    <label class="info_til">安全评级：</label>
                    <label class="info_con_1"><?php echo ($data['grade_name']); ?></label>
                </div>                
                <div>
                    <label class="info_til">网站地址：</label>
                    <label class="info_con_1"><?php echo ($data['website']); ?></label>
                </div>                
                <div>
                    <label class="info_til">注册资金：</label>
                    <label class="info_con_1"><?php echo ($data['injection']); ?></label>
                </div>                
                <div>
                    <label class="info_til">所在地区：</label>
                    <label class="info_con_1"><?php echo ($data['location']); ?></label>
                </div>                
                <div>
                    <label class="info_til">上线时间：</label>
                    <label class="info_con_1"><?php echo ($data['online_time']); ?></label>
                </div>               
                <div>
                    <label class="info_til">ICP备案：</label>
                    <label class="info_con_1"><?php echo ($data['icp']); ?></label>
                </div>                                        
                <div>
                    <label class="info_til">联系电话：</label>
                    <label class="info_con_1"><?php echo ($data['telephone']); ?></label>
                </div>               
                <div>
                    <label class="info_til">服务邮箱：</label>
                    <label class="info_con_1"><?php echo ($data['email']); ?></label>
                </div>
         	</div>                          
            <div class="m_box_x">
                <div class="m_box_1">
                	<label class="til"> 管理费用 </label>
                </div>               
                <div>
                    <label class="info_til">管理费：</label>
                    <label class="info_con_1"><?php echo ($data['management_fee']); ?></label>
                </div>                
                <div>
                    <label class="info_til">VIP费：</label>
                    <label class="info_con_1"><?php echo ($data['vip_fee']); ?></label>
                </div>                
                <div>
                    <label class="info_til">充值费</label>
                    <label class="info_con_1"><?php echo ($data['recharge_fee']); ?></label>
                </div>                
                <div>
                    <label class="info_til">提现费：</label>
                    <label class="info_con_1"><?php echo ($data['cash_fee']); ?></label>
                </div>            
         	</div>  
     	</div> 
        <div class="ppr_box">   
            <div class="m_box_1"><label class="til"> 公司介绍 </label></div>
            <p style=" text-indent:0em"><?php echo ($data['introduction']); ?></p>
        </div>    
	</div>    
</div>      

<div class="clear"></div>  

<div class="box_suju">
	<div class="box_suju_1">	
		<div class="box_suju_01">	    
		    <h2>平台标的类型分布</h2>
		    <div id="js_type_charts" class="box_s_02"></div>
	    </div>  
	    
		<div class="box_suju_01">
		    <h2>平台标的期限分布</h2>
		    <div id="js_term_charts" class="box_s_02"></div>
	    </div>
	    <div class="box_suju_01" style="border:none;">	    
		    <h2>平台标的金额分布</h2>
		    <div id="js_amount_charts" class="box_s_02"></div>
	    </div>	    
	</div>    
</div>


<div class="clear"></div>  

<div class="box_suju">
	<div class="box_suju_1">
	
		<div class="box_suju_02"> 
		    <h2>近两月交易量走势图</h2>
		    <div id="js_trading_charts" class="box_s_02"></div>	    
	    </div>  
		<div class="box_suju_03">	    
		    <h2>利率对比图</h2>
		    <div id="js_rate_charts" class="box_s_03"></div>	    
	    </div>   
	</div>    
</div>

<div class="clear"></div>  
   
<div class="toubiao">
	<div class="t_1">
	   	<ul id="js_sort">
            <li><a class="ms" href="javascript:void(0);" sorttype="0" sortorder="desc">默认排序</a></li>
            <li><a href="javascript:void(0);" sorttype="1" sortorder="desc">收益率<i></i></a></li>
            <li><a href="javascript:void(0);" sorttype="2" sortorder="desc">借款期限<i></i></a></li>
            <li><a href="javascript:void(0);" sorttype="3" sortorder="desc">投标进度<i></i></a></li>
            <li class="m_r">共搜索到<strong style="color:#f00;"><?php echo ($count); ?></strong>个标</li>
        </ul>
  	</div>
    
	<div class="tou_lie" style="height:auto; padding-bottom:20px;">
		<table width="960" class="tab_sty1">
			<thead>
				<tr>
	                <th width="215" align="center" valign="middle">借款标题</th>
	                <th width="113" align="center" valign="middle">借款金额(元)</th>
	                <th width="150" align="center" valign="middle">综合收益率</th>
	                <th width="102" align="center" valign="middle">投资期限</th>
	                <th width="102" align="center" valign="middle">投标进度</th>
	              	<th width="105" align="center" valign="middle">还款方式</th>
	                <th width="141" align="center" valign="middle">详情</th>
				</tr>
			</thead>
         	<tbody>
         	<?php if(($count != 0)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
					<td align="center" valign="middle">
						<span style="height:20px;margin-left:5px;line-height:20px; width:213px;text-align:left;overflow:hidden;float:left;text-indent:30px;"><?php echo ($v['designer']); ?></span>
					</td>
	                <td align="center" valign="middle">
						<div class="td5-p">
							<span class="jiekuan"><?php echo ($v['amount']); ?></span>
						</div>				
					</td>
	                <td align="center" valign="middle"><?php echo ($v['interest_rate']); ?>%</td>
	                <td align="center" valign="middle"><font color="#f00"><?php echo ($v['term']); ?></font>
                	<?php if(($v[isday] == 1)): ?>天
					<?php else: ?>
						个月<?php endif; ?>
					</td>
	                <td class="td3" width="102">
						<strong class="td5-m" style="background-position: -<?php echo ($v['speed']*54); ?>px 0;"><em><?php echo ($v['speed']); ?></em>%</strong>				
	                </td>
	                <td align="center" valign="middle" width="160"><?php echo ($v['way_of_repayment']); ?></td>
	                <td align="center" valign="middle"><a class="btn btn_blue js_invest_jump" href="javascript:void(0);" platform_id="<?php echo ($v['platform_id']); ?>" invest_url="<?php echo ($v['invest_url']); ?>" invest_id="<?php echo ($v['invest_id']); ?>" is_login="<?php echo ($v['is_login']); ?>" is_mail="<?php echo ($v['is_mail']); ?>" is_mobile="<?php echo ($v['is_mobile']); ?>" is_bind="<?php echo ($v['is_bind']); ?>"><span>投 资</span></a></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?> 
			<?php else: ?>
				<tr><td colspan="7" class="tdnone">对不起，暂未检索到任何数据。</td></tr><?php endif; ?>           
			</tbody>
		</table>
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

<script type="text/javascript" src="__ROOT__/static/js/plugins/highcharts.js"></script>
<script type="text/javascript">
$(function(){
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
	//请求数据
	function request(page){
		var obj = {}, arr = [], page=page==undefined?1:page;
		obj.id = <?php echo ($data['id']); ?>;
		obj.page = page;
		obj.sorttype = $("#js_sort li").children(".ms").attr("sorttype");
		obj.sortorder = $("#js_sort li").children(".ms").attr("sortorder");
		$.ajax({
			url: '/Platform/invest',
			type: 'get',
			data: obj,
			dataType: 'json',
			success: function(p){
				$("#js_sort li:last").find("strong").text(p.total);
				//列表数据填充
				var str = '';
				if(p.rows!=null && p.rows.length>0){
					for(var i=0; i<p.rows.length; i++){
						str += '<tr><td align="center" valign="middle">';
						str += '<span style="height:20px;margin-left:5px;line-height:20px;width:213px;text-align:left;overflow:hidden;float:left;text-indent:30px;">'+p.rows[i].designer+'</span></td>';
						str += '<td align="center" valign="middle"><div class="td5-p"><span class="jiekuan">'+p.rows[i].amount+'</span></div></td>';
						str += '<td align="center" valign="middle">'+p.rows[i].interest_rate+'%</td>';
		        		str += '<td align="center" valign="middle"><font color="#f00">'+p.rows[i].term+'</font>';
		        		if(p.rows[i].isday==1){
		        			str += '天';
		        		}else{
		        			str += '个月';
		        		}
						str += '</td><td class="td3" width="102"><strong class="td5-m" style="background-position: -'+p.rows[i].speed*54+'px 0;"><em>'+p.rows[i].speed+'</em>%</strong></td>';
			        	str += '<td align="center" valign="middle" width="160">'+p.rows[i].way_of_repayment+'</td>';
						str += '<td align="center" valign="middle"><a class="btn btn_blue js_invest_jump" href="javascript:void(0)" platform_id="'+p.rows[i].platform_id+'" invest_url="'+p.rows[i].invest_url+'" invest_id="'+p.rows[i].invest_id+'" is_login="'+p.rows[i].is_login+'" is_mail="'+p.rows[i].is_mail+'" is_mobile="'+p.rows[i].is_mobile+'" is_bind="'+p.rows[i].is_bind+'"><span>投 资</span></a></td>';
					}
				}else{
					str += '<tr><td colspan="7" class="tdnone">对不起，暂未检索到任何数据。</td></tr>';
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
	// 加载图形统计
	function loadPieCharts(obj, data){
		obj.highcharts({
	        chart: {
	        	backgroundColor: null,
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            plotShadow:false,
	            plotBorderWidth:0,
		        height:210
	        },
	        title: {
	            text: null
	        },
	        tooltip: {
	    	    pointFormat: '<span>数量：</span><b>{point.y}</b><br/><span>百分比：</span><b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: false,
	                    distance:-50,
	        			format:"<b>{point.percentage:.0f}%</b>",
	        			style:{
	        				fontWeight:"bold",
	        				color:"white",
	        				size:12,
	        				textShadow:"0px 1px 2px black"
	        			}
	                },
	                showInLegend:true,
	                center:["25%","50%"],
	                size: '85%'
	            }
	        },
	        legend:{
	        	layout:"vertical",
	        	align:"right",
	        	verticalAlign:"middle",
	        	floating:true,
	        	borderWidth:0,
	        	symbolRadius: 0,
	        	symbolWidth: 30,
	        	symbolHeight: 15,
	        	itemMarginTop: 5,
	        	itemMarginBottom: 5
	        },
	        series: [{
	            type: 'pie',
	            data: data
	        }]
	    });		
	}
	function loadLineCharts(obj, categories, data){
		obj.highcharts({
	        chart: {
		        height:210
	        },
	        title: {
	            text: null
	        },
	        xAxis: {
	        	lineWidth: 2,
	        	lineColor: '#cccccc',
	            categories: categories,
	            tickmarkPlacement: 'on'
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: null
	            },
	            gridLineDashStyle: 'Dash',
	            tickPixelInterval: 50,
	            labels: {
	                formatter: function() {
	                    return this.value / 10000;
	                }
	            }
	        },
	        tooltip: {
	        	formatter: function(){
	        		var amount = 0;
	        		$.each(this.points, function(i, point) {
	                    amount = Math.round(point.y / 10000);
	                });
	        		return '<span style="color:#FFFFFF"><b>'+amount+'万元</b></span>';
	        	},
	        	backgroundColor: '#db2e28',
	            shared: true,
	            useHTML: true
	        },
	        legend: {
	            enabled: false
	        },
	        plotOptions: {
	            column: {
	                pointPadding: 0.2,
	                borderWidth: 0
	            }
	        },
	        series: [{
	            color: '#db2e28',
	            data: data
	        }]
	    });
	}
	function loadRateCharts(obj, categories, data){
		obj.highcharts({
	        chart: {
	            type: 'bar',
	            height: 210
	        },
	        title: {
	            text: null
	        },
	        xAxis: {
	            categories: categories,
	            labels:{
	            	format: '<span style="color:#08608d;font-weight:bold;">{value}</span><br/>平均利率：</span>'
	            }
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                enabled: false
	            },
	            labels: {
	                format:"{value}%"
	            },
				gridLineColor:"transparent"
	        },
	        tooltip: {
	            pointFormat: '<b>{point.y:.2f}%</b>'
	        },
	        legend: {
	            enabled: false
	        },
	        plotOptions: {
	            bar: {
                    pointWidth: 33,
	                dataLabels: {
	                    enabled: true,
	                    inside: true,
	                    color: '#ffffff',
	                    format:"<b>{point.y:.2f}%</b>"
	                }
	            }
	        },
	        series: [{
	        	color: '#db2e28',
	            data: data
	        }]
	    });
	}
	function randomcolor(){
		var str = Math.ceil(Math.random()*1000).toString(16);
		if(str.length<6){
			str="0"+str;
		}
		return str;
	}
	function setColor(data){
		var colors = ['#eb661b','#00abe6','#aadbfb','#0075c2','#ff6600','#ff0000','#eb661b','#9f2323','#ddd119','#39cd26'];
		$.each(data, function(i, item){
			item.color = colors[i];
			if(i > 9){
				item.color = '#'+randomcolor();
			}
		});
	}
	var data = '<?php echo ($charstJson); ?>';
	if(data!=''){
		data = eval('('+data+')');
	}
	if(data.type_charts){
		setColor(data.type_charts);
		loadPieCharts($("#js_type_charts"), data.type_charts);		
	}
	if(data.term_charts){
		setColor(data.term_charts);
		loadPieCharts($("#js_term_charts"), data.term_charts);		
	}
	if(data.amount_charts){
		setColor(data.amount_charts);
		loadPieCharts($("#js_amount_charts"), data.amount_charts);		
	}
	if(data.trading_charts){
		loadLineCharts($("#js_trading_charts"), data.trading_charts.categories, data.trading_charts.amounts);
	}else{
		loadLineCharts($("#js_trading_charts"), {}, {});
	}
	if(data.rate_charts){
		loadRateCharts($("#js_rate_charts"), data.rate_charts.categories, data.rate_charts.Averages);
	}else{
		loadRateCharts($("#js_rate_charts"), {}, {});
	}
	
	$(".js_invest_jump").live('click', function(){
		var _this = $(this);
		platform_id = _this.attr('platform_id');
		invest_url = _this.attr('invest_url');
		invest_id = _this.attr('invest_id');
		is_login = _this.attr('is_login');
		is_mail = _this.attr('is_mail');
		is_mobile = _this.attr('is_mobile');
		is_bind = _this.attr('is_bind');
		if(is_login!=1){
			$.layer({
			    type: 2,
			    maxmin: false,
			    shadeClose: false,
			    title: false,
			    shade: [0.5, 'rgb(255, 255, 255)'],
			    offset: [($(window).height() - 310)/2+'px', ''], //上下垂直居中
			    area: ['410px', '310px'],    
			    iframe: {src: '__GROUP__/Platlogin/box?invest_url='+invest_url, scrolling: 'no', frameborder: "no"}
			});	
			return;
		}
		if(is_mail!=1 || is_mobile!=1){
			$.layer({
			    shade: [0],
			    area: ['auto','auto'],
			    dialog: {
			        msg: '完成邮箱和手机认证<br />网投所才能为您提供更好的服务',
			        btns: 2,                    
			        type: 4,
			        btn: ['去认证','取消'],
			        yes: function(){
			            location.href = '/Center/Safeinfo.html';
			        }, no: function(){}
			    }
			});
			return;
		}
		if(is_bind!=1){
			window.open('__GROUP__/Platlogin/page/id/'+platform_id+'/invest_id/'+invest_id);
		}else{
			window.open('__GROUP__/Platlogin/index/id/'+platform_id+'/invest_id/'+invest_id);
		}
	});
});
</script>

</body>
</html>