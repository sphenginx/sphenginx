<?php
/**
 * 加密解密library
 *
 * @package Library
 * @author Sphenginx
 * 
 **/
class Mcrypt
{
    /**
     * 加密
     *
     * @param string $plainText 未加密字符串 
     * @param string $key        密钥
     */
    public static function encrypt($plainText,$key = null)
    {
        $key         = $key === null ? 'Sphenginx' : $key;
        $ivSize      = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv          = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_ECB, $iv);
        return trim(base64_encode($encryptText));
    }

    /**
     * 解密
     * 
     * @param string $encryptedText 已加密字符串
     * @param string $key  密钥
     * @return string
     */
    public static function decrypt($encryptedText, $key = null)
    {
        $key         = $key === null ? 'Sphenginx' : $key;
        $cryptText   = base64_decode($encryptedText);
        $ivSize      = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv          = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cryptText, MCRYPT_MODE_ECB, $iv);
        return trim($decryptText);
    }

} 

class Cookie extends Mcrypt
{
    /**
     * 删除cookie
     * 
     * @param array $args
     * @return boolean
     */
    public static function del($args)
    {
        $name = $args['name'];
        $domain = isset($args['domain']) ? $args['domain'] : null;
        return isset($_COOKIE[$name]) ? setcookie($name, '', time() - 86400, '/', $domain) : true;
    }
     
    /**
     * 得到指定cookie的值
     * 
     * @param string $name
     */
    public static function get($name)
    {
        return isset($_COOKIE[$name]) ? parent::decrypt($_COOKIE[$name]) : null;
    }
     
    /**
     * 设置cookie
     *
     * @param array $args
     * @return boolean
     */
    public static function set($args)
    {
        $name = $args['name'];
        $value= parent::encrypt($args['value']);
        $expire = isset($args['expire']) ? $args['expire'] : null;
        $path = isset($args['path']) ? $args['path'] : '/';
        $domain = isset($args['domain']) ? $args['domain'] : null;
        $secure = isset($args['secure']) ? $args['secure'] : 0;
        return setcookie($name, $value, $expire, $path, $domain, $secure);
    }
}