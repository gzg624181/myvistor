<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 17:16:14
person: Feng
**************************
*/


//初始化参数pmw_ticketclass
$tbname = '#@__ticketclass';
$gourl  = 'ticket.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加景区分类

if($action=="add_ticket_class"){

  $icon = $cfg_weburl."/".$icon;

  $posttime=strtotime($posttime);

  $sql="INSERT INTO pmw_ticketclass (title,icon,posttime) VALUES ('$title','$icon',$posttime)";

  if($dosql->ExecNoneQuery($sql))
	{
    $gourl= "ticket_class.php";
		header("location:$gourl");
		exit();
	}
}
//修改导游信息
else if($action == 'update')
{

  if(!isset($picarr))        $picarr = '';
//合同组图
  if(is_array($picarr))
  {
    $picarrNum = count($picarr);
    $picarrTmp = '';

    for($i=0;$i< $picarrNum;$i++)
    {

      $picarrTmp[] =$picarr[$i].$picarr_txt[$i];

    }

    $picarr = json_encode($picarrTmp);
  }

  $ymdtime=substr($regtime,0,10);
  $regtime=strtotime($regtime);

  // if(!check_str($card,$cfg_weburl)){
  //   $card=$cfg_weburl."/".$card; //导游证件
  // }
  //
  // if(!check_str($images,$cfg_weburl)){
  //   $images=$cfg_weburl."/".$images; //导游头像
  // }

  if($password==""){ //密码不修改
    $sql = "UPDATE `$tbname` SET name='$name', agreement='$picarr', sex=$sex,card = '$card', cardnumber='$cardnumber', images='$images', content='$content',regtime=$regtime,ymdtime='$ymdtime' WHERE id=$id";
  }else{
    $password=md5(md5($password));
    $sql = "UPDATE `$tbname` SET name='$name',agreement='$picarr', sex=$sex,card = '$card', cardnumber='$cardnumber', images='$images', password='$password', content='$content',regtime=$regtime,ymdtime='$ymdtime' WHERE id=$id";
  }

	if($dosql->ExecNoneQuery($sql))
	{

		header("location:$gourl");
		exit();
	}
}
//ajax获取导游简介
else if($action == 'checkguide')
{
  if($type=="content"){
	$r=$dosql->GetOne("SELECT content FROM $tbname WHERE id=$id");
  $content = $r['content'];
  }elseif($type=="pics"){
  $r=$dosql->GetOne("SELECT pics,name FROM $tbname WHERE id=$id");
  $contents = $r['pics'];
  $content =  "<span style='font-size:14px;font-weight:bold;margin-bottom:10px;'>".$r['name']."--导游相册"."</span>";

  $arr=explode("|",$contents);
  for($i=0;$i<count($arr);$i++){
  $content .= "<img src='".$arr[$i]."' width=90% style='margin-top:17px;margin-bottom:8px;border-radius:3px;'><br>";
  }
  }elseif($type=="card"){
  $r=$dosql->GetOne("SELECT card,name FROM $tbname WHERE id=$id");
  $contents = $r['card'];
  $content =  "<span style='font-size:18px;font-weight:bold;margin-bottom:10px;'>".$r['name']."的导游证件"."</span>";
  $content .= "<img src='".$contents."' width=90% style='margin-top:17px;'>";
  }
	echo $content;
}

else if($action=="del5"){
//删除空闲时间
$dosql->ExecNoneQuery("DELETE FROM pmw_freetime WHERE id=$id");
$gourl="free_time.php";
header("location:$gourl");
exit();

}
else if($action=="del6"){
//删除景区
$dosql->ExecNoneQuery("DELETE FROM pmw_ticket WHERE id=$id");
$gourl="scenic.php";
header("location:$gourl");
exit();

}
else if($action=="add_ticket"){

  $posttime=strtotime($posttime);
  //文章组图
  if(is_array($picarr))
  {
    $picarrNum = count($picarr);
    $picarrTmp = '';

    for($i=0;$i<$picarrNum;$i++)
    {
      $picarrTmp[] = $picarr[$i].$picarr_txt[$i];
    }

    $picarr = json_encode($picarrTmp);
  }

  //文章属性
	if(is_array($flag))
	{
		$flag = implode(',',$flag);
	}


  // $content=stripslashes($content);
  // $content=rePic($content, $cfg_weburl);

  // $xuzhi=stripslashes($xuzhi);
  // $xuzhi=rePic($xuzhi, $cfg_weburl);

  $sql="INSERT INTO pmw_ticket (names,types,flag,label,remarks,level,picarr,solds,posttime,content,xuzhi,lowmoney) VALUES ('$names','$types','$flag','$label','$remarks',$level,'$picarr',$solds,$posttime,'$content','$xuzhi','$lowmoney')";

  if($dosql->ExecNoneQuery($sql))
  {
    $gourl= "scenic.php";
    header("location:$gourl");
    exit();
  }

}
//获取景区图片
else if($action == 'getpic')
{

  $tbname="pmw_ticket";
  $r=$dosql->GetOne("SELECT picarr,names FROM $tbname WHERE id=$id");
  $picarr = $r['picarr'];
  $name = $r['names'];
  $content =  "<span class='num' style='font-size:14px;font-weight:bold;margin-bottom:10px;'>".$name."--景区相册"."</span>";

    $arr =json_decode($picarr);
  //  $arr .=print_r($arr);
    for($i=0;$i<count($arr);$i++){
    $img = $cfg_weburl."/".$arr[$i];
    $content .= "<img src='".$img."' width=90% style='margin-top:17px;margin-bottom:8px;border-radius:3px;'><br>";
    }

  echo  $content;
  }

  //修改上线下线的操作
