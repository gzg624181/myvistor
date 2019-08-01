 /**
  * @jquery fn keyboard plugin
  * @author jeker@ng666.com
  * @version 2019-1-10
  */
!function($){
  $.numberKeyboard = function(options){
    var defOpt = { 
      element:"",	
      type:"pay",
      submit : true,
      event : "click",	
      decimal : false,
      unit : "￥", 
      exkey:"",
      exevent:function(){},
      callback : function(){}
    };
   var opt = $.extend({}, defOpt, options || {}); 
    
    /*create keyboard element*/
     var createKeyboard = function(){
      if($('body').find('#keyboardblock').length==0){
      	var inputElement = "";
      	switch(opt.type){
      	 case "pay":
      	   	inputElement = '<i>'+opt.unit+'</i><input type="tel" readonly placeholder="0">';
      	   	break;
      	 case "password":
      	    inputElement = '<b></b><b></b><b></b><b></b><b></b><b></b>';
      	   	break;
      	   /*more types*/		
      	} 
       var exkeyElement = opt.exkey ? '<b>'+exkey+'</b>' : '';
       var decimalElement = opt.decimal ? '<b>.</b>' : '<b class="keynormal"></b>';
        	if(exkeyElement)
        		decimalElement = exkeyElement;
       var submitElement = !opt.submit || opt.type =="password" ? '<b class="submitnormal"></b>' : '<b></b><em>确定</em>';
      	$('body').append('<div id="keyboardblock"><style>#keyboardblockbg{display:none;position:fixed;left:0;top:0;width:100%;height:100%;background: #000;opacity: 0.3;z-index:100;}#keyboardblock_body{display:none;position:fixed;z-index:101;bottom:0;left:0;width:100%;background:white;}#keyboardblock_body h3{position:relative;padding:0;margin:0;border-top:1px solid #eee;}#keyboardblock_body h3 input{width:50%;height:3.5rem;line-height:3.5rem;font-size:1.8rem;margin:0 17% 0 33%;border:none;}#keyboardblock_body h3 i{display:block;position:absolute;left:25%;top:.6rem;font-size:1.8rem;text-align:center;color:#999;}#keyboardblock_body h3 b{display:block;float:left;border:1px solid #ddd;height:3rem;line-height:3rem;text-align:center;font-size:22px;color:#666;width:12%;margin:10px 2%;}#keyboardblock_body .keyboard_left{float:left;width:75%;}#keyboardblock_body .keyboard_left b,#keyboardblock_body .keyboard_left small{display:block;float:left;width:33.33%;margin-right:-1px;text-align:center;height:3.5rem;line-height:3.5rem;font-size:1.7rem;border-top:1px solid #eee;border-right:1px solid #eee;color:#888;}#keyboardblock_body .keyboard_left small{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAGFBMVEVHcEyKioqLi4uJiYmKioqMjIyJiYmKioo4tUx5AAAAB3RSTlMAxHuBPhOgnTacmgAAANpJREFUSMfVlIsOgzAIRaFwy///8Wg1vjonLCZz16SxpMcCAkQPFVTK1aNYzxcLaUHUjANyYgbYasTvajy/mSEUqNkCxFJzANQFz5dr2hxMA+BBmZD4ys3UjDvTPwDpLH0DFC8AIW114P64lKqv5Rzo3uoUQC+3HsaNgLwH5BTobUQQl9O+ARWX3peldscg/QjI2JjyY6CMvV/urKUgADaNnNdlzPjAUVxP0834ik1K4/WrwoHjdeMF6MECnwYaIhi5Oxg5rxi5OBi5yBm5XDFy2eXk38ejq2WvFzyjDp4tmYK8AAAAAElFTkSuQmCC) center center no-repeat;background-size:auto 60%;}#keyboardblock_body .keyboard_left b.keynormal{background: #eee;}#keyboardblock_body .keyboard_right{float:right;width:25%;}#keyboardblock_body .keyboard_right b,#keyboardblock_body .keyboard_right em{display:block;width:100%;height:7.1rem;line-height:7.1rem;text-align:center;font-size:1.6rem;}#keyboardblock_body .keyboard_right b{border-top:1px solid #eee;}#keyboardblock_body .keyboard_left b:active{background:#eee;} #keyboardblock_body .keyboard_right b{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAGFBMVEWPj4+Li4uKioqJiYmJiYmKioqKioqKioqtY/O6AAAAB3RSTlMCQcRz76EsRJoVBwAAAPVJREFUSMftlMsWgzAIRA1DmP//40q1PYaAj10XRVeeufIYkmX5xw9GkzI6Ej1IXZ/i1Rb1RqKV0VUt6JX9rF5TeaT3iocUQrkaCY9d6KV+BfDk/yPQGUdwDtzSHwDEEZvsBXZpCQAlJstly3xs7QM0Rr17QjHXc85g0/8/xKpXTD0UBjvBkHoDerEQNul3AMVEvf5g5t7D6kGh90OQACY+kESPd+eJcTbvEbb5ONEzpxkbB78jT4F5tNiLNOTLl5p3ut7gDWI4QLiRYwDmFb8Cbhyi8RKoLB8E4UNm+WBOXFO3vA5m94qS9WWMLH19F9vyjx+KF/TVB2Ap8JNCAAAAAElFTkSuQmCC) center center no-repeat;background-size:35% auto;}#keyboardblock_body .keyboard_right em{background:#2c8df0;color:white;}#keyboardblock_body .keyboard_right b.submitnormal{height:14rem;}</style><div id="keyboardblockbg"></div><div id="keyboardblock_body"><h3>'+inputElement+'</h3><div class="keyboard_left"><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b>'+decimalElement+'<b>0</b><small></small></div><div class="keyboard_right">'+submitElement+'</div></div></div>'); 
      }	
    }
       createKeyboard();
     
    /* hidden keyboard */ 
    var closeKeyboard = function(clear){
    	if(clear)
    	 $('#keyboardblock_body h3 input').val(null);
 		$('#keyboardblock_body').slideUp(300);
 		$('#keyboardblockbg').fadeOut(300);
 		$('html,body').css({"overflow":"auto","height":"auto"});
    }

    /*pay number keydown*/
     var payKeydown = function(n){      	
		var $input = $('#keyboardblock_body h3 input');
		if(opt.exkey && n == opt.exkey){
		  closeKeyboard(true); 	
     	  exevent();return;	
     	}
		var value = $input.val();
		if(value=='0' && n!='0'){
			  $input.val(null);
			  value = '';
			}
	     if(value.length>8)
		  return false;
	  if(value){
		 var ns = value.split('.');
		if(ns.length==2 && ns[1].length>1)
		  return false;
	    }
		if(n=='.'){
		  if(value.indexOf('.')!=-1){
			  return false;
			} 
		    if(value==''){
			   $input.val("0.");
			   return false;	
		     }
		  }
		$input.val(value+n);	
    }

    /*password number keydown*/ 
     var passwordKeydown = function(text){     	
       var $dom = $('#keyboardblock_body h3');
       if(opt.exkey && n == opt.exkey){
       	   $dom.data('index', 0);
           $dom.data('password', '');
           $dom.find('b').empty();
           closeKeyboard();
     	   exevent();return;
     	}
       var index = $dom.data('index') || 0;
       var password = $dom.data('password') || '';
       if(index < 6){
        $dom.find('b').eq(index).text('•');
        ++index;
        $dom.data('index',index);
        password += text;
        $dom.data('password',password);
         if(index==6){
          setTimeout(function(){
           $dom.data('index', 0);
           $dom.data('password', '');
           $dom.find('b').empty();
            closeKeyboard();
           	opt.callback(password); 
 		  }, 300);          
         }
      }
     }


    /*bind call life keyboard in*/
    $('body').on(opt.event, opt.element, function(event){
       event.stopPropagation(); 
       $(this).val(null);
 		if($('#keyboardblock_body').is(':hidden')){
 			$('#keyboardblock_body').slideDown(300);
 			$('#keyboardblockbg').fadeTo(300, 0.3); 
 		}
 		$('html,body').css({"overflow":"hidden","height":"100%"});
     });

     /*hidden keyboard element*/
     $('body').on('click', '#keyboardblock_body .keyboard_left small', function(){
 		closeKeyboard(true);
 	});

     $('body').bind('click',function(){
        closeKeyboard(true);
     });

     /*bind keyboard key's events*/
      $('body').on('click', '#keyboardblock_body .keyboard_left b', function(event){
		event.stopPropagation(); 
		var text = $(this).text();
		switch(opt.type){
           case "pay":
             payKeydown(text);
           break;
           case "password":
            passwordKeydown(text);
           break;
           /*more types*/
		 }
	  });
	 /*delete input*/
	 $('body').on('click', '#keyboardblock_body .keyboard_right b', function(event){
		  event.stopPropagation();  
		 switch(opt.type){
		 	case "pay":
		     var $input = $('#keyboardblock_body h3 input');
		     var _value = $input.val();
		     $input.val(_value.replace(/.$/,''));
		     break;
		    case "password":
		     var $dom = $('#keyboardblock_body h3');
		     var index = $dom.data('index');
		     var password = $dom.data('password');
		      index--; 
		      $dom.find('b').eq(index).empty();
		      $dom.data('index', index);
		      password = password.replace(/.$/,'');
		      $dom.data('password', password);
		     break;
		    /*more types*/  
		  } 
		});

    /*submit*/
	$('body').on('click', '#keyboardblock_body .keyboard_right em', function(event){
        event.stopPropagation(); 
        var input = $('#keyboardblock_body h3 input');
        var inputValue = opt.type =="password" ? $('#keyboardblock_body h3').data('password') : input.val();
        closeKeyboard(true);
        opt.callback(Number(inputValue));
     });
 }
}(jQuery)