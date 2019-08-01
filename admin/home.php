<?php	require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function(){
	//控制便签
	$("#homeNote").focus(function(){
		$(".notearea").addClass("borderOn");
		if($.trim($(this).val()) == "点击输入便签内容..."){
			$(this).val("");
		}
	}).blur(function(){
		$(".notearea").removeClass("borderOn");
		if($.trim($(this).val()) == ""){
			$.ajax({
				url : "ajax_do.php",
				type:'post',
				data:{"action":"deladminnotes"},
				dataType:'html',
				success:function(data){
				}
			});
			$(this).val("点击输入便签内容...");
		}else{
			$.ajax({
				url : "ajax_do.php",
				type:'post',
				data:{"action":"adminnotes", "body":$.trim($(this).val())},
				dataType:'html',
				success:function(data){
				}
			});
		}
	});

	$("#showad").html('<iframe src="showad.php" width="100%" height="25" scrolling="no" frameborder="0" allowtransparency="true"></iframe>');
});
</script>
<style>
.fon{
	font-size:16px;
	color:white;
	vertical-align:bottom;
	padding-bottom:8px;
    font-family: "微软雅黑",Arial,"宋体";
	text-align: center;
	}
.ziti{
	font-size: x-large;
	color: white;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
	text-align: center;
	}
.tor{
	font-size:12px;
	color:white;
    font-family: "微软雅黑",Arial,"宋体";
	text-align: center;
	}
a:hover {
    text-decoration: none;
    color: red;
    font-weight: bold;
}
</style>
</head>
<body>
<div class="homeHeader" style="margin-bottom:10px;">
	<div class="header"  style="margin-bottom: -40px;"><a href="javascript:location.reload();" class="reload"><i class="fa fa-refresh fa-spin fa-fw"></i></a></div>
<div class="news">
		<div class="title"></div >
		<div style=" margin-top:-6px;">欢迎&nbsp;<font color="red"><b><?php echo $_SESSION['admin'];?></b></font>&nbsp;进入<?php echo $cfg_webname?>!</div>
	</div>
</div>
<table width="100%" style="background-image:url(templates/images/bg1.jpg); height:200px; margin-bottom:25px;border-radius: 3px;" >
  <tr>
    <td width="27%" height="53" class="fon" style="text-align: center">今日下注订单</td>
    <td width="29%" class="fon" style="text-align: center">今日支付总额</td>
    <td width="22%" class="fon" style="text-align: center">今日注册会员</td>
    <td width="2%" style="text-align: center">&nbsp;</td>
    <td width="20%" class="fon" style="text-align: center">今日动态发布</td>
  </tr>
    <tr>
    <td width="27%" height="32" class="ziti" style="text-align: center;"><a style=" color:white;" href="allorder.php?check=today"><?php
				$starttime =strtotime(date("Y-m-d"));
                $endtime = strtotime(date("Y-m-d",time()+24*3600));
				$dosql->Execute("SELECT id from pmw_order where pay_time >=$starttime and pay_time<$endtime");
				$num=$dosql->GetTotalRow();
				echo $num;
					?></a></td>
    <td class="ziti" style="text-align: center"><a style="color:white;"href="allorder.php?check=today_zhiufu"><?php

					$r=$dosql->GetOne("SELECT SUM(paymoney) as money from pmw_order where pay_time >=$starttime and pay_time<$endtime and pay_state=1");
					$money=$r['money'];
					if($money==null){
						echo 0;
					}else{
					echo sprintf("%.2f",$money);
				  }
					?></a></td>
    <td class="ziti" style="text-align: center"><a style="color:white;" href="agency.php?check=today"><?php
					$dosql->Execute("SELECT id from pmw_members where addtime >=$starttime and addtime < $endtime");
					$num=$dosql->GetTotalRow();
					if($num==0){
					echo $num;
						}else{
					echo "<font color='red'>".$num."</font>";
						}
					?></a></td>
    <td style="text-align: center">&nbsp;</td>
    <td class="ziti" style="text-align: center"><a style="color:white;" href="member.php?check=today"><?php
		$dosql->Execute("SELECT id from pmw_publish where addtime >=$starttime and addtime < $endtime");
		$num=$dosql->GetTotalRow();
		if($num==0){
		echo $num;
			}else{
		echo "<font color='red'>".$num."</font>";
			}
					?></a></td>
  </tr>
  <tr>
    <td width="27%" height="20" class="tor" style="text-align: center">昨日：<a style="color:white;" href="allorder.php?check=tomorrowdingdan"><?php
				$starttime =strtotime(date("Y-m-d",time()-24*3600));
        $endtime = strtotime(date("Y-m-d"));
				$dosql->Execute("SELECT id from pmw_order where pay_time >=$starttime and pay_time<$endtime");
				$num=$dosql->GetTotalRow();
				echo $num;
					?></a></td>
    <td style="text-align: center"><span class="tor">昨日：<a style="color:white;" href="allorder.php?check=tomorrow_zhifu"><?php
		$r=$dosql->GetOne("SELECT SUM(paymoney) as money from pmw_order where pay_time >=$starttime and pay_time<$endtime and pay_state=1");
		$money=$r['money'];
		if($money==null){
			echo 0;
		}else{
		echo sprintf("%.2f",$money);
		}
					?></a></span></td>
    <td style="text-align: center"><span class="tor">昨日发布：<a style="color:white;" href="agency.php?check=tomorrow"><?php
		$dosql->Execute("SELECT id from pmw_members where addtime >=$starttime and addtime < $endtime");
		$num=$dosql->GetTotalRow();
		if($num==0){
		echo $num;
			}else{
		echo "<font color='red'>".$num."</font>";
			}
					?></a></span></td>
    <td style="text-align: center">&nbsp;</td>
    <td style="text-align: center"><span class="tor">昨日注册：<a style="color:white;" href="guide.php?check=tomorrow"><?php
					$time=date("Y-m-d",strtotime("-1 day"));
					$dosql->Execute("SELECT * from pmw_publish where addtime >=$starttime and addtime < $endtime");
					$num=$dosql->GetTotalRow();
					echo $num;
					?></a></span></td>
  </tr>
    <tr>
    <td width="27%" height="34" style="text-align: center">&nbsp;</td>
    <td style="text-align: center">&nbsp;</td>
    <td style="text-align: center">&nbsp;</td>
    <td style="text-align: center">&nbsp;</td>
    <td style="text-align: center">&nbsp;</td>
  </tr>
