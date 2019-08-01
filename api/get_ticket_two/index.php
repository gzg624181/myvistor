<?php
    /**
	   * 链接地址：get_ticket_two 夏日推荐
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

      $two=2;

      $dosql->Execute("SELECT * FROM `#@__ticket` where types='8'  and checkinfo=1",$two);
      for($i=0;$i<$dosql->GetTotalRow($two);$i++){
       $row2 = $dosql->GetArray($two);
       $Data[$i]=$row2;
       $picarr=stripslashes($row2['picarr']);
       $picarr=GetPic($picarr, $cfg_weburl);
       $content=stripslashes($row2['content']);
       $content=rePic($content, $cfg_weburl);
       $xuzhi=stripslashes($row2['xuzhi']);
       $xuzhi=rePic($xuzhi, $cfg_weburl);
        $Data[$i]['picarr']=$picarr;
        $Data[$i]['xuzhi']=$xuzhi;
        $Data[$i]['content']=$content;
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
