<?php
require_once(dirname(__FILE__).'/include/config.inc.php');
// include("sendmessage.php");
// $appid=$cfg_appid;
// $appsecret=$cfg_appsecret;
// $code="011ZW5ci0uBaip1Xfmei0Tpcci0ZW5cJ";
// $openid=get_openid($code,$appid,$appsecret);
// echo $openid;

// 获取ajax传来的base64编码，$_POST['img']是你后台获取到的图片
// $r=$dosql->GetOne("SELECT pics FROM pmw_guide where id=24");
// $base64_image_content = $r['pics'];
// $myfile=fopen('cc.txt','r');
// $base64_image_content=fgets($myfile);
//
// $arr=explode("|",$base64_image_content);
// $savepath= "./uploads/image/";
// $pic="";
// //这个是自定义函数，将Base64图片转换为本地图片并保存
// for($i=0;$i<count($arr);$i++){
//   $pics  = base64_image_contents($arr[$i],$savepath);
//   $thispic = str_replace("./",$cfg_weburl.'/',$pics)."|";
//   $pic .= $thispic;
// }
// // echo $pic;
// function base64_image_contents($base64_image_content,$path){
//    //匹配出图片的格式
//     if (preg_match('/^(data:\s*image\/(\w+);base64,)/',
//     $base64_image_content, $result)){ //后缀
//     $type = $result[2]; //创建文件夹，以年月日
//     $new_file = $path.date('Ymd',time())."/";
//     if(!file_exists($new_file)){ //检查是否有该文件夹，如果没有就创建，并给予最高权限
//     mkdir($new_file, 0700);
//     }
//     $new_file = $new_file.time().rand(111,999).".{$type}"; //图片名以时间命名
//     //保存为文件
//     if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
//     //返回这个图片的路径
//     return $new_file;
//    }else{
//   return false;
//   }}else{ return false; }
//  }
//
//
//  $data='[{"jinName":"12","starttime":"12","days":"12"},{"jinName":"1","starttime":"1","days":"1"}]';
//  //转换成数组
// $arr = json_decode($data,true);
// //输出
// // print_r($arr);
//
// $content=array(
//   "0" => array(
//           "jinName" =>  1,
//         "starttime" => 2,
//              "days" => 3
//            )
// );
//
// $fruits = array (
//   "fruits" => array("a" => "orange", "b" => "banana", "c" => "apple"),
//   "numbers" => array(1, 2, 3, 4, 5, 6),
//   "holes"  => array("first", 5 => "second", "third")
// );
//
//
// $content=array(
//   "0"=>array(
//           "jinName" =>  1,
//         "starttime" =>  2,
//              "days" => 3
//            ),
//   "1"=>array(
//           "jinName" =>  4,
//         "starttime" =>  5,
//              "days" =>  6
//            ),
//   "2"=>array(
//          "jinName" =>  7,
//        "starttime" => 8,
//             "days" => 8
//           ),
//   "3"=>array(
//          "jinName" =>  1,
//        "starttime" => 1,
//             "days" =>2
//           ),
//   "4"=>array(
//           "jinName" =>  2,
//         "starttime" => 3,
//              "days" => 4
//            ),
//   "5"=>array(
//           "jinName" =>  5,
//         "starttime" => 3,
//              "days" => 4
//           ),
//   "6"=>array(
//           "jinName" =>  4,
//         "starttime" => 5,
//              "days" =>5
//          ),
//    "7"=>array(
//          "jinName" =>  3,
//        "starttime" => 3,
//             "days" => 4
//     ),
//   "8"=>array(
//         "jinName" =>  5,
//       "starttime" => 3,
//            "days" => 2
//     ),
//   "9"=>array(
//           "jinName" =>  3,
//         "starttime" => 3,
//              "days" => 4
//             )
// );
// $json=phpver($content);
// // print_r($json);
//
// $list= '["2019-06-17","2019-06-20","2019-06-21","2019-06-22"]';
// $ar=json_decode($list,true);
// //print_r($ar);
//
//
// function get_agency($id){
//
//  global $dosql;
//
//  $r=$dosql->GetOne("SELECT * FROM pmw_agency where id=$id");
//
//  $return= $r;
//
//  return $return ;
//
// }
//
// // print_r(get_agency(24));
//
//
// //获取所有旅行社的发布行程的年份
//
// function get_years($id){
//
// global $dosql;
//
// $dosql->Execute("SELECT complete_y FROM pmw_travel where aid=$id and state=2 group by complete_y");
// while($show=$dosql->GetArray()){
// 	$return[]=$show;
// }
//
// return $return;
//
// }
//
// print_r(get_years(20));
/*
$gid=1;
$id=14;
$k=$dosql->GetOne("SELECT state,starttime,endtime from pmw_travel where id=$id");
$state=$k['state'];
if($state==0){

  //判断当前的行程的起始时间
  $starttime = $k['starttime'];  //本次行程的开始时间

  $endtime = $k['endtime'];     //本次行程的截至时间

  //计算出当前导游已经预约过的行程的所有的开始时间

  $one=1;

  $num =0;
  $dosql->Execute("SELECT * FROM pmw_travel where state=1 or state=2 and gid=$gid",$one);

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

  echo $num;
}

$t=strtotime('+7 day');

echo $t;
echo "<hr>";
echo date("Y-m-d H:i:s",$t);

// echo get_new_formid("oz7S15BU6YPAdg8d3aDTwovdFjl0");

$id=13;

$k=$dosql->GetOne("SELECT state,starttime,endtime from pmw_travel where id=$id");
$state=$k['state'];
//判断当前的行程的起始时间
$starttime = $k['starttime'];  //本次行程的开始时间
echo date("Y-m-d",$starttime);

$endtime = $k['endtime'];     //本次行程的截至时间
echo date("Y-m-d",$endtime);

$one=1;

$num =0;

$gid=1;
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

echo $num;
*/
//
// function pngMerge($o_pic,$out_pic){
//  $begin_r = 98;
//  $begin_g = 98;
//  $begin_b = 98;
//  list($src_w, $src_h) = getimagesize($o_pic);// 获取原图像信息
//  $src_im = imagecreatefromjpeg($o_pic);
//  //imagecopymerge($target_im, $src_im, 0, 0, 0, 0, $src_w, $src_h, 100);
//  //imagecopyresampled($target_im, $src_im, 0, 0, 0, 0, $src_w, $src_h, $src_w, $src_h);
//  $i = 0;
//  $src_white = imagecolorallocate($src_im, 255, 255, 255);
//  for ($x = 0; $x < $src_w; $x++) {
//    for ($y = 0; $y < $src_h; $y++) {
//     $rgb = imagecolorat($src_im, $x, $y);
//     $r = ($rgb >> 16) & 0xFF;
//     $g = ($rgb >> 8) & 0xFF;
//     $b = $rgb & 0xFF;
//     if($r==255 && $g==255 && $b == 255){
//       $i ++;
//       continue;
//     }
//     if (!($r <= $begin_r && $g <= $begin_g && $b <= $begin_b)) {
//       imagefill($src_im, $x, $y, $src_white);//替换成白色
//     }
//    }
//  }
//  $target_im = imagecreatetruecolor($src_w, $src_h);//新图
//  $tag_white = imagecolorallocate($target_im, 255, 255, 255);
//  imagefill($target_im, 0, 0, $tag_white);
//  imagecolortransparent($target_im, $tag_white);
//  imagecopymerge($target_im, $src_im, 0, 0, 0, 0, $src_w, $src_h, 100);
// }
// $o_pic = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1561008806808&di=6a74347ba057df6269559851323985a4&imgtype=0&src=http%3A%2F%2Fpic.58pic.com%2F58pic%2F14%2F62%2F31%2F84D58PIC7Vy_1024.png';
// $name = pngMerge($o_pic,'aaaa.png');
// print_r($name);


