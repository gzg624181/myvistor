<?php
    /**
	   * 链接地址：get_guide  获取所有已经审核成功的导游列表
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
     * @提供返回参数账号 page  默认为0 ,每页pagenumber条数据
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
    $page = isset($page) ? $page : 1;
    $pagenumber=5;

    $first= ($page - 1) * $pagenumber;

    $dosql->Execute("SELECT id,name,sex,content,images FROM pmw_guide where checkinfo=1 order by id desc limit $first,$pagenumber");

    $num=$dosql->GetTotalRow();//获取数据条数
    if($num>0){
    for($i=0;$i<$num;$i++){
    $row=$dosql->GetArray();
      $Data[]=$row;
      switch($row['sex']){
        case 1:
        $sex="男";
        break;
        case 0:
        $sex="女";
        break;
      }
      $Data[$i]['sex']=$sex;
      if(check_str($row['images'],"https")){
        $Data[$i]['images']=$row['images'];
      }else{
      $Data[$i]['images']=$cfg_weburl."/".$row['images'];
      }
    }
      $State = 1;
      $Descriptor = '数据获取成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
    }else{
      $State = 0;
      $Descriptor = '已经没有数据了';
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
