<?php
    /**
	   * 链接地址：user  获取旅行社或者导游信息
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
     * @提供返回参数账号 id  导游或者旅行社信息  类型 type    agency   guide
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
    if($type=="agency"){
      $r=$dosql->GetOne("SELECT * FROM `#@__agency` WHERE id=$id");
      if(!is_array($r)){  //如果传递过来的账号不存在，则不能更新他的formid
        $State = 0;
        $Descriptor = '此账号不存在，请重新注册！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $Data[]=$r;
      $Data[0]['type']='agency';
      $Data[0]['cardpic']=$cfg_weburl."/".$r['cardpic'];
      if(check_str($r['images'],"https")){
        $Data[0]['images']=$r['images'];
      }else{
      $Data[0]['images']=$cfg_weburl."/".$r['images'];
      }
      $State = 1;
      $Descriptor = '旅行社信息获取成成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
      }
    }elseif($type=="guide"){
      $r=$dosql->GetOne("SELECT * FROM `#@__guide` WHERE id=$id");
      if(!is_array($r)){  //如果传递过来的账号不存在，则不能更新他的formid
        $State = 0;
        $Descriptor = '此账号不存在，请重新注册！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $Data[]=$r;
      switch($r['sex']){
        case 1:
        $sex="男";
        break;
        case 0:
        $sex="女";
        break;
      }
      $Data[0]['sex']=$sex;
      $agreement=stripslashes($r['agreement']);
      $agreement=GetPic($agreement, $cfg_weburl);
      $pics=stripslashes($r['pics']);
      $pics=GetPics($pics, $cfg_weburl);
      $Data[0]['type']='guide';
      $Data[0]['card']=$cfg_weburl."/".$r['card'];
      if(check_str($r['images'],"https")){
        $Data[0]['images']=$r['images'];
      }else{
      $Data[0]['images']=$cfg_weburl."/".$r['images'];
      }
      $Data[0]['agreement']=$agreement;
      $Data[0]['pics']=$pics;
      $State = 1;
      $Descriptor = '导游信息获取成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
      }
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