</table>
<div class="homeCont">
	<div class="leftArea">

		<div class="site">
			<h2 class="title">系统</h2>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" colspan="2">软件版本号： <span title="<?php echo $cfg_vertime; ?>"><?php echo $cfg_vernum; ?></span></td>
				</tr>
				<tr>
					<td width="50%" height="33">服务器版本： <span title="<?php echo $_SERVER['SERVER_SOFTWARE']; ?>"><?php echo ReStrLen($_SERVER['SERVER_SOFTWARE'],7,''); ?></span></td>
					<td width="50%">操作系统： <?php echo PHP_OS; ?></td>
				</tr>
				<tr>
					<td height="33">PHP版本号： <?php echo PHP_VERSION; ?></td>
					<td>GDLibrary： <?php echo ShowResult(function_exists('imageline')); ?></td>
				</tr>
				<tr>
					<td height="33">MySql版本： <?php echo $dosql->GetVersion(); ?></td>
					<td height="28">ZEND支持： <?php echo ShowResult(function_exists('zend_version')); ?></td>
				</tr>
				<tr class="nb">
					<td height="33" colspan="2">支持上传的最大文件：<?php echo ini_get('upload_max_filesize'); ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="rightArea" style="float:left;">

		<div class="count">
			<h2 class="title">快捷<span><a href="lnk.php">更多&gt;&gt;</a></span>&nbsp;&nbsp;</h2>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <?php
				$dosql->Execute("SELECT * FROM `#@__lnk` ORDER BY orderid ASC LIMIT 0, 8");
				while($row = $dosql->GetArray())
				{
					?>
			  <tr>
					<td width="85" height="33">
                <a href="<?php echo $row['lnklink'];?>" class="lnk"><img src="<?php echo $row['lnkico'];?>">&nbsp;&nbsp;<?php echo $row['lnkname'];?></a></td>

			  </tr>
              <?php }?>
		  </table>
		</div>
	</div>

    <div  style="float:right">

		<div class="count">
			<h2 class="title">日志<span><a href="sysevent.php">更多&gt;&gt;</a></span></h2>
				<div class="homeEvent" style="height:135px;">
            	<ul>
				<?php
				$sql = "SELECT * FROM `#@__sysevent` ORDER BY `id` DESC LIMIT 0,5";

				$dosql->Execute($sql);
				while($row = $dosql->GetArray())
				{
					$ip=$row['ip'];
					$r = $dosql->GetOne("SELECT `sitename` FROM `#@__site` WHERE `id`=".$row['siteid']);
					if(empty($r)) $r['sitename'] = '未知站点';

					if($row['model'] == 'login')
					{
				?>
				<li><?php echo MyDate('m-d H:i',$row['posttime']); ?>：用户 <strong><?php echo $row['uname']; ?></strong> 进行了 <span class="blue">登录操作</span> <span style="float:right; font-size:10px; color:#C9C0C2;"> [<?php  echo $ip;?>]</span> </li>
				<?php
					}

					else if($row['model'] == 'logout')
					{
				?>
				<li> <?php echo MyDate('m-d H:i',$row['posttime']); ?>：用户 <strong><?php echo $row['uname']; ?></strong> 进行了 <span class="blue">退出操作</span> <span style="float:right; font-size:10px; color:#C9C0C2;"> [<?php  echo $ip;?>]</span> </li>
				<?php
					}
					else if($row['classid'] != 0)
					{
						$r2 = $dosql->GetOne("SELECT `classname` FROM `#@__infoclass` WHERE `id`=".$row['classid']);

						if($row['action'] == 'add')
							$action = '添加';
						else if($row['action'] == 'update')
							$action = '修改';
						else if($row['action'] == 'del')
							$action = '删除';
						else
							$action = '';
				?>
				<li><?php echo MyDate('m-d H:i',$row['posttime']); ?>：用户 <strong><?php echo $row['uname']; ?></strong> 在 <span class="maroon2"><?php echo $r['sitename']; ?></span> <?php echo $action; ?>了 <span class="blue"><?php echo $r2['classname']; ?></span></li>
				<?php
					}
					else
					{
				?>
				<li> <?php echo MyDate('m-d H:i',$row['posttime']); ?>：用户 <strong><?php echo $row['uname']; ?></strong> 在 <span class="maroon2"><?php echo $r['sitename']; ?></span> 操作了 <span class="blue"><?php echo $row['model']; ?></span><span style="float:right; font-size:10px; color:#C9C0C2; "> [<?php  echo $ip;?>]</span></li>
				<?php
					}
				}
				?>
			</ul>

		 </div>
		</div>
	</div>
	<div class="cl"></div>
