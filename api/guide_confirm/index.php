<?php
    /**
	   * 链接地址：guide_confirm  导游确认行程 （如果导游没有点击，则在行程发布的前一天系统自动执行）
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
     * @导游预约旅行社发布的行程   提供返回参数账号，同时双向发送模板消息提醒
     * id              发布的行程id
     */
require_once("../../include/config.inc.php");
require_once("../../admin/sendmessage.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  # 备注 ： 更改行程为确认

  # 更改行程为确认
  $complete_y = date("Y");

  $complete_ym = date("Y-m");

  $complete_time = time();

  $dosql->ExecNoneQuery("UPDATE `#@__travel` set state=2, complete_y='$complete_y', complete_ym='$complete_ym', complete_time='$complete_time' where id=$id");

  $x=$dosql->GetOne("SELECT * FROM pmw_travel where id=$id");
  $state=$x['state'];

  if($state==2){
      $State = 1;
      $Descriptor = '行程确认成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
    }else{
      $State = 0;
      $Descriptor = '行程确认失败!';
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
