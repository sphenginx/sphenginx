<?php
class main extends controller {
    
    public function index(){
        $data = array('a' => 'hello word!');
        $this->display('index.php', $data);
    }
}