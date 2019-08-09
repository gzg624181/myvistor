<?php
    /**
	   * 链接地址：scanning_qrcode  会员扫描二维码进入动态页面
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
     * @ 访客  访问：vistor_openid  =>vistor_uid      发布：member_openid=> member_uid    海报id ：poster_id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){


     if(isset($vistor_uid) && $vistor_uid!=""){
      //记录访客扫描小程序二维码的记录

      $vtime=time();
      $r= $dosql->GetOne("SELECT openid as vistor_openid FROM pmw_members where id=$vistor_uid");
      $vistor_openid = $r['vistor_openid'];

      $s= $dosql->GetOne("SELECT openid as member_openid FROM pmw_members where id=$member_uid");

      $member_openid = $s['member_openid'];

      $dosql->ExecNoneQuery("INSERT INTO pmw_record (vistor_openid,poster_id,member_openid,vtime) values ('$vistor_openid',$poster_id,'$member_openid',$vtime)");

      //将这条海报的数量加上1


      $dosql->ExecNoneQuery("UPDATE pmw_publish SET num= num+1 where id=$poster_id");


      $State = 1;
      $Descriptor = '数据更新成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);

    }else{
      $State = 0;
      $Descriptor = '数据更新失败！';
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
