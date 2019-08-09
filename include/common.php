<?php	if(!defined('IN_PHPMYWIND')) exit('Request Error!');

function phpver($result){
	if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    $json = preg_replace_callback("#\\\u([0-9a-f]{4})#i", function ($matches) {
        return iconv('UCS-2BE', 'UTF-8', pack('H4', $matches[1]));
    }, json_encode($result));
	   return $json;
} else {
    $json = json_encode($result, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    return $json;
}
}

//base64图片转码

function base64_image_content($base64_image_content,$path){
   //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/',
    $base64_image_content, $result)){ //后缀
    $type = $result[2]; //创建文件夹，以年月日
    $new_file = $path.date('Ymd',time())."/";
    if(!file_exists($new_file)){ //检查是否有该文件夹，如果没有就创建，并给予最高权限
    mkdir($new_file, 0700);
    }
    $new_file = $new_file.time().rand(111,999).".{$type}"; //图片名以时间命名
    //保存为文件
    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
    //返回这个图片的路径
    return $new_file;
   }else{
  return false;
  }}else{ return false; }
 }


//post传值
	function post($url, $data, $proxy = null, $timeout = 20) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //在HTTP请求中包含一个"User-Agent: "头的字符串。
	curl_setopt($curl, CURLOPT_HEADER, 0); //启用时会将头文件的信息作为数据流输出。
	curl_setopt($curl, CURLOPT_POST, true); //发送一个常规的Post请求
	curl_setopt($curl,  CURLOPT_POSTFIELDS, $data);//Post提交的数据包
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //文件流形式
	curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); //设置cURL允许执行的最长秒数。
	$content = curl_exec($curl);
	curl_close($curl);
	unset($curl);
	return $content;
	}

	//POST请求函数
	function https_request($url,$data = null){
			$curl = curl_init();

			curl_setopt($curl,CURLOPT_URL,$url);
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);

			if(!empty($data)){//如果有数据传入数据
					curl_setopt($curl,CURLOPT_POST,1);//CURLOPT_POST 模拟post请求
					curl_setopt($curl,CURLOPT_POSTFIELDS,$data);//传入数据
			}

			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			$output = curl_exec($curl);
			curl_close($curl);

			return $output;
	}

//判断登陆的设备是安卓还是苹果
function get_device_type(){
 $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
 $type = '3';
 if(strpos($agent, 'iphone') || strpos($agent, 'ipad')){
  $type = "1";
 }
 if(strpos($agent, 'android')){
  $type = "0";
 }
 return $type;
}
//获取当前ip的城市
function get_city($ip){
		$url = "http://ip.taobao.com/service/getIpInfo.php?ip={$ip}";
    $ret = https_request($url);
    $jsonAddress = json_decode($ret,true);
		if($jsonAddress['code']==0){
      return $jsonAddress['data']['country']."-".$jsonAddress['data']['region']."-".$jsonAddress['data']['city'];
    }else{
      return "地址未知";
    }
}





//导游预约成功提醒,给导游发送模板消息
function SendGuide($openid,$company,$name,$tel,$title,$time,$tishi,$cfg_guide_appointment,$page,$form_id)
{
    $data = array(
        'touser' => $openid,                   //要发送给导游的openid
   'template_id' => $cfg_guide_appointment,    //改成自己的模板id，在微信后台模板消息里查看
          'page' => $page,                     //点击模板消息详情之后跳转连接
		   'form_id' => $form_id,                   //form_id
          'data' => array(
            'keyword1' => array(
                'value' => $company,            //旅行社公司名称
                'color' => "#3d3d3d"
            ),
            'keyword2' => array(
                'value' => $name,               //旅行社联系人姓名
                'color' => "#3d3d3d"
            ),
            'keyword3' => array(
                'value' => $tel,                //旅行社联系人电话
                'color' => "#3d3d3d"
            ),
            'keyword4' => array(
                'value' => $title,              //行程标题
                'color' => "#3d3d3d"
            ),
			'keyword5' => array(
                'value' => $time,               //行程起始时间
                'color' => "#173177"
            ),
			'keyword6' => array(
                'value' => $tishi,               //温馨提示
                'color' => "#3d3d3d"
            )
        ),
    );
    return $data;
}


