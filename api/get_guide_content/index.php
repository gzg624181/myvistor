<?php
    /**
	   * 链接地址：get_guide_content  获取导游详情
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
     * @提供返回参数账号 type 会员类型  会员id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

      $r=$dosql->GetOne("SELECT * FROM `#@__guide` WHERE id=$id");
      if(!is_array($r)){
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
        $agreement=stripslashes($r['agreement']);
        $agreement=GetPic($agreement, $cfg_weburl);
        $r['agreement']=$agreement;
        $r['card']=$cfg_weburl."/".$r['card'];
      if($r['images']==""){
        $images=$cfg_weburl."/templates/default/images/noimage.jpg";
      }elseif(check_str($r['images'],"https")){
       $images=$r['images'];   //用户头像
      }else{
        $images=$cfg_weburl."/".$r['images'];
      }
      $r['images']=$images;

      $pics=stripslashes($r['pics']);
      $pics=GetPics($pics, $cfg_weburl);
      $r['pics']=$pics;
      $State = 1;
      $Descriptor = '内容获取成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $r
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
