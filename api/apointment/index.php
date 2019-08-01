<?php
    /**
	   * 链接地址：appointment  获取所有待预约的行程安排
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
     * @提供返回参数账号 page  默认为0 ,每页pagenumber条数据
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
   if(isset($page)){
    $pagenumber=4;
    $first=$page * $pagenumber;
    $dosql->Execute("SELECT id,title,starttime,endtime,money,other FROM pmw_travel where state=0 order by id desc limit $first,$pagenumber");
   }else{
    $dosql->Execute("SELECT id,title,starttime,endtime,money,other FROM pmw_travel where state=0 order by id desc limit 0,$pagenumber");
  }
    $num=$dosql->GetTotalRow();//获取数据条数
    if($num>0){
    while($row=$dosql->GetArray()){
      $Data[]=$row;
    }
      $State = 1;
      $Descriptor = '数据获取成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
    }else{
      $State = 0;
      $Descriptor = '已经没有数据了';
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
