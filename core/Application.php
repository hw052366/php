<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/20
 * Time: 11:54
 */
namespace core;

class Application
{
    public static function run()
    {
        self::setCharset();
        self::defineRouteConst();
        self::definePathConst();
        self::defineAutoloader();
        self::openSession();
        self::dispatchRoute();
    }

    protected static function setCharset()
    {
        header("content-type:text/html;charset=utf-8");
    }

    protected static function defineRouteConst()
    {
        $p = isset($_GET['p']) ? $_GET['p'] : 'frontend';
        define('PLATFORM', $p);
        $a = isset($_GET['a']) ? $_GET['a'] : 'index';
        define('ACTION', $a);
        $c = isset($_GET['c']) ? $_GET['c'] : 'Article';
        define('CONTROLLER', $c);
    }

    protected static function definePathConst()
    {
        define("VIEW_PATH", "./app/Views");
        define("CONFIG_PATH", './app/config');
    }

    protected static function loadClass($className)
    {
        $fileName = str_replace('\\', '/', $className) . ".php";
       if (is_file($fileName)) {
           require $fileName;
       }
    }

    protected static function defineAutoloader()
    {
        spl_autoload_register('self::loadClass');
    }

    protected static function openSession()
    {
        session_start();
    }
    protected static function dispatchRoute()
    {
        $c = CONTROLLER;
        $class = "app\\Controller\\" . PLATFORM . "\\" . $c . "Controller";
        $ctrl = new $class();
        $a = ACTION;
        $ctrl->$a();
    }
}