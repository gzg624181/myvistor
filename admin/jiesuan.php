<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>结算统计</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script type="text/javascript" src="layui/layui.js"></script>
<link href="layui/css/layui.css" rel="stylesheet" type="text/css" />
<script>
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

function checkagency(id,type){
	 var ajax_url='agency_save.php?action=checkagency&id='+id+'&type='+type;
  // alert(ajax_url);
	$.ajax({
    url:ajax_url,
    type:'get',
	data: "data" ,
	dataType:'html',
    success:function(data){
        layer.open({
        type: 1
        ,title: false //不显示标题栏
        ,closeBtn: false
        ,area: '800px;'
        ,shade: 0.8
        ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
        ,btn: ['点击关闭']
        ,btnAlign: 'c'
        ,moveType: 1 //拖拽模式，0或者1
        ,content: "<div style='widht:750px;padding:25px; height:600px;line-height: 22px;text-align:center; '>"+ data+"</div>"
        ,
      });
    } ,
	error:function(){
       alert('error');
    }
	});
	}

layui.use('laydate', function(){
  var laydate = layui.laydate;

 //日期范围选择
laydate.render({
  elem: '#keyword',
  type: 'month'

});

});

//审核，未审，功能
  function checkinfo(key){
     var v= key;
	// alert(v)
	window.location.href='jiesuan.php?check='+v;
	}

function GetSearchs(){
var keyword= document.getElementById("keyword").value;
if($("#keyword").val() == "")
{
 layer.alert("请输入搜索内容！",{icon:0});
 $("#keyword").focus();
 return false;
}
if(keyword.indexOf("-") != -1){
window.location.href='travel_list.php?m='+keyword+'&check=search';
}else{
window.location.href='jiesuan.php?keyword='+keyword;
}
}
function member_update(Id){
 var adminlevel=document.getElementById("adminlevel").value;
  if(adminlevel==1){
	  window.location("member_update.php?id="+Id);
    }else{
	  alert("亲，您还没有操作本模块的权限，请联系超级管理员！");
		}
	}

function del_member(){
 var adminlevel=document.getElementById("adminlevel").value;
  if(adminlevel!=1){
	  alert("亲，您还没有操作本模块的权限，请联系超级管理员！");
  }
	}
</script>


<?php
//初始化参数
$action  = isset($action)  ? $action  : '';
$keyword = isset($keyword) ? $keyword : '';
$check = isset($check) ? $check : '';
$username=$_SESSION['admin'];
$adminlevel=$_SESSION['adminlevel'];
$r=$dosql->GetOne("select * from pmw_admin where username='$username'");

?>
</head>
<body  style="padding:11px;">
<?php
$tbname="pmw_agency";
$action="agency_save.php";
$one=1;
$dosql->Execute("SELECT * FROM $tbname",$one);
$num=$dosql->GetTotalRow($one);
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar">
<span class="title">结算统计：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload"><i class="fa fa-refresh fa-spin fa-fw"></i></a>
</div>
<div class="toolbarTab" style="margin-bottom:-14px;">
<!--<ul>
 <li class="<?php if($check==""){echo "on";}?>"><a href="agency.php">全部</a></li> <li class="line">-</li>
 <li class="<?php if($check=="success"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('success')">已通过&nbsp;&nbsp;<i style='color:#509ee1; cursor:pointer;' title='审核已通过' class='fa fa-dot-circle-o' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="failed"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('failed')">未通过&nbsp;&nbsp;<i style='color:red;cursor:pointer;'  title='审核不通过' class='fa fa-dot-circle-o' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="reviewed"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('reviewed ')">待审核&nbsp;&nbsp;<i style='color:#509ee1; cursor:pointer;' title='待审核' class='fa fa-circle-o' aria-hidden='true'></i></a></li>