//背景图片路径
// $srcurl = $cfg_weburl.'/templates/default/images/img.jpg';
// //目标图片路径
// $desurl = $cfg_weburl.'/uploads/erweima/20190620070110.png';
// //创建源图的实例
// $src = imagecreatefromstring(file_get_contents($srcurl));
// //创建点的实例
// $des = imagecreatefrompng($desurl);
// //获取点图片的宽高
// list($point_w, $point_h) = getimagesize($desurl);
// //重点：png透明用这个函数
// imagecopy($src, $des, 970, 1010, 0, 0, $point_w, $point_h);
// imagecopy($src, $des, 930, 1310, 0, 0, $point_w, $point_h);
// header('Content-Type: image/jpeg');
// imagejpeg($src);
// imagedestroy($src);
// imagedestroy($des);

// if(extension_loaded('gd')){
// 	echo "可以使用gd<br>";
// 	foreach(gd_info() as $k=>$v){
// 		echo "$k:$v<br>";
// 	}
// }else{
// 	echo "不能使用";
// }


// $url = $cfg_weburl.'/uploads/erweima/20190620070110.png';
// $im = imagecreatefromstring(file_get_contents($url));
//
// $w = imagesx($im);
// $h = imagesy($im);
// $c = imagecolorallocate($im, 255, 0, 0);
// imagearc($im, $w/2, $h/2, $w, $h, 0, 360, $c);
// imagefilltoborder($im, 0, 0, $c, $c);
// imagefilltoborder($im, $w, 0, $c, $c);
// imagefilltoborder($im, 0, $h, $c, $c);
// imagefilltoborder($im, $w, $h, $c, $c);
//
// imagecolortransparent($im, $c); //!!!!
//
// $dm = imagecreatefromstring(file_get_contents($cfg_weburl.'/templates/default/images/img.jpg'));
// imagecopymerge($dm, $im, 160, 50, 0, 0, $w, $h, 100);
//
// header("Content-type: image/png");
// imagepng($dm);
/*
// 图片一 url地址或者相对地址
 $path_1 = $cfg_weburl.'/templates/default/images/img.jpg';
 // 图片二  url地址或者相对地址
 $path_2 = $cfg_weburl.'/uploads/erweima/20190620070110.png';


 $img = imagecreatefromjpeg($path_2);
 imagepng($img, "./uploads/erweima/aaaaa.png");

 function pngMerge($o_pic,$out_pic){
 $begin_r = 255;
 $begin_g = 250;
 $begin_b = 250;
 list($src_w, $src_h) = getimagesize($o_pic);// 获取原图像信息 宽高
 $src_im = imagecreatefrompng($o_pic); //读取png图片
 print_r($src_im);
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
 return $out_pic;
}

$o_pic ="./uploads/erweima/aaaaa.png";
$name = pngMerge($o_pic,'./uploads/erweima/gzg1.png');
unlink($o_pic);
*/
// 将两张图片合并，（png图片放到背景图片的最上面）

