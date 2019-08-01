<?php
    /**
	   * 链接地址：reg_agency  旅行社注册接口
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
     * @旅行社注册接口   提供返回参数账号，
     * cardpic         营业执照(varchar)
     * address         公司地址(varchar)
     * name            联系人姓名(varchar)
     * tel             联系电话(varchar)
     * images          旅行社头像(varchar)默认第一次拉取微信头像
     * account         账号(varchar)
     * password        密码(varchar)
     * regtime         注册时间(int)
     * openid
     */
     require_once("../../include/config.inc.php");
     require_once("../../admin/sendmessage.php");
     $body = file_get_contents('php://input');
     $json = json_decode($body,true);
     header('Content-Type: application/json; charset=utf-8');
     //通过post格式传递过来

     $cardpic=$json['cardpic'];
     $address=$json['address'];
     $name=$json['name'];
     $tel=$json['tel'];
     $account=$json['account'];
     $password=$json['password'];
     $token=$json['token'];
     $images=$json['images'];
    // $code=$json['code'];
     $formid=$json['formid'];
     $company=$json['company'];
     $openid = $json['openid'];
     $formid = $json['formid'];

     //这个是自定义函数，将Base64图片转换为本地图片并保存
     $savepath= "../../uploads/image/";

     $cardpic = base64_image_content($cardpic,$savepath);
     $cardpic = str_replace("../../",'',$cardpic);

$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

$r=$dosql->GetOne("SELECT * FROM `#@__agency` WHERE account='$account'");
if(is_array($r)){ //判断当前注册的手机账号是否已经被注册过
  if($r['checkinfo']==0){
    $State = 3;
    $Descriptor = '此电话号码正在审核中，请等待管理员审核！';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }elseif($r['checkinfo']==1){
  $State = 0;
  $Descriptor = '此电话号码已经被注册，请重新注册！';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $Data
               );
  echo phpver($result);
  }

}else{
  $appid=$cfg_appid;
  $appsecret=$cfg_appsecret;
  //$openid=get_openid($code,$appid,$appsecret);
  $regtime=time();
  $regip=GetIP();
  $getcity=get_city($regip);
  $ymdtime=date("Y-m-d");
  $password=md5(md5($password));
  $sql = "INSERT INTO `#@__agency` (cardpic,address,name,tel,account,password,regtime,regip,ymdtime,images,getcity,openid,formid,company) VALUES ('$cardpic','$address','$name','$tel','$account','$password',$regtime,'$regip','$ymdtime','$images','$getcity','$openid','$formid','$company')";
  add_formid($openid,$formid);
  if($dosql->ExecNoneQuery($sql)){
  $State = 1;
  $Descriptor = '旅行社注册信息已提交,请等待管理员审核！';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $Data
               );
  echo phpver($result);
}else{
  $State = 2;
  $Descriptor = '旅行社注册信息提交失败！';
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
