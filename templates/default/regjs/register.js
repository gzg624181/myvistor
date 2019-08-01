  /**
  * 推广注册js
  * update 2019-1-8
  * author jeker@ng666.com
  */
 //获取验证码
 function get_mobile_code(){
 	var opts = {"mobile":$('#newmobile').val(),"token":$('#checktoken').val()};
    $.post(commonOpt.get_code_url,opts,function(text){
      if(text.status==1){
      	$('#getcodetag').attr('data-timeout',60);
      	waitRegetCode();
        layer.open({"content":"验证码发送成功",time:2,skin:"msg"});
      }else{
      	layer.open({"content":text.msg,time:2,skin:"msg"});
      }
    })
  }
 //倒计时
 function waitRegetCode(){
   var obj = $('#getcodetag');
   var time = parseInt(obj.attr('data-timeout'));
   var timeOut = setInterval(function(){
         if(time<=0){
           clearInterval(timeOut);
           obj.text('获取验证码').removeClass('waittimeout');
           return false;
         }else{
          if(!obj.hasClass('waittimeout')) 
          	obj.addClass('waittimeout');
           obj.text(time+'s后重新获取');
           --time;
           obj.attr('data-timeout',time);
         }
       },1000);
 }
 //验证
 var dragCfg = {
	   token:true,
	   url:commonOpt.get_token_url,
	   callback:function(){$('#getcodetag').attr('data-token',$('#checktoken').val());get_mobile_code();$('.activity_codedrag').hide('slow',function(){$('.activity_codedrag').remove();});
	     }
	   };
$(function() {
//完成加载后判断可否获取验证码 
var mobileobj = $('#getcodetag');
  if(parseInt(mobileobj.attr('data-timeout'))>0){
	    waitRegetCode();
	  }

$("#getcodetag").click(function(){
	if(parseInt($(this).attr('data-timeout'))>0)
	 return false;
  var mobile=$('#newmobile').val();	
  if(mobile.length!=11){
		 layer.open({
			    content: '请输入正确的手机号码'
			    ,skin: 'msg'
			    ,time: 2 //2秒后自动关闭
			  });
	      return false;
	}
  if($('#captcha_div').length>0){
	    $('#captcha_div,#captcha_bg').remove();
	  }
   layer.open({type:2,content:'加载中'});
   $.get(commonOpt.get_code_widget_url,function(html){
	     $('body').append(html);
		 $('#captcha_bg').fadeTo(400,0.5,function(){$('#captcha_div').show();});
         $('#codedrag').drag(dragCfg);
         layer.closeAll('loading');
	   });	
});

      //执行注册
		$("#reg").click(function(){
		  var form = $('#regdata');
          var errText = '';
           switch(true){
           	 case form.find('input[name=phone]').val()=='':
           	   errText = '请输入手机号码';break;
           	 case form.find('input[name=code]').val()=='':
           	   errText = '请输入手机验证码';break;
           	 case form.find('input[name=password]').val()=='':
           	   errText = '请输入密码';break;
           	 case form.find('input[name=repassword]').val()=='':
           	   errText = '请重复输入密码';break;
           	 case form.find('input[name=nickname]').val()=='':
           	   errText = '请输入昵称';break;
           }
          if(errText!=''){
            layer.open({"content":errText,time:2,skin:"msg"});
            return false;
          }
           $("#reg").attr('disabled',true).text('正在注册...');
            $.post(commonOpt.get_register_url,{params:jaes.aesEncrypt(form.serialize())},function(text){
              if(text.code==1){
              	$("#reg").text('注册成功');
                 layer.open({"content":"注册成功",time:2,skin:"msg"});
              	 setTimeout(function(){location.href = commonOpt.get_success_url;},1000);
              }else{
              	$("#reg").attr('disabled',false).text('注册并下载APP');
              	 layer.open({"content":text.msg,time:2,skin:"msg"});
              }
            })
		})
	})
 
	$(function() { 
		$('.searchkey').focus(function() { 
			$(this).prev().css({
				color: '#fff',
			}); 
		}).blur(function() { 
			$(this).prev().css({
				color: '#efefef',
			});  
		}); 
	}) 