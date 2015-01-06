<?php

// 全局唯一标识符（GUID，Globally Unique Identifier）也称作 UUID(Universally Unique IDentifier) 。
// GUID是一种由算法生成的二进制长度为128位的数字标识符。GUID主要用于在拥有多个节点、多台计算机的网络或系统中。
// 在理想情况下，任何计算机和计算机集群都不会生成两个相同的GUID。
// GUID 的总数达到了2^128（3.4×10^38）个，所以随机生成两个相同GUID的可能性非常小，但并不为0。
// GUID一词有时也专指微软对UUID标准的实现。
function create_guid()
{
　　$charid = strtoupper(md5(uniqid(mt_rand(), true)));
　　$hyphen = chr(45);// "-"
　　$uuid = substr($charid, 0, 8).$hyphen
　　.substr($charid, 8, 4).$hyphen
　　.substr($charid,12, 4).$hyphen
　　.substr($charid,16, 4).$hyphen
　　.substr($charid,20,12);
　　return $uuid;
}

/**
 * 生成guid
 *
 * @param string $mix
 * @param string $hyphen
 * @return string
 */
function guid($mix = null, $hyphen = '-') 
{
    if (is_null($mix)) {
        $randid = uniqid(mt_rand(), true);
    } else {
        if (is_object($mix) && function_exists('spl_object_hash')) {
            $randid = spl_object_hash($mix);
        } elseif (is_resource($mix)) {
            $randid = get_resource_type($mix) . strval($mix);
        } else {
            $randid = serialize($mix);
        }
    }
    $randid = strtoupper(md5($randid));
    $result = array();
    $result[] = substr($randid, 0, 8);
    $result[] = substr($randid, 8, 4);
    $result[] = substr($randid, 12, 4);
    $result[] = substr($randid, 16, 4);
    $result[] = substr($randid, 20, 12);
    return implode($hyphen, $result);
}

/**
 * 获得当前的域名
 *
 * @return  string
 */
function get_domain()
{
    /* 协议 */
    $protocol = (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';

    /* 域名或IP地址 */
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
    {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    }
    elseif (isset($_SERVER['HTTP_HOST']))
    {
        $host = $_SERVER['HTTP_HOST'];
    }
    else
    {
        /* 端口 */
        if (isset($_SERVER['SERVER_PORT']))
        {
            $port = ':' . $_SERVER['SERVER_PORT'];

            if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
            {
                $port = '';
            }
        }
        else
        {
            $port = '';
        }

        if (isset($_SERVER['SERVER_NAME']))
        {
            $host = $_SERVER['SERVER_NAME'] . $port;
        }
        elseif (isset($_SERVER['SERVER_ADDR']))
        {
            $host = $_SERVER['SERVER_ADDR'] . $port;
        }
    }

    return $protocol . $host;
}

/**
 * 获得用户的真实IP地址
 *
 * @return  string
 */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}

/**
 * 获取服务器的ip
 *
 * @access      public
 *
 * @return string
 **/
function real_server_ip()
{
    static $serverip = NULL;

    if ($serverip !== NULL)
    {
        return $serverip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['SERVER_ADDR']))
        {
            $serverip = $_SERVER['SERVER_ADDR'];
        }
        else
        {
            $serverip = '0.0.0.0';
        }
    }
    else
    {
        $serverip = getenv('SERVER_ADDR');
    }

    return $serverip;
}

/**
 * 获得用户操作系统的换行符
 *
 * @access  public
 * @return  string
 */
function get_crlf()
{
/* LF (Line Feed, 0x0A, \N) 和 CR(Carriage Return, 0x0D, \R) */
    if (stristr($_SERVER['HTTP_USER_AGENT'], 'Win'))
    {
        $the_crlf = "\r\n";
    }
    elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Mac'))
    {
        $the_crlf = "\r"; // for old MAC OS
    }
    else
    {
        $the_crlf = "\n";
    }

    return $the_crlf;
}


