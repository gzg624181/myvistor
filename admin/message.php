<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>消息列表管理</title>
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

function checkmessage(id){
	 var ajax_url='message_save.php?action=checkmessage&id='+id;
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
        ,content: "<div style='widht:750px;padding:25px; height:400px;line-height: 22px;text-align:center; '>"+ data+"</div>"
        ,
      });
    } ,
	error:function(){
       alert('error');
    }
	});
	}


//审核，未审，功能
  function checkinfo(key){
     var v= key;
	// alert(v)
	window.location.href='message.php?check='+v;
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
$tbname="pmw_message";
$action="message_save.php";
$one=1;
$dosql->Execute("SELECT * FROM $tbname",$one);
$num=$dosql->GetTotalRow($one);
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar">
<span class="title">消息列表合计：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload"><i class="fa fa-refresh fa-spin fa-fw"></i></a>
</div>
<div class="toolbarTab" style="margin-bottom:5px;">
<ul>
 <li class="<?php if($check==""){echo "on";}?>"><a href="message.php">全部</a></li> 
 <li class="line">-</li>
 <li class="<?php if($check=="agency"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('agency')">旅行社消息&nbsp;&nbsp;<i style='color:#45b5b3; cursor:pointer;' title='旅行社消息' class='fa fa-university' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="guide"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('guide')">导游消息&nbsp;&nbsp;<i style='color:#e079a3; cursor:pointer;' title='导游消息' class='fa fa-flag-o' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="system"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('system')">系统消息&nbsp;&nbsp;<i style='color:#509ee1; cursor:pointer;' title='系统消息' class='fa fa-desktop' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="template"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('template')">模板消息&nbsp;&nbsp;<i style='color:red;cursor:pointer;'  title='模板消息' class='fa fa-clipboard' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="reg"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('reg')">账号注册成功提醒&nbsp;&nbsp;<i style='color:#0007ff; cursor:pointer;' title='账号注册成功提醒' class='fa fa-check' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="cancel"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('cancel')">取消行程&nbsp;&nbsp;<i style='color:red; cursor:pointer;' title='取消行程' class='fa fa-chain-broken' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="appointement"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('appointement')">预约行程&nbsp;&nbsp;<i style='color:#e608f8; cursor:pointer;' title='预约行程' class='fa fa-plug' aria-hidden='true'></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="onread"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('onread')">已读&nbsp;&nbsp;<i style='color:#509ee1; cursor:pointer;' title='已读' class='fa fa-dot-circle-o' aria-hidden='true'></i></a></li>
  <li class="line">-</li>
 <li class="<?php if($check=="unread"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('unread')">未读&nbsp;&nbsp;<i style='color:red; cursor:pointer;' title='未读' class='fa  fa-circle-o' aria-hidden='true'></i></a></li>
</ul>
<!--	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" style="font-size:11px;" placeholder="请输入用户账号" title="请输入用户账号" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>-->
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
                <td width="8%" align="center">用户账号</td>
                <td width="8%" align="center">会员类型</td>
                <td width="6%" align="center">消息类型</td>
                <td width="11%" align="center">模板消息分类</td>
                <td width="12%" align="center">消息小标题</td>
                <td width="20%" align="center">消息标题</td>
                <td width="10%" align="center">消息内容</td>
                <td width="11%" align="center">发布时间</td>
                <td width="8%" align="center">已读状态</td>
                <td width="5%" align="center">操作</td>
                </tr>
              <?php
		if($check=="agency"){
	    //旅行社消息
		$dopage->GetPage("select * from $tbname where type = 'agency'",15);
	    }elseif($check=="guide"){ //导游
		$dopage->GetPage("select * from $tbname where type = 'guide'",15);
	    }elseif($check=="system"){ //系统消息
		$dopage->GetPage("select * from $tbname where messagetype ='system'",15);
	    }elseif($check=="template"){ //模板消息
		$dopage->GetPage("select * from $tbname where messagetype = 'template'",15);
	    }elseif($check=="cancel"){ //取消行程
		$dopage->GetPage("select * from $tbname where templatetype = 'cancel'",15);
	    }elseif($check=="appointement"){ //预约行程
		$dopage->GetPage("select * from $tbname where templatetype = 'appointement'",15);
	    }elseif($check=="reg"){ //注册成功
		$dopage->GetPage("select * from $tbname where templatetype = 'reg'",15);
	    }elseif($check=="onread"){ //已读
		$dopage->GetPage("select * from $tbname where state = 1",15);
	    }elseif($check=="unread"){ //未读
		$dopage->GetPage("select * from $tbname where state = 0",15);
	    }
		elseif($keyword!=""){ //关键字搜索
	    $dopage->GetPage("SELECT * FROM $tbname where account like '%$keyword%' or name  like '%$keyword%' ",15);
		}else{
		$dopage->GetPage("SELECT * FROM $tbname",15);
		}



		while($row = $dosql->GetArray())
		{
			

			if($row['state']==0){

		 $state = "<i style='color:red; cursor:pointer;' title='未读' class='fa fa-circle-o' aria-hidden='true'></i>";

			}elseif($row['state']==1){

		$state = "<i style='color:#509ee1; cursor:pointer;' title='已读' class='fa fa-dot-circle-o' aria-hidden='true'></i>";

			}
			
			$id=$row['mid'];
			
			$type = $row['type'];
			
			$messagetype = $row['messagetype'];
			
			$templatetype =$row['templatetype'];
			
			switch($type){
				
				case 'agency':
				$r=$dosql->GetOne("SELECT account from pmw_agency where id=$id");
				$account=$r['account'];
				$type = '旅行社';
				break;
				
				case 'guide':
				$r=$dosql->GetOne("SELECT account from pmw_guide where id=$id");
				$account=$r['account'];
				$type = '导游';
				break;
			}
			switch ($messagetype){
				
				case 'system':
				$messagetype = '系统消息';
				break;
				
				case 'template':
				$messagetype='模板消息';
				break;
			}
			
		    switch ($templatetype){
				
				case 'cancel':
				$templatetype = '取消行程';
				break;
				
				case 'appointment':
				$templatetype='预约行程';
				break;
				
			    case 'reg':
				$templatetype='注册成功';
				break;
				
				case '':
				$templatetype ='<i class="fa fa-minus-circle" aria-hidden="true"></i>';
				break;
			}

		?>
              <tr class="dataTr" align="left">
                <td height="110" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center"><?php echo $account; ?></td>
                <td align="center"><?php echo $type;?></td>
                <td align="center"><?php echo $messagetype; ?></td>
                <td align="center"><?php echo $templatetype;?></td>
                <td align="center"><?php echo $row['stitle']; ?></td>
                <td align="center"><?php echo $row['title']; ?></td>
                <td align="center"><a style="cursor:pointer;" onclick="checkmessage('<?php echo $row['id'];?>')">点击查看</a></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$row['faxtime']);?></td>
                <td align="center" class="num"><?php echo $state;?></td>
                <td align="center">
			<span class="nb"><a title="删除" href="<?php echo $action;?>?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span></td>
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
