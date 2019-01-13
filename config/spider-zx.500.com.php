<?php

return [
   [
       'rule_desc'=>'竞彩足球',
       'rule_site'=>'http://zx.500.com/',
       'isapi'=>1,
       'request'=>'get',
       'referer'=>'http://zx.500.com/',
       'list'=>'http://zx.500.com/ajax.php?pageCount=1&sortid=1&type=news&hbtype=' ,
       'detail'=>'http://zx.500.com/openplatform/getinfo.php'
   ],
   [
        'rule_desc'=>'足彩',
        'rule_site'=>'http://zx.500.com/',
        'isapi'=>1,
        'request'=>'get',
        'referer'=>'http://zx.500.com/',
        'list'=>'http://zx.500.com/ajax.php?pageCount=0&sortid=2&type=news&hbtype=' ,
    ],
];
