<?php
    /**
	   * 链接地址：issue_guide  导游发布空闲日期
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
     * @导游发布空闲日期   提供返回参数账号，
     * id               导游id
     * time            空闲时间json数据
     * formid          更新导游的formid
     * openid           发布空闲时间
     * addtime         添加时间
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：添加空闲时间 content 内容以json字符串的形式保存在数据库中去
  //  判断表里面是否有这个导游的空闲时间列表

  $r=$dosql->GetOne("SELECT id from pmw_freetime where gid=$id");

  if(!is_array($r)){
    $addtime=time();  //更新时间
    $sql = "INSERT INTO `#@__freetime` (gid,content,addtime) VALUES ($id,'$time',$addtime)";
    $dosql->ExecNoneQuery($sql);
  }else{
    $addtime=time();  //更新时间
    $sql = "UPDATE  `#@__freetime` SET content='$time',addtime=$addtime where gid=$id";
    $dosql->ExecNoneQuery($sql);
  }
  # 更新导游的formid
  $dosql->ExecNoneQuery("UPDATE `#@__guide` set formid='$formid' where id=$id");

  //将用户的formid添加进去
  add_formid($openid,$formid);
  $State = 1;
  $Descriptor = '导游空闲时间发布成功!';
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
