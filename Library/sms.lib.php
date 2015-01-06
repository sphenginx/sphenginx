<?php
/**
 * 发送短信类
 *
 * @package library
 * @author Sphenginx
 * 
 **/
class Sms
{

	//短信模板
	public $_template   = array(
		'sms_order_seller' => '掌柜"【seller】" 您好，恭喜您有新得订单已交易成功，订单号："【order_sn】" ，请尽快发货哦~~',
		'sms_order_buyer'  => '尊敬的顾客，您刚才在 "【store_name】" 店铺购买的 "【goods_name】" 已经成功支付，订单编号 "【order_sn】" ，店掌柜正在发货中，请耐心等待。',
		'sms_register'     => '您的验证码是： "【code】" 。此验证码仅用于搜购注册，请不要泄露给其他人',
		'sms_changepass'   => '您的验证码是：【code】。请不要把验证码泄露给其他人。'
	);

	//账户
	private $_account   = 'username';

	//密码
	private $_password  = 'password';

	//当前短信模板
	public $_content    = '';

	//定义手机号码
	protected $_mobile  = '';

	//定义短信url
	protected $_smsHost = 'http://smsHost/webservice/sms.php?method=Submit';

	/**
	 * 初始化
	 *
	 * @param string $_template 短信模板
	 * @param int    $mobile    手机号
	 * @param array  $replace   被替换的模板
	 * 
	 * @return void
	 * @author sphenginx
	 **/
	function __construct($_template, $mobile, $replace)
	{
		$this->_content = $this->_template[$_template];
		$this->_mobile  = $mobile;
		$this->_replace_content($replace);
	}

	/**
	 * 替换模板中的字段
	 *
	 * @param array $replaceData 需要被替换的字段
	 *
	 * @return void
	 * @author sphenginx
	 **/
	private function _replace_content($replaceData)
	{
		if (!is_array($replaceData) || empty($replaceData)) 
			return;
		foreach ($replaceData as $key => $rD) 
		{
			$this->_content = str_replace('【'.$key.'】', $rD, $this->_content);
		}
	}

	/**
	 * 发送短信
	 *
	 * @return array
	 * @author sphenginx
	 **/
	function send()
	{
		$raw = array(
			'account' => $this->_account,
			'password'=> $this->_password,
			'mobile'  => $this->_mobile,
			'content' => $this->_content
		);

		return $this->xml_to_array($this->_post($raw, $this->_smsHost));
	}

	/**
	 * curl请求
	 *
	 * @param string $curlPost post的数据
	 * @param string $url 	   curl请求的url
	 * 
	 * @return xml
	 * @author Sphenginx
	 **/
	function _post($curlPost, $url)
	{
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        // $error      = curl_error($curl);     //如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);
        return $return_str;
    }

    /**
     * xml to array
     *
     * @param string $xml xml标签
     * 
     * @return array
     * @author Sphenginx
     **/
    function xml_to_array($xml)
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = $this->xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }


    public function __destruct(){}

} // END class 