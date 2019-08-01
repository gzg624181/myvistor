<?php
    /**
	   * 链接地址：update_travel  更改旅行社发布旅游行程
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
     * @旅行社发布旅游行程   提供返回参数账号，
     * id              此条行程的id
     * title           行程标题
     * starttime       开始时间
     * endtime         结束时间
     * num             团队人数
     * origin          客源地
     * content         修改行程
     * money           导游费用
     * other           其他备注
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：修改行程的时候content 内容以json字符串的形式保存在数据库中去

  $posttime=time();  //添加时间
  $days=($endtime-$starttime) / (60 * 60 * 24) +1;  //行程的天数
  $jiesuanmoney = $cfg_jiesuan * $days;
  $sql = "UPDATE `#@__travel` set title='$title',starttime=$starttime,endtime=$endtime,num=$num,origin='$origin',content='$content',money=$money,other='$other',posttime=$posttime,jiesuanmoney='$jiesuanmoney',days=$days WHERE id=$id";
  if($dosql->ExecNoneQuery($sql)){
  $State = 1;
  $Descriptor = '行程修改成功!';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $Data
               );
  echo phpver($result);
}else{
  $State = 0;
  $Descriptor = '行程修改失败!';
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