//旅行社（行程提醒）,给旅行社发送模板消息
function SendAgency($openid,$title,$tel,$name,$time,$timestamp,$cfg_agency_remind,$page,$form_id)
{
    $data = array(
        'touser' => $openid,                   //要发送给旅行社的openid
   'template_id' => $cfg_agency_remind,        //改成自己的模板id，在微信后台模板消息里查看
          'page' => $page,                     //点击模板消息详情之后跳转连接
		   'form_id' => $form_id,                   //form_id
          'data' => array(
            'keyword1' => array(
                'value' => $title,            //行程名称
                'color' => "#3d3d3d"
            ),
            'keyword2' => array(
                'value' => $tel,               //领队电话（导游电话）
                'color' => "#3d3d3d"
            ),
            'keyword3' => array(
                'value' => $name,                //领队姓名（导游姓名）
                'color' => "#3d3d3d"
            ),
            'keyword4' => array(
                'value' => $time,              //行程时间（行程的时间段）
                'color' => "#3d3d3d"
            ),
			'keyword5' => array(
                'value' => $timestamp,               //预约时间（当前时间）
                'color' => "#173177"
            )
        ),
    );
    return $data;
}


# 旅行社取消发布的行程，给旅行社发布行程提醒

function CancelAgency($title,$time,$reason,$tishi,$openid,$cfg_cancel_guide,$page,$form_id){

	$data = array(
			'touser' => $openid,                   //要发送给旅行社的openid
	'template_id' => $cfg_cancel_guide,       //改成自己的模板id，在微信后台模板消息里查看
				'page' => $page,                     //点击模板消息详情之后跳转连接
		 'form_id' => $form_id,                   //form_id
				'data' => array(
					'keyword1' => array(
							'value' => $title,             //出发行程
							'color' => "#3d3d3d"
					),
					'keyword2' => array(
							'value' => $time,               //行程时间
							'color' => "#3d3d3d"
					),
					'keyword3' => array(
							'value' => $reason,             //取消原因
							'color' => "#3d3d3d"
					),
					'keyword4' => array(
							'value' => $tishi,              //温馨提示
							'color' => "#3d3d3d"
					)
			),
	);
	return $data;

}

# 旅行社取消发布的行程，给导游发送模板消息提醒

function CancelGuide($title,$time,$nickname,$tel,$reason,$tishi,$openid,$cfg_cancel_guide,$page,$form_id){

	$data = array(
			'touser' => $openid,                   //要发送给旅行社的openid
	'template_id' => $cfg_cancel_guide,       //改成自己的模板id，在微信后台模板消息里查看
				'page' => $page,                     //点击模板消息详情之后跳转连接
		 'form_id' => $form_id,                   //form_id
				'data' => array(
					'keyword1' => array(
							'value' => $title,             //出发行程
							'color' => "#3d3d3d"
					),
					'keyword2' => array(
							'value' => $time,               //行程时间
							'color' => "#3d3d3d"
					),
					'keyword3' => array(
							'value' => $nickname,             //昵称（旅行社联系人的姓名）
							'color' => "#3d3d3d"
					),
					'keyword4' => array(
							'value' => $tel,              //手机号码(旅行社联系人的电话号码)
							'color' => "#3d3d3d"
					),
					'keyword5' => array(
							'value' => $reason,              //取消原因
							'color' => "#3d3d3d"
					),
					'keyword6' => array(
							'value' => $tishi,              //温馨提示
							'color' => "#3d3d3d"
					)
			),
	);
	return $data;

}

//匹配测试
function check_str($str, $substr)
{
 $nums=substr_count($str,$substr);

 if ($nums>=1)
 {
	return true;
 }
 else
 {
	return false;
 }
}

//获取旅行社发布的所有已完成的行程的月份

function get_months_success($id,$y){

global $dosql;


$dosql->Execute("SELECT complete_ym as time FROM pmw_travel where aid=$id and complete_y='$y' group by complete_ym");

$num=$dosql->GetTotalRow();
$arr =array();
if($num==0){
while($show=$dosql->GetArray()){
	$arr[]=$show;
}
}else{
	$arr =array();
}
return $arr;

}


//获取旅行社已经发布成功的行程的状态
function get_agency_state($id,$y,$m){

global $dosql;

$r = $dosql->GetOne("SELECT SUM(jiesuanmoney) AS money,SUM(num) as teamnumber,SUM(days) as days,Settlement  FROM pmw_travel  where aid=$id and state=2 and complete_y='$y' and complete_ym='$m'");

$return =$r;

return $return;
}


