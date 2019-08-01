!function($){
 var commonCurrentPage;//页数
 $.ajaxPage = function(opt){
  var def = {
	    url:'',
		time:0,
		type:'GET',
		root:'body', 
		append_list:'m_data_list',
		page:1,
	  }; 
 var opts = $.extend({},def,opt||{});
 commonCurrentPage = opts.page; 
  //console.log(opts);
  function jzMore(){  
	 $.ajax({
	    url:opts.url,
	    type:opts.type,
	    async:false,    //或false,是否异步
	    data:{"page":commonCurrentPage},
	    cache:false,
	    timeout:5000,    //超时时间
	    dataType:'html',    //返回的数据格式：json/xml/html/script/jsonp/text
	    beforeSend:function(xhr){
	        //console.log(xhr)
	        //console.log('发送前')
	    },
	    success:function(dat){ 
	    	if(dat){
	    	  $(opts.root).find(".jzMore").css("display","none");
	    		if(commonCurrentPage==1){
	    		  opts;
	    		  $(opts.root).find(opts.append_list).html(dat);
	    		}else{
	    		$(opts.root).find(opts.append_list).append(dat);
	    	  } 
	    	  commonCurrentPage++;
	    	 }else{ 
	    		$(opts.root).find(".jzMore").css("display","block");
	    		$(opts.root).find(".jzMore").css('background','none').html('<div>已经到底了</div>');
	    	}
			//loadBodyScroll();	    	
	        //console.log(dat)
	        //console.log(textStatus)
	        //console.log(jqXHR)
	    },
	    error:function(xhr,textStatus){
	        console.log('错误')
	        console.log(xhr)
	        console.log(textStatus)
	    },
	    complete:function(){
	        //console.log('结束')
	    }
	})
}


function ajax_more(){
	if($(opts.root).find(".jzMore").css("display")=="none" && $(opts.root).find(".jzMore").html()!='<div>已经到底了</div>'){
		$(opts.root).find(".jzMore").css("display","block"); 
		jzMore();
	}
	
}

 $(document).on('scroll',function(){
    if($(document).scrollTop() + $(window).height() > $(document).height()-1 ) { 
    	ajax_more();
    }
  });
  opts.page = 1;
  ajax_more();
 }
}(jQuery)