<?php


//获取发送数据数组
function getDataArray($openid,$type,$name,$tel,$state,$content,$applytime,$sendtime,$cfg_regfailed,$page,$form_id)
{
    $data = array(
        'touser' => $openid,                //要发送给用户的openid
        'template_id' => $cfg_regfailed,    //改成自己的模板id，在微信后台模板消息里查看
        'page' => $page,                     //点击模板消息详情之后跳转连接
		'form_id' => $form_id,              //form_id
        'data' => array(
            'keyword1' => array(
                'value' => $type,            //账户类型
                'color' => "#3d3d3d"
            ),
            'keyword2' => array(
                'value' => $name,             //企业名称
                'color' => "#3d3d3d"
            ),
            'keyword3' => array(
                'value' => $tel,              //手机号码
                'color' => "#3d3d3d"
            ),
            'keyword4' => array(
                'value' => $state,            //审核状态
                'color' => "#3d3d3d"
            ),
			'keyword5' => array(
                'value' => $content,           //失败原因
                'color' => "#173177"
            ),
			'keyword6' => array(
                'value' => $applytime,         //申请时间
                'color' => "#3d3d3d"
            ),
			'keyword7' => array(
                'value' => $sendtime,          //审核时间
                'color' => "#3d3d3d"
            )

        ),
    );
    return $data;
}


//curl请求函数，微信都是通过该函数请求,后台采用https_requests方法
function https_requests($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
//获取微信小程序 access_token
function get_access_token($appid,$appsecret){
  $arr = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret);  //去除对象里面的斜杠
  $result = json_decode($arr, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
  //logs('log.txt',$result);
  $access_token = $result['access_token'];
  return $access_token;
}

//获取微信小程序openid
function get_openid($code,$appid,$appsecret){
  $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code=' . $code . '&grant_type=authorization_code';
  $info = file_get_contents($url);//发送HTTPs请求并获取返回的数据，推荐使用curl
  $json = json_decode($info);//对json数据解码
  $arr = get_object_vars($json);
  $openid = $arr['openid'];
  return $openid;
}

function logs($file,$data){
  file_put_contents($file,print_r($data,true));
}
?>
