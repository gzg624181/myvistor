<?php
    /**
	   * 链接地址：success_travel 获取旅行社已经完成的形成列表
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
     * @提供返回参数账号 id    旅行社的id 返回旅行社的导游形成  （0，待预约，2.已完成,1,待确认 3.已经取消）
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

      $r=$dosql->GetOne("SELECT id FROM `#@__travel` WHERE aid=$id");
      if(!is_array($r)){  //如果传递过来的账号不存在，则没有这一列
        $State = 0;
        $Descriptor = '暂无发布的形成列表，请先发布行程！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      #计算已经发布的形成
      $we='we';
      $me='me';
      $one=1;
      $two=2;
      $three=3;
      $four=4;
      #已完成
      $dosql->Execute("SELECT * FROM `#@__travel` WHERE aid=$id and state=2",$we);

      $success = $dosql->GetTotalRow($we);

      #待预约
      $dosql->Execute("SELECT * FROM `#@__travel` WHERE aid=$id and state=0",$me);

      $appointment = $dosql->GetTotalRow($me);
      #待确认

      $dosql->Execute("SELECT * FROM `#@__travel` WHERE aid=$id and state=1",$one);

      $confirm = $dosql->GetTotalRow($one);
      #已取消

      $dosql->Execute("SELECT * FROM `#@__travel` WHERE aid=$id and state=3",$two);

      $concel = $dosql->GetTotalRow($two);
      #已失效
      $dosql->Execute("SELECT * FROM `#@__travel` WHERE aid=$id and state=4",$four);

       $invalid = $dosql->GetTotalRow($four);
      #去评价

      $dosql->Execute("SELECT * FROM `#@__travel` WHERE aid=$id and state=2 and comment_state=0",$three);
       $comment = $dosql->GetTotalRow($three);


       $Data= array(

            "appointment"=>$appointment,
            "confirm"=>$confirm,
            "comment"=>$comment

       );

      $State = 1;
      $Descriptor = '行程列表查询成功！';
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
