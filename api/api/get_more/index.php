<?php
    /**
	   * 链接地址：get_more  点击查看更多，获取当前这条动态访客的资料，同时更新查看状态为已查看
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
     * @海报 poster_id
     * 当前登陆会员的openid
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){


      $one=1;
      $dosql->Execute("SELECT MAX(a.vtime) as vtime,b.nickname,b.images,b.sex,a.id FROM pmw_record a inner join pmw_members b on a.vistor_openid=b.openid where a.poster_id=$poster_id  group by a.vistor_openid ORDER BY vtime desc",$one);
      $nums = $dosql->GetTotalRow($one);
      //拉取微信支付
      include("../weixinpay/index.php");

      if($nums == 0){
        $record=array();
        $Data= array(
          "record" => $record,
             "vip" => $return
        );
        $State = 0;
        $Descriptor = '暂无数据！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      for($i=0;$i<$nums;$i++){
      $row=$dosql->GetArray($one);
      $record[]=$row;
      $sex=$row['sex'];
      switch($sex){ case 1: $sex="男"; break;case 0: $sex='女'; break;}
      $record[$i]['sex']=$sex;
      }
      $Data= array(
        "record" => $record,
           "vip" => $return
      );
      $State = 1;
      $Descriptor = '访客记录获取成功！';
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
