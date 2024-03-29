
/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-29 00:12:36
person: Feng
**************************
*/
function message(Id){
  // alert(Id);
   layer.ready(function(){ //为了layer.ext.js加载完毕再执行
   layer.photos({
   photos: '#layer-photos-demo_'+Id,
	 area:['300px','270px'],  //图片的宽度和高度
   shift: 0 ,//0-6的选择，指定弹出图片动画类型，默认随机
   closeBtn:1,
   offset:'40px',  //离上方的距离
   shadeClose:false
  });
});
}

$(function(){

	$(".dataTr").mouseover(function(){
		$(this).attr("class","dataTrOn");
	}).mouseout(function(){
		$(this).attr("class","dataTr");
	});


	$(".alltype").mouseover(function(){
		$(this).find(".btn").addClass("on");
		$(this).find(".drop").show();
	}).mouseout(function(){
		$(this).find(".btn").removeClass("on");
		$(this).find(".drop").hide();
	});


	QuickToolBar();


	$(window).resize(function(){
		QuickToolBar();
	});


	$(window).scroll(function(){
		QuickToolBar();
	});

}).keydown(function(event){

	//快捷键
	if(event.keyCode == 27){
		window.top.location.href = 'logout.php';
	}
});



//快捷工具栏
function QuickToolBar()
{
	if($(window).scrollTop() < $(document).height() - $(window).height() - 100){
		$(".quickToolbar").show();
	}else{
		$(".quickToolbar").fadeOut(300);
	}
}


//选择所有
function CheckAll(value)
{
	$("input[type='checkbox'][name^='checkid'][disabled!='true']").attr("checked",value);
}



//删除单条提示
function ConfDel(i)
{
	var tips = Array();
	tips[0] = "确定要删除选中的信息吗？";
	tips[1] = "系统会自动删除类别下所有子类别以及信息，确定删除吗？";
	tips[2] = "系统会自动删除类别下所有子类别，确定删除吗？";
	tips[3] = "确定要提现吗？";
	tips[4] = "确定要更改订票状态吗？";

	if(confirm(tips[i])) return true;
	else return false;
}
//审核操作
function ConfCheck(i)
{
	var tips = Array();
	tips[0] = "是否确认通过审核？";
	tips[1] = "是否确认拒绝审核？";
	tips[2] = "系统会自动删除类别下所有子类别，确定删除吗？";
	tips[3] = "确定禁止用户发布任何动态？禁止之后，用户发布的所有动态将全部删除！";

	if(confirm(tips[i])) return true;
	else return false;
}
//删除单条提示
function ConfDels(i)
{
	var tips = Array();
	tips[0] = "确定要提现吗？";

	if(confirm(tips[i])) return true;
	else return false;
}
//删除单条提示
function ConfDelss(i)
{
	var tips = Array();
	tips[0] = "确定要发送提现通知吗？";

	if(confirm(tips[i])) return true;
	else return false;
}

//选中发放记录的商户单条提示
function ConfSend(i)
{
	var tips = Array();
	tips[0] = "确定要发放推荐奖励吗？";

	if(confirm(tips[i])) return true;
	else return false;
}
//删除选中提示
function ConfDelAll(i)
{
	var myDate = new Date();  
	var year=myDate.getFullYear(); 
	var month=myDate.getMonth()+1;
	var tips = Array();
	tips[0] = "确定要删除选中的信息吗？";
	tips[1] = "系统会自动删除类别下所有子类别以及信息，确定删除吗？";
	tips[2] = "系统会自动删除类别下所有子类别，确定删除吗？";
	tips[3] = "确定要提现吗？";
	tips[4] = "确定要发放"+year+"-"+month+"月的注册奖励？";

	if($("input[type='checkbox'][name!='checkid'][name^='checkid']:checked").size() > 0)
	{
		if(confirm(tips[i])) return true;
		else return false;
	}
	else
	{
		alert('没有任何选中信息！');
		return false;
	}
}



//删除所有(包含子分类)
function DelAll(url,par)
{
	var par = arguments[1] ? arguments[1] : "";
	$("#form").attr("action", url+"?action=delall"+par).submit();
}



//删除所有(不包含子分类)
function DelAllNone(url)
{
	$("#form").attr("action", url+"?action=delall2").submit();
}

//同时发送所有的推荐奖励
function SendAllNone(url)
{
	$("#form").attr("action", url+"?action=sendall").submit();
}


//发放注册奖励提示
function ConfsendReg(url)
{

     $("#form").attr("action",url+"?action=sendreg").submit();
		
	
}

//提交更新表单
function UpdateForm(url)
{
	$("#form").attr("action", url+"?action=update").submit();
}



//执行特定参数
function SubUrlParam(url)
{
	$("#form").attr("action", url).submit();
}



//更新排序
function UpOrderID(url)
{
	$("#form").attr("action", url+"?action=uporder").submit();
}



//展开合并下级
function DisplayRows(id)
{
	var rowpid = $("div[rel='rowpid_"+id+"']");
	var rowid  = $("span[id='rowid_"+id+"']");

	if(rowid.attr("class") == "minusSign")
	{
		rowpid.slideUp(200);
		rowid.attr("class","plusSign");

		//判断快捷操作栏
		setTimeout("QuickToolBar()",200);
	}
	else
	{
		rowpid.slideDown(200);
		rowid.attr("class","minusSign");

		//判断快捷操作栏
		setTimeout("QuickToolBar()",200);
	}

}



//全部显示行
function ShowAllRows()
{
	$("div[rel^='rowpid'][rel!='rowpid_0']").slideDown(200);
	$("span[id^='rowid']").attr("class","minusSign");

	//判断快捷操作栏
	setTimeout("QuickToolBar()",200);
}



//全部隐藏行
function HideAllRows()
{
	$("div[rel^='rowpid'][rel!='rowpid_0']").slideUp(200, QuickToolBar());
	$("span[id^='rowid']").attr("class","plusSign");

	//判断快捷操作栏
	setTimeout("QuickToolBar()",200);
}



//文件上传提示
function UploadPrompt(string)
{
	if(string == 0)
	{
		$(".uploading").html('<div class="upload_newfile_loading"><img src="templates/images/loading.gif">文件上传中...</div>');
	}
	else
	{
		$('.uploading').html(string);
	}
}



//检查是否存在上传文件
function CheckIsUpload()
{
	if($("#upfile").val() == "")
	{
		UploadPrompt("请选择上传文件！");
		return false;
	}
	else
	{
		return true;
	}
}



//显示div
function ShowDiv(id)
{
	$("#"+id).show();
}



//隐藏div
function HideDiv(id)
{
	$("#"+id).fadeOut();
}

