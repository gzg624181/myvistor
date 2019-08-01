<?php
    /**
	   * 链接地址：cancel_travel  旅行社取消行程
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
     * id        此条行程的id
     * formid    旅行社的formid
     * openid    旅行社的openid
     * reason     旅行社取消的原因
     * aid        旅行社id
     * gid       导游id
     * reason    取消原因
     */
require_once("../../include/config.inc.php");
require_once("../../admin/sendmessage.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：取消行程的时候分为两种状态
  // 1.待预约状态的时候，直接取消
  // 2.待确认状态下的时候，发送双向模板消息
  $r=$dosql->GetOne("SELECT state FROM pmw_travel where id=$id");
  if($r['state']==0){
    $sql = "UPDATE `#@__travel` set state=5 WHERE id=$id";
    if($dosql->ExecNoneQuery($sql)){
    $s=$dosql->GetOne("SELECT state FROM pmw_travel where id=$id");
    $State = 1;
    $Descriptor = '行程取消成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $s
                 );
    echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '行程取消失败!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }
  }elseif($r['state']==1){
    $faxtime=time();
    $sql = "UPDATE `#@__travel` set state=3 WHERE id=$id";
    $dosql->ExecNoneQuery($sql);
    //发送双向模板消息

    // 给旅行社发布模板消息 （旅行社的formid通过参数获取）

    $g=$dosql->GetOne("SELECT * FROM pmw_guide where id=$gid");
    $a=$dosql->GetOne("SELECT * FROM pmw_agency where id=$aid");
    $x=$dosql->GetOne("SELECT * FROM pmw_travel where id=$id");

    //将用户的formid添加进去
    add_formid($openid,$formid);

    $openid_agency=$openid;            //旅行社联系人openid
    $formid= get_new_formid($openid);  //旅行社formid


    $openid_guide=$g['openid'];               //导游openid
    $form_id =get_new_formid($openid_guide);  //导游formid


    $title=$x['title'];           //旅行社发布的行程标题

    $time=date("Y-m-d",$x['starttime'])."--".date("Y-m-d",$x['endtime']); //旅行社发布的行程时间

    //$reason="世界这么大，我想自己单独出去走走";
    $arr = array();

    $arr =explode(".",$reason);

    $reason =$arr[1];

    $tishi="您发布的此条行程已取消，可进入小程序再次发布行程，欢迎您再次使用。";

    $page="pages/about/confirm/confirm?id=".$id."&gid=".$gid."&tem=tem";

    $data_agency=CancelAgency($title,$time,$reason,$tishi,$openid_agency,$cfg_concel_agency,$page,$formid);

    $ACCESS_TOKEN = get_access_token($cfg_appid,$cfg_appsecret);//ACCESS_TOKEN

    //模板消息请求URL
    $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$ACCESS_TOKEN;

    $json_data_agency = json_encode($data_agency);//转化成json数组让微信可以接收
    $res_agency = https_request($url, urldecode($json_data_agency));//请求开始
    $res_agency = json_decode($res_agency, true);
  //  $errcode_agency=$res_agency['errcode'];
  //删除已经用过的formid
     del_formid($formid,$openid_agency);
//==================================================================================================
    //将旅行社注撤销行程的模板消息保存起来
    $type = 'agency';
    $messagetype='template';
    $templatetype='cancel';  //取消行程的模板消息类型
    $tent = "行程已取消成功：|";
    $tent .= "出发行程：".$title."|";
    $tent .= "行程时间：".$time."|";
    $tent .= "取消原因：".$reason."|";
    $tent .= "温馨提示：".$tishi;
    $stitle="行程取消通知";
    $biaoti="你好，你发布的".$time."行程已取消";

    $tbnames = 'pmw_message';
    $sql = "INSERT INTO `$tbnames` (type, messagetype, templatetype, content,stitle, title, mid, faxtime) VALUES ('$type', '$messagetype', '$templatetype', '$tent', '$stitle', '$biaoti', $aid, $faxtime)";
    $dosql->ExecNoneQuery($sql);
//===========================================================================================

    //向导游发送取消行程的模板消息
    $nickname =$a['company'];    //旅行社的名称
    $tel = $a['tel'];            //旅行社联系人电话号码
    $tishi="您预约的此条行程已取消，可进入小程序再次预约行程，欢迎您再次使用。";
    $page="pages/about/guideConfirm/index?id=".$id."&gid=".$gid."&aid=".$aid."&tem=tem";

    $data_guide=CancelGuide($title,$time,$nickname,$tel,$reason,$tishi,$openid_guide,$cfg_cancel_guide,$page,$form_id);

    $ACCESS_TOKEN = get_access_token($cfg_appid,$cfg_appsecret);//ACCESS_TOKEN

    //模板消息请求URL
    $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$ACCESS_TOKEN;

    $json_data_guide = json_encode($data_guide);//转化成json数组让微信可以接收
    $res_guide = https_request($url, urldecode($json_data_guide));//请求开始
    $res_guide = json_decode($res_guide, true);
  //  $errcode_guide=$res_guide['errcode'];
     del_formid($form_id,$openid_guide);
    //==================================================================================================
        //将导游接收到的撤销行程的模板消息保存起来
        $type = 'guide';
        $messagetype='template';
        $templatetype='cancel';  //取消行程的模板消息类型
        $tent = "行程已被取消：|";
        $tent .= "出发行程：".$title."|";
        $tent .= "行程时间：".$time."|";
        $tent .= "昵称：".$nickname."|";
        $tent .= "取消原因：".$reason."|";
        $tent .= "温馨提示：".$tishi;
        $stitle="行程取消通知";
        $biaoti="你好，你预约的".$time."行程已被取消";

        $banames = 'pmw_message';
        $sql = "INSERT INTO `$tbnames` (type, messagetype, templatetype, content,stitle, title, mid, faxtime) VALUES ('$type', '$messagetype', '$templatetype', '$tent', '$stitle', '$biaoti', $gid, $faxtime)";
        $dosql->ExecNoneQuery($sql);
    //===========================================================================================
    $s=$dosql->GetOne("SELECT state FROM pmw_travel where id=$id");

    $states =$s['state'];
    if($states==3){
    $State = 1;
    $Descriptor = '行程取消成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $s
                 );
    echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '行程取消失败!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
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
