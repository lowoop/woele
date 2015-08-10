<?php
header("Content-type: text/html; charset=utf-8");
header('Expires: Thu, 01 Jan 1970 00:00:01 GMT');
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

ini_set("safe_mode",true);

define('WW_ROOT', dirname(__FILE__));
$arr_test_hosts = array("127.0.0.1");
if(in_array($_SERVER['SERVER_ADDR'], $arr_test_hosts))//test config
{
	define('WW_DOMAIN', "http://www.woele.com.au");
	$config_file = "test";
}
else 
{
	define('WW_DOMAIN', "http://www.woele.com.au");
	$config_file = "main";
}
define('WW_RES_DIR', WW_DOMAIN."/resources");
// change the following paths if necessary
$yii=WW_ROOT.'/lib/yii-1.1.15.022a51/yii.php';
$config=WW_ROOT.'/protected/config/'.$config_file.'.php';
// remove the following lines when in production mode
define('YII_DEBUG', true);

// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
