<?php
    /**
	   * 链接地址： issue_news   用户发布动态
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
     * @提供返回参数账号，
     * token              token
     * uid               用户的uid
     * content           动态文字内容
     * pic               用户添加的图片
     */
header('Content-Type: application/json; charset=utf-8');
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
$body = file_get_contents('php://input');
$json = json_decode($body,true);

$token = $json['token'];

if(isset($token) && $token==$cfg_auth_key){

  //备注 ：添加行程的时候content 内容以json字符串的形式保存在数据库中去

  $addtime=time();  //添加时间

  $content=$json['content'];

  $uid=$json['uid'];

  $pic=$json['pic'];

  $poster="haibao";

  $checkgongkai = $json['checkgongkai'];

  $r=$dosql->GetOne("SELECT checkpost,openid from pmw_members where id=$uid");
  $checkpost=$r['checkpost'];
  $openid = $r['openid'];
  if($checkpost==1){
  //这个是自定义函数，将Base64图片转换为本地图片并保存
  $savepath= "../../uploads/image/";

  $pic = base64_image_content($pic,$savepath);

  $pic=str_replace("../../",'',$pic);

  $randnumber=rand(11111111,9999999);

  $sql = "INSERT INTO `#@__publish`(openid,content,pic,addtime,randnumber,checkgongkai) VALUES ('$openid','$content','$pic',$addtime,$randnumber,$checkgongkai)";
  $dosql->ExecNoneQuery($sql);

  $srcImg=$cfg_weburl."/".$pic;               //分享的背景图片
  $image_blur = new image_blur();
  $image_blur->gaussian_blur($srcImg,"../../uploads/erweima",$randnumber.".png",5);   //生成模糊图片
  $srcImg = $cfg_weburl."/uploads/erweima/".$randnumber.".png";

  //1.第一步 先生成小程序二维码
  $xiaochengxu_path="pages/scan/index";  //默认扫码之后进入的页面
	$erweima_name=date("Ymdhis");
	$url="uploads/erweima/".$erweima_name.".png";
	$save_path="../../".$url;         //生成成功之后的二维码地址
	$access_token=token($cfg_appid,$cfg_appsecret);
  $r=$dosql->GetOne("SELECT id from pmw_publish where randnumber=$randnumber");
  $id=$r['id'];   //发布的此条动态的id
  $erweima= save_erweima($access_token,$xiaochengxu_path,$save_path,$url,$id,$uid,$poster);

  //2.将背景图片和生成的二维码进行合并
  $savename="new_".$erweima_name.".png";
  $savepath="../../uploads/erweima";
  $erweima="../../".$erweima;

  $newimg=img_water_mark($srcImg, $erweima, $savepath, $savename, $positon=3, $alpha=100);
  $newimg = str_replace("../../",'',$newimg);


  //将生成的海报地址保存到数据库中去
  $dosql->ExecNoneQuery("UPDATE pmw_publish set qrcode='$newimg' where id=$id");

  $k=$dosql->GetOne("SELECT * FROM  pmw_publish where id=$id");
  $k['qrcode']=$cfg_weburl."/".$k['qrcode'];
  $k['pic']=$cfg_weburl."/".$k['pic'];
    $State = 1;
    $Descriptor = '发布成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $k
                 );
    echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '您的权限已被禁止发布动态，请联系管理员!';
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
