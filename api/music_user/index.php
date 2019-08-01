<?php
    /**
	   * 链接地址：音频小程序  添加会员接口
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
     * nickname        会员昵称
     * images          用户头像
     * sex             性别
     * code            用户关注的code
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：添加行程的时候content 内容以json字符串的形式保存在数据库中去
  $openid = openid($code,$cfg_music_appid,$cfg_music_appsecret);

  if($openid==""){
    $State = 1;
    $Descriptor = '用户信息保存失败!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }else{
  $r=$dosql->GetOne("SELECT openid from pmw_member where openid='$openid'");
  if(!is_array($r)){
  $addtime=time();  //添加时间
  $sql = "INSERT INTO `#@__member`(nickname,images,sex,addtime,openid) VALUES ('$nickname','$images',$sex,$addtime,'$openid')";
  $dosql->ExecNoneQuery($sql);
  }
  $k=$dosql->GetOne("SELECT openid from pmw_member where openid='$openid'");
    $State = 1;
    $Descriptor = '用户信息保存成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $k
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
