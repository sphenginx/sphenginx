#php_ini

*	U can visit [php_core_ini.php](http://php.net/manual/zh/ini.core.php) to get more info.


*	语言选项一些有趣的配置

>	expose_php boolean( on | off)

	决定是否暴露 PHP 被安装在服务器上（例如在 Web 服务器的信息头中加上其签名：X-Powered-By: PHP/5.3.7)。
	The PHP logo guids are also exposed, thus appending them to the URL of a PHP enabled site will display the appropriate logo 
	(e.g., » http://www.php.net/?=PHPE9568F34-D428-11d2-A769-00AA001ACF42). 
	This also affects the output of phpinfo(), as when disabled, the PHP logo and credits information will not be displayed.

>	disable_functions string(disable functions list)
	本指令允许你基于安全原因禁止某些函数。接受逗号分隔的函数名列表作为参数。 disable_functions 不受安全模式的影响。 
	本指令只能设置在 php.ini 中。例如不能将其设置在 httpd.conf。

>	disable_classes string(disable classes list)
	本指令可以使你出于安全的理由禁用某些类。用逗号分隔类名。disable_classes 不受安全模式的影响。 
	本指令只能设置在 php.ini 中。例如不能将其设置在 httpd.conf。

>	request_order string   ( GP    (default PHP_VERSION>5.3))
	variables_order string ( EGPCS (default PHP_VERSION<5.3))

	EGPCS 是 Environment, Get, Post, Cookie, and Server

	This directive describes the order in which PHP registers GET, POST and Cookie variables into the _REQUEST array. Registration is done from left to right, newer values override older values.

	If this directive is not set, variables_order is used for $_REQUEST contents.

	Note that the default distribution php.ini files does not contain the 'C' for cookies, due to security concerns.



*	ini的函数
>	phpcredits()    — 打印 PHP 贡献者名单  
	phpversion()    - 获取当前的PHP版本  
	php_logo_guid() - 获取 logo 的 guid  
	phpinfo()       - 输出关于 PHP 配置的信息  
	ini_set()       — 为一个配置选项设置值  

***
Collected by [sphenginx](http://sphenginx.sinaapp.com)