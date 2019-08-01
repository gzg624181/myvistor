<?php
    /**
	   * 链接地址：get_ticket_content  获取票务规格
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

      $r=$dosql->GetOne("SELECT * FROM `#@__ticket` WHERE id=$id and checkinfo=1");
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
      $one=1;

      $picarr=stripslashes($r['picarr']);
      $picarr=GetPic($picarr, $cfg_weburl);

      $content=stripslashes($r['content']);
      $content=rePic($content, $cfg_weburl);

      $xuzhi=stripslashes($r['xuzhi']);
      $xuzhi=rePic($xuzhi, $cfg_weburl);

      $r['picarr']=$picarr;
      $r['xuzhi']=$xuzhi;
      $r['content']=$content;

      $specs =array();
      $dosql->Execute("SELECT * FROM `#@__specs` where tid=$id",$one);
      while($row1=$dosql->GetArray($one)){
       $specs[]=$row1;
        }

      //示例 1:引用循环变量的地址赋值

      foreach($specs as &$shoplist){

        $shoplist['label']=$r['label'];
        $shoplist['remarks']=$r['remarks'];

      }
      $Data= array(

            "content" => $r,

            "specs" => $specs

      );

      $State = 1;
      $Descriptor = '内容获取成功！';
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
