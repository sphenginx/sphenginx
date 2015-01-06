<?php
/**
 * 这个是一个自动抓取360kb网页的Google hosts，然后更新本地Google host，防止被墙
 *
 * @package script
 * @author Sphenginx
 **/
echo 'start catch google hosts ……';

//hosts文件夹位置
$hostsFile = "C:/Windows/System32/drivers/etc/hosts";

//匹配Google的主机ip
$RegExp    = '/#google hosts [0-9]+ by 360kb.com[\s\S]+#google hosts [0-9]+ end/';

//抓取Google的ip
$html = strip_tags(file_get_contents('http://www.360kb.com/kb/2_122.html'));
 
preg_match($RegExp, $html, $matchs);

//获取google的主机地址
$googleHosts = str_replace('&nbsp;', ' ', $matchs[0]);

//echo $googleHosts;

$hosts = file_get_contents($hostsFile);

if(preg_match($RegExp, $hosts)){
    $hosts = preg_replace($RegExp, $googleHosts, $hosts);
}else{
    $hosts .= "\r\n\r\n".$googleHosts."\r\n\r\n";
}

file_put_contents($hostsFile, $hosts);

echo 'Congratulations，update Google hosts success！';
