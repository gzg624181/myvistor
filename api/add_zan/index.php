<?php
    /**
	   * 链接地址： add_zan   用户点赞
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
     * @访客点赞，每个用户对一个海报只允许点赞一次
     * vistor_openid          访客openid
     * poster_id              海报id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  $vtime=time();  //点赞时间

  //点赞次数加上1,每个海报每个访客只能点赞一次 ，如果已经点赞 ，则不需要再次增加

  $r=$dosql->GetOne("SELECT id FROM pmw_zan_record where vistor_openid='$vistor_openid' and poster_id=$poster_id");

  if(!is_array($r)){

  $dosql->ExecNoneQuery("UPDATE pmw_publish SET zan= zan+1 where id=$poster_id");

  $sql = "INSERT INTO `#@__zan_record`(vistor_openid,poster_id,vtime) VALUES ('$vistor_openid',$poster_id,$vtime)";

  $dosql->ExecNoneQuery($sql);

  //更新海报的点赞数量

  $j=$dosql->GetOne("SELECT zan from pmw_publish where id=$poster_id");

  if(is_array($j)){
    $State = 1;
    $Descriptor = '点赞数量获取成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $j
                 );
    echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '点赞数量获取失败!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }
  }else{
    $k=$dosql->GetOne("SELECT zan from pmw_publish where id=$poster_id");
    $State = 2;
    $Descriptor = '访客已点赞，不需要重复操作!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $k
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
