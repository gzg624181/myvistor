<?php	if(!defined('IN_PHPMYWIND')) exit('Request Error!');

/*
**************************
(C)2018-2019 phpMyWind.com
update: 2019-03-03 16:55:36
person: Gang
**************************
*/

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

#转json格式数据
function phpvers($result){
	if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    $json = preg_replace_callback("#\\\u([0-9a-f]{4})#i", function ($matches) {
        return iconv('UCS-2BE', 'UTF-8', pack('H4', $matches[1]));
    }, json_encode($result));
	   return $json;
} else {
    $json = json_encode($result, JSON_UNESCAPED_UNICODE);
    return $json;
}
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

 # 旅行社添加行程

  function add_travel($getarray){
    //判断传了几条行程
		$num=(count($getarray) - 9) / 3;
	if($num==0){
		$content=array();
	}elseif($num == 1){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
                 )
			);
	  }elseif($num == 2){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" => strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
				 				 )
			);
		}elseif($num == 3){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" =>  strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
					      ),
				"2"=>array(
					"jinName" =>  $getarray['jinName3'],
				"starttime" =>  strtotime($getarray['starttime3']),
						 "days" =>  $getarray['days3']
				 		 )
			);
		}elseif($num == 4){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" =>  strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
					      ),
				"2"=>array(
					"jinName" =>  $getarray['jinName3'],
				"starttime" =>  strtotime($getarray['starttime3']),
						 "days" =>  $getarray['days3']
					 ),
				"3"=>array(
					"jinName" =>  $getarray['jinName4'],
				"starttime" => strtotime($getarray['starttime4']),
						 "days" =>  $getarray['days4']
								 )
			);
		}elseif($num==5){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" =>  strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
					      ),
				"2"=>array(
					"jinName" =>  $getarray['jinName3'],
				"starttime" =>  strtotime($getarray['starttime3']),
						 "days" =>  $getarray['days3']
					 ),
				"3"=>array(
					"jinName" =>  $getarray['jinName4'],
				"starttime" =>  strtotime($getarray['starttime4']),
						 "days" =>  $getarray['days4']
					 ),
				"4"=>array(
					"jinName" =>  $getarray['jinName5'],
				"starttime" =>  strtotime($getarray['starttime5']),
						 "days" =>  $getarray['days5']
				         )
			);
		}elseif($num==6){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" =>  strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
					      ),
				"2"=>array(
					"jinName" =>  $getarray['jinName3'],
				"starttime" =>  strtotime($getarray['starttime3']),
						 "days" =>  $getarray['days3']
					 ),
				"3"=>array(
					"jinName" =>  $getarray['jinName4'],
				"starttime" =>  strtotime($getarray['starttime4']),
						 "days" =>  $getarray['days4']
					 ),
				"4"=>array(
					"jinName" =>  $getarray['jinName5'],
				"starttime" =>  strtotime($getarray['starttime5']),
						 "days" =>  $getarray['days5']
					 ),
				"5"=>array(
					"jinName" =>  $getarray['jinName6'],
				"starttime" =>  strtotime($getarray['starttime6']),
						 "days" =>  $getarray['days6']
				)
			);
		}elseif($num==7){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" => strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" =>  strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
					      ),
				"2"=>array(
					"jinName" =>  $getarray['jinName3'],
				"starttime" =>  strtotime($getarray['starttime3']),
						 "days" =>  $getarray['days3']
					 ),
				"3"=>array(
					"jinName" =>  $getarray['jinName4'],
				"starttime" =>  strtotime($getarray['starttime4']),
						 "days" =>  $getarray['days4']
					 ),
				"4"=>array(
					"jinName" =>  $getarray['jinName5'],
				"starttime" =>  strtotime($getarray['starttime5']),
						 "days" =>  $getarray['days5']
					 ),
				"5"=>array(
					"jinName" =>  $getarray['jinName6'],
				"starttime" =>  strtotime($getarray['starttime6']),
						 "days" =>  $getarray['days6']
				),
				"6"=>array(
					"jinName" =>  $getarray['jinName7'],
				"starttime" =>  strtotime($getarray['starttime7']),
						 "days" =>  $getarray['days7']
				       )
			);
		}elseif($num==8){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" => strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
					      ),
				"2"=>array(
					"jinName" =>  $getarray['jinName3'],
				"starttime" =>  strtotime($getarray['starttime3']),
						 "days" =>  $getarray['days3']
					 ),
				"3"=>array(
					"jinName" =>  $getarray['jinName4'],
				"starttime" =>  strtotime($getarray['starttime4']),
						 "days" =>  $getarray['days4']
					 ),
				"4"=>array(
					"jinName" =>  $getarray['jinName5'],
				"starttime" =>  strtotime($getarray['starttime5']),
						 "days" =>  $getarray['days5']
					 ),
				"5"=>array(
					"jinName" =>  $getarray['jinName6'],
				"starttime" =>  strtotime($getarray['starttime6']),
						 "days" =>  $getarray['days6']
				),
				"6"=>array(
					"jinName" =>  $getarray['jinName7'],
				"starttime" =>  strtotime($getarray['starttime7']),
						 "days" =>  $getarray['days7']
					 ),
				 "7"=>array(
					 "jinName" =>  $getarray['jinName8'],
 				"starttime" =>  strtotime($getarray['starttime8']),
 						 "days" =>  $getarray['days8']
			 				     )
			);
		}elseif($num==9){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" =>  strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
					      ),
				"2"=>array(
					"jinName" =>  $getarray['jinName3'],
				"starttime" =>  strtotime($getarray['starttime3']),
						 "days" =>  $getarray['days3']
					 ),
				"3"=>array(
					"jinName" =>  $getarray['jinName4'],
				"starttime" => strtotime($getarray['starttime4']),
						 "days" =>  $getarray['days4']
					 ),
				"4"=>array(
					"jinName" =>  $getarray['jinName5'],
				"starttime" =>  strtotime($getarray['starttime5']),
						 "days" =>  $getarray['days5']
					 ),
				"5"=>array(
					"jinName" =>  $getarray['jinName6'],
				"starttime" =>  strtotime($getarray['starttime6']),
						 "days" =>  $getarray['days6']
				),
				"6"=>array(
					"jinName" =>  $getarray['jinName7'],
				"starttime" =>  strtotime($getarray['starttime7']),
						 "days" =>  $getarray['days7']
					 ),
				 "7"=>array(
					 "jinName" =>  $getarray['jinName8'],
 				"starttime" =>   strtotime($getarray['starttime8']),
 						 "days" =>   $getarray['days8']
					 ),
				"8"=>array(
					"jinName" =>  $getarray['jinName9'],
			 "starttime" =>   strtotime($getarray['starttime9']),
						"days" =>   $getarray['days9']
										)
			);
		}elseif($num==10){
			$content=array(
				"0"=>array(
					"jinName" =>  $getarray['jinName1'],
				"starttime" =>  strtotime($getarray['starttime1']),
						 "days" =>  $getarray['days1']
								 ),
				"1"=>array(
					"jinName" =>  $getarray['jinName2'],
				"starttime" =>  strtotime($getarray['starttime2']),
						 "days" =>  $getarray['days2']
								),
				"2"=>array(
					"jinName" =>  $getarray['jinName3'],
				"starttime" =>  strtotime($getarray['starttime3']),
						 "days" =>  $getarray['days3']
					 ),
				"3"=>array(
					"jinName" =>  $getarray['jinName4'],
				"starttime" => strtotime($getarray['starttime4']),
						 "days" =>  $getarray['days4']
					 ),
				"4"=>array(
					"jinName" =>  $getarray['jinName5'],
				"starttime" =>  strtotime($getarray['starttime5']),
						 "days" =>  $getarray['days5']
					 ),
				"5"=>array(
					"jinName" =>  $getarray['jinName6'],
				"starttime" =>  strtotime($getarray['starttime6']),
						 "days" =>  $getarray['days6']
				),
				"6"=>array(
					"jinName" =>  $getarray['jinName7'],
				"starttime" =>  strtotime($getarray['starttime7']),
						 "days" =>  $getarray['days7']
					 ),
				 "7"=>array(
					 "jinName" =>  $getarray['jinName8'],
				"starttime" =>   strtotime($getarray['starttime8']),
						 "days" =>   $getarray['days8']
					 ),
				"8"=>array(
					"jinName" =>  $getarray['jinName9'],
			 "starttime" =>   strtotime($getarray['starttime9']),
						"days" =>   $getarray['days9']
					),
				"9"=>array(
					"jinName" =>  $getarray['jinName10'],
			 "starttime" =>   strtotime($getarray['starttime10']),
						"days" =>   $getarray['days10']
					      	)
			);
		}
    //转为json格式的数据
		$json=phpvers($content);
		return $json;
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