//获取导游已经带团成功的次数和带团人数


function get_guide_num($id){

 global $dosql;

 $arr=array();

 $dosql->Execute("SELECT  id FROM pmw_travel where state=2 and gid=$id");

 $team_num = $dosql->GetTotalRow();

 $r=$dosql->GetOne("SELECT SUM(num) as num FROM pmw_travel where state=2 and gid=$id");

	if(is_array($r)){
	 $people_num = $r['num'];
  }else{
	 $people_num = 0;
	}

 $arr =array(
	       "team"=>$team_num,
				 "people"=>intval($people_num)
 );

return $arr;

}


//获取旅行社已经发布成功的次数和带团人数


function get_agency_num($id){

 global $dosql;

 $arr=array();

 $dosql->Execute("SELECT  id FROM pmw_travel where state=2 and aid=$id");

 $team_num = $dosql->GetTotalRow();

 $r=$dosql->GetOne("SELECT SUM(num) as num FROM pmw_travel where state=2 and aid=$id");

	if(is_array($r)){
	 $people_num = $r['num'];
  }else{
	 $people_num = 0;
	}

 $arr =array(
	       "team"=>$team_num,
				 "people"=>intval($people_num)
 );

return $arr;

}

//获取关注的微信小程序的openid

//获取微信小程序openid
function openid($code,$appid,$appsecret){
  $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code=' . $code . '&grant_type=authorization_code';
  $info = file_get_contents($url);//发送HTTPs请求并获取返回的数据，推荐使用curl
  $json = json_decode($info);//对json数据解码
  $arr = get_object_vars($json);

	if(isset($arr['openid'])){
  $openid = $arr['openid'];
	}else{
		$openid ="";
	}

  return $openid;
}


//用户购票成功之后，发送购票成功的模板消息

 function paysuccess($openid,$cfg_paysuccess,$page,$form_id,$jingquname,$typename,$nums,$totalamount,$posttime,$tishi,$cfg_appid,$cfg_appsecret)
{
	// code...
	$data = array(
			'touser' => $openid,                     //要发送给购票用户的openid
	'template_id' => $cfg_paysuccess,            //改成自己的模板id，在微信后台模板消息里查看
				'page' => $page,                      //点击模板消息详情之后跳转连接
		 'form_id' => $form_id,                   //购票用户的formid
				'data' => array(
					'keyword1' => array(
							'value' => $jingquname,          //景区名称
							'color' => "#3d3d3d"
					),
					'keyword2' => array(
							'value' => $typename,            //票务类型
							'color' => "#3d3d3d"
					),
					'keyword3' => array(
							'value' => $nums,               //购买张数
							'color' => "#3d3d3d"
					),
					'keyword4' => array(
							'value' => $totalamount,        //购票总金额
							'color' => "#3d3d3d"
					),
					'keyword5' => array(
							'value' => $posttime,        //购买时间
							'color' => "#3d3d3d"
					),
					'keyword6' => array(
							'value' => $tishi,        //温馨提示
							'color' => "#3d3d3d"
					)
			),
	);

	$ACCESS_TOKEN = token($cfg_appid,$cfg_appsecret);//ACCESS_TOKEN

	//模板消息请求URL
	$url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$ACCESS_TOKEN;

	$data = json_encode($data);//转化成json数组让微信可以接收
	$data = https_request($url, urldecode($data));//请求开始
	$data = json_decode($data, true);
	// $errcode=$data['errcode'];  //判断模板消息发送是否成功
	// return $errcode;
}


