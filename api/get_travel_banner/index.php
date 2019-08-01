<?php
    /**
	   * 链接地址：get_travel_banner  获取行程Banner图片
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
     * @提供返回参数账号 导游id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

    //
      $dosql->Execute("SELECT * from pmw_banner where typename='travel'");
      $num=$dosql->GetTotalRow();
      if($num==0){
        $State = 0;
        $Descriptor = '图片获取为空';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
        for($i=0;$i<$dosql->GetTotalRow();$i++){
        $row=$dosql->GetArray();
        $Data[]=$row;
        $content=stripslashes($row['content']);
        $content=rePic($content, $cfg_weburl);
        $Data[$i]['pic']=$cfg_weburl."/".$row['pic'];
        $Data[$i]['content']=$content;
        }
      $State = 1;
      $Descriptor = '图片获取成功！';
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
