<?php
    /**
	   * 链接地址：add_qrcode  生成二维码
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
     * @购票订单   提供返回参数账号，
     * id
     * time
     * poster
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  $k=$dosql->GetOne("SELECT * FROM pmw_share where id=2");
  $srcImg=$cfg_weburl."/".$k['imagesurl'];  //分享的背景图片
  $tubiaopic=$cfg_weburl."/".$k['tubiaopic'];

  //1.第一步 先生成小程序二维码
  $xiaochengxu_path="pages/play/index";  //默认扫码之后进入的页面
	$erweima_name=date("Ymdhis");
	$url="uploads/erweima/".$erweima_name.".png";
	$save_path="../../".$url;         //生成成功之后的二维码地址
	$access_token=token($cfg_music_appid,$cfg_music_appsecret);
  $erweima= save_erweima($access_token,$xiaochengxu_path,$save_path,$url,$id,$time,$poster);

  $img = imagecreatefromjpeg($save_path);
  $new_qrcode="../../uploads/erweima/new_code_".$erweima_name.".png";
  imagepng($img, $new_qrcode);

  $qrcode="../../uploads/erweima/code_".$erweima_name.".png";
  pngMerge($new_qrcode,$qrcode);
  unlink($new_qrcode);

  //$srcImg="../../templates/default/images/img.jpg";
  $waterImg=$cfg_weburl."/uploads/erweima/code_".$erweima_name.".png";

  $savename="new_".$erweima_name.".png";
  $savepath="../../uploads/erweima";
  $newimg1=img_water_mark($srcImg, $waterImg, $savepath, $savename, $positon=5, $alpha=100);
  $newimg=img_water_mark($newimg1, $tubiaopic, $savepath, $savename, $positon=2, $alpha=100);
  $newimg = str_replace("../..",$cfg_weburl,$newimg);
  unlink($save_path);


  $State = 1;
  $Descriptor = '小程序码生成成功!';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $newimg
               );
  echo phpver($result);

}else{
  $State = 520;
  $Descriptor = 'token验证失败！';
  $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
  				         'Version' => $Version,
                   'Data' => $newimg,
                   );
  echo phpver($result);
}

?>
