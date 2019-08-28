<?php

/**
 * Class Base
 * 框架基础类
 * 完成以下功能:
 * 1.读取配置 2.自动加载 3.请求分发
 */
class Base{
    public function run()
    {
        $this->loadConfig();//加载配置
        $this->registerAutoLoad();//注册自动加载
        $this->getRequestParms();//获取请求参数
        $this->dispatch();//请求分发

    }

    /**
     *
     */
    private function loadConfig()
    {
        $GLOBALS['config']=require "./application/config/config.php";
    }
    private function registerAutoLoad()
    {
        spl_autoload_register([$this,'userAutoload']);
    }
    public function userAutoload($className)
    {
        //定义基类
        $baseClass=[
            'Model'=>'./framework/Model.php',
            'Db'=>'./framework/Db.php'
        ];
        if (isset($baseClass[$className]))
        {
            require $baseClass[$className];
        }elseif(substr($className,-5)=='Model'){
            require './application/home/model/'.$className.'.php';
        }elseif(substr($className,-10)=='Controller'){
            require './application/home/controller/'.$className.'.php';
        }
    }

    /**
     *
     */
    public function getRequestParms()
    {
        //当前平台
        $defPlate = $GLOBALS['config']['app']['default_platform'];
        $p = isset($_GET['p'])?$_GET['p']:$defPlate;
        define('PLATFORM', $p);

        //当前控制器
        $defController = $GLOBALS['config'][PLATFORM]['default_controller'];
        $c = isset($_GET['c'])?$_GET['c']:$defController;
        define('CONTROLLER', $c);

        //当前方法
        $defAction = $GLOBALS['config'][PLATFORM]['default_action'];
        $a = isset($_GET['a'])?$_GET['a']:$defAction;
        define('ACTION', $a);
    }

    /**
     *
     */
    public function dispatch()
    {
        //实例化控制器
        $controllerName = CONTROLLER.'Controller';
        $controller = new $controllerName();

        //调用当前方法
        $actionName = ACTION.'Action';
        $controller -> $actionName();
    }
}