// $bigImgPath = '16351_213838405158_2.png';      //背景图片
// $qCodePath = "uploads/erweima/code_20190621063048.png";
//
// $bigImg =   imagecreatefromstring(file_get_contents($bigImgPath));
// $qCodeImg = imagecreatefromstring(file_get_contents($qCodePath));
//
// list($qCodeWidth, $qCodeHight, $qCodeType) = getimagesize($qCodePath);
//
// imagecopymerge($bigImg, $qCodeImg, 239, 677, 0, 0, $qCodeWidth, $qCodeHight, 100);
//
// list($bigWidth, $bigHight, $bigType) = getimagesize($bigImgPath);
//
// imagejpeg($bigImg,'g.jpg');



$a = array(1, 2, 3, 4);

array_walk(
   $a,
   function(&$value, $key, $prefix){$value = $prefix.$value;},
   $cfg_weburl
);
    print_r($a);

    $r=$dosql->GetOne("SELECT content from pmw_banner where id=19");
    $content=$r['content'];
    $content=replacePicUrl($content, $cfg_weburl);
    echo $content;
    
    function replacePicUrl($content = null, $strUrl = null) {
    		if ($strUrl) {
    				//提取图片路径的src的正则表达式 并把结果存入$matches中
    				preg_match_all("/<img(.*)src=\"([^\"]+)\"[^>]+>/isU",$content,$matches);
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
    										$final_imgUrl = $strUrl.$imgItem;
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
