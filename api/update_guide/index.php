<?php
    /**
	   * 链接地址：update_guide  更改导游个人资料
	   *
     * 下面直接来连接操作数据库进而得到json串
     *
     * 按json方式输出通信数据
     *
     * @param unknown $State 状态码
     *
     * @param string $Descriptor  提示信息
     *
	   * @param string $Version  操作时间
     *
     * @param array $Data 数据
     *
     * @return string
     *
     * @旅行社发布旅游行程   提供返回参数账号，
     * id              导游id
     * images          导游头像
     * pics            相册
     * tel             电话号码
     * content         导游简介
     */
require_once("../../include/config.inc.php");

$body = file_get_contents('php://input');
$_POST = json_decode($body,true);

$Data = array();
$Version=date("Y-m-d H:i:s");
$token = $_POST['token'];
$id = $_POST['id'];

if(isset($_POST['images'])){
$images = $_POST['images'];
}

if(isset($_POST['pics'])){
$pics = $_POST['pics'];
}

if(isset($_POST['content'])){
$content = $_POST['content'];
}

if(isset($_POST['tel'])){
$tel = $_POST['tel'];
}

if(isset($token) && $token==$cfg_auth_key){

  //这个是自定义函数，将Base64图片转换为本地图片并保存
  $savepath= "../../uploads/image/";

  if(isset($images)){
  $images = base64_image_content($images,$savepath);
  $images=str_replace("../../",'',$images);
  }
  //将相册里面的图片进行处理

 if(isset($pics)){
  $arr=array();
  $pic ="";
  $arr=explode("|",$pics);
  for($i=0;$i<count($arr);$i++){
    $pics  = base64_image_content($arr[$i],$savepath);
    if($i==count($arr)-1){
      $thispic = str_replace("../../",'',$pics);
    }else{
      $thispic = str_replace("../../",'',$pics)."|";
    }
    $pic .= $thispic;
    }
}

// 将GET传过来的参数进行判断最后一个参数，如果是最后一个参数，则最后一个逗号去除掉、

  $arr=$_POST;
  $nums= count($arr)-1;
  $newarr=array_keys($arr);

  $lastkey = $newarr[$nums];  //最后一个参数的键

  $sql = "UPDATE `#@__guide` set ";


  if(isset($tel)){
    if($lastkey == "tel"){
    $sql .= "tel='$tel' ";
    }else{
    $sql .= "tel='$tel',";
    }
  }

  if(isset($content)){
    if($lastkey == "content"){
    $sql .= " content='$content' ";
    }else{
    $sql .= " content='$content',";
    }
  }

  if(isset($pics)){
      if($lastkey == "pics"){
      $sql .= " pics='$pic' ";
      }else{
      $sql .= " pics='$pic',";
      }
  }

  if(isset($images)){
    if($lastkey=="images"){
      $sql .= " images='$images'";
    }else{
      $sql .= " images='$images',";
    }
  }

  $sql .= "WHERE id=$id";
  $dosql->ExecNoneQuery($sql);
  $r=$dosql->GetOne("SELECT * FROM pmw_guide where id=$id");
  if(is_array($r)){
  $Data[]=$r;
  $agreement=stripslashes($r['agreement']);
  $agreement=GetPic($agreement, $cfg_weburl);
  $pics=stripslashes($r['pics']);
  $pics=GetPics($pics, $cfg_weburl);
  $Data[0]['type']='guide';
  $Data[0]['card']=$cfg_weburl."/".$r['card'];
  $Data[0]['images']=$cfg_weburl."/".$r['images'];
  $Data[0]['agreement']=$agreement;
  $Data[0]['pics']=$pics;
  $State = 1;
  $Descriptor = '导游信息修改成功!';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $Data
               );
  echo phpver($result);
}else{
  $State = 0;
  $Descriptor = '导游信息修改失败!';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $Data
               );
   echo phpver($result);
}
}else{
  $State = 520;
  $Descriptor = 'token验证失败！';
  $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
  				         'Version' => $Version,
                   'Data' => $Data,
                   );
  echo phpver($result);
}

?>
