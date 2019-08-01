<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加赔率</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" src="templates/js/getarea.js"></script>
<script>

  function changemtype(){

	  var options=$("#typename option:selected");
	  var typename=options.val();

	  var da = document.getElementById("das");
	  var xiao = document.getElementById("xiaos");
	  var dan = document.getElementById("dans");
	  var shuang = document.getElementById("shuangs");
	  var jida = document.getElementById("jidas");
	  var dadan = document.getElementById("dadans");
	  var xiaodan = document.getElementById("xiaodans");
	  var dashuang = document.getElementById("dashuangs");
	  var xiaoshuang = document.getElementById("xiaoshuangs");
	  var jixiao = document.getElementById("jixiaos");
	  var zero = document.getElementById("zeros");
	  var one = document.getElementById("ones");
	  var two = document.getElementById("twos");
	  var three = document.getElementById("threes");
	  var four = document.getElementById("fours");
	  var five = document.getElementById("fives");
	  var six = document.getElementById("sixs");
	  var seven = document.getElementById("sevens");
	  var eight = document.getElementById("eights");
	  var night = document.getElementById("nights");
	  var ten = document.getElementById("tens");
	  var one_one = document.getElementById("one_ones");
	  var one_two = document.getElementById("one_twos");
	  var one_three = document.getElementById("one_threes");
	  var one_four = document.getElementById("one_fours");
	  var one_five = document.getElementById("one_fives");
	  var one_six = document.getElementById("one_sixs");
	  var one_seven = document.getElementById("one_sevens");
	  var one_eight = document.getElementById("one_eights");
	  var one_night = document.getElementById("one_nights");
	  var two_zero = document.getElementById("two_zeros");
	  var two_one = document.getElementById("two_ones");
	  var two_two = document.getElementById("two_twos");
	  var two_three = document.getElementById("two_threes");
	  var two_four = document.getElementById("two_fours");
	  var two_five = document.getElementById("two_fives");
	  var two_six = document.getElementById("two_sixs");
	  var two_seven = document.getElementById("two_sevens");
	  var baozi = document.getElementById("baozis");
	  var shunzi = document.getElementById("shunzis");
	  var duizi = document.getElementById("duizis");
	  var long = document.getElementById("longs");
	  var hu = document.getElementById("hus");
	  var bao = document.getElementById("baos");

	  if(typename == "大小单双"){
      //========================大小单双============================
    		da.style.display = "";
    		xiao.style.display = "";
    		dan.style.display = "";
    		shuang.style.display = "";
    		jida.style.display = "";
    		dadan.style.display = "";
    		xiaodan.style.display = "";
    		dashuang.style.display = "";
    		xiaoshuang.style.display = "";
    		jixiao.style.display = "";
      //========================猜数字============================
      zero.style.display = "none";
      one.style.display = "none";
      two.style.display = "none";
      three.style.display = "none";
      four.style.display = "none";
      five.style.display = "none";
      six.style.display = "none";
      seven.style.display = "none";
      eight.style.display = "none";
      night.style.display = "none";
      ten.style.display = "none";
      one_one.style.display = "none";
      one_two.style.display = "none";
      one_three.style.display = "none";
      one_four.style.display = "none";
      one_five.style.display = "none";
      one_six.style.display = "none";
      one_seven.style.display = "none";
      one_eight.style.display = "none";
      one_night.style.display = "none";
      two_zero.style.display = "none";
      two_one.style.display = "none";
      two_two.style.display = "none";
      two_three.style.display = "none";
      two_four.style.display = "none";
      two_five.style.display = "none";
      two_six.style.display = "none";
      two_seven.style.display = "none";
      //========================特殊玩法============================
      baozi.style.display = "none";
      shunzi.style.display = "none";
      duizi.style.display = "none";
      long.style.display = "none";
      hu.style.display = "none";
      bao.style.display = "none";
       }
     if(typename == "猜数字"){
       //========================猜数字============================
        zero.style.display = "";
        one.style.display = "";
        two.style.display = "";
        three.style.display = "";
        four.style.display = "";
        five.style.display = "";
        six.style.display = "";
        seven.style.display = "";
        eight.style.display = "";
        night.style.display = "";
        ten.style.display = "";
        one_one.style.display = "";
        one_two.style.display = "";
        one_three.style.display = "";
        one_four.style.display = "";
        one_five.style.display = "";
        one_six.style.display = "";
        one_seven.style.display = "";
        one_eight.style.display = "";
        one_night.style.display = "";
        two_zero.style.display = "";
        two_one.style.display = "";
        two_two.style.display = "";
        two_three.style.display = "";
        two_four.style.display = "";
        two_five.style.display = "";
        two_six.style.display = "";
        two_seven.style.display = "";
       //========================大小单双============================
       da.style.display = "none";
       xiao.style.display = "none";
       dan.style.display = "none";
       shuang.style.display = "none";
       jida.style.display = "none";
       dadan.style.display = "none";
       xiaodan.style.display = "none";
       dashuang.style.display = "none";
       xiaoshuang.style.display = "none";
       jixiao.style.display = "none";
       //========================特殊玩法============================
       baozi.style.display = "none";
       shunzi.style.display = "none";
       duizi.style.display = "none";
       long.style.display = "none";
       hu.style.display = "none";
       bao.style.display = "none";

    }
    if(typename == "特殊玩法"){
      //========================特殊玩法============================
      baozi.style.display = "";
      shunzi.style.display = "";
      duizi.style.display = "";
      long.style.display = "";
      hu.style.display = "";
      bao.style.display = "";
      //========================猜数字============================
      zero.style.display = "none";
      one.style.display = "none";
      two.style.display = "none";
      three.style.display = "none";
      four.style.display = "none";
      five.style.display = "none";
      six.style.display = "none";
      seven.style.display = "none";
      eight.style.display = "none";
      night.style.display = "none";
      ten.style.display = "none";
      one_one.style.display = "none";
      one_two.style.display = "none";
      one_three.style.display = "none";
      one_four.style.display = "none";
      one_five.style.display = "none";
      one_six.style.display = "none";
      one_seven.style.display = "none";
      one_eight.style.display = "none";
      one_night.style.display = "none";
      two_zero.style.display = "none";
      two_one.style.display = "none";
      two_two.style.display = "none";
      two_three.style.display = "none";
      two_four.style.display = "none";
      two_five.style.display = "none";
      two_six.style.display = "none";
      two_seven.style.display = "none";
      //========================大小单双============================
      da.style.display = "none";
      xiao.style.display = "none";
      dan.style.display = "none";
      shuang.style.display = "none";
      jida.style.display = "none";
      dadan.style.display = "none";
      xiaodan.style.display = "none";
      dashuang.style.display = "none";
      xiaoshuang.style.display = "none";
      jixiao.style.display = "none";
    }
  }