// 计算旅游社所有的成功的计算总额


function sum($id){

	global $dosql;

	$r = $dosql->GetOne("SELECT SUM(jiesuanmoney) AS money  FROM pmw_travel  where aid=$id and state=2");

	$sum=$r['money'];

	return $sum;

}

//获取旅行社所有的信息

function get_agency($id){

 global $dosql;

 $r=$dosql->GetOne("SELECT * FROM pmw_agency where id=$id");

 $return= $r;

 return $return ;

}

//获取导游所有的信息

function get_guide($id){

 global $dosql;

 $r=$dosql->GetOne("SELECT * FROM pmw_guide where id=$id");

 $return= $r;

 return $return ;

}


//获取旅行社在同一年内发布 所有行程(所有的状态都算)

//传过来的旅行社的id和年份

function get_year($id,$y){

global $dosql;

$dosql->Execute("SELECT id FROM pmw_travel where aid=$id and fabu_y='$y'");

$num = $dosql->GetTotalRow();

return $num;

}

//获取旅行社发布的所有行程的年份

function get_years($id){

global $dosql;
$return=array();
$dosql->Execute("SELECT fabu_y FROM pmw_travel where aid=$id group by fabu_y");
while($show=$dosql->GetArray()){
	$return[]=$show;
}

return $return;

}

