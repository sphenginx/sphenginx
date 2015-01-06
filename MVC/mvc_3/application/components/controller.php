<?php
if(!defined('MVC_PATH')){
    exit('Access Denied');
}

class controller {
    
    public $tpl; // 模版对象
    public $config; // 配置对象
    public $siteurl; // 网站路径url
    public $baseurl; // 网站基本url
    public $resource;// 资源路径
    
    /**
     * 初始化
     */
    public function init()
    {
        $this->noAuthInit();
    }

    /**
     * 没有检查登录的初始化
     */
    public function noAuthInit()
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
        
        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        $this->siteurl = $this->config['site']['rewrite'] ? substr($url, 0, strrpos($url, '/', - 2)) : $url;
        $this->baseurl = substr($url, 0, strrpos($url, '/', - 2));
        $this->resource = $this->config['site']['resource'] ? $this->config['site']['resource'] : $url;
    }
    
    
    public function initViews()
    {
        require PLUGIN_PATH . '/smarty/Smarty.class.php';
        $this->tpl = new Smarty();
        $data = $this->config['smarty'];
        foreach ($data as $key => $val) {
            $this->tpl->$key = $val;
        }
        $this->assign('build', $this->config['site']['build']);
        $this->assign('title', $this->config['site']['title']);
        $this->assign('charset', $this->config['site']['charset']);
        $this->assign('siteurl', $this->siteurl);
        $this->assign('baseurl', $this->baseurl);
        $this->assign('resource', $this->resource);
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