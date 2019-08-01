<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>开奖号码管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script>
function GetSearchs(){
var keyword= document.getElementById("keyword").value;
if($("#keyword").val() == "")
{
 layer.alert("请输入开奖期数！",{icon:0});
 $("#keyword").focus();
 return false;
}
window.location.href='lottery.php?keyword='+keyword;
}

</script>
<?php
//初始化参数
$keyword = isset($keyword) ? $keyword : '';

?>
</head>
<body>
<?php
$tomorrow=date("Y-m-d",strtotime("+1 day"));
//$tomorrow=date("Y-m-d",time());

$r=$dosql->GetOne("SELECT * FROM pmw_lotterynumber order by id desc;");
if(is_array($r)){
$kj_times=$r['kj_times'];
}
?>
<div class="topToolbar"> <span class="title">开奖号码管理</span>
  <a href="javascript:location.reload();" class="reload">刷新</a>

	<!--<a class="reload" style="float:right;width:100px;color:red;font-family: Verdana, Geneva, sans-serif;
font-weight: bold;" href="javascript:if(confirm('确定要生成开奖号码吗?'))location='lottery_save.php?date=<?php echo $tomorrow;?>&action=add&firsttimes=<?php // echo $kj_times;?>'">生成开奖号码</a>-->

</div>
<div class="toolbarTab" style="margin-bottom:-12px;">
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" style="font-size:11px;" placeholder="请输入开奖期数" title="请输入开奖期数" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="member_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr >
			<td width="2%" height="36" align="center" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="1%" align="center">ID</td>
			<td width="13%" align="center">开奖期数</td>
			<td width="12%" align="center">开奖时间</td>
			<td width="12%" align="center">开奖号码</td>
			<td width="11%" align="center">开奖类型</td>
			<td width="11%" align="center">开奖求和</td>
			<td width="10%" align="center">当前状态</td>
			<td width="9%" align="center">是否开奖</td>
			<td width="10%" align="center">生成日期</td>
			<td width="9%" align="center">操作</td>
		</tr>
		<?php
		if($keyword!=""){
	    $dopage->GetPage("SELECT * FROM `#@__lotterynumber` where kj_times='$keyword'");
		}else{
		$dopage->GetPage("SELECT * FROM `#@__lotterynumber`");
		}

		while($row = $dosql->GetArray())
		{
        $kj_state=$row['kj_state'];

		?>
		<tr align="left" class="dataTr">
			<td height="60" align="center" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="center"  class="number"><?php echo $row['id']; ?></td>
			<td align="center"  class="number"><?php echo $row['kj_times']; ?></td>
			<td align="center" class="number"><?php echo $row['kj_endtime']; ?></td>
			<td align="center" class="num" style="color:#990808"><?php echo $row['kj_number']; ?></td>
			<td align="center" class="number" style="font-weight:normal"><?php echo $row['kj_varchar']; ?></td>
			<td align="center" class="number" style="font-weight:normal"><?php echo $row['kj_he']; ?></td>
			<td align="center" class="number" style="font-weight:normal">
            <?php 
			$state=$row['state'];
			 if($state=="fp"){
				echo "封盘中"; 
			 }elseif($state=="kj"){
				echo "已开奖";
			 }else{
				echo "下注中"; 
			 }
			 ?>
            </td>
			<td align="center" class="number" style="font-weight:normal">
            <?php if($kj_state==0){echo "<font color='red'><b>未开奖</b></font>";}else{echo "<font color='#509ee1'><B>已开奖</b></font>";}?>
            </td>
			<td align="center" class="number" style="font-weight:normal"><?php echo $row['addtime']; ?></td>
			<td align="center">
			<span><a href="lottery_update.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o fa-fw" aria-hidden="true"></i></a></span>
			<span class="nb"><a href="lottery_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></span></td>
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
<div class="bottomToolbar"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('member_save.php');" onclick="return ConfDelAll(0);">删除</a></span>  </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('lottery_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <span class="pageSmall"> <?php echo $dopage->GetList(); ?> </span></div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
</body>
</html>
