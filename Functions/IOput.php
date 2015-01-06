<?php
/**
 *  rdump的别名
 *
 *  @author Sphenginx
 *  @param  any
 *  @return void
 */
function dump($arr)
{
    $args = func_get_args();
    call_user_func_array('rdump', $args);
}

/**
 *  格式化显示出变量
 *
 *  @author Sphenginx
 *  @param  any
 *  @return void
 */
function rdump($arr)
{
    echo '<pre>';
    array_walk(func_get_args(), create_function('&$item, $key', 'print_r($item);'));
    echo '</pre>';
    exit();
}

/**
 *  格式化并显示出变量类型
 *
 *  @author Sphenginx
 *  @param  any
 *  @return void
 */
function vdump($arr)
{
    echo '<pre>';
    array_walk(func_get_args(), create_function('&$item, $key', 'var_dump($item);'));
    echo '</pre>';
    exit();
}

/**
 *    导入一个类
 *
 *    @author    Sphenginx
 *    @return    void
 */
function import()
{
    $c = func_get_args();
    if (empty($c))
    {
        return;
    }
    array_walk($c, create_function('$item, $key', 'include_once(\'/includes/libraries/\' . $item . \'.php\');'));
}

/**
 *    保存数据至文件
 *
 *    @author    Sphenginx
 *    @param     array $data      需要保存的数据
 *    @param     string $filePath 保存路径
 *    @return    bool
 */
function saveData_to_file($data, $filePath = './temp/save.inc.php')
{
    $php_data = "<?php\r\nreturn " . var_export($data, true) . ";\r\n?>";
    return file_put_contents($filePath, $php_data, LOCK_EX);
}

/**
 *    自文件获取数据
 *
 *    @author    Sphenginx
 *    @param     string $filePath 文件路径
 *    @return    bool
 */
function getData_from_file($filePath = './temp/save.inc.php')
{
    if (!is_file($filePath))
    {
        return array();
    }

    return include_once($filePath);
}