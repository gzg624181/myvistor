<?php
    /**
	   * 链接地址：guide_apointment  导游预约旅行社发布的行程
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
     * gid             导游id
     * name            导游姓名
     * id              发布的行程id
     * aid             旅行社的id
     * formid          导游的formid
     * openid          导游的openid
     */
require_once("../../include/config.inc.php");
require_once("../../admin/sendmessage.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  # 备注 ： 更改行程为待确认
  #        双向发送模板消息
  #  判断当前的行程是否已经被预约
  #  判断当前预约的行程是否和前面已经预约的行程相冲突

  $k=$dosql->GetOne("SELECT state,starttime,endtime from pmw_travel where id=$id");
  $state=$k['state'];
  if($state==0){

    //判断当前的行程的起始时间
    $starttime = $k['starttime'];  //本次行程的开始时间

    $endtime = $k['endtime'];     //本次行程的截至时间

    //计算出当前导游已经预约过的行程的所有的开始时间

    $one=1;

    $num =0;
    $dosql->Execute("SELECT * FROM pmw_travel where (state=1 or state=2) and gid=$gid",$one);

    while($sow=$dosql->GetArray($one)){

     $f=$sow['starttime'];

     $e=$sow['endtime'];

     if($starttime < $e && $e < $endtime){

        $num=1;

        break;

     }elseif($f< $endtime && $endtime< $e){

       $num=2;

       break;

     }elseif($starttime <= $f && $e <= $endtime){

       $num=3;

       break;

     }elseif($f< $starttime && $endtime< $e){

       $num=4;

       break;
     }

    }

    if($num==0){

    #向导游发送模板消息
    $g=$dosql->GetOne("SELECT * FROM pmw_guide where id=$gid");
    $a=$dosql->GetOne("SELECT * FROM pmw_agency where id=$aid");
    $x=$dosql->GetOne("SELECT * FROM pmw_travel where id=$id");
    $faxtime=time();

    //将用户的formid添加进去
  add_formid($openid,$formid);

  $formid=get_new_formid($openid);   //导游的formid
  $openid_guide=$openid;           //导游openid

  $company=$a['company'];   //旅行社公司名称

  $names=$a['name'];        //旅行社联系人姓名

  $name_guide=$g['name'];

  $tel=$a['tel'];          //旅行社联系人电话

  $title=$x['title'];      //旅行社发布的行程标题

  $time=date("Y-m-d",$x['starttime'])."--".date("Y-m-d",$x['endtime']); //旅行社发布的行程时间

  # 更改行程为待确认
  $dosql->ExecNoneQuery("UPDATE `#@__travel` set state=1,gid=$gid,name='$name_guide' where id=$id");

  $tishi="亲爱的".$name_guide."您好，您预约的行程已提交成功，请尽快与旅行社核实行程信息并查看详情确认此行程。";

  $page="pages/about/guideConfirm/index?id=".$id."&gid=".$gid."&aid=".$aid."&tem=tem";

  $ACCESS_TOKEN = get_access_token($cfg_appid,$cfg_appsecret);//ACCESS_TOKEN

  //模板消息请求URL
  $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$ACCESS_TOKEN;

  $data_guide=SendGuide($openid_guide,$company,$names,$tel,$title,$time,$tishi,$cfg_guide_appointment,$page,$formid);

  $json_data = json_encode($data_guide);//转化成json数组让微信可以接收
  $res = https_request($url, urldecode($json_data));//请求开始
  $res_guide = json_decode($res, true);
  $errcode_guide=$res_guide['errcode'];

  //删除已经用过的formid
  del_formid($formid,$openid_guide);
  //==================================================================================================
      //将导游预约的行程保存到消息表里面去
      $tbnames = 'pmw_message';
      $type = 'guide';
      $messagetype='template';
      $templatetype='appointment';  //预约行程的模板消息类型
      $tent = "恭喜你，你的行程预约成功：|";
      $tent .= "旅行社名称：".$company."|";
      $tent .= "旅行社联系人：".$names."|";
      $tent .= "联系人电话：".$tel."|";
      $tent .= "预约行程：".$title."|";
      $tent .= "预约时间：".$time."|";
      $tent .= "温馨提示：".$tishi;
      $stitle="预约成功通知";
      $biaoti="你预约的".$time.$title."行程已预约成功，请尽快与旅行社联系";

      $banames = 'pmw_message';
      $sql = "INSERT INTO `$tbnames` (type, messagetype, templatetype, content,stitle, title, mid, faxtime) VALUES ('$type', '$messagetype', '$templatetype', '$tent', '$stitle', '$biaoti', $gid, $faxtime)";
      $dosql->ExecNoneQuery($sql);
  //===========================================================================================


  #向旅行社发送模板消息
  $tel_guide=$g['tel'];
  $timestamp=date("Y-m-d H:i:s");
  $page_agency="pages/about/confirm/confirm?id=".$id."&gid=".$gid."&tem=tem";
  $openid_agency=$a['openid'];     //旅行社联系人openid
  $form_id_agency=get_new_formid($openid_agency) ;


  $data_agency=SendAgency($openid_agency,$title,$tel_guide,$name_guide,$time,$timestamp,$cfg_agency_remind,$page_agency,$form_id_agency);

  $json_data_agency = json_encode($data_agency);//转化成json数组让微信可以接收
  $res_agency = https_request($url, urldecode($json_data_agency));//请求开始
  $res_agency = json_decode($res_agency, true);
  $errcode_agency=$res_agency['errcode'];

  //删除已经用过的formid
  del_formid($form_id_agency,$openid_agency);
  //==================================================================================================
      //行程被导游预约，将向旅行社发布的消息表里面去
      $type = 'agency';
      $messagetype='template';
      $templatetype='appointment';  //预约行程的模板消息类型
      $tent = "恭喜你，你发布的行程已被预约成功：|";
      $tent .= "行程名称：".$title."|";
      $tent .= "导游电话：".$tel_guide."|";
      $tent .= "导游姓名：".$name_guide."|";
      $tent .= "行程时间：".$time."|";
      $tent .= "预约时间：".$timestamp;
      $stitle="预约成功通知";
      $biaoti="你发布的".$time.$title."行程已被导游成功预约，请尽快与导游联系";

      $banames = 'pmw_message';
      $sql = "INSERT INTO `$tbnames` (type, messagetype, templatetype, content,stitle, title, mid, faxtime) VALUES ('$type', '$messagetype', '$templatetype', '$tent', '$stitle', '$biaoti', $aid, $faxtime)";
      $dosql->ExecNoneQuery($sql);
  //===========================================================================================



  if($errcode_guide==0 && $errcode_agency==0){
      $State = 1;
      $Descriptor = '导游预约行程成功!，模板消息发送成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
    }else{
      $State = 0;
      $Descriptor = '导游预约行程成功,模板消息发送失败!';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
    }
  }else{
    $State = 3;
    $Descriptor = '您已有此时间段内行程，请合理安排出行时间!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }
}else{
  $State = 2;
  $Descriptor = '行程已经被预约，请重新预约新的行程!';
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
