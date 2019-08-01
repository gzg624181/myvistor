<?php
    /**
	   * 链接地址：get_freetime  获取导游发布的还未过期的空闲时间
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
      $now=time();
      $r=$dosql->GetOne("SELECT * from pmw_freetime where gid=$id");
      $num=$dosql->GetTotalRow();
      if($num==0){
        $State = 0;
        $Descriptor = '暂无此导游发布的空闲时间信息';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $free=$r;
      $freetime=json_decode($free['content'],true);
      foreach($freetime as $key=> $val){
        if($now > $val){
          unset($freetime[$key]);
        }
      }

      $freetime= array_values($freetime);
      $freetime=json_encode($freetime);
      $free['content']= $freetime;
      $State = 1;
      $Descriptor = '空闲时间获取成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $free
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
