<?php
    /**
	   * 链接地址：del_publish  删除已经发布的动态
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
     * @ 访客openid   海报id  发布人的openid
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

      //删除已经发布的动态

      /*1.将表pmw_publish 里面的发布记录删除掉        */
      $dosql->ExecNoneQuery("DELETE FROM pmw_publish where id=$id and openid='$openid'");

      //2.将浏览了当前动态的所有数据删除掉

      //计算被访问次数，总的动态和访问次数

      $one=1;

      $dosql->Execute("SELECT id FROM `#@__record` WHERE member_openid='$openid'",$one);
      $nums = $dosql->GetTotalRow($one);

      if($nums==0){
        $list=array();
        $Data= array(

            "nums"=>0,

            "list"=>$list

        );
        $State = 0;
        $Descriptor = '当前暂无发布的动态！';
        $result = array (
                        'State' => $State,
                        'Descriptor' => $Descriptor,
                         'Version' => $Version,
                         'Data' => $Data,
                         );
        echo phpver($result);
      }else{
        //计算当前用户的发布的动态
          $three=3;
          $dosql->Execute("SELECT * from pmw_publish where openid='$openid' order by addtime desc",$three);

          $num=$dosql->GetTotalRow($three);
          $list=array();
          if($num!=0){
          for($i=0;$i<$num;$i++){
            $row=$dosql->GetArray($three);
            $list[]=$row;
            $list[$i]['pic']= $cfg_weburl."/".$row['pic'];
            $list[$i]['qrcode']= $cfg_weburl."/".$row['qrcode'];
            $id = $row['id'];
            //计算当前还没浏览的数量
            $two=2;
            $dosql->Execute("SELECT * from pmw_record where poster_id=$id and islook=0",$two);
            $looknums =$dosql->GetTotalRow($two);
            $list[$i]['looknums']= $looknums;
            $Data= array( "nums"=>$nums,"list"=>$list);
          }
          }else{
            $Data= array( "nums"=>$nums,"list"=>$list);
          }

          $State = 1;
          $Descriptor = '图片获取成功！';
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
