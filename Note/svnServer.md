#CentOS下使用yum安装配置和使用svn

*    安装说明

>	系统环境：CentOS-6.3  
>	安装方式：yum install （源码安装容易产生版本兼容的问题）   
>	安装软件：系统自动下载SVN软件 

*	检查已安装版本

		//检查是否安装了低版本的SVN  
		[root@localhost /]# rpm -qa subversion    
		//卸载旧版本SVN  
		[root@localhost /]# yum remove subversion  
		安装SVN  
		[root@localhost /]# yum install svn  

*	验证安装 

		检验已经安装的SVN版本信息   
		[root@localhost /]# svnserve --version   
		svnserve，版本 1.6.11 (r934486)   
		编译于 Dec 12 2014，19:44:03   

		版权所有 (C) 2000-2009 CollabNet。   
		Subversion 是开放源代码软件，请参阅 http://subversion.tigris.org/ 站点。   
		此产品包含由 CollabNet( http://www.Collab.Net/) 开发的软件。   

		下列版本库后端(FS) 模块可用: 
		* fs_base : 模块只能操作BDB版本库。 
		* fs_fs : 模块与文本文件(FSFS)版本库一起工作。 
		Cyrus SASL 认证可用。 

*	代码库创建 

	SVN软件安装完成后还需要建立SVN库 

		[root@localhost /]# mkdir -p /data/svn_repositories
		[root@localhost /]# svnadmin create /data/svn_repositories

	执行上面的命令后，自动建立repositories库，查看/data/svn_repositories 文件夹发现包含了conf, db,format,hooks, locks, README.txt等文件，说明一个SVN库已经建立

*	配置代码库 

	进入上面生成的文件夹conf下，进行配置 

		[root@localhost /]# cd /data/svn_repositories/conf 


	用户密码passwd配置 

		[root@localhost password]# cd /data/svn_repositories/conf
		[root@localhost conf]# vi + passwd
		修改passwd为以下内容： 
		[users]
		# harry = harryssecret
		# sally = sallyssecret
		cuiyl=123456

	权限控制authz配置 

		[root @localhost conf]# vi + authz 
		目的是设置哪些用户可以访问哪些目录，向authz文件追加以下内容： 
		#设置[/]代表根目录下所有的资源 
		[/] 
		cuiyl=rw 
		服务svnserve.conf配置 

		[root @localhost conf]# vi + svnserve.conf 

		追加以下内容： 
		[general]
		#匿名访问的权限，可以是read,write,none,默认为read
		anon-access=none
		#使授权用户有写权限
		auth-access=write
		#密码数据库的路径
		password-db=passwd
		#访问控制文件
		authz-db=authz
		#认证命名空间，subversion会在认证提示里显示，并且作为凭证缓存的关键字
		realm=/data/svn_repositories

	配置防火墙端口 

		[root@localhost conf]# vi /etc/sysconfig/iptables
		添加以下内容：
		-A INPUT -m state --state NEW -m tcp -p tcp --dport 3690 -j ACCEPT
		保存后重启防火墙
		[root@localhost conf]# service iptables restart
		启动SVN 
		[root@localhost conf]# svnserve -d -r /data/
		查看SVN进程 
		[root@localhost conf]# ps -ef|grep svn|grep -v grep
		root 12538 1 0 14:40 ? 00:00:00 svnserve -d -r /data/
		检测SVN 端口 
		[root@localhost conf]# netstat -ln |grep 3690
		tcp 0 0 0.0.0.0:3690 0.0.0.0:* LISTEN
		停止重启SVN 
		[root@localhost password]# killall svnserve //停止
		[root@localhost password]# svnserve -d -r /data/ // 启动

*	测试 

	SVN服务已经启动，使用客户端测试连接。 
	客户端连接地址：svn://192.168.1.221/svn_repositories
	用户名/密码： cuiyl/123456 
	测试创建文件夹等操作。




*	可能出现的问题 

>	如果外网不能正常访问，可能还需要作端口映射，对外网开放3690端口。
    检查端口是否打开，可以用命令： telnet xxx.xxx.xxx.xxx 3690

>	svnserve参数：-d 为后台运行，-r为运行的目录，注意目录不能包含svn_repositories这个仓库目录！！！







***
Collected by [sphenginx](http://sphenginx.sinaapp.com)