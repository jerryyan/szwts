var name_patrn = /^[a-zA-Z]([a-zA-Z0-9])+$/;
var phone_patrn = /^(?:13\d|14\d|15\d|17\d|18\d)-?\d{5}(\d{3}|\*{3})$/;
var email_patrn = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;
var card_patrn = /^(\d{17}X|\d{17}x|\d{18})$/;
var money_patrn = /^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/;
var num_patrn = /^[\da-zA-Z]+$/;
//发送手机验证码
var send = {
    count: 60,
    start: function () {
        var _this = this;
        if (_this.count > 0) {
            var html = (_this.count--) + "秒重新获取";
            $("#sendCode").attr('disabled', true).hide();
            $("#send_code_status").text(html).show();
            //$("#phone").attr('disabled', true);
            setTimeout(function () {
                _this.start();
            }, 1000);
        } else {
            $("#sendCode").attr('disabled', false).show();
            $("#send_code_status").text('').hide();
            //$("#phone").attr('disabled', false);
            _this.count = 60;
        }
    }
};

/* 检测是否是中文 */
function str_chinese(name) {
    for (i = 0; i < name.length; i++) {
        if (name.charCodeAt(i) > 128) {
            return true;
            break;
        } else {
            return false;
        }
    }
}

//获取字符串长度
function str_length(str) {
    sl1 = str.length;
    strLen = 0;
    for (i = 0; i < sl1; i++) {
        if (str.charCodeAt(i) > 256)
            strLen += 2;
        else
            strLen++;
    }
    return strLen;
}

//添加收藏
function AddFavorite(sURL, sTitle) {
    try {
        window.external.addFavorite(sURL, sTitle);
    } catch (e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        } catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}

//设置首页
function SetHome(obj, vrl) {
    try {
        obj.style.behavior = 'url(#default#homepage)';
        obj.setHomePage(vrl);
    } catch (e) {
        if (window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            }
            catch (e) {
                alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
            }
            var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
            prefs.setCharPref('browser.startup.homepage', vrl);
        }
    }
}

//自定义下拉菜单
$.DivSelect = function () {
    var dom = arguments[0],
            cls = arguments[1],
            vname = arguments[2],
            tname = arguments[3];
    $(dom).live('click', function () {
        $(this).find('ul').slideToggle();
        $(this).addClass(cls);
    }).live('mouseleave', function () {
        $(this).find("ul").slideUp();
        $(this).removeClass(cls);
    });
    $(dom).find("ul").live('mouseleave', function () {
        $(this).slideUp();
    });
    $(dom).find("ul>li").live('click', function () {
        var tid = $(this).attr("tid"),
                text = $(this).text();
        $(dom + " span").attr({title: text, tid: tid}).text(text);
        if (vname && tname) {
            $("input[name='" + vname + "']").val(tid);
            $("input[name='" + tname + "']").val(text);
        }
    });
}

