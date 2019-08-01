<?php
    /**
	   * 链接地址：get_order   获取单个用户的购票列表
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
     * @提供返回参数账号 id    用户类型  agency guide
     *  # 全部
     *  # 待出行
     *  # 已出行
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

      $r=$dosql->GetOne("SELECT id FROM `#@__order` WHERE did=$id and type='$type'");
      if(!is_array($r)){  //如果传递过来的账号不存在，则没有这一列
        $State = 0;
        $Descriptor = '暂无购票列表！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      #全部
      $we='we';
      $me='me';
      $one=1;

      $now=time();
      #全部

      $dosql->Execute("SELECT a.*,b.picarr FROM `#@__order` a inner join `#@__ticket` b  on a.tid=b.id  WHERE a.did=$id and a.type='$type'",$we);
      for($i=0;$i<$dosql->GetTotalRow($we);$i++){
        $row = $dosql->GetArray($we);
        $Data['All'][$i]=$row;
        $Data['All'][$i]['posttime']=date("Y-m-d",$row['posttime']);
        $picarr=stripslashes($row['picarr']);
        $picarr=GetPic($picarr, $cfg_weburl);
        $Data['All'][$i]['picarr']=$picarr;
      }
      #待出行
      $dosql->Execute("SELECT a.*,b.picarr FROM `#@__order` a inner join `#@__ticket` b  on a.tid=b.id  WHERE a.did=$id and a.type='$type' and a.timestampuse > $now",$me);
      for($j=0;$j<$dosql->GetTotalRow($me);$j++){
        $show = $dosql->GetArray($me);
        $Data['Tobe_travelled'][$j]=$show;
        $Data['Tobe_travelled'][$j]['posttime']=date("Y-m-d",$show['posttime']);
        $picarr=stripslashes($show['picarr']);
        $picarr=GetPic($picarr, $cfg_weburl);
        $Data['Tobe_travelled'][$j]['picarr']=$picarr;
      }
      #已出行
    $dosql->Execute("SELECT a.*,b.picarr FROM `#@__order` a inner join `#@__ticket` b  on a.tid=b.id  WHERE a.did=$id and a.type='$type' and a.timestampuse <= $now",$one);
      for($i=0;$i<$dosql->GetTotalRow($one);$i++){
        $row1 = $dosql->GetArray($one);
        $Data['Traveled'][$i]=$row1;
        $Data['Traveled'][$i]['posttime']=date("Y-m-d",$row1['posttime']);

        $picarr=stripslashes($row1['picarr']);
        $picarr=GetPic($picarr, $cfg_weburl);
        $Data['Traveled'][$i]['picarr']=$picarr;
      }

      $State = 1;
      $Descriptor = '购票列表查询成功！';
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
