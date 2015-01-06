<?php
/**
 * 格式化费用：可以输入数字或百分比的地方
 *
 * @param   string      $fee    输入的费用
 */
function format_fee($fee)
{
    $fee = make_semiangle($fee);
    if (strpos($fee, '%') === false)
    {
        return floatval($fee);
    }
    else
    {
        return floatval($fee) . '%';
    }
}

function price_format($price, $price_format = NULL)
{
    if (empty($price)) $price = '0.00';
    $price = number_format($price, 2);

    if ($price_format === NULL)
    {
        $price_format = Conf::get('price_format');
    }

    return sprintf($price_format, $price);
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author Sphenginx <cuiyuleidiy@gmail.com>
 */
function format_bytes($size, $delimiter = '') 
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 递归方式的对变量中的特殊字符进行转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}

/**
 * 将对象成员变量或者数组的特殊字符进行转义
 *
 * @access   public
 * @param    mix        $obj      对象或者数组
 * @author   Xuan Yan
 *
 * @return   mix                  对象或者数组
 */
function addslashes_deep_obj($obj)
{
    if (is_object($obj) == true)
    {
        foreach ($obj AS $key => $val)
        {
            if ( ($val) == true)
            {
                $obj->$key = addslashes_deep_obj($val);
            }
            else
            {
                $obj->$key = addslashes_deep($val);
            }
        }
    }
    else
    {
        $obj = addslashes_deep($obj);
    }

    return $obj;
}

/**
 * 递归方式的对变量中的特殊字符去除转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function stripslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    }
}

/**
 * 根据总金额和费率计算费用
 *
 * @param     float    $amount    总金额
 * @param     string    $rate    费率（可以是固定费率，也可以是百分比）
 * @param     string    $type    类型：s 保价费 p 支付手续费 i 发票税费
 * @return     float    费用
 */
function compute_fee($amount, $rate, $type)
{
    $amount = floatval($amount);
    if (strpos($rate, '%') === false)
    {
        return round(floatval($rate), 2);
    }
    else
    {
        $rate = floatval($rate) / 100;
        if ($type == 's')
        {
            return round($amount * $rate, 2);
        }
        elseif($type == 'p')
        {
            return round($amount * $rate / (1 - $rate), 2);
        }
        else
        {
            return round($amount * $rate, 2);
        }
    }
}