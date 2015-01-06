<?php
if(!defined('MVC_PATH')){
    exit('Access Denied');
}

class Func {
    
    /**
     * 过滤特殊符号
     * 该方法在GBK数据表下有漏洞
     */
    static public function saddslashes(&$text){
        if(!get_magic_quotes_gpc()){
            if(is_array($text)){
                foreach($text as $k => $v)
                    $text[$k] = self::saddslashes($v);
            }else{
                $text = addslashes($text);
            }
        }
        return $text;
    }
}