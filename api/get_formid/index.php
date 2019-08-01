<?php
    /**
	   * 链接地址：get_formid  获取小程序的formid
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
     * @提供返回参数账号 account  用户账号  类型 type  formid
     */
require_once("../../include/config.inc.php");
require_once("../../admin/sendmessage.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
    if($type=="agency"){
      $r=$dosql->GetOne("SELECT id FROM `#@__agency` WHERE account='$account'");
      if(!is_array($r)){  //如果传递过来的账号不存在，则不能更新他的formid
        $State = 0;
        $Descriptor = '此账号不存在，请重新发送！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $dosql->ExecNoneQuery("UPDATE `#@__agency` SET formid='$formid' WHERE account='$account'");
      $State = 1;
      $Descriptor = 'formid获取成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
      }
    }elseif($type=="guide"){
      $r=$dosql->GetOne("SELECT id FROM `#@__guide` WHERE account='$account'");
      if(!is_array($r)){  //如果传递过来的账号不存在，则不能更新他的formid
        $State = 0;
        $Descriptor = '此账号不存在，请重新发送！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $dosql->ExecNoneQuery("UPDATE `#@__guide` SET formid='$formid' WHERE account='$account'");
      $State = 1;
      $Descriptor = 'formid获取成功！';
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
