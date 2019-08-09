<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>授权用户会员管理</title>
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
//设置授权用户为购票管理员，且只有一个售票管理员
function change_checkpost(id,checkpost,name) {


  if(checkpost==1){
  layer.confirm("确定禁止<span style='color:#38b41e;font-weight:bold'>"+name+"</span>发布动态的权限吗?", function () {
  window.location.href="admin_save.php?action=change_checkpost&id="+id+"&checkpost=1";
  }
)
  }else{
layer.confirm("确定允许<span style='color:#38b41e;font-weight:bold'>"+name+"</span>发布动态的权限吗?", function () {
  window.location.href="admin_save.php?action=change_checkpost&id="+id+"&checkpost=0";
  }
)

	  }
}

function sets(id,name) {
  layer.confirm("确定要设置<span style='color:#38b41e;font-weight:bold'>"+name+"</span>成管理员吗?", function () {
  window.location.href="admin_save.php?action=sets&id="+id;
  }
)
}


function change_vip(id) {

  layer.confirm("确定要给此用户添加VIP权限吗?", function () {
  window.location.href="admin_save.php?action=change_vip&id="+id;
  }
)
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
$check = isset($check) ? $check : '';
$username=$_SESSION['admin'];
$adminlevel=$_SESSION['adminlevel'];
$r=$dosql->GetOne("select * from pmw_admin where username='$username'");

?>
</head>
<body style="padding:10px;">
<?php
$tbname="pmw_members";
$one=1;
$dosql->Execute("SELECT * FROM $tbname",$one);
$num=$dosql->GetTotalRow($one);

?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar">
<span class="title">授权会员列表：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload"><?php echo $cfg_reload;?></a>
</div>
<div class="toolbarTab" style="margin-bottom:5px;">
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
                <td width="6%" align="center">用户昵称</td>
                <td width="7%" align="center">头像</td>
                <td width="10%" align="center">性别</td>
                <td width="10%" align="center">已发布动态</td>
                <td width="12%" align="center">已发布审核成功动态</td>
                <td width="12%" align="center">是否禁止权限</td>
                <td width="19%" align="center">授权时间</td>
                <td width="11%" align="center">是否是VIP</td>
                <td width="12%" align="center">设置联系管理员</td>
                </tr>
              <?php

		$dopage->GetPage("SELECT * from $tbname",15);

		while($row = $dosql->GetArray())
		{
			$id=$row['id'];

			switch($row['sex'])
			{

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


			switch($row['vip'])
						{
							case 1:
								$vip = "<i title='是'_ style='font-size:16px;color: blue; font-weight:bold;' class='fa fa-vimeo-square' aria-hidden='true'></i>";
								break;
							case 0:
								$vip = "<i onclick='change_vip({$row['id']})' title='否,点击给此用户添加vip权限' style='font-size:16px;color: red;font-weight:bold;cursor:pointer;' class='fa fa-vimeo' aria-hidden='true'></i>";
								break;

						}

			if($row['images']==""){
			$images="../templates/default/images/noimage.jpg";
		    }else{
            $images=$row['images'];
            }
		?>
              <tr class="dataTr" align="left">
                <td height="110" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center"><?php echo $row['nickname']; ?></td>
                <td align="center"><div id="layer-photos-demo_<?php  echo $row['id'];?>" class="layer-photos-demo"> <img  width="100px;" layer-src="<?php echo $images;?>" style="cursor:pointer" onclick="message('<?php echo $row['id']; ?>');"  src="<?php echo $images;?>" alt="<?php echo $row['nickname']; ?>" /></div></td>
                <td align="center" class="num"><?php echo $sex; ?></td>
                <td align="center" class="num" ><a style="color:#C3C" href="guide.php?check=openid&openid=<?php echo $row['openid'];?>"><?php

				  $openid=$row['openid'];

				  $two=2;

				  $dosql->Execute("SELECT * FROM pmw_publish where openid= '$openid'",$two);

				  $nums = $dosql->GetTotalRow($two);

				  echo $nums;
				  ?></a>
                </td>
                <td align="center" class="num" ><a style="color:#396" href="guide.php?check=openid_success&openid=<?php echo $row['openid'];?>"><?php

				  $three=3;

				  $dosql->Execute("SELECT * FROM pmw_publish where openid= '$openid' and checkinfo=1",$three);

				  $nums = $dosql->GetTotalRow($three);

				  echo $nums;
				  ?></a></td>
                <td align="center" class="num">
                <?php
				if($row['checkpost']==1){?>
				<i onclick="change_checkpost('<?php echo $row['id']; ?>','<?php echo $row['checkpost']; ?>','<?php echo $row['nickname']; ?>')"  title='点击将禁止用户权限' style='cursor:pointer;font-size:16px;color: blue; font-weight:bold;' class='fa fa-check-circle' aria-hidden='true'></i>
        <?php }else{?>
				<i  onclick="change_checkpost('<?php echo $row['id']; ?>','<?php echo $row['checkpost']; ?>','<?php echo $row['nickname']; ?>')"  title='点击将允许用户权限' style='font-size:16px;color: red; cursor:pointer; font-weight:bold;' class='fa fa-times-circle' aria-hidden='true'></i>
        <?php }?>
                </td>
                <td align="center" class="num"><?php echo date("Y-m-d H:i:s",$row['addtime']);?></td>
                <td align="center" class="num"><?php echo $vip;?></td>
                <?php if($row['sets']==0){?>
                <td align="center" class="num"><i style="cursor:pointer;" onclick="sets('<?php echo $row['id']; ?>','<?php echo $row['nickname']; ?>')" title="设为订票管理员" class="fa fa-star-o"></i></td>
                <?php }else{?>
                <td width="0%" align="center" class="num" style="color:blue"><i title="订票管理员" class="fa fa-star"></i></td>
                <?php } ?>
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
