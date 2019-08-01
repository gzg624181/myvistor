<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>导游发布空闲时间</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
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
//审核，未审，功能
  function checkinfo(key){
     var v= key;
	// alert(v)
	window.location.href='free_time.php?check='+v;
	}

function GetSearchs(){
var keyword= document.getElementById("keyword").value;
if($("#keyword").val() == "")
{
 layer.alert("请输入搜索内容！",{icon:0});
 $("#keyword").focus();
 return false;
}
window.location.href='free_time.php?keyword='+keyword;
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
<body style="padding:10px;">
<?php
$tbname="pmw_freetime";
$action="guide_save.php";
$one=1;
$dosql->Execute("SELECT * FROM $tbname",$one);
$num=$dosql->GetTotalRow($one);
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar">
<span class="title">导游空闲时间列表：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload"><?php echo $cfg_reload;?></a>
</div>
<div class="toolbarTab" style="margin-bottom:5px;">

	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" style="font-size:11px;" placeholder="请输入搜索日期" title="请输入搜索日期" />
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
                <td width="7%" align="center">用户账号</td>
                <td width="6%" align="center">头像</td>
                <td width="7%" align="center">导游姓名</td>
                <td width="4%" align="center">性别</td>
                <td width="60%" align="center">空闲时间</td>
                <td width="11%" align="center">发布时间</td>
                <td width="4%" align="center">操作</td>
                </tr>
              <?php
	     if($keyword!=""){ //关键字搜索
      $keyword=strtotime($keyword);
	    $dopage->GetPage("SELECT a.*,b.account,b.images,b.name,b.sex FROM $tbname a inner join pmw_guide b on a.gid=b.id  where a.content like '%$keyword%'",15);
    		}else{
    		$dopage->GetPage("SELECT a.*,b.account,b.images,b.name,b.sex FROM $tbname a inner join pmw_guide b on a.gid=b.id",15);
    		}

		while($row = $dosql->GetArray())
		{
			$id=$row['id'];
			switch($row['sex'])
			{
				case 1:
					$sex = "<i title='男' style='font-size:16px;color: #3339;' class='fa fa-venus' aria-hidden='true'></i>";
					break;
				case 0:
					$sex = "<i title='女' style='font-size:16px;color: #3339;' class='fa fa-mercury' aria-hidden='true'></i>";
					break;

			}
			if($row['images']==""){
			$images="../templates/default/images/noimage.jpg";
		    }else{
      $images=$row['images'];
            }

			$freetime="";
			$content=json_decode($row['content'],true);
			foreach($content as $val){

				$freetime .=date("Y-m-d",$val)."&nbsp;&nbsp;&nbsp;&nbsp;";

				}
		?>
              <tr class="dataTr" align="left">
                <td height="110" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center"><?php echo $row['account']; ?></td>
                <td align="center"><div id="layer-photos-demo_<?php  echo $row['id'];?>" class="layer-photos-demo"> <img  width="100px;" layer-src="<?php echo $images;?>" style="cursor:pointer" onclick="message('<?php echo $row['id']; ?>');"  src="<?php echo $images;?>" alt="<?php echo $row['name']; ?>" /></div></td>
                <td align="center" class="num"><a href="guide.php?check=user&id=<?php echo $row['gid'];?>"><?php echo $row['name']; ?></a></td>
                <td align="center"><?php echo $sex; ?></td>
                <td align="center" class="num">

                  <?php echo $freetime;?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$row['addtime']);?></td>
                <td align="center">
      <?php if($adminlevel==1){ ?>
			<span class="nb"><a title="删除空闲日期" href="<?php echo $action;?>?action=del5&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
    <?php }else{ ?>
      <span class="nb"><i class="fa fa-trash-o" aria-hidden="true"></i></span> 
    <?php } ?>
    </td>
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
<script>
layui.use('laydate', function(){
  var laydate = layui.laydate;

 //日期范围选择
laydate.render({
  elem: '#keyword'
});

//初始赋值
laydate.render({
  elem: '#test19'
  ,value: '1989-10-14',
  ,isInitValue: true
});

});

</script>
</body>
</html>
