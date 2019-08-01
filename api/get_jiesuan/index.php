<?php
    /**
	   * 链接地址：get_jiesuan  获取每个月结算的数据
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

      $y=date("Y");
      $arr= get_months_success($id,$y);

      $num=count($arr);
      if($num==0){
        $State = 0;
        $Descriptor = '暂无消息！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      for($i=0;$i<$num;$i++){
        $m=$arr[$i]['time'];
        $agency_arr=get_agency_state($id,$y,$m);
        $Data[$i]['time']=$m;
        $Data[$i]['teamnumber']=$agency_arr['teamnumber'];
        $Data[$i]['days']=$agency_arr['days'];
        $Data[$i]['money']=$agency_arr['money'];
        $Data[$i]['Settlement']=$agency_arr['Settlement'];
      }
      $State = 1;
      $Descriptor = '消息获取成功！';
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
