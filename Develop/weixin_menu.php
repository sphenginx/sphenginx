<?php
/**
 * 用php实现微信公众号自定义菜单
 *
 * @package develop
 * @author Sphenginx
 **/
class WeiXin_Menu
{
	private $appid = "";  //这里填写自己的appid
	private $secret = "";  //这里填写自己的secret
	private $cacheFile = "AccessToken.cache";

	function __construct($menu)
	{
		$result = $this->GetAccessToken();
		//print_r($result);
		if (array_key_exists('errcode',$result)) {
			throw new Exception($result['errmsg'], 1);
		} else {
			
			
		//删除菜单
	//	$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . $result['access_token'];
    // 	$result = $this->Get($url);	
		
			//创建菜单
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $result['access_token'];
		$result = $this->Post($url,$menu);
		
			
			if ($result['errcode'] == 0) {
				echo 'ok';
				//正常
			} else {
				throw new Exception($result['errcode'], 1);
			}
		}
	}

	public function Post($url, $data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$data = curl_exec($ch);
		curl_close($ch);
		return json_decode($data,true);
	}

	public function Get($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$data = curl_exec($ch);
		curl_close($ch);
		return json_decode($data,true);
	}

	public function GetAccessToken()
	{
		$result=array();
		$grant_type = "client_credential";
		$appid = $this->appid;
		$secret = $this->secret;
		if(file_exists($this->cacheFile)){
			$mtime=filemtime($this->cacheFile);
			if( time()-$mtime <  7200 ){ //access_token的有效期目前为2个小时
				$result = unserialize( file_get_contents($this->cacheFile) );
			}
		}
		if(empty($result)){
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type={$grant_type}&appid={$appid}&secret={$secret}";
			$result = $this->Get($url);
			file_put_contents( $this->cacheFile,serialize($result) );
		}
		return $result;
	}
}

$menu = array(
	"button" => array(
		array(
			"type" => "click",
			"name" => urlencode("微生活"),
			"key" => "KEY_1"
		),
		array(
			"type" => "click",
			"name" => urlencode("微旅游"),
			"key" => "KEY_2"
		),
		array(
			"name" => urlencode("我的网站"),
			"sub_button" => array(
				array(
					"type" => "click",
					"name" => urlencode("我的订单"),
					"key" => "KEY_3"
				),
				array(
					"type" => "click",
					"name" => urlencode("收藏夹"),
					"key" => "KEY_4"
				),
				array(
					"type" => "click",
					"name" => urlencode("个人资料"),
					"key" => "KEY_5"
				)
			)
		)
	)
);

$menu =  json_encode($menu, JSON_UNESCAPED_UNICODE);
$wx   = new WeiXin_Menu($menu);
echo "ok";