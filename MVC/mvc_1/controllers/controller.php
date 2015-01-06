<?php
class controller {
    
    public function display($template, $data){
        extract($data);
        ob_start();
        include VIEWS_PATH.'/'.$template;
        $content = ob_get_contents();
        ob_end_clean();
        exit($content);
    }
}