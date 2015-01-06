<?php

class main extends controller {

    public function __construct(){
        parent::init();    
    }
    
    public function index(){
        //查询
        CORE::db_init();
        $user = CORE::$db->find('select * from user limit 10');
        
        $this->assign('user', $user);
        $this->display('index.html');
    }
}