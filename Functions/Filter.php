<?php
/**
 * 验证输入的邮件地址是否合法
 *
 * @param   string      $email      需要验证的邮件地址
 *
 * @return bool
 */
function is_email($user_email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
    {
        if (preg_match($chars, $user_email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

/**
 * 检查是否为一个合法的时间格式
 *
 * @param   string  $time
 * @return  void
 */
function is_time($time)
{
    $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';

    return preg_match($pattern, $time);
}

/**
 * 返回是否是通过浏览器访问的页面
 *
 * @author wj
 * @param  void
 * @return boolen
 */
function is_from_browser()
{
    static $ret_val = null;
    if ($ret_val === null)
    {
        $ret_val = false;
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
        if ($ua)
        {
            if ((strpos($ua, 'mozilla') !== false) && ((strpos($ua, 'msie') !== false) || (strpos($ua, 'gecko') !== false)))
            {
                $ret_val = true;
            }
            elseif (strpos($ua, 'opera'))
            {
                $ret_val = true;
            }
        }
    }
    return $ret_val;
}

/**
 * ajax request
 *
 * @return bool
 */
function is_xhr_request() 
{
    return ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : null)
        || (isset($_POST['X-Requested-With']) ? $_POST['X-Requested-With'] : null)) == 'XMLHttpRequest';
}
/**
 * ipad request
 *
 * @return bool
 */
function is_ipad_request() 
{
    return strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false;
}
/**
 * mobile request
 *
 * @return bool
 */
function is_mobile_request() 
{
    return strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false
    || strpos($_SERVER['HTTP_USER_AGENT'], 'iPod') !== false
    || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
    || strpos($_SERVER['HTTP_USER_AGENT'], 'webOS') !== false;
}
/**
 * accept json
 *
 * @return bool
 */
function is_accept_json() 
{
    return strpos(strtolower((isset($_POST['X-Http-Accept']) ? $_POST['X-Http-Accept'] . ',' : '') . $_SERVER['HTTP_ACCEPT']), 'application/json') !== false;
}
/**
 * 检查数组类型
 *
 * @param array $array
 * @return bool
 */
function is_assoc($array) 
{
    return (is_array($array) && (0 !== count(array_diff_key($array, array_keys(array_keys($array)))) || count($array) == 0));
}
/**
 * 判断是否为json格式
 *
 * @param $text
 * @return bool
 */
function is_jsoned($text) 
{
    return preg_match('/^("(\\\.|[^"\\\n\r])*?"|[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t])+?$/', $text);
}
/**
 * 检查值是否已经序列化
 *
 * @param mixed $data Value to check to see if was serialized.
 * @return bool
 */
function is_serialized($data) 
{
    // if it isn't a string, it isn't serialized
    if (!is_string($data))
        return false;
    $data = trim($data);
    if ('N;' == $data)
        return true;
    if (!preg_match('/^([adObis]):/', $data, $badions))
        return false;
    switch ($badions[1]) {
        case 'a' :
        case 'O' :
        case 's' :
            if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                return true;
            break;
        case 'b' :
        case 'i' :
        case 'd' :
            if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                return true;
            break;
    }
    return false;
}
/**
 * 根据概率判定结果
 *
 * @param float $probability
 * @return bool
 */
function is_happened($probability) 
{
    return (mt_rand(1, 100000) / 100000) <= $probability;
}
/**
 * 判断是否汉字
 *
 * @param string $str
 * @return int
 */
function is_hanzi($str) 
{
    return preg_match('%^(?:
          [\xC2-\xDF][\x80-\xBF]            # non-overlong 2-byte
        | \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
        | \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
        | \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
        | \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
        )*$%xs', $str);
}
/**
 * 判断是否搜索蜘蛛
 *
 * @static
 * @return bool
 */
function is_spider() 
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (stripos($user_agent, 'Googlebot') !== false
        || stripos($user_agent, 'Sosospider') !== false
        || stripos($user_agent, 'Baiduspider') !== false
        || stripos($user_agent, 'Baidu-Transcoder') !== false
        || stripos($user_agent, 'Yahoo! Slurp') !== false
        || stripos($user_agent, 'iaskspider') !== false
        || stripos($user_agent, 'Sogou') !== false
        || stripos($user_agent, 'YodaoBot') !== false
        || stripos($user_agent, 'msnbot') !== false
        || stripos($user_agent, 'Sosoimagespider') !== false
    ) {
        return true;
    }
    return false;
}