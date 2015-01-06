<?php
if(!defined('MVC_PATH')){
    exit('Access Denied');
}

class core {
    
    static public $db;
    
    /**
     * 数据库初始化
     */
    static public function db_init(){
        if(isset(self::$db)) return;
        
        require CONFIGS_PATH.'/config.php';
        require COMPONENTS_PATH.'/db_medoo.php';
        $db = new db_medoo($db_options);
        self::$db = &$db;
    }
    
}