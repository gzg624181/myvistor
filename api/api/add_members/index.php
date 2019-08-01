<?php
    /**

     * 链接地址： 会员关注小程序之后，获取用户的个人信息和openid
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
     * nickname         会员昵称
     * images           用户头像
     * sex              性别
     * code             通过code获取用户的唯一openid
     */

     require_once("../../include/config.inc.php");

     $Data = array();

     $Version=date("Y-m-d H:i:s");

     if(isset($token) && $token==$cfg_auth_key){

    //备注 ：添加行程的时候content 内容以json字符串的形式保存在数据库中去

    $addtime=time();  //添加时间

   // 获取用户的openid

   $openid = Openid($code,$cfg_appid,$cfg_appsecret);

   $r=$dosql->GetOne("SELECT id FROM pmw_members where openid='$openid'");

  if(!is_array($r)){

     $sql = "INSERT INTO `#@__members`(nickname,images,sex,addtime,openid) VALUES ('$nickname','$images',$sex,$addtime,'$openid')";

  }else{

     $sql = "UPDATE `#@__members` SET nickname='$nickname',images='$images',sex=$sex,addtime=$addtime where openid='$openid'";
  }
  $dosql->ExecNoneQuery($sql);

  $k = $dosql->GetOne("SELECT * FROM `#@__members` WHERE openid='$openid'");

  if(is_array($k)){
    $State = 1;
    $Descriptor = '授权用户信息保存成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $k
                 );
    echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '授权用户信息保存失败!';
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
