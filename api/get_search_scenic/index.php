<?php
    /**
	   * 链接地址：get_search_scenic  搜索景点 关键字模糊搜索
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
     * @提供返回参数账号  keyword=>   行程标题 title
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
    $r=$dosql->GetOne("SELECT imagesurl FROM pmw_share  where id=3");
    $cfg_default = $r['imagesurl'];
    $dosql->Execute("SELECT id,names,label,solds,types,flag,lowmoney,remarks,level,picarr FROM pmw_ticket where names like '%$keyword%' and  checkinfo=1 order by id desc ");

    $num=$dosql->GetTotalRow();//获取数据条数

      if($num!=0){
        for($i=0;$i<$num;$i++){
         $row = $dosql->GetArray();
         $Data[$i]=$row;

         $picarr=stripslashes($row['picarr']);
         if($picarr==""){
         $picarrTmp=array("0"=>$cfg_weburl."/".$cfg_default);
         $picarr = json_encode($picarrTmp);
         }else{
         $picarr=GetPic($picarr, $cfg_weburl);
         }
         $Data[$i]['picarr']=$picarr;
        }

      $State = 1;
      $Descriptor = '搜索数据查询成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
      }else{
        $Data=array();
        $State = 0;
        $Descriptor = '搜索数据为空！';
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
