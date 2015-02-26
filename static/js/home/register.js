/**
 * 注册
 */
$(function () {
    $("#uname").focusin(function () {
        $("#js_submit_tips").hide();
        $("#js_uname_tips").css({'color': '#999'}).text('4-16位字符，只能输入字母或数字').show();
    }).focusout(function () {
        var _this = $(this),
                v = _this.val();
        checkUser(v);
    });
    $("#upwd").focusin(function () {
        $("#js_submit_tips").hide();
        $("#js_upwd_tips").css({'color': '#999'}).text('6-20位字符，建议使用字母、数字、符号组合').show();
    }).focusout(function () {
        var _this = $(this),
                v = _this.val();
        checkUpwd(v);
    });
    $("#upwd_confirm").focusin(function () {
        $("#js_submit_tips").hide();
        $("#js_upwd_confirm_tips").css({'color': '#999'}).text('两次密码输入必须一致').show();
    }).focusout(function () {
        var _this = $(this),
                v = _this.val();
        checkUpwdConfirm(v);
    });


    //手机号码格式检测
    $("#phone").focusin(function () {
        $("#js_verifyphone_tips").css({'color': '#999'}).text('建议使用常用的手机号码').show();
    }).focusout(function () {
        var v = $(this).val();
        checkPhone(v);
    });
    //手机号码格式检测
    $("#email").focusin(function () {
        $("#js_verifyemail_tips").css({'color': '#999'}).text('建议使用常用的邮箱地址').show();
    }).focusout(function () {
        var v = $(this).val();
        checkEmail(v);
    });


    //验证手机短信验证码格式
    $("#smscode").focusin(function () {
        $("#js_verifyphone_tips").css({'color': '#999'}).text('验证码长度必须为6位').show();
    }).focusout(function () {
        var v = $(this).val();
        checkCode(v);
    });
//    $("#valicode").focusin(function () {
//        $("#js_submit_tips").hide();
//        $("#js_valicode_tips").css({'color': '#999'}).text('验证码长度必须为4位').show();
//    }).focusout(function () {
//        var _this = $(this),
//                v = _this.val();
//        checkCode(v);
//    });
    $("#registerTo").click(function () {
        var obj = {};
        obj.invite_id = $("#invite_userid").val();
        obj.oid = $("#oauth_id").val();
        obj.uname = $("#uname").val();
        obj.upwd = $("#upwd").val();
        //obj.valicode = $("#valicode").val();
        obj.smscode = $("#smscode").val();
        obj.phone = $("#phone").val();
        var upwdt = $("#upwd_confirm").val();
        $("#js_submit_tips").hide();
        if (checkUser(obj.uname) && checkUpwd(obj.upwd) && checkUpwdConfirm(upwdt) && checkPhone(obj.phone) && checkCode(obj.smscode)) {
            var check_confirm = $("#check_confirm").attr('checked');
            if (!check_confirm) {
                alert("必须同意“用户协议”");
                return false;
            }
            $.post('/Register/save', obj, function (data) {
                eval("var p=" + data);
                $("#js_submit_tips").css({color: '#f00'}).show().text(p.msg).show();
                if (p.state == 1) {
                    $("input").each(function (k, v) {
                        $(this).val('');
                    });
                    location.href = "/Center.html";
                } else {
                    $("#valicodeforimage").trigger("click");
                    return false;
                }
            });
        }
    });
});


//检测手机号码是否合法
function checkPhone(v) {
    var phone = $.trim(v),
            len = phone.length;
    $("#js_verifyphone_tips").text('').hide();
    if (len == 0) {
        $("#js_verifyphone_tips").css({'color': '#f00'}).text('请输入手机号码').show();
        return false;
    } else {
        if (phone_patrn.test(phone)) {
            return true;
        } else {
            $("#js_verifyphone_tips").css({'color': '#f00'}).text('手机号码格式不正确').show();
            return false;
        }
    }
}
//检测短信验证码是否合法
function checkCode(v) {
    var code = $.trim(v),
            len = code.length;
    if (len == 0) {
        $("#js_verifyphone_tips").css({'color': '#f00'}).text('请输入手机验证码').show();
        return false;
    } else if (len < 6) {
        $("#js_verifyphone_tips").css({'color': '#f00'}).text('验证码长度必须为6位').show();
        return false;
    } else {
        $("#js_verifyphone_tips").css({'color': '#f00'}).text('').hide();
        return true;
    }
}

