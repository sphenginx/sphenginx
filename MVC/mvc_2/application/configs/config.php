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