/**
 * 返回由对象属性组成的关联数组
 *
 * @access   pubilc
 * @param    obj    $obj
 *
 * @return   array
 */
function get_object_vars_deep($obj)
{
    if(is_object($obj))
    {
        $obj = get_object_vars($obj);
    }
    if(is_array($obj))
    {
        foreach ($obj as $key => $value)
        {
            $obj[$key] = get_object_vars_deep($value);
        }
    }
    return $obj;
}

function file_ext($filename)
{
    return trim(substr(strrchr($filename, '.'), 1, 10));
}

/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表数组或字符串,如果为字符串时,字符串只接受数字串
 * @param    string   $field_name     字段名称
 * @author   wj
 *
 * @return   void
 */
function db_create_in($item_list, $field_name = '')
{
    if (empty($item_list))
    {
        return $field_name . " IN ('') ";
    }
    else
    {
        if (!is_array($item_list))
        {
            $item_list = explode(',', $item_list);
            foreach ($item_list as $k=>$v)
            {
                $item_list[$k] = intval($v);
            }
        }

        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item)
        {
            if ($item !== '')
            {
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp))
        {
            return $field_name . " IN ('') ";
        }
        else
        {
            return $field_name . ' IN (' . $item_list_tmp . ') ';
        }
    }
}

/**
 * 创建目录（如果该目录的上级目录不存在，会先创建上级目录）
 * 依赖于 ROOT_PATH 常量，且只能创建 ROOT_PATH 目录下的目录
 * 目录分隔符必须是 / 不能是 \
 *
 * @param   string  $absolute_path  绝对路径
 * @param   int     $mode           目录权限
 * @return  bool
 */
function sph_mkdir($absolute_path, $mode = 0777)
{
    if (is_dir($absolute_path))
    {
        return true;
    }

    $root_path      = '/';
    $relative_path  = str_replace($root_path, '', $absolute_path);
    $each_path      = explode('/', $relative_path);
    $cur_path       = $root_path; // 当前循环处理的路径
    foreach ($each_path as $path)
    {
        if ($path)
        {
            $cur_path = $cur_path . '/' . $path;
            if (!is_dir($cur_path))
            {
                if (@mkdir($cur_path, $mode))
                {
                    fclose(fopen($cur_path . '/index.htm', 'w'));
                }
                else
                {
                    return false;
                }
            }
        }
    }

    return true;
}

/**
 * 删除目录,不支持目录中带 ..
 *
 * @param string $dir
 *
 * @return boolen
 */
function sph_rmdir($dir)
{
    $dir = str_replace(array('..', "\n", "\r"), array('', '', ''), $dir);
    $ret_val = false;
    if (is_dir($dir))
    {
        $d = @dir($dir);
        if($d)
        {
            while (false !== ($entry = $d->read()))
            {
               if($entry!='.' && $entry!='..')
               {
                   $entry = $dir.'/'.$entry;
                   if(is_dir($entry))
                   {
                       sph_rmdir($entry);
                   }
                   else
                   {
                       @unlink($entry);
                   }
               }
            }
            $d->close();
            $ret_val = rmdir($dir);
         }
    }
    else
    {
        $ret_val = unlink($dir);
    }

    return $ret_val;
}

/**
 *  fopen封装函数
 *
 *  @author wj
 *  @param string $url
 *  @param int    $limit
 *  @param string $post
 *  @param string $cookie
 *  @param boolen $bysocket
 *  @param string $ip
 *  @param int    $timeout
 *  @param boolen $block
 *  @return responseText
 */
