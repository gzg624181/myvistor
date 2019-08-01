<?php
    /**
	   * 链接地址：search_travel  搜索行程
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
     * @提供返回参数账号  keyword=>   行程标题 title   行程起始时间 starttime_ymd   行程时间 days
     *                   用户的openid
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

    if(isset($keyword)){

    if(strpos($keyword,"-")){
          $starttime_ymd = $keyword;
    }elseif(is_numeric($keyword)){
          $days = $keyword;
    }else{
          $title = $keyword;
    }

    if(isset($title)){

    $dosql->Execute("SELECT * FROM pmw_travel where title like '%$title%' and  state=0 order by id desc ");

    }elseif(isset($starttime_ymd)){

    $dosql->Execute("SELECT * FROM pmw_travel where starttime_ymd ='$starttime_ymd' and state=0 order by id desc ");

    }elseif(isset($days)){

    $dosql->Execute("SELECT * FROM pmw_travel where days=$days and state=0 order by id desc ");

    }

    $num=$dosql->GetTotalRow();//获取数据条数

   }else{

   //当没有关键字搜索的时候
   $num=0;

   }

    //searchlist  搜索历史
    //list        搜索内容
    //recommand   推荐

    if($num>0){

    //如果搜索的有数据的时候，则将搜索记录保存到数据库中去
    if(isset($openid)){
    $two=2;
    $posttime=time();
    $r=$dosql->GetOne("SELECT keyword FROM pmw_searchlist where keyword='$keyword' and openid='$openid'");
    if(!is_array($r)){
    $sql="INSERT INTO  `#@__searchlist` (keyword,openid,posttime) values ('$keyword','$openid',$posttime)";
     $dosql->ExecNoneQuery($sql);
    }

     $dosql->Execute("SELECT * FROM `#@__searchlist` where openid='$openid' order by id desc limit  5",$two);
     while($show=$dosql->GetArray($two)){
      $Data['searchlist'][]=$show;
     }
   }

    while($row=$dosql->GetArray()){
      $Data['list'][]=$row;
    }
      //默认推荐四条数据
      $four=4;
      $dosql->Execute("SELECT * from pmw_travel where state=0 order by rand() limit 4",$four);
      while($sow=$dosql->GetArray($four)){
        $Data['recommand'][]=$sow;
      }
      $State = 1;
      $Descriptor = '搜索数据查询成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);
    }else{
      $six=6;
      $dosql->Execute("SELECT * FROM pmw_travel where state=0 order by rand() limit 4",$six);
      while($row=$dosql->GetArray($six)){
      $Data['recommand'][]=$row;
      }
      if(isset($openid)){
       $five=5;
       $dosql->Execute("SELECT * FROM `#@__searchlist` where openid='$openid' order by id desc limit 5",$five);

       while($go=$dosql->GetArray($five)){
       $Data['searchlist'][]=$go;
                      }
       }


      $State = 0;
      $Descriptor = '搜索数据为空，推荐数据获取成功！';
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
