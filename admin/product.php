<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>游戏列表管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/listajax.js"></script>
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<script>
function fn(id){
      if(layer.confirm("您确定要上线这个游戏吗?")){
        var ajax_url='product_save.php?action=getup&id='+id;
  //alert(ajax_url);
	$.ajax({
    url:ajax_url,
    type:'get',
	  data: "data" ,
	dataType:'html',
    success:function(data){
   document.getElementById("sj_"+id).innerHTML = data;
   window.location.reload()
    } ,
	error:function(){
       alert('error');
    }
	});
      }
}
function fd(id){
      if(layer.confirm("您确定要下线这个游戏吗?")){
     var ajax_url='product_save.php?action=getdown&id='+id;

  // alert(ajax_url);
	$.ajax({
    url:ajax_url,
    type:'get',
	data: "data" ,
	dataType:'html',
    success:function(data){
     document.getElementById("sj_"+id).innerHTML = data;
	 window.location.reload()
    } ,
	error:function(){
       alert('error');
    }
	});
      }
}
//审核，未审，功能
  function checkinfo(key){
     var v= key;
	// alert(v)
	window.location.href='product.php?check='+v;
	}
//标题搜索
   function GetSearchs(){
	 var keyword= document.getElementById("keyword").value;
	if($("#keyword").val() == "")
	{
		alert("请输入搜索内容！");
		$("#keyword").focus();
		return false;
	}
  window.location.href='product.php?keyword='+keyword;
}
function message(Id){
 //  alert(Id);
   layer.ready(function(){ //为了layer.ext.js加载完毕再执行
   layer.photos({
    photos: '#layer-photos-demo_'+Id,
	//area:['500px','300px'],  //图片的宽度和高度
    shift: 0 ,//0-6的选择，指定弹出图片动画类型，默认随机
	closeBtn:1,
	offset:'40px',  //离上方的距离
	shadeClose:true
  });
});
}
function checkcontent(id){
	 var ajax_url='game_save.php?action=checkcontent&id='+id;
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
        ,id: 'LAY_layuipros' //设定一个id，防止重复弹出
        ,btn: ['点击关闭']
        ,btnAlign: 'c'
        ,moveType: 1 //拖拽模式，0或者1
        ,content: "<div style='widht:750px;padding:25px; height:400px;line-height: 22px;'>"+ data+"</div>"
        ,
      });
    } ,
	error:function(){
       alert('error');
    }
	});
	}
</script>
</head>
<body>

<?php
//初始化参数
$action  = isset($action)  ? $action  : '';
$keyword = isset($keyword) ? $keyword : '';
$check = isset($check) ? $check : '';

?>
<div class="topToolbar"> <span class="title">游戏列表管理</span>
<a href="javascript:location.reload();" class="reload">刷新</a>
<!--<a onClick="return confirm('确认更新所有商品缓存？');"   style="width:100px; color:#e44410;font-weight: bold;" href="product_save.php?action=update_cache" class="reload">更新商品缓存</a>-->
</div>
<div class="toolbarTab">
	<ul>
 <li class="<?php if($check==""){echo "on";}?>"><a href="product.php">全部</a></li> <li class="line">-</li>
 <li class="<?php if($check=="alltrue"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('alltrue')">已上线</a></li> <li class="line">-</li>
 <li class="<?php if($check=="allnull_1"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('allnull_1')">维护中</a></li>
	</ul>
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" placeholder="请输入游戏名进行搜索" title="请输入游戏名进行搜索" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="product_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="1%" height="36" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="4%" align="center">图片</td>
			<td width="7%" align="left">游戏简称</td>
			<td width="10%" align="center">游戏名</td>
			<td width="15%" align="center">游戏分类名称</td>
			<td width="9%" align="center">直属下线提成比例</td>
			<td width="9%" align="center">二级下线提成比例</td>
			<td width="22%" align="center">游戏赔率说明</td>
			<td width="5%" align="center">在线人数</td>
			<td width="5%" align="center">是否在线</td>
			<td width="10%" align="center">创建时间</td>
			<td width="3%" align="center">操作</td>
		</tr>
		<?php
		$username=$_SESSION['admin'];
		$adminlevel=$_SESSION['adminlevel'];
		 if($check=="alltrue"){
		$dopage->GetPage("SELECT * FROM `pmw_game` where gameonline=1",10);
		  }elseif($check=="allnull_1"){
		$dopage->GetPage("SELECT * FROM `pmw_game` where gameonline=0",10);
		  }elseif($keyword!=""){
		$dopage->GetPage("SELECT * FROM `pmw_game` where gametypes like '%$keyword%' OR gamename like '%$keyword%' ",10);
		  }else{
		$dopage->GetPage("SELECT * FROM `pmw_game`",10);
		  }
		while($row = $dosql->GetArray())
		{


			switch($row['gameonline']){

				case 0:
					$gameonline= "<i class='fa fa-times' aria-hidden='true'></i>";
					break;
				case 1:
					$gameonline= "<i class='fa fa-check' aria-hidden='true'></i>";
					break;
				default:
        $gameonline = '暂无分类';

				}
		?>
		<tr align="left" class="dataTr">
			<td height="50" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="center">
   <div id="layer-photos-demo_<?php echo $row['id'];?>" class="layer-photos-demo">
   <input type="hidden" id="id" value="<?php echo $row['id'];?>" />
     <img  width="70px" height="70px" layer-src="<?php echo $row['gamepic']; ?>" style="cursor:pointer" onclick="message('<?php echo $row['id']; ?>');"  src="<?php echo $row['gamepic']; ?>" alt="<?php echo $row['gamename']; ?>" />
       </div>
            </td>
			<td align="center"><?php echo $row['game']; ?></td>
			<td align="center" class="num"><?php echo $row['gamename']; ?></td>
			<td align="center"><?php echo $row['gametypes']; ?></td>
			<td align="center" class="num" style="color:#529ee0"><?php echo $row['zsticheng']; ?></td>
			<td align="center" class="num" style="color:#529ee0"><?php echo $row['ejticheng']; ?></td>
			<td align="center"><a style="cursor:pointer;" onclick="checkcontent('<?php echo $row['id'];?>');">点击查看游戏赔率说明</a></td>
			<td align="center"><?php echo $row['gamenumber']; ?></td>
			<td align="center" id="sj_<?php echo $row['id'];?>"><?php
			if($row['gameonline']==1){
			echo "<font color='#339933'><B>"."<i class='fa fa-check' aria-hidden='true'></i>"."</b></font>";
			}else{
			echo "<font color='#FF0000'><B>"."<i class='fa fa-times' aria-hidden='true'></i>"."</b></font>";
			}
			?></td>
			<td align="center"><span class="number"><?php echo date("Y-m-d H:i:s",$row['gametime']); ?></span></td>
			<td align="center">
 <div id="jsddm"><a title="删除" href="product_save.php?action=del3&id=<?php echo $row['id'];?>" onclick="return ConfDel(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
            <div id="jsddm"><a title="编辑" href="product_update.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></div>
            <div id="jsddm"><a href="javascript:fn('<?php echo $row['id']; ?>')" title="点击进行上线操作"><i class="fa fa-caret-square-o-up" aria-hidden="true"></i></a></div>
            <div id="jsddm"><a href="javascript:fd('<?php echo $row['id']; ?>')" title="点击进行下线操作"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></i></a></div>
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
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('product_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <a href="product_add.php" class="dataBtn">新增游戏</a> </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php
//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea">
        <a href="product_add.php" class="dataBtn">新增游戏</a> <span class="pageSmall"><?php echo $dopage->GetList(); ?></span>
        </div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
</body>
</html>
