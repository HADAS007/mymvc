﻿<?php 
return [
//数据库配置信息
 	'db'=>[
 	'host'=>'127.0.0.1',
 	'user'=>'root',
 	'password'=>'root',
    'port'=>3306,
 	'charset'=>'utf8',
 	'dbName'=>'mvc',
 	],
 	//应用程序配置信息
 	'app'=>[
 	'p'=>'Admin',
 	'c'=>'Admin',
 	'a'=>'login'
 	],
 	//上传文件的配置信息
 	'upload'=>[
 		'dir'=>'./Public/upload/',
 		'size'=>2*1024*1024,
 		'type'=>['image/jpeg','image/png','image/gif'],
 		'pre'=>'goods_'
 	],
 	"thumb"=>[
        "dir"=>"./Public/upload/"
    ]
];