<?php
require_once(dirname(__FILE__).'/include/config.inc.php');


//将所有导游已经接单，但是还未确认的系统自动确认
// 更改行程为确认
$complete_y = date("Y");

$complete_ym = date("Y-m");

$starttime_ymd=date("Y-m-d");

$complete_time= time();

$sql="UPDATE pmw_travel SET state=2,complete_y='$complete_y',complete_ym='$complete_ym',complete_time='$complete_time' where state=1 and starttime_ymd='$starttime_ymd'";

$dosql->ExecNoneQuery($sql);

//将所有旅行社已经发布行程，但是还未有导游接单的行程，弄成已失效

$sql="UPDATE pmw_travel SET state=4 where state=0 and starttime_ymd='$starttime_ymd'";

$dosql->ExecNoneQuery($sql);

?>
