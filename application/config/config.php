<?php
return [
    //数据库配置
    'db' => [
        'user' => 'root',  //用户名称
        'pass' => 'root',  //用户密码
        'dbname'=>'edu',   //默认数据库名称
    ],

    //整体配置
    'app' => [
        'default_platform'=> 'home', //默认平台
    ],

    //前台配置
    'home' => [
        'default_controller' => 'Student', //默认控制器
        'default_action' => 'listAll', //默认操作方法
    ],

    //后台配置
    'admin' => [
        'default_controller' => '', //默认控制器
        'defautl_action' => '', //默认操作方法
    ],
];