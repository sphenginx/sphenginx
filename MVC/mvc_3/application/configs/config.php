<?php
/* Smarty配置 */
$config['smarty']['left_delimiter'] = '{{';
$config['smarty']['right_delimiter'] = '}}';
$config['smarty']['template_dir'] = VIEWS_PATH . '/default';
$config['smarty']['compile_dir'] = CACHE_PATH . '/smarty/template_c';
$config['smarty']['cache_dir'] = CACHE_PATH . '/smarty/cache_c';
$config['smarty']['caching'] = false;
$config['smarty']['cache_lifetime'] = 3600;
$config['smarty']['debugging'] = false;


/* 网站配置 */
$config['site']['resource'] = '';
$config['site']['title'] = 'MVC';
$config['site']['charset'] = 'utf-8';
$config['site']['rewrite'] = false;
$config['site']['build'] = '2014';


/* Mysql配置 */
$db_options['database_type']    = 'mysql';
$db_options['server']           = '127.0.0.1';
$db_options['username']         = 'root';
$db_options['password']         = '';
$db_options['database_file']    = '';
$db_options['post']             = '3306';
$db_options['charset']          = 'utf8';
$db_options['database_name']    = 'mvc';