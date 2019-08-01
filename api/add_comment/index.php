<?php
    /**
	   * 链接地址：add_comment  旅行社给导游评价
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
     * id              本次旅游行程id
     * gid            导游id
     * aid            旅行社id
     * star           评价几星
     * content        提出来的评价和建议
     * addtime        评价时间
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：添加行程的时候content 内容以json字符串的形式保存在数据库中去

  $addtime=time();  //添加时间
  $sql = "INSERT INTO `#@__comment` (gid,aid,star,content,addtime) VALUES ($gid,$aid,'$star','$content',$addtime)";
  $dosql->ExecNoneQuery($sql);
   #更新旅游行程的状态为1，已经评论
  $dosql->ExecNoneQuery("UPDATE `#@__travel` set comment_state=1 where id=$id");
  $State = 1;
  $Descriptor = '评论信息发布成功！!';
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
