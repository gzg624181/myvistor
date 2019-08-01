<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首页banner图片列表管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/listajax.js"></script>
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script>
function message(Id){
  // alert(Id);
   layer.ready(function(){ //为了layer.ext.js加载完毕再执行
   layer.photos({
   photos: '#layer-photos-demo_'+Id,
	// area:['800px','270px'],  //图片的宽度和高度
   shift: 0 ,//0-6的选择，指定弹出图片动画类型，默认随机
   closeBtn:1,
   offset:'40px',  //离上方的距离
   shadeClose:false
  });
});
}

//标题搜索
   function GetSearchs(){
	 var keyword= document.getElementById("keyword").value;
	if($("#keyword").val() == "")
	{
		layer.alert("请输入搜索内容！",{icon:0});
		$("#keyword").focus();
		return false;
	}
  window.location.href='bannerss.php?keyword='+keyword;
}
//审核，未审，功能
  function checkinfo(key){
     var v= key;
	// alert(v)
	window.location.href='bannerss.php?check='+v;
	}
</script>
</head>
<body>
<?php
//初始化参数
$action  = isset($action)  ? $action  : 'banner_save.php';
$keyword = isset($keyword) ? $keyword : '';
$check = isset($check) ? $check : '';
$adminlevel=$_SESSION['adminlevel'];
?>
<div class="topToolbar"> <span class="title">Banner轮播图片</span>
<a href="javascript:location.reload();" class="reload"><i class="fa fa-refresh fa-spin fa-fw"></i></a>

</div>
<!--<div class="toolbarTab">
	<ul>
 <li class="<?php if($check==""){echo "on";}?>"><a href="bannerss.php">全部</a></li> <li class="line">-</li>
 <li class="<?php if($check=="index"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('index')">首页Banner图片&nbsp;&nbsp;<i class='fa  fa-circle-o-notch' aria-hidden='true' style="color:#30B534"></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="travel"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('travel')">行程Banner图片&nbsp;&nbsp;<i class='fa fa-unlock' aria-hidden='true' style="color:#F90"></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="piao"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('piao')">票务Banner图片&nbsp;&nbsp;<i class='fa fa-unlock-alt' aria-hidden='true' style="color:#509ee1"></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="guide"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('guide')">导游Banner图片&nbsp;&nbsp;<i class='fa fa-chain-broken' aria-hidden='true' style="color:#F00"></i></a></li>
<li class="line">-</li>
<li class="<?php if($check=="ticket"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('ticket')">景区&nbsp;&nbsp;<i class='fa fa-paper-plane-o' aria-hidden='true' style="color:#F1700E"></i></a></li>
  <li class="line">-</li>
  <li class="<?php if($check=="reg"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('reg')">注册&nbsp;&nbsp;<i class='fa fa-stop-circle-o' aria-hidden='true' style="color:#ccc"></i></a></li>
<li class="line">-</li>
  <li class="<?php if($check=="text"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('text')">文本介绍&nbsp;&nbsp;<i class='fa fa-stop-circle-o' aria-hidden='true' style="color:#ccc"></i></a></li>
  <li class="line">-</li>
  <li class="<?php if($check=="no"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('no')">无跳转链接&nbsp;&nbsp;<i class='fa fa-stop-circle-o' aria-hidden='true' style="color:#ccc"></i></a></li>
	</ul>
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" placeholder="请输入图片标题" title="请输入图片标题" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>-->

<form name="form" id="form" method="post" action="banner_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td height="36" align="center">图片标题</td>
		  <td align="center">banner图片</td>
		  <td align="center">添加时间</td>
		  <td width="3%" align="center">操作</td>
		</tr>
		<?php
		$tbname='pmw_banner';
		if($check=="index"){
		$dopage->GetPage("SELECT * FROM $tbname where typename='index'",10);
		  }elseif($check=="travel"){
		$dopage->GetPage("SELECT * FROM $tbname where typename='travel'",10);
		  }elseif($check=="piao"){
		$dopage->GetPage("SELECT * FROM $tbname where typename='piao'",10);
		  }elseif($check=="guide"){
		$dopage->GetPage("SELECT * FROM $tbname where typename='guide'",10);
        }elseif($check=="ticket"){
		$dopage->GetPage("SELECT * FROM $tbname where type='ticket'",10);
		  }elseif($check=="reg"){
		$dopage->GetPage("SELECT * FROM $tbname where type='reg'",10);
		  }elseif($check=="text"){
		$dopage->GetPage("SELECT * FROM $tbname where type='text'",10);
		  }elseif($check=="no"){
		$dopage->GetPage("SELECT * FROM $tbname where type='no'",10);
		  }elseif($keyword!=""){
		$dopage->GetPage("SELECT * FROM $tbname where title like '%$keyword%'",10);
		  }else{
		 $dopage->GetPage("SELECT * FROM $tbname",10);
		  }
		 while($row = $dosql->GetArray())
		{
		switch($row['type']){
		case 'reg':
		$type = "注册";
		break;

		case 'text':
		$type="文本介绍";
		break;

		case 'ticket':
		$type="景区";
		break;

		case 'no':
		$type="无跳转链接";
		break;

		}

		switch($row['typename']){

		case 'index':
		$typename = "首页Banner图片";
		break;

		case 'travel':
		$typename="行程Banner图片";
		break;

		case 'piao':
		$typename="票务Banner图片";
		break;

		case 'guide':
		$typename="导游Banner图片";
		break;

		}

		?>
		<tr align="left" class="dataTr">
			<td height="54" align="center"><?php echo $row['title'];?></td>
			<td align="center"><div id="layer-photos-demo_<?php  echo $row['id'];?>" class="layer-photos-demo"> <img  width="200px;" layer-src="<?php echo $cfg_weburl."/".$row['pic'];?>" style="cursor:pointer; padding:5px; border-radius:9px;"
			onclick="message('<?php echo $row['id']; ?>');"  src="<?php echo $cfg_weburl."/".$row['pic'];?>" alt="<?php echo $row['title']; ?>" /></div></td>
			<td align="center"><?php echo date("Y-m-d H:i:s",$row['pictime']);?></td>
			<td align="center">
			  <div id="jsddm">
		      <a title="编辑"  href="banner_update.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></div>
			  <?php if($adminlevel==1){ ?>
			  <div id="jsddm" style=" margin-top:3px;"><a title="删除" href="banner_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
			  <?php }else{ ?>
			  <div id="jsddm" style=" margin-top:3px;"><a title="删除"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
			  <?php } ?>
		    </td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('<?php echo $action;?>');" onclick="return ConfDelAll(0);">删除</a> - <a style="cursor:pointer;" onclick="return history.go(-1);">返回</a></span><a href="banner_add.php" class="dataBtn">添加图片</a> </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php
//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea">
        <span class="pageSmall"><?php echo $dopage->GetList(); ?></span>
        </div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
</body>
</html>