//用户购票成功之后，向购票管理员发送模板消息

 function ticketsuccess($openid,$cfg_ticketsuccess,$page,$form_id,$jingquname,$typename,$usetime,$nums,$type,$totalamount,$contactname,$contacttel,$paytype,$posttime,$cfg_appid,$cfg_appsecret)
{
	// code...
	$data = array(
			'touser' => $openid,                     //要发送给购票管理员的openid
	'template_id' => $cfg_ticketsuccess,         //改成自己的模板id，在微信后台模板消息里查看
				'page' => $page,                      //点击模板消息详情之后跳转连接
		 'form_id' => $form_id,                   //购票用户的formid
				'data' => array(
					'keyword1' => array(
							'value' => $jingquname,          //景区名称
							'color' => "#3d3d3d"
					),
					'keyword2' => array(
							'value' => $typename,            //票务类型
							'color' => "#3d3d3d"
					),
					'keyword3' => array(
							'value' => $usetime,               //出发日期
							'color' => "#3d3d3d"
					),
					'keyword4' => array(
							'value' => $nums,                 //订票数量
							'color' => "#3d3d3d"
					),
					'keyword5' => array(
							'value' => $type,               //订单类型（用户的类型）
							'color' => "#3d3d3d"
					),
					'keyword6' => array(
							'value' => $totalamount,          //订单总金额
							'color' => "#3d3d3d"
					),
					'keyword7' => array(
							'value' => $contactname,          //联系人姓名
							'color' => "#3d3d3d"
					),
					'keyword8' => array(
							'value' => $contacttel,          //联系人手机
							'color' => "#3d3d3d"
					),
					'keyword9' => array(
							'value' => $paytype,              //支付方式
							'color' => "#3d3d3d"
					),
					'keyword10' => array(
							'value' => $posttime,             //支付时间
							'color' => "#3d3d3d"
					)
			),
	);

	$ACCESS_TOKEN = token($cfg_appid,$cfg_appsecret);//ACCESS_TOKEN

	//模板消息请求URL
	$url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$ACCESS_TOKEN;

	$data = json_encode($data);//转化成json数组让微信可以接收
	$data = https_request($url, urldecode($data));//请求开始
	$data = json_decode($data, true);
	// $errcode=$data['errcode'];  //判断模板消息发送是否成功
	// return $errcode;
}

//获取微信小程序 access_token
function token($appid,$appsecret){
  $arr = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret);  //去除对象里面的斜杠
  $result = json_decode($arr, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
  //logs('log.txt',$result);
  $access_token = $result['access_token'];
  return $access_token;
}

//获取导游或者旅行社的信息
function get_information($id,$type)
{
	// code...
	global $dosql;
	$data=array();
	if($type=="agency"){
		$r=$dosql->GetOne("SELECT * FROM pmw_agency where id=$id");
		if(is_array($r)){
			$data=$r;
		}
	}elseif($type=="guide"){
		$r=$dosql->GetOne("SELECT * FROM pmw_guide where id=$id");
		if(is_array($r)){
			$data=$r;
		}
	}
  return $data;
}

//获取当前购票成功的id
 function get_orderid($did,$posttime)
{
	// code...
  global $dosql;

	$r=$dosql->GetOne("SELECT id FROM pmw_order where did=$did and posttime=$posttime");

	$id=$r['id'];

	return $id;
}

//获取购票管理员的openid和formid

 function get_openid_formid()
{
	// code...
  global $dosql;
	$r=$dosql->GetOne("SELECT openid FROM pmw_members where sets=1");
	return $r;
}

//保存用户的formid，同时将过期的formid删除掉

function add_formid($openid,$formid)
{
	// code...  将所有的用户的最新的formid保存到数据库中来

  global $dosql;

  $guoqi_time = strtotime("+7 days");  //设置7天过期时间

	$dosql->ExecNoneQuery("INSERT INTO `#@__formid` (formid,openid,guoqi_time) VALUES ('$formid','$openid',$guoqi_time)");

}

//当用户使用formid的时候，找出最新的fromid提供给用户
 # 1.判断当前用户的所有的fromid是否已经过期
 # 2.将最后一条没有过期的formid拿出来

 function get_new_formid($openid)
 {
 	// code...
  global $dosql;

	$formid="";

	$now=time();  //当前的时间戳

	//删除formid表里面 openid是空的数据 ，同时删除 formid为本机测试产生的数据 the formId is a mock one
	 $dosql->ExecNoneQuery("DELETE FROM `#@__formid` where openid ='' or formid='the formId is a mock one'");

	//删除七天的过期的formid
	$dosql->ExecNoneQuery("DELETE FROM `#@__formid` where guoqi_time <= $now and openid='$openid'");

	$k=$dosql->GetOne("SELECT MIN(id) as id	FROM `#@__formid` where openid='$openid'");

	$ids=$k['id'];

	$r=$dosql->GetOne("SELECT formid FROM `#@__formid` where id=$ids");


  if(is_array($r)){

	$formid=$r['formid'];

  }

	return $formid;
 }

 //用户使用完毕formid之后，删除已经已经使用过的formid

  function del_formid($formid,$openid)
 {
 	// code... 删除使用完毕的formid

	global $dosql;

	$dosql->ExecNoneQuery("DELETE FROM `#@__formid` where formid='$formid' and openid='$openid'");

 }