//Luhm校验规则：16位银行卡号（19位通用）:
//1.将未带校验位的 15（或18）位卡号从右依次编号 1 到 15（18），位于奇数位号上的数字乘以 2。
//2.将奇位乘积的个十位全部相加，再加上所有偶数位上的数字。
//3.将加法和加上校验位能被 10 整除。
$.luhmCheck = function () {
    var bankno = arguments[0];
    var lastNum = bankno.substr(bankno.length - 1, 1);//取出最后一位（与luhm进行比较）

    var first15Num = bankno.substr(0, bankno.length - 1);//前15或18位
    var newArr = new Array();
    for (var i = first15Num.length - 1; i > -1; i--) {    //前15或18位倒序存进数组
        newArr.push(first15Num.substr(i, 1));
    }
    var arrJiShu = new Array();  //奇数位*2的积 <9
    var arrJiShu2 = new Array(); //奇数位*2的积 >9

    var arrOuShu = new Array();  //偶数位数组
    for (var j = 0; j < newArr.length; j++) {
        if ((j + 1) % 2 == 1) {//奇数位
            if (parseInt(newArr[j]) * 2 < 9)
                arrJiShu.push(parseInt(newArr[j]) * 2);
            else
                arrJiShu2.push(parseInt(newArr[j]) * 2);
        }
        else //偶数位
            arrOuShu.push(newArr[j]);
    }

    var jishu_child1 = new Array();//奇数位*2 >9 的分割之后的数组个位数
    var jishu_child2 = new Array();//奇数位*2 >9 的分割之后的数组十位数
    for (var h = 0; h < arrJiShu2.length; h++) {
        jishu_child1.push(parseInt(arrJiShu2[h]) % 10);
        jishu_child2.push(parseInt(arrJiShu2[h]) / 10);
    }

    var sumJiShu = 0; //奇数位*2 < 9 的数组之和
    var sumOuShu = 0; //偶数位数组之和
    var sumJiShuChild1 = 0; //奇数位*2 >9 的分割之后的数组个位数之和
    var sumJiShuChild2 = 0; //奇数位*2 >9 的分割之后的数组十位数之和
    var sumTotal = 0;
    for (var m = 0; m < arrJiShu.length; m++) {
        sumJiShu = sumJiShu + parseInt(arrJiShu[m]);
    }

    for (var n = 0; n < arrOuShu.length; n++) {
        sumOuShu = sumOuShu + parseInt(arrOuShu[n]);
    }

    for (var p = 0; p < jishu_child1.length; p++) {
        sumJiShuChild1 = sumJiShuChild1 + parseInt(jishu_child1[p]);
        sumJiShuChild2 = sumJiShuChild2 + parseInt(jishu_child2[p]);
    }
    //计算总和
    sumTotal = parseInt(sumJiShu) + parseInt(sumOuShu) + parseInt(sumJiShuChild1) + parseInt(sumJiShuChild2);

    //计算Luhm值
    var k = parseInt(sumTotal) % 10 == 0 ? 10 : parseInt(sumTotal) % 10;
    var luhm = 10 - k;

    if (lastNum == luhm) {
        return true;
    } else {
        return false;
    }
}

//JQUERY 模拟淘宝控件银行帐号输入 
// 输入框格式化 
$.bankInput = function () {
    var defaults = {
        min: 19, // 最少输入字数 
        max: 23, // 最多输入字数 
        deimiter: ' ', // 账号分隔符 
        onlyNumber: true, // 只能输入数字 
        copy: true // 允许复制 
    };
    var opts = $.extend({}, defaults);
    var dom = arguments[0];
    var obj = $(dom);
    obj.css({imeMode: 'Disabled', borderWidth: '1px', color: '#000', fontFamly: 'Times New Roman'}).attr('maxlength', opts.max);
    if (obj.val() != '')
        obj.val(obj.val().replace(/\s/g, '').replace(/(\d{4})(?=\d)/g, "$1" + opts.deimiter));
    obj.bind('keyup', function (event) {
        if (opts.onlyNumber) {
            if (!(event.keyCode >= 48 && event.keyCode <= 57)) {
                this.value = this.value.replace(/\D/g, '');
            }
        }
        this.value = this.value.replace(/\s/g, '').replace(/(\d{4})(?=\d)/g, "$1" + opts.deimiter);
    }).bind('dragenter', function () {
        return false;
    }).bind('onpaste', function () {
        return !clipboardData.getData('text').match(/\D/);
    }).bind('blur', function () {
        this.value = this.value.replace(/\s/g, '').replace(/(\d{4})(?=\d)/g, "$1" + opts.deimiter);
        /*if(this.value.length < opts.min){
         obj.focus(); 
         }*/
    });
}
// 列表显示格式化 
$.bankList = function (options) {
    var defaults = {
        deimiter: ' ' // 分隔符 
    };
    var opts = $.extend({}, defaults, options);
    return this.each(function () {
        $(this).text($(this).text().replace(/\s/g, '').replace(/(\d{4})(?=\d)/g, "$1" + opts.deimiter));
    });
}

