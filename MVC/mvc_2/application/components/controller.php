<?php
if(!defined('MVC_PATH')){
    exit('Access Denied');
}

class controller {
    
    public $tpl; // 模版对象
    public $config; // 配置对象
    
    /**
     * 初始化
     */
    public function init()
    {
        $this->initConfig();
        $this->initViews();
    }
    
    /**
     * 加载配置
     */
    public function initConfig()
    {
        session_start();
        require CONFIGS_PATH . '/config.php';
        $this->config = $config;
    }
    
    
    public function initViews()
    {
        require PLUGIN_PATH . '/smarty/Smarty.class.php';
        $this->tpl = new Smarty();
        $data = $this->config['smarty'];
        foreach ($data as $key => $val) {
            $this->tpl->$key = $val;
        }
    }
    
    /**
     * smarty同名方法assign
     * 
     * @param string $tpl_var
     * @param mixed $value
     */
    public function assign($tpl_var, $value = null)
    {
        $this->tpl->assign($tpl_var, $value);
    }

    /**
     * smarty同名方法display
     * 
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     */
    public function display($resource_name, $cache_id = null, $compile_id = null)
    {
        $this->tpl->display($resource_name, $cache_id, $compile_id);
    }
    
}