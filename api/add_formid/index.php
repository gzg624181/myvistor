<?php
    /**
	   * 链接地址：add_formid  添加formid
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
     * @购票订单   提供返回参数账号，
     * formid
     * openid
     */
require_once("../../include/config.inc.php");
add_formid($openid,$formid);
?>
