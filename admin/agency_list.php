<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>访客记录</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
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

function SendCheck(id,type)
{
if(confirm("是否确认拒绝此旅行社注册审核？"))
 {

layer.open({
  type: 2,
  title: '审核未通过模板消息：',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['800px' , '545px'],
  content: 'check.php?id='+id+'&type='+type,
  });
  }
}
//审核，未审，功能
  function checkinfo(key){
     var v= key;
	// alert(v)
	window.location.href='agency.php?check='+v;
	}

function GetSearchs(){
var keyword= document.getElementById("keyword").value;
if($("#keyword").val() == "")
{
 layer.alert("请输入搜索内容！",{icon:0});
 $("#keyword").focus();
 return false;
}
window.location.href='agency.php?keyword='+keyword;
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
<body>
<?php
$tbname="pmw_record";
$action="agency_save.php";
$one=1;
$dosql->Execute("SELECT * FROM $tbname where vistor_openid='$openid'",$one);
$num=$dosql->GetTotalRow($one);
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar">
<span class="title">访客记录：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload"><?php echo $cfg_reload;?></a>
</div>
<div class="toolbarTab" style="margin-bottom:5px;">
<ul>
 <li class="<?php if($check==""){echo "on";}?>"><a href="agency.php">全部</a></li> <li class="line">-</li>
 <li class="<?php if($check=="success"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('success')">男&nbsp;&nbsp;<i style='color:#509ee1; cursor:pointer;' title='男' class='fa fa-dot-circle-o' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="failed"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('failed')">女&nbsp;&nbsp;<i style='color:red;cursor:pointer;'  title='女' class='fa fa-dot-circle-o' aria-hidden='true'></i></a></li>
<!-- <li class="line">-</li>
 <li class="<?php if($check=="reviewed"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('reviewed ')">待审核&nbsp;&nbsp;<i style='color:#509ee1; cursor:pointer;' title='待审核' class='fa fa-circle-o' aria-hidden='true'></i></a></li>-->
</ul>
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" style="font-size:11px;" placeholder="请输入访客昵称" title="请输入访客昵称" />
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
            <td width="3%" height="144" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
              <tr align="left" class="head" style="font-weight:bold;">
                <td width="2%" height="36" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
                <td width="12%" align="center">访客昵称</td>
                <td width="21%" align="center">访客头像</td>
                <td width="16%" align="center">访客性别</td>
                <td width="22%" align="center">海报内容</td>
                <td width="19%" align="center">浏览时间</td>
                <td width="8%" align="center">操作</td>
                </tr>
              <?php
		$dopage->GetPage("SELECT a.id,b.nickname,b.sex,b.images,a.vtime,a.poster_id,a.vistor_openid FROM $tbname a inner join pmw_members b on a.vistor_openid=b.openid where a.vistor_openid='$openid'",15);

		while($row = $dosql->GetArray())
		{
			switch($row['sex']){

        case 1:
					$sex = "<i title='男' style='font-size:16px;color: blue; font-weight:bold;' class='fa fa-venus' aria-hidden='true'></i>";
					break;
				case 2:
					$sex = "<i title='女' style='font-size:16px;color: red;font-weight:bold;' class='fa fa-mercury' aria-hidden='true'></i>";
					break;
        case 0:
            $sex = "<i title='未知' style='font-size:16px;font-weight:bold;' class='fa fa-minus-circle' aria-hidden='true'></i>";
            break;


			}

			$vtime=date("Y-m-d H:i:s",$row['vtime']);

		?>
              <tr class="dataTr" align="left">
                <td height="101" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center"><Img src="<?php echo $row['images'];?>" width="100px;height:100px;" style="border-radius:3px;" /></td>
                <td align="center"><?php echo $row['nickname']; ?></td>
                <td align="center"><?php echo $sex; ?></td>
                <td align="center" class="num">
                <?php
				$id=$row['poster_id'];
				$k=$dosql->GetOne("SELECT pic FROM pmw_publish where id=$id");
				if(is_array($k)){
				$pic=$cfg_weburl."/".$k['pic'];
				}else{
				$pic= "templates/images/nopic.jpg";
					}
				?>
                <img style="width:100px; border-radius:3px;" src="<?php echo $pic;?>" />
                </td>
                <td align="center"><?php echo $vtime;?></td>
                <td align="center">
                 <span class="nb"><a title="删除" href="<?php echo $action;?>?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
                </td>
              </tr>
              <?php } ?>
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
