/**
 * APP内置注册js
 * update 2019-1-7
 * author jeker@ng666.com
 */

/**
 * [errTags description]
 * @type {Array}
 */
var uErrTags = ['请输入用户名', '请输入密码', '请输入确认密码', '请输入昵称', '', '请输入验证码'];
var uErrFlags = [0, 0, 0, 0, 1, 0];
var uValidateDom = $('ul.ulist li');
var uForm = $('#uregdata');

/**
 * 验证表单 
 */

var checkUformData = function (index) {
    var value = uValidateDom.eq(index).find('.verifyd').val();
    if (index != 4 && value == '')
        return callUconsole(index, 0);
    switch (index) {
        case 1: //密码
            if (value.length < 6)
                return callUconsole(index, 0, "密码不能少于6位");
            if (/\s+/.test(value))
                return callUconsole(index, 0, "密码不能包含空格");
            var regx = new RegExp(/^(?![a-zA-Z]+$)(?![0-9]+$)/);
            if (!regx.test(value))
                return callUconsole(index, 0, "必须为字母和数字");
            break;
        case 2: //确认密码
            if (value != uValidateDom.find('.verifyd').eq(index - 1).val())
                return callUconsole(index, 0, "两次密码输入不一致");
            break;
        case 3: //昵称
            if (value.length > 12)
                return callUconsole(index, 0, "昵称不能大于12位");
            if (!/^[\u4e00-\u9fa5\w_]{3,12}$/.test(value))
                return callUconsole(index, 0, "格式3~12位中文、英文或数字");
            break;
        case 4: //推荐人
            if (value == '')
                return callUconsole(index, 1);
            if (value.length > 8)
                return callUconsole(index, 0, "推荐人UID输入不正确");
            if (/[^\d+]/.test(value))
                return callUconsole(index, 0, "推荐人UID为数字");
            break;
        case 5: //验证码
            if (!/^\d{4}$/.test(value))
                return callUconsole(index, 0, "验证码输入不正确");
            break;
        default: //用户名
            if (!/^(?!\d+$)[\da-zA-Z]{6,12}$/.test(value))
                return callUconsole(index, 0, "必须为6~12位数字英文组合");
    }
    return callUconsole(index, 1);
}

var callUconsole = function (index, status, msg) {
    if (status == 0) {
        msg = msg ? msg : uErrTags[index];
        uValidateDom.eq(index).find('i').text(msg);
        uErrFlags[index] = 0;
        return false;
    } else {
        uValidateDom.eq(index).find('i').empty();
        uErrFlags[index] = 1;
        return true;
    }
}



//验证所有
var uValidateData = function (callback) {
    uValidateDom.each(function (index) {
        checkUformData(index);
    });
    if (uErrFlags[0] && uErrFlags[1] && uErrFlags[2] && uErrFlags[3] && uErrFlags[4] && uErrFlags[5]) {
        $("#reg2").attr('disabled', true).text('正在注册...');
        $.post(commonOpt.get_register_url, {
            params: jaes.aesEncrypt(uForm.serialize())
        }, function (text) {
            if (text.code == 1) {
                $("#reg2").text('注册成功');
                jeker.alert("欢迎加入南宫娱乐", $('#newmobile').val(), "前去登录", function () {
                    yPhone.goLogin();
                });
                /*layer.open({"content":"注册成功",time:2,skin:"msg"});
                setTimeout(function(){if(commonOpt.device){ios.goLogin();}else{android.goLogin();}},1000);*/
            } else {
                $('#captcha').click();
                $("#reg2").attr('disabled', false).text('注册');
                if (text.index == -1)
                    layer.open({
                        "content": text.msg,
                        time: 2,
                        skin: "msg"
                    });
                else
                    callUconsole(text.index, 0, text.msg);
            }
            callback(text.code, text.msg);
        })
    }
}



$(function () {

    uValidateDom.find('.verifyd').blur(function () {
        var index = uValidateDom.find('.verifyd').index(this);
        checkUformData(index);
    })

    //执行注册
    $("#reg2").click(function () {
        uValidateData(function(){});
    })

    $('.quickreg').click(function () {
        var t = parseInt($(this).attr('data-t'));
        if (t) {
            $('.username_register_list').show();
            $('.phone_register_list').hide();
        } else {
            $('.phone_register_list').show();
            $('.username_register_list').hide(); 
        }
    });

})