function save_erweima($access_token,$xiaochengxu_path,$save_path,$url,$id,$uid,$poster) {
    $post_url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=$access_token";
    $width = '200';
  	$scene = $uid."&".$id;   //uid发布人的用户id    id  当前动态的id
    $post_data='{"page":"'.$xiaochengxu_path.'","width":'.$width.',"scene":"'.$scene.'"}';
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $post_data
        )
    );
    $context = stream_context_create($opts);
    $result = file_get_contents($post_url, false, $context);
    $file_path = $save_path;
    $bytes = file_put_contents($file_path, $result);
    return $url;
}

/**
 *图片加水印
 *@param $srcImg 原图
 *@param $waterImg 水印图片
 *@param $savepath 保存路径
 *@param $savename 保存名字
 *@param $position 水印位置
 *1：左上  2：右上 3:居中 4：左下 5：右下
 *@param $opacity 透明度
 *0:全透明 100：完全不透明
 *@return  成功 -- 加水印后的新图片地址
 *         失败 -- -1：源文件不存在，-2：水印不存在，-3源文件图片对象建立失败，-4：水印文件图像对象建立失败，-5：加水印后的新图片保存失败
 * 获取源文件路径、宽高等信息，得出保存后文件保存路径、水印放置位置->建立源文件和水印图片对象->合并图片对象（imagecopymerge）->销毁图片对象
 */


function img_create_from_ext($imgfile){
    $info = getimagesize($imgfile);
    $im = null;
    switch ($info[2]) {
        case 1:
            $im = imagecreatefromgif($imgfile);
            break;
        case 2:
            $im = imagecreatefromjpeg($imgfile);
            break;
        case 3:
            $im = imagecreatefrompng($imgfile);
            break;
    }
    return $im;
}



function img_water_mark($srcImg, $waterImg, $savepath=null, $savename=null, $position=5, $opacity=50){
    $temp = pathinfo($srcImg);
    $name = $temp['basename'];
    $path = $temp['dirname'];
  //  $exte = $temp['extension'];
    $savename = $savename ? $savename : $name;
    $savepath = $savepath ? $savepath : $path;
    $savefile = $savepath.'/'.$savename;

    $srcinfo = @getimagesize($srcImg);
    if(!$srcinfo){
        return -1;
    }
    $waterinfo = @getimagesize($waterImg);
    if(!$waterinfo){
        return -2;
    }
    $srcImgObj = img_create_from_ext($srcImg);
    if(!$srcImgObj){
        return -3;
    }
    $waterImgObj = img_create_from_ext($waterImg);
    if(!$waterImgObj){
        return -4;
    }
    switch ($position) {
        case 1:
            $x=$y=0;
            break;
        case 2:
            $x=$srcinfo[0] /2.8;
            $y=$waterinfo[1]/1.5;
            break;
        case 3:
            $x=($srcinfo[0] - $waterinfo[0])/2;
            $y=($srcinfo[1] - $waterinfo[1])/2;
            break;
        case 4:
            $x=0;
            $y=$srcinfo[1] - $waterinfo[1];
            break;
        case 5:
            $x=$srcinfo[0] /2;
            $y=$srcinfo[1] - $waterinfo[1]*1.5;
            break;
    }
    // 合并图片+水印
    imagecopymerge($srcImgObj, $waterImgObj, $x, $y, 0, 0, $waterinfo[0], $waterinfo[1], $opacity);

    switch ($srcinfo[2]) {
        case 1:
            imagegif($srcImgObj, $savefile);
            break;
        case 2:
            imagejpeg($srcImgObj, $savefile);
            break;
        case 3:
            imagepng($srcImgObj, $savefile);
            break;
        default: return -5;
    }
    imagedestroy($srcImgObj);
    imagedestroy($waterImgObj);
    return $savefile;
}

