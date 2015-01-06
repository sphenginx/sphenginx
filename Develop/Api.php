<?php
 
// php://input 是个可以访问请求的原始数据的只读流。 POST 请求的情况下，最好使用 php://input 来代替 $HTTP_RAW_POST_DATA，因为它不依赖于特定的 php.ini 指令。 而且，这样的情况下 $HTTP_RAW_POST_DATA 默认没有填充， 比激活 always_populate_raw_post_data 潜在需要更少的内存。 enctype="multipart/form-data" 的时候 php://input 是无效的。 
    
// 1, php://input 可以读取http entity body中指定长度的值,由Content-Length指定长度,不管是POST方式或者GET方法提交过来的数据。但是，一般GET方法提交数据 时，http request entity body部分都为空。 
// 2,php://input 与$HTTP_RAW_POST_DATA读取的数据是一样的，都只读取Content-Type不为multipart/form-data的数据。
// 学习笔记
//  1，Coentent-Type仅在取值为application/x-www-data-urlencoded和multipart/form-data两种情况下，PHP才会将http请求数据包中相应的数据填入全局变量$_POST 
//  2，PHP不能识别的Content-Type类型的时候，会将http请求包中相应的数据填入变量$HTTP_RAW_POST_DATA 
//  3, 只有Coentent-Type为multipart/form-data的时候，PHP不会将http请求数据包中的相应数据填入php://input，否则其它情况都会。填入的长度，由Coentent-Length指定。 
//  4，只有Content-Type为application/x-www-data-urlencoded时，php://input数据才跟$_POST数据相一致。 
//  5，php://input数据总是跟$HTTP_RAW_POST_DATA相同，但是php://input比$HTTP_RAW_POST_DATA更凑效，且不需要特殊设置php.ini 
//  6，PHP会将PATH字段的query_path部分，填入全局变量$_GET。通常情况下，GET方法提交的http请求，body为空。

error_reporting(E_ERROR);
 
define('API', 'api');
define('DOCROOT',__DIR__);
define('API_SECRET','Sphenginx'); // 根据需要修改
 
//兼容各种提交方式，get、post、字节流
$data1 = $_GET;
$data2=file_get_contents("php://input");
parse_str($data2, $data2);
$data = array_merge($data2, $data1);
unset($data1,$data2);
 
//接口权限验证
$token = md5($data['time'] . API_SECRET);
if (!isset($data['token']) || $token != $data['token']) {
    exit('token error');
}
 
if ( !isset($data['action']) || !$data['action'] ) {
    exit('action error');
}
 
foreach ($data as $k => $v) {
    $v = trim($v);
    $v = strip_tags($v);
    $v = addslashes($v);
    $data[$k] = $v;
}
 
$data['action']=explode('_',$data['action']);
 
try{
    include DOCROOT . '/model/' . $data['action'][0] . '/' . $data['action'][0] . '.php';
    $api = new $data['action'][0]($data);
    $api->$data['action'][1]();
}
catch (Exception $e) {
    echo $e->getMessage();
}
 
 
class api {
 
    public $data = array();
 
    function __construct($data) {
        //根据需要，在此加载公用资源；
        $this->data = $data;
    }
 
}
 
//next are demos -------------------------------------------------------

// 1.一个手机上传图片到服务器的小程序
//   上传文件
    
//@file phpinput_post.php 
$data=file_get_contents('btn.png'); 
$http_entity_body = $data; 
$http_entity_type = 'application/x-www-form-urlencoded'; 
$http_entity_length = strlen($http_entity_body); 
$host = '127.0.0.1'; 
$port = 80; 
$path = '/image.php'; 
$fp = fsockopen($host, $port, $error_no, $error_desc, 30); 
if ($fp){ 
    fputs($fp, "POST {$path} HTTP/1.1\r\n"); 
    fputs($fp, "Host: {$host}\r\n"); 
    fputs($fp, "Content-Type: {$http_entity_type}\r\n"); 
    fputs($fp, "Content-Length: {$http_entity_length}\r\n"); 
    fputs($fp, "Connection: close\r\n\r\n"); 
    fputs($fp, $http_entity_body . "\r\n\r\n"); 

    while (!feof($fp)) { 
     $d .= fgets($fp, 4096); 
    } 
    fclose($fp); 
    echo $d; 
} 

// 接收文件
  

/** 
 *Recieve image data 
 */    
error_reporting(E_ALL); 
function get_contents() {    
    $xmlstr= file_get_contents("php://input"); 
    $filename=time().'.png'; 
    if(file_put_contents($filename,$xmlstr)){ 
     echo 'success'; 
    }else{ 
     echo 'failed'; 
    } 
} 
get_contents(); 


// 2.获取HTTP请求原文
  
/** 
* 获取HTTP请求原文 
* @return string 
*/ 
function get_http_raw() { 
    $raw = ''; 

    // (1) 请求行 
    $raw .= $_SERVER['REQUEST_METHOD'].' '.$_SERVER['REQUEST_URI'].' '.$_SERVER['SERVER_PROTOCOL']."\r\n"; 

    // (2) 请求Headers 
    foreach($_SERVER as $key => $value) { 
        if(substr($key, 0, 5) === 'HTTP_') { 
         $key = substr($key, 5); 
         $key = str_replace('_', '-', $key); 

         $raw .= $key.': '.$value."\r\n"; 
        } 
    } 

    // (3) 空行 
    $raw .= "\r\n"; 

    // (4) 请求Body 
    $raw .= file_get_contents('php://input'); 

    return $raw; 
}
