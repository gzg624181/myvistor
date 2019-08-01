/**
 * APP内置注册js
 * update 2019-1-7
 * author jeker@ng666.com
 */

/**
 * [errTags description]
 * @type {Array}
 */
var errTags = ['请输入手机号', '请输入验证码', '请输入密码', '请输入确认密码', '请输入昵称'];
var errFlags = [0, 0, 0, 0, 0, 1];
var validateDom = $('ul.plist li');
var form = $('#regdata');

//获取验证码
function get_mobile_code() {
  var opts = {
    "mobile": $('#newmobile').val(),
    "token": $('#checktoken').val()
  };
  $.post(commonOpt.get_code_url, opts, function (text) {
    if (text.status == 1) {
      $('#getcodetag').attr('data-timeout', 60);
      waitRegetCode();
      layer.open({
        "content": "验证码发送成功",
        time: 2,
        skin: "msg"
      });
    } else {
      callConsole(0, 0, text.msg);
      //layer.open({"content":text.msg,time:2,skin:"msg"});
    }
  })
}
//倒计时
function waitRegetCode() {
  var obj = $('#getcodetag');
  var time = parseInt(obj.attr('data-timeout'));
  var timeOut = setInterval(function () {
    if (time <= 0) {
      clearInterval(timeOut);
      obj.text('发送').removeClass('waittimeout');
      return false;
    } else {
      if (!obj.hasClass('waittimeout'))
        obj.addClass('waittimeout');
      obj.text('CD ' + time + 's');
      --time;
      obj.attr('data-timeout', time);
    }
  }, 1000);
}
//验证
var dragCfg = {
  token: true,
  url: commonOpt.get_token_url,
  callback: function () {
    $('#getcodetag').attr('data-token', $('#checktoken').val());
    get_mobile_code();
    $('.activity_codedrag').hide('slow', function () {
      $('.activity_codedrag').remove();
    });
  }
};

/**
 * 验证表单 
 */

var checkFormData = function (index) {
  var value = validateDom.eq(index).find('.verifyd').val();
  if (index < 5 && value == '')
    return callConsole(index, 0);
  switch (index) {
    case 1: //验证码
      if (!/^\d{4,}$/.test(value) || value.length > 6)
        return callConsole(index, 0, "验证码输入不正确");
      break;
    case 2: //密码
      if (value.length < 6)
        return callConsole(index, 0, "密码不能少于6位");
      if (/\s+/.test(value))
        return callConsole(index, 0, "密码不能包含空格");
      var regx = new RegExp(/^(?![a-zA-Z]+$)(?![0-9]+$)/);
      if (!regx.test(value))
        return callConsole(index, 0, "必须为字母和数字");
      break;
    case 3: //确认密码
      if (value != validateDom.find('.verifyd').eq(index - 1).val())
        return callConsole(index, 0, "两次密码输入不一致");
      break;
    case 4: //昵称
      if (value.length > 12)
        return callConsole(index, 0, "昵称不能大于12位");
      if (!/^[\u4e00-\u9fa5\w_]{3,12}$/.test(value))
        return callConsole(index, 0, "格式3~12位中文、英文或数字");
      break;
    case 5: //推荐人
      if (value == '')
        return callConsole(index, 1);
      if (value.length > 8)
        return callConsole(index, 0, "推荐人UID输入不正确");
      if (/[^\d+]/.test(value))
        return callConsole(index, 0, "推荐人UID为数字");
      break;
    default: //手机号
      if (!/^1[\d+]{10}$/.test(value))
        return callConsole(index, 0, "手机号必须为11位");
  }
  return callConsole(index, 1);
}

var callConsole = function (index, status, msg) {
  if (status == 0) {
    msg = msg ? msg : errTags[index];
    validateDom.eq(index).find('i').text(msg);
    errFlags[index] = 0;
    return false;
  } else {
    validateDom.eq(index).find('i').empty();
    errFlags[index] = 1;
    return true;
  }
}



//验证所有
var validateData = function (callback) {
  validateDom.each(function (index) {
    checkFormData(index);
  });
  if (errFlags[0] && errFlags[1] && errFlags[2] && errFlags[3] && errFlags[4] && errFlags[5]) {
    $("#reg").attr('disabled', true).text('正在注册...');
    $.post(commonOpt.get_register_url, {
      params: jaes.aesEncrypt(form.serialize())
    }, function (text) {
      if (text.code == 1) {
        $("#reg").text('注册成功');
        jeker.alert("欢迎加入南宫娱乐", $('#newmobile').val(), "前去登录", function () {
          yPhone.goLogin();
        });
        /*layer.open({"content":"注册成功",time:2,skin:"msg"});
        setTimeout(function(){if(commonOpt.device){ios.goLogin();}else{android.goLogin();}},1000);*/
      } else {
        $("#reg").attr('disabled', false).text('注册');
        if (text.index == -1)
          layer.open({
            "content": text.msg,
            time: 2,
            skin: "msg"
          });
        else
          callConsole(text.index, 0, text.msg);
      }
      callback(text.code, text.msg);
    })
  }
}



$(function () {
  //完成加载后判断可否获取验证码 
  var mobileobj = $('#getcodetag');
  if (parseInt(mobileobj.attr('data-timeout')) > 0) {
    waitRegetCode();
  }

  $("#getcodetag").click(function () {
    if (parseInt($(this).attr('data-timeout')) > 0)
      return false;
    var mobile = $('#newmobile').val();
    if (mobile.length != 11) {
      layer.open({
        content: '请输入正确的手机号码',
        skin: 'msg',
        time: 2 //2秒后自动关闭
      });
      return false;
    }
    if ($('#captcha_div').length > 0) {
      $('#captcha_div,#captcha_bg').remove();
    }
    layer.open({
      type: 2,
      content: '加载中'
    });
    $.get(commonOpt.get_code_widget_url, function (html) {
      $('body').append(html);
      $('#captcha_bg').fadeTo(400, 0.5, function () {
        $('#captcha_div').show();
      });
      $('#codedrag').drag(dragCfg);
      layer.closeAll('loading');
    });
  });

  validateDom.find('.verifyd').blur(function () {
    var index = validateDom.find('.verifyd').index(this);
    checkFormData(index);
  })

  //执行注册
  $("#reg").click(function () {
    validateData();
  })



})