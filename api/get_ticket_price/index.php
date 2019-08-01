<?php
    /**
	   * 链接地址：get_ticket_content  获取票务规格的价格 （两个月）
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
     * @提供返回参数账号 type 会员类型  会员id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  $month=date("m");
  $years=date("Y");
  $one=1;
  $two=2;
  $dosql->Execute("SELECT * FROM pmw_selectdate where sid=$id and tid=$tid and years=$years  and month='$month'",$one);
  for($i=0;$i<$dosql->GetTotalRow($one);$i++){
    $row1=$dosql->GetArray($one);
    $Data['current_month'][$i]=$row1;
  }

  $dosql->Execute("SELECT * FROM pmw_selectdate where sid=$id and tid=$tid and years=$years  and month='$month'+1",$two);
  for($j=0;$j<$dosql->GetTotalRow($two);$j++){
    $row2=$dosql->GetArray($two);
    $Data['last_month'][$j]=$row2;
  }

      $State = 1;
      $Descriptor = '内容获取成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);


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