function sph_fopen($url, $limit = 500000, $post = '', $cookie = '', $bysocket = false, $ip = '', $timeout = 15, $block = true)
{
    $return = '';
    $matches = parse_url($url);
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;

    if($post)
    {
        $out = "POST $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= 'Content-Length: '.strlen($post)."\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cache-Control: no-cache\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
        $out .= $post;
    }
    else
    {
        $out = "GET $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
    }
    $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    if(!$fp)
    {
        return '';
    }
    else
    {
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        @fwrite($fp, $out);
        $status = stream_get_meta_data($fp);
        if(!$status['timed_out'])
        {
            while (!feof($fp))
            {
                if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))
                {
                    break;
                }
            }

            $stop = false;
            while(!feof($fp) && !$stop)
            {
                $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                $return .= $data;
                if($limit)
                {
                    $limit -= strlen($data);
                    $stop = $limit <= 0;
                }
            }
        }
        @fclose($fp);
        return $return;
    }
}

/**
 * 危险 HTML代码过滤器
 *
 * @param   string  $html   需要过滤的html代码
 *
 * @return  string
 */
function html_filter($html)
{
    $filter = array(
        "/\s/",
        "/<(\/?)(script|i?frame|style|html|body|title|link|\?|\%)([^>]*?)>/isU",//object|meta|
        "/(<[^>]*)on[a-zA-Z]\s*=([^>]*>)/isU",
        );

    $replace = array(
        " ",
        "&lt;\\1\\2\\3&gt;",
        "\\1\\2",
        );

    $str = preg_replace($filter,$replace,$html);
    return $str;
}

/**
 * 如果系统不存在file_put_contents函数则声明该函数
 *
 * @author  wj
 * @param   string  $file
 * @param   mix     $data
 * @return  int
 */
if (!function_exists('file_put_contents'))
{
    define('FILE_APPEND', 'FILE_APPEND');
    if (!defined('LOCK_EX'))
    {
        define('LOCK_EX', 'LOCK_EX');
    }

    function file_put_contents($file, $data, $flags = '')
    {
        $contents = (is_array($data)) ? implode('', $data) : $data;

        $mode = ($flags == 'FILE_APPEND') ? 'ab+' : 'wb';

        if (($fp = @fopen($file, $mode)) === false)
        {
            return false;
        }
        else
        {
            $bytes = fwrite($fp, $contents);
            fclose($fp);

            return $bytes;
        }
    }
}

/**
 *    从文件或数组中定义常量
 *
 *    @author    Garbin
 *    @param     mixed $source
 *    @return    void
 */
function sph_define($source)
{
    if (is_string($source))
    {
        /* 导入数组 */
        $source = include($source);
    }
    if (!is_array($source))
    {
        /* 不是数组，无法定义 */
        return false;
    }
    foreach ($source as $key => $value)
    {
        if (is_string($value) || is_numeric($value) || is_bool($value) || is_null($value))
        {
            /* 如果是可被定义的，则定义 */
            define(strtoupper($key), $value);
        }
    }
}

/**
 *    获取当前时间的微秒数
 *
 *    @author    Garbin
 *    @return    float
 */
function sph_microtime()
{
    if (PHP_VERSION >= 5.0)
    {
        return microtime(true);
    }
    else
    {
        list($usec, $sec) = explode(" ", microtime());

        return ((float)$usec + (float)$sec);
    }
}

function  html_script($text)
{
    $str="'<script[^>]*?>.*?</script\s*>'si";
    $text = preg_replace('/onerror/','',$text);
    $text = preg_replace( $str,'',$text);
    $text =  str_replace('[','&#091;',$text);
    $text = str_replace(']','&#093;',$text);
    $text =  str_replace('|','&#124;',$text); 
    return $text;
}

/**
 * 页面跳转
 *
 * @param string $url
 * @param int $status
 * @return array | string
 */
function redirect($url, $status = 302) 
{
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        return array('status' => $status, 'location' => $url);
    } else {
        if (!headers_sent()) header("Location: {$url}", true, $status);
        $html = '<!DOCTYPE html>';
        $html .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $html .= '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        $html .= '<title>' . $url . '</title>';
        $html .= '<script type="text/javascript" charset="utf-8">';
        $html .= 'self.location.replace("' . addcslashes($url, "'") . '");';
        $html .= '</script>';
        $html .= '</head><body></body></html>';
        return $html;
    }
}