function checkUser(uname) {
    var len = str_length(uname);
    if (len == 0) {
        $("#js_uname_tips").css({'color': '#f00'}).text('请输入用户名').show();
        return false;
    } else if (len < 4) {
        $("#js_uname_tips").css({'color': '#f00'}).text('用户名过短').show();
        return false;
    } else if (len > 16) {
        $("#js_uname_tips").css({'color': '#f00'}).text('用户名过长').show();
        return false;
    } else {
        if (name_patrn.test(uname)) {
            $("#js_uname_tips").css({'color': '#f00'}).text('').hide();
            return true;
        } else {
            $("#js_uname_tips").css({'color': '#f00'}).text('只能输入字母、数字，不能以数字开头').show();
            return false;
        }
    }
}
function checkUpwd(upwd) {
    var len = str_length(upwd);
    if (len == 0) {
        $("#js_upwd_tips").css({'color': '#f00'}).text('请输入密码').show();
        return false;
    } else if (len < 6) {
        $("#js_upwd_tips").css({'color': '#f00'}).text('密码不能少于6位').show();
        return false;
    } else if (len > 20) {
        $("#js_upwd_tips").css({'color': '#f00'}).text('密码不能大于20位').show();
        return false;
    } else {
        $("#js_upwd_tips").css({'color': '#f00'}).text('').hide();
        return true;
    }
}
function checkUpwdConfirm(upwdt) {
    var len = str_length(upwdt),
            upwd = $("#upwd").val();
    if (len == 0) {
        $("#js_upwd_confirm_tips").css({'color': '#f00'}).text('请确认密码').show();
        return false;
    } else if (len < 6) {
        $("#js_upwd_confirm_tips").css({'color': '#f00'}).text('确认密码不能少于6位').show();
        return false;
    } else if (len > 20) {
        $("#js_upwd_confirm_tips").css({'color': '#f00'}).text('确认密码不能大于20位').show();
        return false;
    } else {
        if (upwdt == upwd) {
            $("#js_upwd_confirm_tips").css({'color': '#f00'}).text('').hide();
            $("#upwd_confirm").attr('flag', 0);
            return true;
        } else {
            $("#js_upwd_confirm_tips").css({'color': '#f00'}).text('两次密码输入不一致').show();
            return false;
        }
    }
}
//function checkCode(code) {
//    var len = str_length(code);
//    if (len == 0) {
//        $("#js_valicode_tips").css({'color': '#f00'}).text('请输入验证码').show();
//        return false;
//    } else if (len < 4 || len > 4) {
//        $("#js_valicode_tips").css({'color': '#f00'}).text('验证码长度必须为4位').show();
//        return false;
//    } else {
//        $("#js_valicode_tips").css({'color': '#f00'}).text('').hide();
//        return true;
//    }
//}

//发送手机短信
$("#sendCode").click(function () {
    var obj = $("#phone"),
            v = obj.val();
    if (checkPhone(v)) {
        $.ajax({
            url: '/Register/sendcode',
            type: 'get',
            data: "phone=" + v,
            dataType: 'json',
            beforeSend: function () {
                $("#sendCode").css({background: 'none repeat scroll 0 0 #999'}).attr('disabled', true).val('发送中');
                $("#phone").attr('disabled', true);
            },
            success: function (p) {
                $("#sendCode").css({background: 'url("/static/images/home/login/dx.jpg") no-repeat'}).attr('disabled', false).val('');
                $("#phone").attr('disabled', false);
                if (p.state > 0) {
                    //layer.alert(p.msg, 1);
                    $("#sendinfo").html(p.msg);
                    send.start();
                } else {
                    // layer.alert(p.msg, 8);
                    $("#sendinfo").html(p.msg);
                    return false;
                }
            }
        });
    }
});

