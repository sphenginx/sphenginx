<?php
// 定义路径
define('MVC_PATH', dirname(__FILE__));
define('CONTROLLERS_PATH', MVC_PATH.'/controllers');
define('VIEWS_PATH', MVC_PATH.'/views');


$act = $_REQUEST['act'] = !empty($_REQUEST['act']) ? $_REQUEST['act'] : 'main';
$mod = $_REQUEST['mod'] = !empty($_REQUEST['mod']) ? $_REQUEST['mod'] : 'index';
require CONTROLLERS_PATH.'/controllers.php';
require CONTROLLERS_PATH.'/'.$act.'.php';
$c = new $act();
$c->$mod();