</script>
</head>
<body>
<div class="formHeader">添加游戏赔率<a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="game_save.php" onsubmit="return cfm_playgame();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
         <tr>
           <td height="40" align="right">游戏大类名称：</td>
           <td colspan="4" valign="middle"><input type="text" name="name" id="name" class="input" value="加拿大28"/></td>
         </tr>
         <tr>
           <td height="40" align="right">游戏名称：</td>
           <td colspan="4" valign="middle"><select name="gid" id="gid" class="input">
                    <option value="-1">请选择游戏类型</option>
                    <?php
					$dosql->Execute("SELECT id,gametypes FROM pmw_game  where gamename='加拿大28'");
					while($row=$dosql->GetArray()){
					?>
                    <option value="<?php echo $row['id'];?>"><?php echo $row['gametypes'];?></option>
                    <?php }?>
                  </select></td>
         </tr>
         <tr>
              <td height="40" align="right">赔率类型：</td>
                  <td colspan="4" valign="middle"><select name="typename" id="typename" class="input" onchange="return changemtype();">
                    <option value="-1">请选择赔率类型</option>
                    <option value="大小单双">大小单双</option>
                    <option value="猜数字">猜数字</option>
                    <option value="特殊玩法">特殊玩法</option>
                  </select></td>
            </tr>
    <!--  ==============================大小单双================================= -->
		<tr style="display:none" id="das">
		   <td width="16%" height="40" align="right">猜大赔率：</td>
		   <td width="84%" colspan="4"><input type="text" name="da" id="da" class="input"/></td>
         </tr>
         <tr style="display:none"  id="xiaos">
          <td height="40" align="right">猜小赔率：</td>
          <td colspan="4" valign="middle"><input type="text" name="xiao" id="xiao" class="input"/></td>
        </tr>
        <tr style="display:none"  id="dans">
      <td height="40" align="right">猜单赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="dan" id="dan" class="input"/></td>
        </tr>
        <tr style="display:none"  id="shuangs">
      <td height="40" align="right">猜双赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="shuang" id="shuang" class="input"/></td>
        </tr>
        <tr style="display:none"  id="jidas">
      <td height="40" align="right">猜极大赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="jida" id="jida" class="input"/></td>
        </tr>
                <tr style="display:none"  id="dadans">
      <td height="40" align="right">猜大单赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="dadan" id="dadan" class="input"/></td>
        </tr>
        <tr style="display:none"  id="xiaodans">
      <td height="40" align="right">猜小单赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="xiaodan" id="xiaodan" class="input"/></td>
        </tr>
        <tr style="display:none"  id="dashuangs">
      <td height="40" align="right">猜大双赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="dashuang" id="dashuang" class="input"/></td>
        </tr>
         <tr style="display:none"  id="xiaoshuangs">
      <td height="40" align="right">猜小双赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="xiaoshuang" id="xiaoshuang" class="input"/></td>
        </tr>
        <tr style="display:none"  id="jixiaos">
      <td height="40" align="right">猜极小赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="jixiao" id="jixiao" class="input"/></td>
        </tr>
      <!--  ==============================猜数字================================= -->
      <tr style="display:none"  id="zeros">
      <td height="40" align="right">猜0赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="zero" id="zero" class="input"/></td>
        </tr>
       <tr style="display:none"  id="ones">
      <td height="40" align="right">猜1赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one" id="one" class="input"/></td>
        </tr>
        <tr style="display:none"  id="twos">
      <td height="40" align="right">猜2赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two" id="two" class="input"/></td>
        </tr>
       <tr style="display:none"  id="threes">
      <td height="40" align="right">猜3赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="three" id="three" class="input"/></td>
        </tr>
       <tr style="display:none"  id="fours">
      <td height="40" align="right">猜4赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="four" id="four" class="input"/></td>
        </tr>
       <tr style="display:none"  id="fives">
      <td height="40" align="right">猜5赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="five" id="five" class="input"/></td>
        </tr>
       <tr style="display:none"  id="sixs">
      <td height="40" align="right">猜6赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="six" id="six" class="input"/></td>
        </tr>
       <tr style="display:none"  id="sevens">
      <td height="40" align="right">猜7赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="seven" id="seven" class="input"/></td>
        </tr>
       <tr style="display:none"  id="eights">
      <td height="40" align="right">猜8赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="eight" id="eight" class="input"/></td>
        </tr>
       <tr style="display:none"  id="nights">
      <td height="40" align="right">猜9赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="night" id="night" class="input"/></td>
        </tr>
       <tr style="display:none"  id="tens">
      <td height="40" align="right">猜10赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="ten" id="ten" class="input"/></td>
        </tr>
        <tr style="display:none"  id="one_ones">
      <td height="40" align="right">猜11赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_one" id="one_one" class="input"/></td>
        </tr>
       <tr style="display:none"  id="one_twos">
      <td height="40" align="right">猜12赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_two" id="one_two" class="input"/></td>
        </tr>
       <tr style="display:none"  id="one_threes">
      <td height="40" align="right">猜13赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_three" id="one_three" class="input"/></td>
        </tr>
       <tr style="display:none"  id="one_fours">
      <td height="40" align="right">猜14赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_four" id="one_four" class="input"/></td>
        </tr>
       <tr style="display:none"  id="one_fives">
      <td height="40" align="right">猜15赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_five" id="one_five" class="input"/></td>
        </tr>
       <tr style="display:none"  id="one_sixs">
      <td height="40" align="right">猜16赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_six" id="one_six" class="input"/></td>
        </tr>
       <tr style="display:none"  id="one_sevens">
      <td height="40" align="right">猜17赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_seven" id="one_seven" class="input"/></td>
        </tr>
        <tr style="display:none"  id="one_eights">
      <td height="40" align="right">猜18赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_eight" id="one_eight" class="input"/></td>
        </tr>
       <tr style="display:none"  id="one_nights">
      <td height="40" align="right">猜19赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="one_night" id="one_night" class="input"/></td>
        </tr>
       <tr style="display:none"  id="two_zeros">
      <td height="40" align="right">猜20赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two_zero" id="two_zero" class="input"/></td>
        </tr>
       <tr style="display:none"  id="two_ones">
      <td height="40" align="right">猜21赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two_one" id="two_one" class="input"/></td>
        </tr>
       <tr style="display:none"  id="two_twos">
      <td height="40" align="right">猜22赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two_two" id="two_two" class="input"/></td>
        </tr>
       <tr style="display:none"  id="two_threes">
      <td height="40" align="right">猜23赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two_three" id="two_three" class="input"/></td>
        </tr>
        <tr style="display:none"  id="two_fours">
      <td height="40" align="right">猜24赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two_four" id="two_four" class="input"/></td>
        </tr>
       <tr style="display:none"  id="two_fives">
      <td height="40" align="right">猜25赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two_five" id="two_five" class="input"/></td>
        </tr>
      <tr style="display:none"  id="two_sixs">
      <td height="40" align="right">猜26赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two_six" id="two_six" class="input"/></td>
        </tr>
        <tr style="display:none"  id="two_sevens">
      <td height="40" align="right">猜27赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="two_seven" id="two_seven" class="input"/></td>
        </tr>
        <!--  ==============================特殊玩法================================= -->
       <tr style="display:none"  id="baozis">
      <td height="40" align="right">猜豹子赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="baozi" id="baozi" class="input"/></td>
        </tr>
       <tr style="display:none"  id="shunzis">
      <td height="40" align="right">猜顺子赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="shunzi" id="shunzi" class="input"/></td>
        </tr>
       <tr style="display:none"  id="duizis">
      <td height="40" align="right">猜对子赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="duizi" id="duizi" class="input"/></td>
        </tr>
        <tr style="display:none"  id="longs">
      <td height="40" align="right">猜龙赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="long" id="long" class="input"/></td>
        </tr>
        <tr style="display:none"  id="hus">
      <td height="40" align="right">猜虎赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="hu" id="hu" class="input"/></td>
        </tr>
       <tr style="display:none"  id="baos">
      <td height="40" align="right">猜豹赔率：</td>
      <td colspan="4" valign="middle"><input type="text" name="bao" id="bao" class="input"/></td>
        </tr>
      <tr>
		  <td height="272" align="right">赔率备注说明：</td>
		  <td colspan="4"><textarea style="width:80%" name="content" id="content" class="kindeditor"></textarea>
				<script>
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="content"]', {
						allowFileManager : true,
						width:'80%',
						height:'365px',
						extraFileUploadParams : {
							sessionid :  '<?php echo session_id(); ?>'
						}
					});
				});
				</script>			<div id="fenlei" style="font-size:12px; color:#ffa8a8;display:inline;"></div></td>
	  </tr>
      <tr>
      <td height="40" align="right">&nbsp;</td>
       <td><div class="formSubBtn" style="float:left; margin-top:5px;">
        <input type="submit" class="submit" value="保存" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="add" />
  </div></td>
    </tr>
	</table>

</form>
</body>
</html>
