<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员头像列表</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getjcrop.js"></script>
<script type="text/javascript" src="templates/js/getinfosrc.js"></script>
<script type="text/javascript" src="plugin/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<style>
.imgwidth{
	width:90px;
	height:90px;
	borer-radius:8px;
	cursor:pointer;
}
</style>
<script>

function selectpic(id){
var picurl = "./templates/images/avatar/"+id+".jpg";

parent.$('#changepic')[0].src = picurl; 
parent.$('#images').val(id) ;
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
parent.layer.close(index);//关闭窗口
	
}

</script>
</head>
<body>
<?php
//初始化参数
$adminlevel=$_SESSION['adminlevel'];
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title">请选择头像：</span> <a title="刷新" href="javascript:location.reload();" class="reload"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<form name="form" id="form" method="post" action="erweima_tuijian_save.php" onsubmit="return tuijian();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

		<tr>
		  <td width="25%" height="120"><img onclick="selectpic('1')" class="imgwidth" src="templates/images/avatar/1.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth" onclick="selectpic('2')"  src="templates/images/avatar/2.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth" onclick="selectpic('3')"  src="templates/images/avatar/3.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth" onclick="selectpic('4')"  src="templates/images/avatar/4.jpg" width="220" height="220" /></td>
       </tr>
       
		<tr>
		  <td width="25%" height="120"><img onclick="selectpic('5')"  src="templates/images/avatar/5.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img onclick="selectpic('6')"  src="templates/images/avatar/6.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('7')"   src="templates/images/avatar/7.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('8')"   src="templates/images/avatar/8.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
      </tr>
      
      <tr>
		  <td width="25%" height="120"><img  onclick="selectpic('9')"   class="imgwidth" src="templates/images/avatar/9.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('10')"   class="imgwidth" src="templates/images/avatar/10.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('11')"    class="imgwidth" src="templates/images/avatar/11.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('12')"   class="imgwidth" src="templates/images/avatar/12.jpg" width="220" height="220" /></td>
    </tr>
    
    <tr>
		  <td width="25%" height="120"><img  onclick="selectpic('13')"   class="imgwidth" src="templates/images/avatar/13.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth"  onclick="selectpic('14')"   src="templates/images/avatar/14.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth"  onclick="selectpic('15')"   src="templates/images/avatar/15.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('16')"   class="imgwidth" src="templates/images/avatar/16.jpg" width="220" height="220" /></td>
    </tr>
    
    <tr>
		  <td width="25%" height="120"><img  onclick="selectpic('17')"   class="imgwidth" src="templates/images/avatar/17.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth"  onclick="selectpic('18')"   src="templates/images/avatar/18.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth"  onclick="selectpic('19')"   src="templates/images/avatar/19.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('20')"   class="imgwidth" src="templates/images/avatar/20.jpg" width="220" height="220" /></td>
    </tr>
    
    		<tr>
		  <td width="25%" height="120"><img  onclick="selectpic('21')"   class="imgwidth" src="templates/images/avatar/21.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('22')"   class="imgwidth" src="templates/images/avatar/22.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('23')"  class="imgwidth" src="templates/images/avatar/23.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('24')"  class="imgwidth" src="templates/images/avatar/24.jpg" width="220" height="220" /></td>
       </tr>
       
		<tr>
		  <td width="25%" height="120"><img  onclick="selectpic('25')"  src="templates/images/avatar/25.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('26')"  src="templates/images/avatar/26.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('27')"  src="templates/images/avatar/27.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('28')"  src="templates/images/avatar/28.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
      </tr>
      <tr>
		  <td width="25%" height="120"><img  onclick="selectpic('29')"  class="imgwidth" src="templates/images/avatar/29.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('30')"  class="imgwidth" src="templates/images/avatar/30.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('31')"  class="imgwidth" src="templates/images/avatar/31.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('32')"  class="imgwidth" src="templates/images/avatar/32.jpg" width="220" height="220" /></td>
    </tr>
    <tr>
		  <td width="25%" height="120"><img onclick="selectpic('33')"   class="imgwidth" src="templates/images/avatar/33.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('34')"   class="imgwidth" src="templates/images/avatar/34.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('35')"   class="imgwidth" src="templates/images/avatar/35.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('36')"  class="imgwidth" src="templates/images/avatar/36.jpg" width="220" height="220" /></td>
    </tr>
    <tr>
		  <td width="25%" height="120"><img onclick="selectpic('37')"   class="imgwidth" src="templates/images/avatar/37.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('38')"   class="imgwidth" src="templates/images/avatar/38.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('39')"   class="imgwidth" src="templates/images/avatar/39.jpg" width="220" height="220" /></td>
		  <td width="25%"><img onclick="selectpic('40')"   class="imgwidth" src="templates/images/avatar/40.jpg" width="220" height="220" /></td>
    </tr>

		<tr>
		  <td width="25%" height="120"><img onclick="selectpic('41')"   class="imgwidth" src="templates/images/avatar/41.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('42')"   class="imgwidth" src="templates/images/avatar/42.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('43')"   class="imgwidth" src="templates/images/avatar/43.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('44')"   class="imgwidth" src="templates/images/avatar/44.jpg" width="220" height="220" /></td>
       </tr>
       
		<tr>
		  <td width="25%" height="120"><img onclick="selectpic('45')"   src="templates/images/avatar/45.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img onclick="selectpic('46')"   src="templates/images/avatar/46.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('47')"  src="templates/images/avatar/47.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('48')"  src="templates/images/avatar/48.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
      </tr>
      <tr>
		  <td width="25%" height="120"><img  onclick="selectpic('49')"  class="imgwidth" src="templates/images/avatar/49.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('50')"  class="imgwidth" src="templates/images/avatar/50.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('51')"  class="imgwidth" src="templates/images/avatar/51.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('52')"  class="imgwidth" src="templates/images/avatar/52.jpg" width="220" height="220" /></td>
    </tr>
    <tr>
		  <td width="25%" height="120"><img  onclick="selectpic('53')"  class="imgwidth" src="templates/images/avatar/53.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('54')"  class="imgwidth" src="templates/images/avatar/54.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('55')"  class="imgwidth" src="templates/images/avatar/55.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('56')"  class="imgwidth" src="templates/images/avatar/56.jpg" width="220" height="220" /></td>
    </tr>
    <tr>
		  <td width="25%" height="120"><img  onclick="selectpic('57')"  class="imgwidth" src="templates/images/avatar/57.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('58')"  class="imgwidth" src="templates/images/avatar/58.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('59')"  class="imgwidth" src="templates/images/avatar/59.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('60')"  class="imgwidth" src="templates/images/avatar/60.jpg" width="220" height="220" /></td>
    </tr>
    
    		<tr>
		  <td width="25%" height="120"><img  onclick="selectpic('61')"  class="imgwidth" src="templates/images/avatar/61.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth"  onclick="selectpic('62')"  src="templates/images/avatar/62.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth" onclick="selectpic('63')"   src="templates/images/avatar/63.jpg" width="220" height="220" /></td>
		  <td><img class="imgwidth" onclick="selectpic('64')"   src="templates/images/avatar/64.jpg" width="220" height="220" /></td>
       </tr>
       
		<tr>
		  <td width="25%" height="120"><img onclick="selectpic('65')"   src="templates/images/avatar/65.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('66')"  src="templates/images/avatar/66.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('67')"  src="templates/images/avatar/67.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img  onclick="selectpic('68')"  src="templates/images/avatar/68.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
      </tr>
      <tr>
		  <td width="25%" height="120"><img  onclick="selectpic('69')"  class="imgwidth" src="templates/images/avatar/69.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('70')"  class="imgwidth" src="templates/images/avatar/70.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('71')"  class="imgwidth" src="templates/images/avatar/71.jpg" width="220" height="220" /></td>
		  <td width="25%"><img onclick="selectpic('72')"   class="imgwidth" src="templates/images/avatar/72.jpg" width="220" height="220" /></td>
    </tr>
    <tr>
		  <td width="25%" height="120"><img onclick="selectpic('73')"   class="imgwidth" src="templates/images/avatar/73.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('74')"   class="imgwidth" src="templates/images/avatar/74.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('75')"   class="imgwidth" src="templates/images/avatar/75.jpg" width="220" height="220" /></td>
		  <td width="25%"><img onclick="selectpic('76')"   class="imgwidth" src="templates/images/avatar/76.jpg" width="220" height="220" /></td>
    </tr>
    <tr>
		  <td width="25%" height="120"><img onclick="selectpic('77')"   class="imgwidth" src="templates/images/avatar/77.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('78')"   class="imgwidth" src="templates/images/avatar/78.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('79')"   class="imgwidth" src="templates/images/avatar/79.jpg" width="220" height="220" /></td>
		  <td width="25%"><img onclick="selectpic('80')"   class="imgwidth" src="templates/images/avatar/80.jpg" width="220" height="220" /></td>
    </tr>
    
    		<tr>
		  <td width="25%" height="120"><img onclick="selectpic('81')"   class="imgwidth" src="templates/images/avatar/81.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('82')"   class="imgwidth" src="templates/images/avatar/82.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('83')"  class="imgwidth" src="templates/images/avatar/83.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('84')"  class="imgwidth" src="templates/images/avatar/84.jpg" width="220" height="220" /></td>
       </tr>
       
		<tr>
		  <td width="25%" height="120"><img onclick="selectpic('85')"   src="templates/images/avatar/85.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img onclick="selectpic('86')"   src="templates/images/avatar/86.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img onclick="selectpic('87')"   src="templates/images/avatar/87.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
		  <td width="25%"><img onclick="selectpic('88')"   src="templates/images/avatar/88.jpg" alt="" width="220" height="220" class="imgwidth" /></td>
      </tr>
      <tr>
		  <td width="25%" height="120"><img onclick="selectpic('89')"   class="imgwidth" src="templates/images/avatar/89.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('90')"   class="imgwidth" src="templates/images/avatar/90.jpg" width="220" height="220" /></td>
		  <td><img onclick="selectpic('91')"   class="imgwidth" src="templates/images/avatar/91.jpg" width="220" height="220" /></td>
		  <td width="25%"><img onclick="selectpic('92')"   class="imgwidth" src="templates/images/avatar/92.jpg" width="220" height="220" /></td>
    </tr>
    <tr>
		  <td width="25%" height="120"><img onclick="selectpic('93')"   class="imgwidth" src="templates/images/avatar/93.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('94')"  class="imgwidth" src="templates/images/avatar/94.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('95')"  class="imgwidth" src="templates/images/avatar/95.jpg" width="220" height="220" /></td>
		  <td width="25%"><img onclick="selectpic('96')"   class="imgwidth" src="templates/images/avatar/96.jpg" width="220" height="220" /></td>
    </tr>
    <tr>
		  <td width="25%" height="120"><img onclick="selectpic('97')"   class="imgwidth" src="templates/images/avatar/97.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('98')"  class="imgwidth" src="templates/images/avatar/98.jpg" width="220" height="220" /></td>
		  <td><img  onclick="selectpic('99')"  class="imgwidth" src="templates/images/avatar/99.jpg" width="220" height="220" /></td>
		  <td width="25%"><img  onclick="selectpic('100')"  class="imgwidth" src="templates/images/avatar/100.jpg" width="220" height="220" /></td>
    </tr>
  </table>
</form>
</body>
</html>
