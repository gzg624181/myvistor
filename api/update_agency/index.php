<?php
    /**
	   * 链接地址：update_agency  更改旅行社资料
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
     * id               旅行社id
     * images           旅行社头像
     * name             联系人姓名
     * tel              联系电话
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

if(isset($_POST['name'])){
$name = $_POST['name'];
}

if(isset($_POST['tel'])){
$tel = $_POST['tel'];
}

if(isset($token) && $token==$cfg_auth_key){

  //这个是自定义函数，将Base64图片转换为本地图片并保存
  $savepath= "../../uploads/image/";

  if(isset($images)){
  $images = base64_image_content($images,$savepath);
  $images=str_replace("../..",'',$images);
  }

// 将GET传过来的参数进行判断最后一个参数，如果是最后一个参数，则最后一个逗号去除掉、

  $arr=$_POST;
  $nums= count($arr)-1;
  $newarr=array_keys($arr);

  $lastkey = $newarr[$nums];  //最后一个参数的键

  $sql = "UPDATE `#@__agency` set ";


  if(isset($tel)){
    if($lastkey == "tel"){
    $sql .= "tel='$tel' ";
    }else{
    $sql .= "tel='$tel',";
    }
  }

  if(isset($name)){
    if($lastkey == "name"){
    $sql .= " name='$name' ";
    }else{
    $sql .= " name='$name',";
    }
  }

  if(isset($images)){
    if($lastkey=="images"){
      $sql .= " images='$images' ";
    }else{
      $sql .= " images='$images',";
    }
  }

  $sql .= "WHERE id=$id";
  $dosql->ExecNoneQuery($sql);
  $r=$dosql->GetOne("SELECT * FROM pmw_agency where id=$id");
  if(is_array($r)){
  $Data[]=$r;
  $Data[0]['type']='agency';
  $Data[0]['cardpic']=$cfg_weburl."/".$r['cardpic'];
  $Data[0]['images']=$cfg_weburl."/".$r['images'];
  $State = 1;
  $Descriptor = '旅行社信息修改成功!';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $Data
               );
  echo phpver($result);
}else{
  $State = 0;
  $Descriptor = '旅行社信息修改失败!';
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
