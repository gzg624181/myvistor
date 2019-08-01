<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>景区管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script>




function ChangeState(id,checkinfo){

   var url = "ticket_save.php?action=changestate&id="+id+"&checkinfo="+checkinfo;

	 window.location.href= url;

}

function checknum(id) {
  var url="allorder.php?id="+id+"&check=numsid";
  window.location.href=url;
}

function getpic(id){
	 var ajax_url='ticket_save.php?action=getpic&id='+id;
   //alert(ajax_url);
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
        ,content: "<div style='widht:750px;padding:25px; height:400px;line-height: 22px;text-align:center'>"+ data+"</div>"
        ,
      });
    } ,
	error:function(){
       alert('error');
    }
	});
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
$tbname="pmw_ticket";
$action="ticket_save.php";
$one=1;
$dosql->Execute("SELECT * FROM $tbname",$one);
$num=$dosql->GetTotalRow($one);
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />

<div class="topToolbar">
  <span class="title">景区列表管理：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload"><?php echo $cfg_reload;?></a>
</div>
<div class="toolbarTab" style="margin-bottom:5px;">
<form name="form" id="form" method="post" action="<?php echo $action;?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
  <tr align="left" class="head">
    <td width="3%" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
      <tr align="left" class="head">
        <td width="3%" height="88" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
          <tr align="left" class="head">
            <td width="3%" height="87" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
              <tr align="left" class="head" style="font-weight:bold;">
                <td width="1%" height="36" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
                <td width="15%" align="center">景区名称</td>
                <td width="11%" align="center">景区分类</td>
                <td width="11%" align="center">景区标签</td>
                <td width="9%" align="center">景区等级</td>
                <td width="6%" align="center">景区图片</td>
                <td width="9%" align="center">已售数量起始值</td>
                <td width="12%" align="center">发布时间</td>
                <td width="7%" aligin="center">票务统计(张）</td>
                <td width="7%" aligin="center">票务总金额</td>
								<td width="12%" aligin="center">操作</td>
                </tr>
              <?php

		$dopage->GetPage("SELECT a.*,b.title FROM $tbname a inner join pmw_ticketclass b on b.id=a.types",15);

		while($row = $dosql->GetArray())
		{
			$id=$row['id'];

	  if($row['checkinfo']==1){

			 $checkinfo ="<a href='javascript:void(0);' onclick=\"ChangeState('$id','1')\"><i style='color:#509ee1;cursor:pointer;'  title='已上线，点击进行下线操作' class='fa fa-arrow-up' aria-hidden='true'></i></a>";

		 }elseif($row['checkinfo']==0){

			 $checkinfo ="<a href='javascript:void(0);' onclick=\"ChangeState('$id','0')\"><i style='color:red;cursor:pointer;'  title='已下线，点击进行上线操作' class='fa fa-arrow-down' aria-hidden='true'></i></a>";

			}

		?>
              <tr class="dataTr" align="left">
                <td height="44" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center"><?php echo $row['names'];?></td>
                <td align="center"><?php echo $row['title'];?></td>
                <td align="center"><?php echo $row['label']; ?></td>
                <td align="center"><?php echo $row['level']; ?>星</td>
                <td align="center"><a style="cursor:pointer" onclick="getpic('<?php echo $id;?>');">点击查看</a></td>
                <td align="center"><?php echo $row['solds'];?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$row['posttime']);?>
                 </td>
                <td align="center" class="num" style="color:red; font-size:18px; cursor:pointer;"><span onclick="checknum('<?php echo $row['id'];?>');"><?php $arr=get_nums($row['id']);  echo $arr['nums'] ?></span></td>
                <td align="center" class="num" style="color:#3476cb; font-size:18px; cursor:pointer;"><span onclick="checknum('<?php echo $row['id'];?>');"><?php echo $arr['total'] ?></span></td>
								 <td align="center">
      <a title="点击添加票务规格" style="cursor:pointer"  href="specs_add.php?id=<?php echo $id;?>&lowmoney=<?php echo $row['lowmoney'];?>">
        <i class="fa fa-folder-open" aria-hidden="true"></i></a>&nbsp;
      <span><?php echo $checkinfo; ?></span> &nbsp;
 			<span><a title="编辑" href="scenic_update.php?id=<?php echo $row['id']; ?>">
 			<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span> &nbsp;
      <?php if($adminlevel==1){ ?>
 			<span class="nb"><a title="删除景区" href="<?php echo $action;?>?action=del6&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
      <?php }else{ ?>
      <span class="nb"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
     <?php  }?>
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