//旅行社成功发布的行程

function success_xingcheng($id,$y){

			global $dosql;

			$dosql->Execute("SELECT id FROM pmw_travel where aid=$id and state=2 and complete_y='$y'");

			$num = $dosql->GetTotalRow();

			return $num;

}


//计算旅行社一年之内的结算总额


function sum_year($id,$y){

	global $dosql;

	$r = $dosql->GetOne("SELECT SUM(jiesuanmoney) AS money  FROM pmw_travel  where aid=$id and state=2 and complete_y='$y'");

	$sum=$r['money'];

	return $sum;

}



//获取旅行社发布的所有行程的月份

function get_months($id,$y){

global $dosql;

$dosql->Execute("SELECT fabu_ym FROM pmw_travel where aid=$id and fabu_y='$y' group by fabu_ym");
while($show=$dosql->GetArray()){
	$return[]=$show;
}

return $return;

}


//计算旅行社一个月之内发布 的所有状态的行程


function sum_month($id,$y,$m){

	global $dosql;

	$dosql->Execute("SELECT id FROM pmw_travel where aid=$id and fabu_y='$y' and fabu_ym='$m'");

	$num = $dosql->GetTotalRow();

	return $num;

}

//计算旅行社一个月之内 已经完结的行程

function success_xingcheng_month($id,$y,$m){

  global $dosql;

	$dosql->Execute("SELECT id FROM pmw_travel where aid=$id and complete_y='$y' and complete_ym='$m'");

	$num=$dosql->GetTotalRow();

	return $num;

}


//计算旅行社一月之内的结算总额


function sum_months($id,$y,$m){

	global $dosql;

	$r = $dosql->GetOne("SELECT SUM(jiesuanmoney) AS money  FROM pmw_travel  where aid=$id and state=2 and complete_y='$y' and complete_ym='$m'");

	$sum=$r['money'];

	return $sum;

}


//判断旅行社当月已经完成的行程是否已经结算

