<?php
/**
 * Created by PhpStorm.
 * User: taorong
 * Date: 2019-01-13
 * Time: 19:30
 */


return  [
    [
        'rule_desc'=>'竞彩分析',
        'rule_site'=>'http://zx.500.com/',
        'isapi'=>1,
        'request'=>'get',
        'referer'=>'http://zx.500.com/',
        'list'=>'http://zx.500.com/ajax.php?pageCount=1&sortid=1&type=news&hbtype=' ,
        'detail'=>'http://zx.500.com/openplatform/getinfo.php'
    ],
];