#Composer - Dependency Management for PHP

###介绍

Composer是 PHP 用来管理依赖（dependency）关系的工具。  
你可以在自己的项目中声明所依赖的外部工具库（libraries），Composer 会帮你安装这些依赖的库文件。

###依赖管理

Composer不是包管理器。是的，它实际上和"包"或者库打交道，但是它是以项目为单位进行管理，把它们安装到你项目中的一个目录（例如vendor）。默认情况下它不会以全局的方式安装任何东西。因此，它是一个依赖管理器。

这个想法并不新鲜，Composer的灵感是来自于node的npm和ruby的bundler。但是目前PHP还没有一个这样的工具。

>	Composer解决的问题是：  
	a)   你有一个依赖N多库的项目。  
	b)   这些库中一些又依赖于其他的库。  
	c)   你声明你所依赖的库。  
	d)   Composer找出哪些包的哪个版本将会被安装，然后安装它们（也就是把它们下载到你的项目中）。  

###声明依赖关系

假设你正在创建一个项目，然后你需要一个日志操作的库。你决定使用monolog。为了把它加入到你的项目中，你需要做的就是创建一个名为composer.json的文件，其描述这个项目的依赖关系。

	{
	    "require": {
	        "monolog/monolog": "1.2.*"
	    }
	}

我们简单的描述说我们的项目依赖某个monolog/monolog包，版本只要是以1.2开头的就行。

###系统要求

Composer需要PHP 5.3.2+才能运行。一些灵敏的PHP设置和编译选项也是必须的，不过安装程序（installer）会警告你任何不兼容的地方。

如果想要从源码而不是简单的从zip压缩包中安装软件包的话，你将需要git，svn或者hg，这依赖于软件包是通过什么进行版本控制的。

Composer是兼容多平台的，并且我们力争使其在Windows，Linux和OSX上的运行无差异。

###more:

>	官网              [org website](http://www.phpcomposer.com/)  
	github            [github](https://github.com/composer/composer)  
	composer依赖包库  [packagist](https://packagist.org/)  

***
Collected by [sphenginx](http://sphenginx.sinaapp.com)