//去除输入框中的所有空格
String.prototype.NoSpace = function () {
    return this.replace(/\s+/g, "");
}

var browser = {
    versions: function () {
        var u = navigator.userAgent, app = navigator.appVersion;
        return {//移动终端浏览器版本信息   
            trident: u.indexOf('Trident') > -1, //IE内核  
            presto: u.indexOf('Presto') > -1, //opera内核  
            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核  
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核  
            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端  
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端  
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器  
            iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器  
            iPad: u.indexOf('iPad') > -1, //是否iPad    
            webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部  
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}

//侧边栏推广组件
/*$.sideBar = function(){
 if(!browser.versions.mobile && !browser.versions.ios && !browser.versions.android && !browser.versions.iPhone && !browser.versions.iPad){
 var dom = arguments[0],sidebarHtml = '<div id="sidebar" class="sidebar">';
 sidebarHtml += '<a href="http://shang.qq.com/wpa/qunwpa?idkey=6d7cc95ce4148588afe35e4bb3d5e5d2f2c0ecbb2af48612d16cb8cef437b1c1" title="网投所官方交流群" target="_blank" class="btn btn-qq"></a>';
 sidebarHtml += '<div class="btn btn-wx"><img class="pic" src="static/images/weixin.jpg"/></div><div class="btn btn-top"></div></div>';
 $(dom).html(sidebarHtml);
 $("#sidebar").each(function(){
 _this = $(this);
 _this.find(".btn-wx").mouseenter(function(){
 $(this).find(".pic").fadeIn("fast");
 });
 _this.find(".btn-wx").mouseleave(function(){
 $(this).find(".pic").fadeOut("fast");
 });
 _this.find(".btn-top").click(function(){
 $("html, body").animate({
 "scroll-top":0
 },"fast");
 });
 });
 var lastStatus = false;
 $(window).scroll(function(){
 var _top = $(window).scrollTop();
 if(_top>200){
 $("#sidebar .btn-top").slideDown();
 }else{
 $("#sidebar .btn-top").slideUp();
 }
 });	
 }
 }*/

$.sideBar = function () {
    if (!browser.versions.mobile && !browser.versions.ios && !browser.versions.android && !browser.versions.iPhone && !browser.versions.iPad) {
        var dom = arguments[0], sidebarHtml = '<div class="sidebar"><ul>';
       sidebarHtml += '<li class="s_c_11"><a class="a2" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=973012883&site=qq&menu=yes target="_blank" style="width: 36px; right: 0px;"></a></li>';
        sidebarHtml += '<li class="s_c"><a class="a1" href="javascript:void(0);" style="width: 36px; right: 0px;"></a></li><li class="s_c"><a class="a3" href="http://weibo.com/u/5475395913?topnav=1&wvr=6" target="_blank" style="width: 36px; right: 0px;"></a></li>';
        sidebarHtml += '<li class="s_c_w"><a class="a4"></a> <p class="weixin" style="display: none; left: -80px; opacity: 0;"><img src="/static/images/home/sidebar/weixin.jpg" width="98"><span class="s_h"></span></p></li></ul></div>';
        //sidebarHtml += '<li class="s_c"><a class="a2" href="http://shang.qq.com/wpa/qunwpa?idkey=6d7cc95ce4148588afe35e4bb3d5e5d2f2c0ecbb2af48612d16cb8cef437b1c1" target="_blank" style="width: 36px; right: 0px;"></a></li></ul></div>';

        $(dom).html(sidebarHtml);
        $(".sidebar").each(function () {
            _this = $(this);
            _this.find(".s_c").hover(function () {
                $(this).children("a").stop(true).animate({width: 142, right: 0});
            }, function () {
                $(this).children("a").stop(true).animate({width: 36, right: 0});
            });
            _this.find(".s_c_w").hover(function () {
                $(this).children("p").show().stop(true).animate({left: -110, opacity: 1});
            }, function () {
                $(this).children("p").stop(true).animate({left: -80, opacity: 0}).hide();
            });
        });
    }
}


