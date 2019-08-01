
//倒计时功能
//jeker@ng666.com
(function($){
	
 $.fn.timeOut = function(options){
	 //默认配置
	 var defaults = {
		 attr:'data-time',
		 isRun:true,
		 datetype:"fulltime",
		 sp:['天','时','分','秒'],
		 callBack : function() {
		  }	 
	   }; 
	 var params = $.extend({},defaults,options || {});
	 var nowtime = parseInt((new Date()).getTime()/1000);	
	 var overtime = parseInt($(this).attr(params.attr));
	 var times = params.datetype =='fulltime' ? overtime-nowtime : overtime;
	 var obj = $(this);
	 var sp = params.sp.length==4 ? params.sp : defaults.sp;
	 
	 /*加载时间，实时计时*/
	 var loading = function(){ 
		if(times){	 
		 //动态展示
		 if(params.isRun){
	     var runtime = setInterval(function(){
			 if(times<=0){
			  clearInterval(runtime);
			  params.callBack();
			}	  
			  obj.html(loadingtime(times));
			  times--;			 
			},1000);
		  }else{
		    obj.html(loadingtime(times));
		  }
		}		 
	  }
	  
	  /*计算时间单位*/
	  var loadingtime = function(times){
		  var days = Math.floor(times/(3600*24));
		  var string='',hour,minute;
		  switch(true){
		   /*case days>=1:
		    string += (days>=10 ? days : '0'+days)+sp[0];
			times -= days*3600*24;*/
		   case times/3600>=1:
		    hour = Math.floor(times/3600);
		    string += (hour>=10 ? hour : '0'+hour)+sp[1];
			times -= hour*3600;
		   case times/60>=1:
		    minute = Math.floor(times/60);
			string += (minute>=10 ? minute : '0'+minute)+sp[2];
			times -= minute*60;
		   default:
		    string += (times>=10 ? times : '0'+times)+sp[3];
		  }
		  return string; 
		}
	  //加载倒计时
	  loading();
	}	
})(jQuery)

$(function(){
if($('.timeout').length>0){
   var config = {
	   attr:'data-time',
	   isRun:true
	  };
	 $('.timeout').each(function(ixd){
		  $(this).timeOut(config);
		 }) 
	 }
  })