</div>
<?php
date_default_timezone_set('PRC');
$dates2="";

$dosql->Execute("SELECT *,sum(paymoney) as money,sum(nums) as nums from `pmw_order` where pay_state=1 group by ymd asc limit 15");
while($row=$dosql->GetArray()){
      $pv[] = floatval($row['money']);//购买金额  //注意这里必须要用intval强制转换，不然图表不能显示
	  $tz[] = floatval($row['nums']);
	  $dates2.="'".$row['ymd']."',";
}
$data = array(
array(
"name"=>"购票金额(元)",
"data"=>$pv)
,
array(
"name"=>"购买次数",
"data"=>$tz
)
);
$data = json_encode($data);    //把获取的数据对象转换成json格式

?>

<script type="text/javascript" src="public/jquery-1.8.2.min.js"></script>
<script src="public/highcharts.js"></script>
<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            title: {
                text: '<?php echo $cfg_webname;?>'+ "15天购票金额,购票数量统计表",
                x: -20 //center
            },
            subtitle: {
                text: '来源:<?php echo $cfg_weburl;?>',
                x: -20
            },
            xAxis: {
              //  categories: ['周一', '周二', '周三', '周四', '周五', '周六','周日']
				categories: [<?php echo rtrim($dates2,",");?>]
            },
            yAxis: {
                title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '元'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series:<?php echo $data?>
        });
    });
</script>
<div class="homeTeam">
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>
<div class="homeNote">
	<h2 class="title">记事</h2>
	<div class="notearea">
		<textarea name="homeNote" id="homeNote"><?php
		$uname    = $_SESSION['admin'];
		$posttime = time();
		$postip   = GetIP();

		$r = $dosql->GetOne("SELECT `body` FROM `#@__adminnotes` WHERE uname='$uname'");
		if(isset($r['body']))
			echo trim($r['body']);
		else
			echo '点击输入便签内容...';
		?></textarea>
	</div>
</div>
<div class="homeCopy"> 敬请您将在使用中发现的问题或者不适提交给我们，以便改进 <a target="_blank" class="feedback">点击提交反馈</a> | <a href="help.php" class="doc">开发帮助</a> </div>
<?php
function ShowResult($revalue)
{
	if($revalue == 1)
		return '<span class="ture">支持</span>';
	else
		return '<span class="flase">不支持</span>';
}
function address($ip){
  $ipContent   =  file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
  $jsonAddress = json_decode($ipContent,true);
  if($jsonAddress['code']==0){
      return $jsonAddress['data']['country']."-".$jsonAddress['data']['region']."-".$jsonAddress['data']['city'];
    }else{
      return "地址未知";
    }
}
?>

</body>
</html>
