<?php
    /**
	   * 链接地址：get_index_list  获取首页用户已经发布同时审核成功的动态
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
     * @提供返回参数账号   current_id  默认显示的海报id
     *
     * @向上或者向下滑动的方向 move （up / down）
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

 if(isset($current_id) && $current_id!="" && isset($move) && $move!=""){
   if($move=="down"){ //往下翻的时候
   $k = $dosql->GetOne("SELECT a.id,a.pic,a.qrcode,a.content,a.addtime,a.num,a.zan,b.nickname,b.images,a.openid FROM pmw_publish a inner join pmw_members b on a.openid=b.openid where a.checkinfo=1 and a.checkgongkai=1 and a.id>$current_id order by a.id asc limit 1");
     if(is_array($k)){
       $k['pic'] = $cfg_weburl."/".$k['pic'];
       $k['qrcode'] = $cfg_weburl."/".$k['qrcode'];
       $State =1;
       $Descriptor = '下划数据查询成功！';
       $result = array (
                       'State' => $State,
                       'Descriptor' => $Descriptor,
                        'Version' => $Version,
                        'Data' => $k,
                        );
       echo phpver($result);
     }else{
       $State =0;
       $Descriptor = '下划数据查询为空！';
       $result = array (
                       'State' => $State,
                       'Descriptor' => $Descriptor,
                        'Version' => $Version,
                        'Data' => $Data,
                        );
       echo phpver($result);
     }
   }elseif($move=="up"){ //上划的时候
     $k = $dosql->GetOne("SELECT a.id,a.pic,a.qrcode,a.content,a.addtime,a.num,a.zan,b.nickname,b.images,a.openid FROM pmw_publish a inner join pmw_members b on a.openid=b.openid where a.checkinfo=1 and a.checkgongkai=1 and a.id<$current_id order by a.id desc limit 1");

       if(is_array($k)){
         $k['pic'] = $cfg_weburl."/".$k['pic'];
         $k['qrcode'] = $cfg_weburl."/".$k['qrcode'];
         $State =1;
         $Descriptor = '上划数据查询成功！';
         $result = array (
                         'State' => $State,
                         'Descriptor' => $Descriptor,
                          'Version' => $Version,
                          'Data' => $k,
                          );
         echo phpver($result);
       }else{
         $State =0;
         $Descriptor = '上划数据查询为空！';
         $result = array (
                         'State' => $State,
                         'Descriptor' => $Descriptor,
                          'Version' => $Version,
                          'Data' => $Data,
                          );
         echo phpver($result);
       }
   }
 }else{
 //默认第一次进入首页页面的时候，自动将已审核的最新一条的会员发布的动态展示出来，也就是只能上翻
 $k = $dosql->GetOne("SELECT a.id,a.pic,a.qrcode,a.content,a.addtime,a.num,a.zan,b.nickname,b.images,a.openid FROM pmw_publish a inner join pmw_members b on a.openid=b.openid where a.checkinfo=1  and a.checkgongkai=1 order by a.id desc limit 1");
 if(is_array($k)){
 $k['pic'] = $cfg_weburl."/".$k['pic'];
 $k['qrcode'] = $cfg_weburl."/".$k['qrcode'];
 $State = 1;
 $Descriptor = '数据查询成功！';
 $result = array (
                 'State' => $State,
                 'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $k,
                  );
 echo phpver($result);
 }else{
   $State = 0;
   $Descriptor = '数据查询失败！';
   $result = array (
                   'State' => $State,
                   'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data,
                    );
   echo phpver($result);
 }
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