/**
 * Detect MIME Content-type for a file (deprecated)
 *
 * @param string $filename
 * @return string
 */
function file_mime_type($filename) 
{
    if (is_file($filename) && function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return $mimetype;
    } else if (is_file($filename) && function_exists('mime_content_type')) {
        return mime_content_type($filename);
    } else {
        switch (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
            case 'txt':
                return 'text/plain';
            case 'htm':
            case 'html':
            case 'php':
                return 'text/html';
            case 'css':
                return 'text/css';
            case 'js':
                return 'application/javascript';
            case 'json':
                return 'application/json';
            case 'xml':
                return 'application/xml';
            case 'swf':
                return 'application/x-shockwave-flash';
            case 'flv':
                return 'video/x-flv';
            // images
            case 'png':
                return 'image/png';
            case 'jpe':
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'gif':
                return 'image/gif';
            case 'bmp':
                return 'image/bmp';
            case 'ico':
                return 'image/x-icon';
            case 'tiff':
            case 'tif':
                return 'image/tiff';
            case 'svg':
            case 'svgz':
                return 'image/svg+xml';
            // archives
            case 'zip':
                return 'application/zip';
            case 'rar':
                return 'application/rar';
            case 'exe':
            case 'cpt':
            case 'bat':
            case 'dll':
                return 'application/x-msdos-program';
            case 'msi':
                return 'application/x-msi';
            case 'cab':
                return 'application/x-cab';
            case 'qtl':
                return 'application/x-quicktimeplayer';
            // audio/video
            case 'mp3':
            case 'mpga':
            case 'mpega':
            case 'mp2':
            case 'm4a':
                return 'audio/mpeg';
            case 'qt':
            case 'mov':
                return 'video/quicktime';
            case 'mpeg':
            case 'mpg':
            case 'mpe':
                return 'video/mpeg';
            case '3gp':
                return 'video/3gpp';
            case 'mp4':
                return 'video/mp4';
            // adobe
            case 'pdf':
                return 'application/pdf';
            case 'psd':
                return 'image/x-photoshop';
            case 'ai':
            case 'ps':
            case 'eps':
            case 'epsi':
            case 'epsf':
            case 'eps2':
            case 'eps3':
                return 'application/postscript';
            // ms office
            case 'doc':
            case 'dot':
                return 'application/msword';
            case 'rtf':
                return 'application/rtf';
            case 'xls':
            case 'xlb':
            case 'xlt':
                return 'application/vnd.ms-excel';
            case 'ppt':
            case 'pps':
                return 'application/vnd.ms-powerpoint';
            case 'xlsx':
                return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            case 'xltx':
                return 'application/vnd.openxmlformats-officedocument.spreadsheetml.template';
            case 'pptx':
                return 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
            case 'ppsx':
                return 'application/vnd.openxmlformats-officedocument.presentationml.slideshow';
            case 'potx':
                return 'application/vnd.openxmlformats-officedocument.presentationml.template';
            case 'docx':
                return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            case 'dotx':
                return 'application/vnd.openxmlformats-officedocument.wordprocessingml.template';
            // open office
            case 'odt':
                return 'application/vnd.oasis.opendocument.text';
            case 'ods':
                return 'application/vnd.oasis.opendocument.spreadsheet';
            case 'odp':
                return 'application/vnd.oasis.opendocument.presentation';
            case 'odb':
                return 'application/vnd.oasis.opendocument.database';
            case 'odg':
                return 'application/vnd.oasis.opendocument.graphics';
            case 'odi':
                return 'application/vnd.oasis.opendocument.image';
            default:
                return 'application/octet-stream';
        }
    }
}