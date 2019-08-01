/**
 * @deprecated recharge pay
 * @author jeker@ng66.com
 * @version 2019-1-9
 */

 $(function(){
	 
 	var min_money = 50;
 	var max_money = 3000;
	
 	//h5 online pay tab event
 	$('body').on('click','#online_list li',function(){
 		var code = $(this).attr('data-code');
        var payway_id = $(this).attr('data-payway_id');
 		var action = $(this).attr('data-action');
 		var defaultPayTips = '<span>1、在线充值不需要填写UID,系统会自动填写转账附言，请不要修改金额与转账附言，否则不能自动到账！</span><br><span>2、每次在线充值请在本页面发起，不要自行转账，自行转账到冻结账户损失自己承担。</span>';
 		var payTips = $(this).attr('data-tips');
 		payTips = payTips || defaultPayTips;
 		index = $('#online_list li').index(this);
 		$('#online_list em').removeClass('active');
 		$(this).find('em').addClass('active');
        $('.pay_tips_desc').html(payTips);
 		$('#onlinepay').find('input[name=paytype]').val(code);
 		$('#onlinepay').find('input[name=payway_id]').val(payway_id);
 		$('#onlinepay').attr('action',action+'/index/h5pay');
 		min_money = $(this).attr('data-min');
 		max_money = $(this).attr('data-max');
 		$('.withdrawtips').text('* 充值金额限定：'+min_money+' ~ '+max_money);
 	});
 	$('body #online_list li').eq(0).trigger('click'); 
 
   //call input keyboard
    $.numberKeyboard({ 
       element:".feeinput",	
       decimal:false,
       callback:function(fee){ 
          $('.feeinput').val(fee);  
           if(!fee || fee<min_money || fee>max_money){
				 layer.open({content:"充值金额最低"+min_money+"，最高"+max_money,skin:"msg",time:2});
				 return false;
			   } 
			   
			 var rule = $('#online_list em.active').parent().attr('data-rule');
			 if (rule && fee%10==0) {
				 layer.open({content:"网关限制充值金额尾数不能为0",skin:"msg",time:2});
				 return false;
			 }
			 
		 	var form = $('#onlinepay'); 
		   layer.open({type:2,content:'加载中'}); 
		   $.post(form.attr('_action'),form.serialize(),function(text){ 
		   	layer.closeAll('loading');
			    if(text.code==1){
			    if(text._action){
                  location.href = text._action;
			    }else{
			     //var device = $('#onlinepay').attr('data-device'); 
                 yPhone.openBrowser(text.action);
              }
           }else{
				 layer.open({content:text.msg,skin:"msg",time:2});   
				}
			  });		 
          }
      });  
 });