else if($action =="changestate"){

//上线操作
if($checkinfo==0){
$dosql->ExecNoneQuery("UPDATE pmw_ticket set checkinfo=1 WHERE id=$id");
//下线操作
}else if($checkinfo==1){
$dosql->ExecNoneQuery("UPDATE pmw_ticket set checkinfo=0 WHERE id=$id");
$gourl="scenic.php";
header("location:$gourl");
}
}
//添加票务规格
else if($action=="specs_add"){

  $randnumber=rand(11111111,9999999);
  $sql="INSERT INTO pmw_specs (names,tid,tickettype,normalmoney,randnumber) VALUES ('$names',$tid,'$tickettype','$lowmoney',$randnumber)";
  $dosql->ExecNoneQuery($sql);

  //更新这一条数据
  $k=$dosql->GetOne("SELECT id FROM pmw_specs where randnumber=$randnumber");
  $sid=$k['id'];

  $r=$dosql->GetOne("SELECT price FROM pmw_selectdate where timestamps=$selectdate and tid=$id");
  if(is_array($r)){
    //更新当前的价格
    $dosql->ExecNoneQuery("UPDATE pmw_selectdate SET price='$prices' where timestamps=$selectdate and tid=$id");
  }else{
    $datetimes = date("Y-m-d",$selectdate);
    $dosql->ExecNoneQuery("INSERT INTO pmw_selectdate (tid,sid,timestamps,datetimes,price) VALUES ($id,$sid,$selectdate,'$datetimes','$prices')");
  }

    $gourl= "specs_add.php?id=".$tid."&lowmoney=".$lowmoney;
    header("location:$gourl");
    exit();

}
//添加景区的规格类别
else if($action=="add_guige"){

  $randnumber=rand(11111111,9999999);

  $sql="INSERT INTO pmw_specs (names,tid,tickettype,normalmoney,randnumber) VALUES ('$names',$tid,'$tickettype','$lowmoney',$randnumber)";
  $dosql->ExecNoneQuery($sql);

  //更新这一条数据
  $k=$dosql->GetOne("SELECT id FROM pmw_specs where randnumber=$randnumber");
  $sid=$k['id'];

  add_default_price($tid,$sid,$lowmoney);

  $gourl= "specs_add.php?id=".$tid."&lowmoney=".$lowmoney;
  header("location:$gourl");
  exit();
}
else if($action=="del100"){

  $dosql->ExecNoneQuery("DELETE FROM pmw_specs WHERE id=$id");
  $gourl= "specs_add.php?id=".$tid."&lowmoney=".$lowmoney;
  header("location:$gourl");
  exit();

}else if($action=="specs_update"){

  $dosql->ExecNoneQuery("UPDATE pmw_specs SET tickettype='$tickettype',normalmoney='$normalmoney',resetmoney='$resetmoney' WHERE id=$id");
  $gourl= "specs_add.php?id=".$tid;
  header("location:$gourl");
  exit();

}else if($action=="update_ticket"){

  if(is_array($picarr))
  {
    $picarrNum = count($picarr);
    $picarrTmp = '';

    for($i=0;$i<$picarrNum;$i++)
    {

    $picarrTmp[] = $picarr[$i].$picarr_txt[$i];


    }

    $picarr = json_encode($picarrTmp);
  }

  if(is_array($flag))
	{
		$flag = implode(',',$flag);
	}

  $dosql->ExecNoneQuery("UPDATE pmw_ticket SET names='$names',types='$types',flag='$flag',lowmoney='$lowmoney',label='$label',remarks='$remarks',level=$level,picarr='$picarr',specs='$specs',content='$content1',xuzhi='$xuzhi',solds=$solds,content='$content' WHERE id=$id");
  $gourl= "scenic.php";
  header("location:$gourl");
  exit();

}
 else if($action=="update_ticket_class"){

   $dosql->ExecNoneQuery("UPDATE pmw_ticketclass SET title='$title',icon='$icon' WHERE id=$id");
   $gourl= "ticket_class.php";
   header("location:$gourl");
   exit();

 }
 else if($action=="searchdate"){

   $k=$dosql->GetOne("SELECT lowmoney FROM pmw_ticket where id=$id");
   $lowmoney=$k['lowmoney']; //最低价格

   $r=$dosql->GetOne("SELECT price FROM pmw_selectdate where timestamps=$selectdate and tid=$id");

   if(is_array($r)){
   $price=$r['price'];
   }else{
   $price= $lowmoney;
   }

   echo $price;
 }
 //修改票务规格的价格
 else if($action=="specs_update_price"){

   $dosql->ExecNoneQuery("UPDATE pmw_selectdate SET price='$price' WHERE id=$id");

   $r=$dosql->GetOne("SELECT * FROM pmw_selectdate where id=$id");

   $tid=$r['tid'];
   $sid=$r['sid'];
   $gourl= "specs_update_date.php?tid=".$tid."&sid=".$sid."&names=".$names."&tickettype=".$tickettype;
   header("location:$gourl");
   exit();
 }
//无条件返回
else
{
    header("location:$gourl");
	  exit();
}
?>