function pngMerge($o_pic,$out_pic){
$begin_r = 255;
$begin_g = 250;
$begin_b = 250;
list($src_w, $src_h) = getimagesize($o_pic);// 获取原图像信息 宽高
$src_im = imagecreatefrompng($o_pic); //读取png图片
//print_r($src_im);
imagesavealpha($src_im,true);//这里很重要 意思是不要丢了$src_im图像的透明色
$src_white = imagecolorallocatealpha($src_im, 255, 255, 255,127); // 创建一副白色透明的画布
for ($x = 0; $x < $src_w; $x++) {
 for ($y = 0; $y < $src_h; $y++) {
	 $rgb = imagecolorat($src_im, $x, $y);
	 $r = ($rgb >> 16) & 0xFF;
	 $g = ($rgb >> 8) & 0xFF;
	 $b = $rgb & 0xFF;
	 if($r==255 && $g==255 && $b == 255){
	 imagefill($src_im,$x, $y, $src_white); //填充某个点的颜色
	 imagecolortransparent($src_im, $src_white); //将原图颜色替换为透明色
	 }
	 if (!($r <= $begin_r && $g <= $begin_g && $b <= $begin_b)) {
		imagefill($src_im, $x, $y, $src_white);//替换成白色
		imagecolortransparent($src_im, $src_white); //将原图颜色替换为透明色
	 }
 }
}
$target_im = imagecreatetruecolor($src_w, $src_h);//新图
imagealphablending($target_im,false);//这里很重要,意思是不合并颜色,直接用$target_im图像颜色替换,包括透明色;
imagesavealpha($target_im,true);//这里很重要,意思是不要丢了$target_im图像的透明色;
$tag_white = imagecolorallocatealpha($target_im, 255, 255, 255,127);//把生成新图的白色改为透明色 存为tag_white
imagefill($target_im, 0, 0, $tag_white);//在目标新图填充空白色
imagecolortransparent($target_im, $tag_white);//替换成透明色
imagecopymerge($target_im, $src_im, 0, 0, 0, 0, $src_w, $src_h, 100);//合并原图和新生成的透明图
imagepng($target_im,$out_pic);
// return $out_pic;
}


// 空闲时间发送模板消息提醒

function Send_Remind($starttime,$title)
{
	// code...  计算所有导游发布的空闲时间,每天只能发送一次
  global $dosql,$cfg_free_time,$cfg_appid,$cfg_appsecret;

  $todaytime=strtotime(date("Y-m-d"));

	$dosql->Execute("SELECT * FROM pmw_freetime where usetime <> $todaytime");

	while($row=$dosql->GetArray()){

		$content1= $row['content'];  //导游发布的所有的空闲时间

		if(check_str($content1,$starttime)){  //进行匹配操作

    $gid= $row['gid'];  //导游的id

		$id= $row['id'];  //当前用户发布的空闲时间id

		$array=Get_Guide_Infromation($gid);

    $openids=$array['openid'];

		$name=$array['name'];

		$formids=get_new_formid($openids);

		$travel_date=date("Y-m-d",$starttime);

		$travel_bak="亲爱的".$name."你好，与您空闲时间匹配的行程已经出现，请点击进入我的小程序查看详情";

  	$page="pages/searchDetail/index?data=".$travel_date."&search=true";

		$travel_date=date("Y-m-d",$starttime)."开始出发";

		Send_Freetime_Message($openids,$cfg_free_time,$page,$formids,$title,$travel_date,$travel_bak,$cfg_appid,$cfg_appsecret);

	  del_formid($formids,$openids);

		//将用户今天的空闲时间更改为一次，每天只能有一次发送模板消息的机会

		$dosql->ExecNoneQuery("UPDATE pmw_freetime SET usetime=$todaytime where id=$id");

		}
	}

}


