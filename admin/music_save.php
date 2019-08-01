<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 17:22:45
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__member';
$gourl  = 'user.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加音频文件
if($action == 'add')
{

	$addtime = GetMkTime($addtime);
  $appid=$cfg_music_appid;  //音频小程序appid
  $secret=$cfg_music_appsecret; //音频小程序秘钥
  $xiaochengxu_path="pages/play/index";  //默认扫码之后进入的页面
  $erweima_name=date("Ymdhis");
  $urls="/uploads/erweima/".$erweima_name.".png";
  $save_path=$cfg_weburl.$urls;         //生成成功之后的二维码地址
  $url=$url;
	$sql = "INSERT INTO `#@__music` (title, url, num, codeurl, addtime, orderid, sharename) VALUES ('$title', '$url', $num, '$urls', '$addtime', $orderid, '$sharename')";
	if($dosql->ExecNoneQuery($sql))
	{
		$gourl="music.php";
		header("location:$gourl");
		exit();
	}
}
else if($action == 'playmp3')
{

	$r=$dosql->GetOne("SELECT url,title FROM pmw_music WHERE id=$id");
  $url= $r['url'];
  $content =  "<span style='font-size:18px;font-weight:bold;margin-bottom:10px;'>".$r['title']."播放测试"."</span>";
	$content .="<video controls='' autoplay='' name='media'><source src=".$url." type='audio/mpeg'></video>";
	echo $content;
}
else if($action=="share_update"){
	if(!check_str($pic,$cfg_weburl)){
    $pic1=$cfg_weburl."/".$pic; //
  }
	if(!check_str($tubiaopic,$cfg_weburl)){
		$tubiaopic1=$cfg_weburl."/".$tubiaopic; //导游证件
	}
	$dosql->ExecNoneQuery("UPDATE pmw_share SET tubiaopic='$tubiaopic',imagesurl='$pic' where id=2");
	$gourl="share_config.php";

  // 生成实例海报图片
  $waterImg=$cfg_weburl."/uploads/erweima/code_example.png";
  $erweima_name=date("Ymdhis");
	$savename="example_".$erweima_name.".png";
	$savepath="../uploads/erweima";

  $newimg1=img_water_mark($pic1, $waterImg, $savepath, $savename, $positon=5, $alpha=100);
  $newimg=img_water_mark($newimg1, $tubiaopic1, $savepath, $savename, $positon=2, $alpha=100);

  $dosql->ExecNoneQuery("UPDATE pmw_share SET examplepic='$newimg' where id=2");
	header("LOCATION:$gourl");
}
//无条件返回
else
{
    header("location:$gourl");
	exit();
}

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
    $exte = $temp['extension'];
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

?>
