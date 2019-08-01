<?php
    /**
	   * 链接地址：get_vistor  获取访客动态的列表
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
     * @提供返回参数账号    海报id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

      //获取访客的人数
      $one=1;
      $two=2;
      $dosql->Execute("SELECT * from pmw_record  where poster_id=$id",$one);
      $num=$dosql->GetTotalRow($one);

    

      if($num==0){
        $State = 0;
        $Descriptor = '暂无访客！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $dosql->Execute("SELECT b.nickname,b.images,b.sex,a.vtime FROM pmw_record a inner join pmw_members b on a.vistor_openid=b.openid where
      a.poster_id=$id order by vtime desc limit 1",$two);
      for($i=0;$i<$dosql->GetTotalRow($two);$i++){
      $row=$dosql->GetArray($two);
      $list[]=$row;
      }

      $Data = array(

        "num" => $num,
        "list"=>$list

      );
      $State = 1;
      $Descriptor = '访客列表获取成功！';
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