// 发送空闲时间模板消息
function Send_Freetime_Message($openid,$cfg_free_time,$page,$formid,$travel_name,$travel_date,$travel_bak,$cfg_appid,$cfg_appsecret)
{
 // code...
 $data = array(
		 'touser' => $openid,                     //要发送给导游的openid
 'template_id' => $cfg_free_time,            //改成自己的模板id，在微信后台模板消息里查看
			 'page' => $page,                      //点击模板消息详情之后跳转连接
		'form_id' => $formid,                   //导游的formid
			 'data' => array(
				 'keyword1' => array(
						 'value' => $travel_name,          //行程名称
						 'color' => "#3d3d3d"
				 ),
				 'keyword2' => array(
						 'value' => $travel_date,            //行程日期
						 'color' => "#3d3d3d"
				 ),
				 'keyword3' => array(
						 'value' => $travel_bak,               //行程备注
						 'color' => "#3d3d3d"
				 )
		 ),
 );

 $ACCESS_TOKEN = token($cfg_appid,$cfg_appsecret);//ACCESS_TOKEN

 //模板消息请求URL
 $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$ACCESS_TOKEN;

 $data = json_encode($data);//转化成json数组让微信可以接收
 $data = https_request($url, urldecode($data));//请求开始
 $data = json_decode($data, true);
 // $errcode=$data['errcode'];  //判断模板消息发送是否成功
 // return $errcode;
}

//获取导游的信息
function Get_Guide_Infromation($id)
{
	// code...
	global $dosql;

	$r=$dosql->GetOne("SELECT * from pmw_guide where id=$id");

	return $r;
}

//替换编辑器里面的图片链接 ，前面自动加上域名
/**
 * 替换fckedit中的图片 添加域名
 * @param  string $content 要替换的内容
 * @param  string $strUrl 内容中图片要加的域名
 * @return string
 * @eg
 */
 function GetPic($content = null, $strUrl = null) {
 		if ($strUrl) {
 		     $img=json_decode($content,TRUE);
 					if (!empty($img)) {
 								$patterns= array();
 								$replacements = array();
 								foreach($img as $imgItem){
 									if(!filter_var($imgItem, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)){
 										$final_imgUrl = $strUrl."/".$imgItem;
 									}else{
 										$final_imgUrl = $imgItem;
 									}
 										$replacements[] = $final_imgUrl;
 										$img_new = "/".preg_replace("/\//i","\/",$imgItem)."/";
 										$patterns[] = $img_new;
 								}

 								//让数组按照key来排序
 								ksort($patterns);
 								ksort($replacements);

 								//替换内容
 								$vote_content = preg_replace($patterns, $replacements, $content);

 								return $vote_content;


 				}else {
 						return $content;
 				}
 		} else {
 				return $content;
 		}
 }

 //替换相册里面的图片，加上域名、

 function GetPics($content = null, $strUrl = null) {
 		if ($strUrl) {
 		     $img=explode("|",$content);
 					if (!empty($img)) {
 								$patterns= array();
 								$replacements = array();
 								foreach($img as $imgItem){
 									if(!filter_var($imgItem, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)){
 										$final_imgUrl = $strUrl."/".$imgItem;
 									}else{
 										$final_imgUrl = $imgItem;
 									}
 										$replacements[] = $final_imgUrl;
 										$img_new = "/".preg_replace("/\//i","\/",$imgItem)."/";
 										$patterns[] = $img_new;
 								}

 								//让数组按照key来排序
 								ksort($patterns);
 								ksort($replacements);

 								//替换内容
 								$vote_content = preg_replace($patterns, $replacements, $content);

 								return $vote_content;


 				}else {
 						return $content;
 				}
 		} else {
 				return $content;
 		}
 }

 function rePic($content = null, $strUrl = null) {
 		if ($strUrl) {
 				//提取图片路径的src的正则表达式 并把结果存入$matches中
 				preg_match_all("/<img(.*)src=\"([^\"]+)\"[^>]+>/U",$content,$matches);
 				$img = "";
 				if(!empty($matches)) {
 				//注意，上面的正则表达式说明src的值是放在数组的第三个中
 				$img = $matches[2];
 				}else {
 				$img = "";
 				}

 					if (!empty($img)) {
 								$patterns= array();
 								$replacements = array();
 								foreach($img as $imgItem){
 									if(!filter_var($imgItem, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)){
 										$final_imgUrl = $strUrl.$imgItem;
 									}else{
 										$final_imgUrl = $imgItem;
 									}
 										$replacements[] = $final_imgUrl;
 										$img_new = "/".preg_replace("/\//i","\/",$imgItem)."/";
 										$patterns[] = $img_new;
 								}

 								//让数组按照key来排序
 								ksort($patterns);
 								ksort($replacements);

 								//替换内容
 								$vote_content = preg_replace($patterns, $replacements, $content);

 								return $vote_content;


 				}else {
 						return $content;
 				}
 		} else {
 				return $content;
 		}
 }
?>
