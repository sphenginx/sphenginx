<?php
header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ALL ^ E_NOTICE);


// 定义路径
define('MVC_PATH', dirname(__FILE__));
define('PLUGIN_PATH', MVC_PATH.'/plugin');
define('SMARTY_PATH', PLUGIN_PATH.'/smarty');
define('APPLICATION_PATH', MVC_PATH.'/application');
define('COMPONENTS_PATH', APPLICATION_PATH.'/components');
define('CONTROLLERS_PATH', APPLICATION_PATH.'/controllers');
define('VIEWS_PATH', APPLICATION_PATH.'/views');
define('CONFIGS_PATH', APPLICATION_PATH.'/configs');
define('CACHE_PATH', APPLICATION_PATH.'/cache');
// 定义常量
define('TIMESTAMP', time());
define('DAYTIMES', date('Y-m-d', TIMESTAMP));
define('DATETIMES', date('Y-m-d H:i:s', TIMESTAMP));


require_once COMPONENTS_PATH.'/functions.php';      //加载函数类
require_once COMPONENTS_PATH.'/controller.php';    //加载主控制器


/**
 * 过滤特殊符号
 * 该方法在GBK数据表下有漏洞
 */
foreach(array('_REQUEST', '_GET', '_POST', '_COOKIE') as $value) {
    foreach(${$value} as $k => $v){
        ${$value}[$k] = Func::saddslashes($v);
    }
    unset($value);
}


$act = $_REQUEST['act'] = !empty($_REQUEST['act']) ? $_REQUEST['act'] : 'main';
$mod = $_REQUEST['mod'] = !empty($_REQUEST['mod']) ? $_REQUEST['mod'] : 'index';

$controller_file = CONTROLLERS_PATH.'/'.$act.'.php';
if(!file_exists($controller_file)){
    die('没有找到对应的程序文件');
}
require $controller_file;
$controller = new $act();
$controller->$mod();