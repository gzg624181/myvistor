<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('admanage'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改发布行程</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="layui/layui.js"></script>
<link href="layui/css/layui.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<script>
 
     var add = function(){
       var num = 0;
       return  function addNum(){
         return  num +=1;
       }
   }
     var number = add()
	
    function  addTable(){
       var num = number();
		// alert(num);
       var tr="<tr>"+
			"<td height=\"40\" align=\"right\">行程安排"+num+"：</td>"+
			"<td><input type='text' name='jinName"+num+"'"+
			"id='jinName"+num+"'"+
			"class=\"input\" required=\"required\" />"+
				"<span class=\"maroon\">*</span><span class=\"cnote\">带<span class=\"maroon\">*</span>号表示为必填项</span></td>"+
		"</tr>";
		tr += "<tr>"+
			"<td height=\"40\" align=\"right\">行程日期"+num+"：</td>"+
			"<td><input type='text' name='starttime"+num+"'"+
			"id='starttime"+num+"'"+
			"onclick='selecttime("+num+")'"+
			"class=\"input\" required=\"required\" />"+
				"<span class=\"maroon\">*</span><span class=\"cnote\">带<span class=\"maroon\">*</span>号表示为必填项</span></td>"+
		"</tr>";
		
		tr += "<tr>"+
			"<td  style=\"border-bottom: 1px dashed #817b7b;\" height=\"40\" align=\"right\">行程时长期"+num+"：</td>"+
			"<td  style=\"border-bottom: 1px dashed #817b7b;\">"+
			"<select name='days"+num+"'"+
			"id='days"+num+"'"+
			"class=\"input\" style=\"width:508px;\">"+
			"<option value=\"上午\">上午</option>"+
			"<option value=\"下午\">下午</option>"+
			"<option value=\"全天\">全天</option>"+
			"</select>"+
		 "<span class=\"maroon\">*</span><span class=\"cnote\">带<span class=\"maroon\">*</span>号表示为必填项</span></td>"+
		"</tr>";

　  　$("#table1 #addcontent").after(tr);　　

	}
    
</script>
<body>
<?php
//初始化参数
$action  = isset($action)  ? $action  : 'travel_save.php';
$tbname='pmw_travel';
$row = $dosql->GetOne("SELECT * FROM $tbname WHERE id=$id");
$starttime=date("Y-m-d",$row['starttime']);
$endtime=date("Y-m-d",$row['endtime']);
?>
<div class="formHeader"> <span class="title" style="margin-left: 13px;">修改发布行程</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="<?php echo $action;?>" onsubmit="return cfm_travel()">
	<table id="table1"  width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable" >

		<tr>
			<td width="25%" height="40" align="right">旅行社名称：</td>
			<td width="75%" class="num" style="color:#06C"><?php echo $row['company']?></td>
		</tr>
         <tr>
			<td height="40" align="right">行程标题：</td>
			<td>
             <input type="text" class="input" id="title" name="title" required="required" value="<?php echo $row['title']?>"/>
             <span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
             </td>
		</tr>
                <tr>
			<td height="40" align="right">行程起始时间：</td>
			<td>
             <input type="text" class="input" id="time" name="time" required="required" value="<?php echo $starttime?> -- <?php echo $endtime?>">
             <span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
             </td>
		</tr>
        <tr>
			<td height="40" align="right">团队人数：</td>
			<td><input type="text" name="num" id="num" class="input" required="required" value="<?php echo $row['num']?>"/>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
        <tr>
			<td height="40" align="right">客源地：</td>
			<td><input type="text" name="origin" id="origin" class="input" required="required" value="<?php echo $row['origin']?>"/>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
        <!--
        <tr id='addcontent'>
			<td height="40" align="right">添加行程：</td>
			<td><i onclick="addTable()" style="color:#6d6b6b; font-weight:bold;font-size: 28px; cursor:pointer" class="fa fa-plus-square"></i></td>
		</tr>-->
        <?php 
		//获取数据库里面的行程安排
		$content=array();
		$content=json_decode($row['content'],true);
		for($i=0;$i<count($content);$i++){
		?> 
        <tr>
			<td height="40" align="right">行程安排<?php echo $i+1;?>：</td>
			<td><input type="text" name="jinName<?php echo $i+1;?>" id="jinName<?php echo $i+1;?>" class="input" required="required"  value="<?php echo $content[$i]['jinName']?>"/>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
        <tr>
			<td height="40" align="right">行程日期<?php echo $i+1;?>：</td>
			<td><input onfocus="selecttime('<?php echo $i+1;?>')" type="text" name="starttime<?php echo $i+1;?>" id="starttime<?php echo $i+1;?>" class="input" required="required"  value="<?php echo date("Y-m-d",$content[$i]['starttime'])?>"/>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
        <tr>
			<td style="border-bottom: 1px dashed #817b7b;" height="40" align="right">行程时长<?php echo $i+1;?>：</td>
			<td style="border-bottom: 1px dashed #817b7b;">
            <select name="days<?php echo $i+1;?>" id="days<?php echo $i+1;?>" class="input" style="width:508px;">
            <option <?php if($content[$i]['days']=="上午"){echo "selected = 'selected'"; } ?> value="上午">上午</option>
            <option <?php if($content[$i]['days']=="下午"){echo "selected = 'selected'"; } ?> value="下午">下午</option>
            <option <?php if($content[$i]['days']=="全天"){echo "selected = 'selected'"; } ?> value="全天">全天</option>
            </select>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
                
                </td>
		</tr>
        <?php }?>
        
		<tr>
			<td height="40" align="right">导游费用：</td>
			<td><input type="text" name="money" id="money" class="input" required="required"  value="<?php echo $row['money']?>"/>
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>


		<tr>
			<td height="40" align="right">备注信息：</td>
			<td><textarea  name="other" id="other" class="input" style="height:90px; width:500px;"><?php echo $row['other']?></textarea>
				</td>
		</tr>
		<tr>
			<td height="40" align="right">更新时间：</td>
			<td><input type="text" name="posttime" id="posttime" class="input" value="<?php echo GetDateTime($row['posttime']); ?>"/>
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
  
  </div>
</form>
<script>
layui.use('laydate', function(){
  var laydate = layui.laydate;

 //日期范围选择
laydate.render({
  elem: '#time'
  ,range: "--" //或 range: '~' 来自定义分割字符
});

  
/*    laydate.render({
    elem: '#test19'
    ,value: '1989-10-14'
    ,isInitValue: true
  });*/

});

function selecttime(num){
   
  
  layui.use('laydate', function(){
  var laydate = layui.laydate;
  var times=$("#time").val();
  //alert(times);
  startime = times.split(' -- ')[0];
  endtime  = times.split(' -- ')[1];
	//限定可选日期
  var ins22 = laydate.render({
    elem: '#starttime'+num,
    min: startime,
    max: endtime,
    ready: function(){
	   var msg="日期可选值设定在 <br> "+startime +" 到"+endtime;
      ins22.hint(msg);
    }
  });

 
});
	
}





</script>

</body>
</html>