function isjiesuan($id,$y,$m){

	global $dosql;

	$r = $dosql->GetOne("SELECT Settlement  FROM pmw_travel  where aid=$id and state=2 and complete_y='$y' and complete_ym='$m'");

  if(is_array($r)){
	$state=$r['Settlement'];
  }else{
	$state=NULL;
  }
	return $state;

}


//后台点击结算，统计结算当月的所有行程和金额

  function jiesuan($id,$y,$m){

  global $dosql;

  $agency_array =get_agency($id);

	$company =$agency_array['company'];

	$r = $dosql->GetOne("SELECT SUM(jiesuanmoney) AS money,SUM(num) as teamnumber,SUM(days) as days  FROM pmw_travel  where aid=$id and state=2 and complete_y='$y' and complete_ym='$m'");

	$teamnumber=$r['teamnumber'];  //带团总人数

	$summoney = $r['money'];

	$days = $r['days'];

	$jiesuantime= time();

	$sql = "INSERT INTO `#@__jiesuan` (aid,company,time,teamnumber,days,summoney,jiesuantime) VALUES ($id,'$company','$m', $teamnumber, $days, $summoney,$jiesuantime)";

	$dosql->ExecNoneQuery($sql);

	}


  //计算经典购票的总的张数

	function get_nums($id)
	{
		// code...
		global $dosql;

		$r=$dosql->GetOne("SELECT SUM(nums) as nums,SUM(totalamount) as totalamount FROM pmw_order where tid=$id");
    $num=$r['nums'];
    if($num==	NULL){
		$nums= 0;
		$totalamount=0;
		}else{
		$nums= $num;
		$totalamount=sprintf("%.2f",$r['totalamount']);
		}
		$get_array=array(
			"nums" => $nums,
			"total"=> $totalamount
		);
		return $get_array;
	}


	//当用户使用formid的时候，找出最新的fromid提供给用户
	 # 1.判断当前用户的所有的fromid是否已经过期
	 # 2.将最后一条没有过期的formid拿出来

	 function getformid($openid)
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

	 //获取微信小程序 access_token
	 function token($appid,$appsecret){
	   $arr = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret);  //去除对象里面的斜杠
	   $result = json_decode($arr, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
	   //logs('log.txt',$result);
	   $access_token = $result['access_token'];
	   return $access_token;
	 }


	 //用户购票成功之后，向购票管理员发送模板消息

	  function send_template_message($openid,$cfg_system_template_message,$page,$formid,$contact_name,$contact_tel,$content,$cfg_appid,$cfg_appsecret)
	 {
	 	// code...
	 	$data = array(
	 			'touser' => $openid,                              //要发送给发送模板消息的用户（导游或者旅行社）
	 	'template_id' => $cfg_system_template_message,         //改成自己的模板id，在微信后台模板消息里查看
	 				'page' => $page,                                 //点击模板消息详情之后跳转连接
	 		 'form_id' => $formid,                               //用户的formid
	 				'data' => array(
	 					'keyword1' => array(
	 							'value' => $contact_name,           //系统联系人
	 							'color' => "#3d3d3d"
	 					),
	 					'keyword2' => array(
	 							'value' => $contact_tel,            //联系人电话
	 							'color' => "#3d3d3d"
	 					),
	 					'keyword3' => array(
	 							'value' => $content,                //温馨提示
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

	 function del_formid($formid,$openid)
  {
  	// code... 删除使用完毕的formid

 	global $dosql;

 	$dosql->ExecNoneQuery("DELETE FROM `#@__formid` where formid='$formid' and openid='$openid'");

  }

  //获取旅行社的已经购票的总额
	function get_ticket_sum($id,$type)
	{
		// code...
		global $dosql;
		$r=$dosql->GetOne("SELECT SUM(nums) as nums from pmw_order where type='$type' and did=$id");
		$nums=$r['nums'];
		if($nums==null){
			$nums=0;
		}
		return $nums;
	}


   // 将未审核通过的旅行社的信息保存到数据库中去

	  function Save_Un_Agency($agency_array)
	 {
	 	// code...
		global $dosql;
		$cardpic=$agency_array['cardpic'];
		$address=$agency_array['address'];
		$name=$agency_array['name'];
		$tel = $agency_array['tel'];
		$account = $agency_array['account'];
		$password = $agency_array['password'];
		$regtime = $agency_array['regtime'];
		$regip = $agency_array['regip'];
		$ymdtime =$agency_array['ymdtime'];
		$images = $agency_array['images'];
		$getcity =$agency_array['getcity'];
		$openid= $agency_array['openid'];
		$formid= $agency_array['formid'];
		$company = $agency_array['company'];

		//将旅行社审核未通过的用户单独放到另外一个表里面,全部都是未审核的

		$sql = "INSERT INTO `#@__un_agency` (cardpic,address,name,tel,account,password,regtime,regip,ymdtime,images,getcity,openid,formid,company,checkinfo) VALUES ('$cardpic','$address','$name','$tel','$account','$password',$regtime,'$regip','$ymdtime','$images','$getcity','$openid','$formid','$company',2)";
		$dosql->ExecNoneQuery($sql);
	 }

	 // 将未审核通过的导游的信息保存到数据库中去

	  function Save_Un_Guide($guide_array)
	 {
	 	// code...
		global $dosql;
		$name=$guide_array['name'];
		$sex = $guide_array['sex'];
		$card = $guide_array['card'];
		$cardnumber = $guide_array['cardnumber'];
		$tel = $guide_array['tel'];
		$account = $guide_array['account'];
		$password =$guide_array['password'];
		$content = $guide_array['content'];
		$pics =$guide_array['pics'];
		$openid= $guide_array['openid'];
		$formid= $guide_array['formid'];
		$regtime = $guide_array['regtime'];
		$regip = $guide_array['regip'];
		$ymdtime = $guide_array['ymdtime'];
		$images = $guide_array['images'];
		$getcity = $guide_array['getcity'];

		//将导游审核未通过的用户单独放到另外一个表里面,全部都是未审核的

		$sql = "INSERT INTO `#@__un_guide` (name,sex,card,cardnumber,tel,account,password,content,pics,regtime,regip,ymdtime,images,getcity,openid,formid,checkinfo) VALUES ('$name',$sex,'$card','$cardnumber','$tel','$account','$password','$content','$pic',$regtime,'$regip','$ymdtime','$images','$getcity','$openid','$formid',2)";
		$dosql->ExecNoneQuery($sql);
	 }


//替换编辑器里面的图片链接 ，前面自动加上域名
/**
 * 替换fckedit中的图片 添加域名
 * @param  string $content 要替换的内容
 * @param  string $strUrl 内容中图片要加的域名
 * @return string
 * @eg
 */
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

 //计算当月有多少天

function getMonthLastDay($month, $year) {
switch ($month) {
case 4 :
case 6 :
case 9 :
case 11 :
$days = 30;
break;
case 2 :
if ($year % 4 == 0) {
if ($year % 100 == 0) {
$days = $year % 400 == 0 ? 29 : 28;
} else {
$days = 29;
}
} else {
$days = 28;
}
break;

default :
$days = 31;
break;
}
return $days;
}

//添加景区规格的时候，自动将此规格一年的价格生成出来

function add_default_price($tid,$sid,$price)
{
	// code...
  global $dosql;

	$year=date("Y");

  for($j=1;$j<=12;$j++){

	$days=getMonthLastDay($j, $year);

	for($i=1;$i<=$days;$i++){
		$month=str_pad($j,2,"0",STR_PAD_LEFT);
		$day=str_pad($i,2,"0",STR_PAD_LEFT);
		$datetimes =date($year."-".$month."-".$day);
		$timestamps = strtotime($datetimes);
		$month=str_pad($month,2,"0",STR_PAD_LEFT);
    $dosql->ExecNoneQuery("INSERT INTO pmw_selectdate (tid,sid,timestamps,datetimes,price,years,month,days) VALUES ($tid,$sid,$timestamps,'$datetimes','$price',$year,'$month','$day')");
	}

  }

}

function get_member_nums($openid){

	 global $dosql;

	 $dosql->Execute("SELECT * FROM pmw_publish where openid= '$openid'");

	 $nums = $dosql->GetTotalRow();

	 return $nums;
}
?>
