<?php

class main extends controller {

    public function __construct(){
        parent::init();    
    }
    
    public function index(){
        $this->assign('hi', 'holle smarty!');
        $this->display('index.html');
    }
}