</ul>-->
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" style="font-size:11px;" placeholder="请输入账号或者旅行社名称或者查询的结算月份" title="请输入账号或者旅行社名称或者查询的结算月份" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="<?php echo $action;?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
  <tr align="left" class="head">
    <td width="3%" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
      <tr align="left" class="head">
        <td width="3%" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
          <tr align="left" class="head">
            <td width="3%" height="165" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
              <tr align="left" class="head" style="font-weight:bold;">
                <td width="1%" height="36" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
                <td width="4%" align="center">用户账号</td>
                <td width="6%" align="center">头像</td>
                <td width="7%" align="center">联系人姓名</td>
                <td width="5%" align="center">营业执照</td>
                <td width="13%" align="center">旅行社名称</td>
                <td width="11%" align="center">公司地址</td>
                <td width="10%" align="center">联系电话</td>
                <td width="8%" align="center">最后登陆城市</td>
                <td width="11%" align="center">注册时间</td>
                <td width="6%" align="center">已发布行程</td>
                <td width="8%" align="center">已发布成功行程</td>
                <td width="7%" align="center">结算总额</td>
                <td width="3%" align="center">操作</td>
                </tr>
              <?php
		/*if($check=="today"){
		$time=date("Y-m-d"); //今天注册
		$dopage->GetPage("select * from $tbname where ymdtime = '%$time%'",15);
	    }elseif($check=="tomorrowzhuce"){ //昨天注册
		$time=date("Y-m-d",strtotime("-1 day"));
		$dopage->GetPage("select * from $tbname where ymdtime = '%$time%'",15);
	    }elseif($check=="success"){ //已通过
		$dopage->GetPage("select * from $tbname where checkinfo = 1",15);
	    }elseif($check=="failed"){ //未通过
		$dopage->GetPage("select * from $tbname where checkinfo = 2",15);
	    }elseif($check=="reviewed"){ //待审核
		$dopage->GetPage("select * from $tbname where checkinfo = 0",15);
	    }*/
		if($keyword!=""){ //关键字搜索
	    $dopage->GetPage("SELECT * FROM $tbname where account like '%$keyword%' or company  like '%$keyword%' or name like '%$keyword%' ",15);
		}else{
		$dopage->GetPage("SELECT * FROM $tbname where checkinfo = 1",15);
		}



		while($row = $dosql->GetArray())
		{
			$id=$row['id'];
			if($row['images']==""){
			$images="../templates/default/images/noimage.jpg";
		    }else{
            $images=$row['images'];
            }




		  $checkinfo = "<a href='jiesuan_year.php?id={$id}'><i  style='color:#509ee1; cursor:pointer;' title='查看所有年份结算统计' class='fa fa-sign-in' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;";



            $id=$row['id'];
			$six=6;
			$dosql->Execute("SELECT id from pmw_travel where aid=$id",$six);
			$agency_num=$dosql->GetTotalRow($six);

			$seven=7;
			$dosql->Execute("SELECT id,jiesuanmoney from pmw_travel where aid=$id and state=2",$seven);
			$num=$dosql->GetTotalRow($seven);

		    $sum=sum($row['id']);
			if($sum==""){

			$sum=0;

			}

		?>
              <tr class="dataTr" align="left">
                <td height="110" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center"><?php echo $row['account']; ?></td>
                <td align="center"><div id="layer-photos-demo_<?php  echo $row['id'];?>" class="layer-photos-demo"> <img  width="100px;" layer-src="<?php echo $images;?>" style="cursor:pointer" onclick="message('<?php echo $row['id']; ?>');"  src="<?php echo $images;?>" alt="<?php echo $row['name']; ?>" /></div></td>
                <td align="center"><?php echo $row['name']; ?></td>
                <td align="center" class="num"><a style="cursor:pointer;" onclick="checkagency('<?php echo $row['id'];?>','cardpic');">点击查看</a></td>
                <td align="center"><?php echo $row['company']; ?></td>
                <td align="center"><?php echo $row['address']; ?></td>
                <td align="center"><?php echo $row['tel']; ?></td>
                <td align="center"><?php echo $row['getcity']?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$row['regtime']);?></td>
                <td align="center" class="num"><a title="点击查看详情"  style="color:red;font-weight:bold;" href="travel_list.php?check=agency&id=<?php echo $row['id'];?>"><?php echo $agency_num;?></a></td>
                <td align="center"   style="color:#509ee1;font-weight:bold;"  class="num"><?php echo $num;?></td>
                <td align="center"   style="font-weight:bold;"  class="num"><?php echo $sum;?></td>
                <td align="center">
                <span><?php echo $checkinfo;?></span></td>
                <?php //}?>
              </tr>
              <?php
		}
		?>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  </table>
</form>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('<?php echo $action;?>');" onclick="return ConfDelAll(0);">删除</a></span></div>
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
