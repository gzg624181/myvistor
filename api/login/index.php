<?php
    /**
	   * 链接地址：login  旅行社或者导游登陆
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
     * @提供返回参数账号  account  用户账号   password 用户密码   类型 type    更新最新的formid 登陆ip
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
  $m=$dosql->GetOne("SELECT id FROM `#@__agency` WHERE account='$account'");
  $n=$dosql->GetOne("SELECT id FROM `#@__guide` WHERE account='$account'");
  if(is_array($m) || is_array($n)){
    if($type=="agency"){
      $r=$dosql->GetOne("SELECT id FROM `#@__agency` WHERE account='$account'");
      if(!is_array($r)){  //如果传递过来的账号不存在，则不能更新他的formid
        $State = 0;
        $Descriptor = '账号类型选择错误，请重新选择！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $password=md5(md5($password));
      $r=$dosql->GetOne("SELECT * FROM `pmw_agency` where account='$account' and password='$password'");
        if(!is_array($r)){
          $State = 1;
          $Descriptor = '账号或者密码错误，请重新填写！';
          $result = array (
                      'State' => $State,
                      'Descriptor' => $Descriptor,
                      'Version' => $Version,
                      'Data' => $Data
                       );
          echo phpver($result);
          }else{
            if($r['checkinfo']==2){   //审核失败
              $State = 3;
              $Descriptor = '账号审核未通过，请重新注册！';
              $result = array (
                          'State' => $State,
                          'Descriptor' => $Descriptor,
                          'Version' => $Version,
                          'Data' => $Data
                           );
              echo phpver($result);
            }elseif($r['checkinfo']==0){//待审核
              $State = 4;
              $Descriptor = '账号正在审核中，请等待！';
              $result = array (
                          'State' => $State,
                          'Descriptor' => $Descriptor,
                          'Version' => $Version,
                          'Data' => $Data
                           );
              echo phpver($result);
            }else{
         //账号密码正确，且审核通过，则更新用户的formid
          $dosql->ExecNoneQuery("UPDATE `#@__agency` SET formid='$formid' WHERE account='$account' and password='$password'");
          //将用户的formid添加进去
          add_formid($openid,$formid);
          $show=$dosql->GetOne("SELECT * FROM `pmw_agency` where account='$account' and password='$password'");
          $Data[]=$show;
          $agreement=stripslashes($show['agreement']);
          $agreement=GetPic($agreement, $cfg_weburl);
          $Data[0]['type']='agency';
          $Data[0]['cardpic']=$cfg_weburl."/".$show['cardpic'];
          $Data[0]['images']=$cfg_weburl."/".$show['images'];
          $Data[0]['agreement']=$agreement;
          $State = 2;
          $Descriptor = '账号登陆成功';
          $result = array (
                      'State' => $State,
                      'Descriptor' => $Descriptor,
                      'Version' => $Version,
                      'Data' => $Data
                       );
          echo phpver($result);
          }
      }
      }
    }elseif($type=="guide"){
      $r=$dosql->GetOne("SELECT id FROM `#@__guide` WHERE account='$account'");
      if(!is_array($r)){  //如果传递过来的账号不存在，则不能更新他的formid
        $State = 0;
        $Descriptor = '账号类型选择错误，请重新选择！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $password=md5(md5($password));
      $r=$dosql->GetOne("SELECT * FROM `pmw_guide` where account='$account' and password='$password'");
        if(!is_array($r)){
          $State = 1;
          $Descriptor = '账号或者密码错误，请重新填写！';
          $result = array (
                      'State' => $State,
                      'Descriptor' => $Descriptor,
                      'Version' => $Version,
                      'Data' => $Data
                       );
          echo phpver($result);
      }else{
        if($r['checkinfo']==2){   //审核失败
          $State = 3;
          $Descriptor = '账号审核未通过，请重新注册！';
          $result = array (
                      'State' => $State,
                      'Descriptor' => $Descriptor,
                      'Version' => $Version,
                      'Data' => $Data
                       );
          echo phpver($result);
        }elseif($r['checkinfo']==0){//待审核
          $State = 4;
          $Descriptor = '账号正在审核中，请等待！';
          $result = array (
                      'State' => $State,
                      'Descriptor' => $Descriptor,
                      'Version' => $Version,
                      'Data' => $Data
                       );
          echo phpver($result);
        }else{
        //账号密码正确，则更新用户的formid
          $dosql->ExecNoneQuery("UPDATE `#@__guide` SET formid='$formid' WHERE account='$account' and password='$password'");
          //将用户的formid添加进去
           add_formid($openid,$formid);
          $show=$dosql->GetOne("SELECT * FROM `pmw_guide` where account='$account' and password='$password'");
          $Data[]=$show;
          $agreement=stripslashes($show['agreement']);
          $agreement=GetPic($agreement, $cfg_weburl);
          $pics=stripslashes($show['pics']);
          $pics=GetPics($pics, $cfg_weburl);
          $Data[0]['type']='guide';
          $Data[0]['card']=$cfg_weburl."/".$show['card'];
          $Data[0]['images']=$cfg_weburl."/".$show['images'];
          $Data[0]['agreement']=$agreement;
          $Data[0]['pics']=$pics;
          $State = 2;
          $Descriptor = '账号登陆成功';
          $result = array (
                      'State' => $State,
                      'Descriptor' => $Descriptor,
                      'Version' => $Version,
                      'Data' => $Data
                       );
          echo phpver($result);
          }
        }
      }
}
}else{
  $State = 5;
  $Descriptor = '账号还未注册，请先注册！';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $Data
               );
  echo phpver($result);
}
}
else{
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
