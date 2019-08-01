<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>账户明细</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script>
//已付订单，未付订单，搜索
  function checkinfo(key){
     var v= key;
	// alert(v)
	window.location.href='allorder_sh.php?check='+v;
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
  window.location.href='allorder_sh.php?keyword='+keyword;
}

   function chargeorder(chargeorder,types){
	   
	   layer.open({
		   type:2,
		   title:'',
		   maxmin:true,
		   shadeClose:true,
		   area : ['480px' , '380px'],
           content: 'chargeorder.php?types='+types+'&chargeorder='+chargeorder, 
	   });
	   
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
$one=1;
$dosql->Execute("SELECT * FROM `#@__record`",$one);
$num=$dosql->GetTotalRow($one);
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title">账单合计：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<div class="toolbarTab">
	<ul>
 <li class="<?php if($check==""){echo "on";}?>"><a href="allorder_sh.php">全部</a></li> <li class="line">-</li> 
 <li class="<?php if($check=="charge"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('charge')">充值</a></li> <li class="line">-</li> 
 <li class="<?php if($check=="back_money"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('back_money')">提现</a></li>
 <li class="line">-</li> 
 <li class="<?php if($check=="fanshui"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('fanshui')">返水</a></li>
	</ul>
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" placeholder="请输入会员账号或昵称进行搜索" title="请输入会员账号或昵称进行搜索" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="member_save.php">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
  <tr align="left" class="head">
    <td width="3%" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
      <tr align="left" class="head">
        <td width="3%" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
          <tr align="left" class="head">
            <td width="3%" height="99" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
              <tr align="left" class="head" style="font-weight:bold;">
                <td width="1%" height="36" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
                <td width="7%" align="center">用户账号</td>
                <td width="16%" align="center">昵称</td>
                <td width="18%" align="center">账单类型</td>
                <td width="21%" align="center">订单号</td>
                <td width="24%" align="center">账单金额</td>
                <td width="8%" align="center">时间</td>
                <td width="5%" align="center">操作</td>
              </tr>
              <?php
		if($check=="charge"){
		$dopage->GetPage("select a.*,b.telephone,b.nickname from `pmw_record` a inner join `pmw_members` b on a.mid=b.id  where a.types='recharge'",15);
	    }elseif($check=="back_money"){
		$dopage->GetPage("select a.*,b.telephone,b.nickname from `pmw_record` a inner join `pmw_members` b on a.mid=b.id  where a.types='take_money'",15);
		}elseif($check=="fanshui"){
		$dopage->GetPage("select a.*,b.telephone,b.nickname from `pmw_record` a inner join `pmw_members` b on a.mid=b.id  where a.types='back_money'",15);
	    }elseif($keyword!=""){
	    $dopage->GetPage("SELECT a.*,b.telephone,b.nickname FROM `pmw_record` a inner join `pmw_members` b on a.mid=b.id where b.telephone like '%$keyword%' or b.nickname like '%$keyword%'",15);
		}else{
		$dopage->GetPage("SELECT a.*,b.telephone,b.nickname FROM `pmw_record` a inner join `pmw_members` b on a.mid=b.id",15);
		}

		while($row = $dosql->GetArray())
		{
			switch($row['types'])
			{
				case 'recharge':
					$types = "<i style='font-size:16px;color: #3339;' class='fa fa-sign-in' aria-hidden='true'></i>";
					$types.="&nbsp;&nbsp;[充值]";
					break;
				case 'take_money':
					$types = "<i style='font-size:16px;color: #3339;' class='fa fa-dollar' aria-hidden='true'></i>";
					$types.="&nbsp;&nbsp;[提现]";
					break;
				case 'fanshui':
				    $types = "<i style='font-size:16px;color: #3339;' class='fa fa-undo' aria-hidden='true'></i>";
					$types.="&nbsp;&nbsp;[返水]";
				case 'ticheng':
				    $types = "<i style='font-size:16px;color: #3339;' class='fa fa-strikethrough' aria-hidden='true'></i>";
					$types.="&nbsp;&nbsp;[提成]";    

			}
		?>
              <tr class="dataTr" align="left">
                <td height="56" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center"><?php echo $row['telephone']; ?></td>
                <td align="center"><?php echo $row['nickname']; ?></td>
                <td align="center" class="num"><?php echo $types; ?></td>
                <td align="center" class="num" title="查看订单详情"><span style="cursor:pointer" onclick="chargeorder('<?php echo $row['chargeorder']; ?>','<?php echo $row['types']; ?>')"><?php echo $row['chargeorder']; ?></span></td>
                <td align="center" class="num"><?php echo sprintf("%.2f",$row['money_list']); ?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$row['time_list']);?></td>
                <td colspan="2" align="center">
                  <div style="margin-top: 6px;margin-bottom: 8px;"><a title="删除" href="member_save.php?action=del3&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></div></td>
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

//

if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"><span class="selArea"><span>选择：</span>
<a href="javascript:CheckAll(true);">全部</a> -
<a href="javascript:CheckAll(false);">无</a> -
<a href="javascript:DelAllNone('member_save.php');" onclick="return  ConfDelAll(0);">删除</a></span></div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('member_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <span class="pageSmall"> <?php echo $dopage->GetList(); ?></a> </span></div>
		<div class="quickAreaBg"></div>
	</div>

	</div>
<?php
}
?>

</body>
</html>
