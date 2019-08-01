<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>结算年份统计</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script type="text/javascript" src="layui/layui.js"></script>
<link href="layui/css/layui.css" rel="stylesheet" type="text/css" />

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
$tbname="pmw_travel";
$one=1;
$dosql->Execute("SELECT * FROM $tbname where aid=$id group by fabu_y",$one);
$num=$dosql->GetTotalRow($one);

$agency=get_agency($id);
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar">
<span class="title">结算年份统计：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload"><i class="fa fa-refresh fa-spin fa-fw"></i></a>
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
                <td width="11%" align="center">用户账号</td>
                <td width="13%" align="center">旅行社名称</td>
                <td width="13%" align="center">旅行社地址</td>
                <td width="8%" align="center">联系人姓名</td>
                <td width="8%" align="center">联系电话</td>
                <td width="11%" align="center">发布年份</td>
                <td width="11%" align="center">已发布行程</td>
                <td width="9%" align="center">已发布成功行程</td>
                <td width="9%" align="center">结算总额</td>
                <td width="6%" align="center">操作</td>
                </tr>
              <?php
      $arr= array_reverse(get_years($id));

      for($i=0;$i<count($arr);$i++){
		  $y=$arr[$i]['fabu_y'];
		  $checkinfo = "<a href='jiesuan_month.php?id={$id}&y={$y}'><i  style='color:#509ee1; cursor:pointer;' title='查看所有月份结算统计' class='fa fa-calendar-check-o' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;";
		?>
              <tr class="dataTr" align="left">
                <td height="110" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center" class="num"><?php echo $agency['account']; ?></td>
                <td align="center"><?php echo $agency['company']; ?></td>
                <td align="center"><?php echo $agency['address']; ?></td>
                <td align="center"><?php echo $agency['name']; ?></td>
                <td align="center" class="num"><?php echo $agency['tel']; ?></td>
                <td align="center" class="num" style="font-weight:bold; color:#0FAB53; font-size:18px;"><a style="color:red" href='jiesuan_month.php?id=<?php echo $id;?>&y=<?php echo $y;?>'><?php echo $y; ?></td>
                <td align="center" class="num" style="color:#13b497"><?php echo get_year($id,$y);?></td>
                <td align="center"   style="color:#509ee1;font-weight:bold;"  class="num"><?php  echo  success_xingcheng($id,$y);?></td>
                <td align="center"   style="font-weight:bold;"  class="num"><?php
                 $sum_year = sum_year($id,$y);
                 if($sum_year==""){
                   $sum_year=0;
                 }
                 echo  $sum_year;?></td>
                <td align="center">
                <span><?php echo $checkinfo;?></span></td>
              </tr>
              <?php  }?>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  </table>
</form>

<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('<?php echo $action;?>');" onclick="return ConfDelAll(0);">删除</a></span>
<div class="bottomToolbar" style="float:right;"> <a href="javascript:history.go(-1)" class="dataBtn">返回</a> </div>
</div>


</body>
</html>
