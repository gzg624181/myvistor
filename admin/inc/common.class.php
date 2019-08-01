<?php	if(!defined('IN_PHPMYWIND')) exit('Request Error!');

/*
**************************
(C)2010-2019 phpMyWind.com
update: 2019-7-12 21:59:40
person: Gang
**************************
*/

// 计算会员发布的动态数量

class Member{

     private $openid;

     function __construct($openid){
       $this->openid= $openid;
     }

     function get_nums(){

      	global $dosql;

        $openid=$this->openid;

        $dosql->Execute("SELECT id FROM pmw_publish where openid= '$openid'");

        $nums = $dosql->GetTotalRow();

        return $nums;
     }

}
