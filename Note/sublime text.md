#Sublime Text

***
##简介


Sublime Text 是一个代码编辑器（Sublime Text是收费软件，但可以无限期试用），也是HTML和散文先进的文本编辑器。Sublime Text是由程序员Jon Skinner于2008年1月份所开发出来，它最初被设计为一个具有丰富扩展功能的Vim。


Sublime Text具有漂亮的用户界面和强大的功能，例如代码缩略图，Python的插件，代码段等。还可自定义键绑定，菜单和工具栏。Sublime Text 的主要功能包括：拼写检查，书签，完整的 Python API ， Goto 功能，即时项目切换，多选择，多窗口等等。Sublime Text 是一个跨平台的编辑器，同时支持Windows、Linux、Mac OS X等操作系统。


2012年6月26日推出新版本的Sublime Text 2.0，与之前版本相比主要有较大的改善：支持 Retina 视网膜屏、快速跳到下一个、文本拖放、改善构建系统、CSS 自动完成和高亮设置等。

***
##功能特性

Sublime Text 支持多种编程语言的语法高亮、拥有优秀的代码自动完成功能，还拥有代码片段（Snippet）的功能，可以将常用的代码片段保存起来，在需要时随时调用。支持 VIM 模式，可以使用Vim模式下的多数命令。支持宏，简单地说就是把操作录制下来或者自己编写命令，然后播放刚才录制的操作或者命令。


Sublime Text 还具有良好的扩展能力和完全开放的用户自定义配置与神奇实用的编辑状态恢复功能。支持强大的多行选择和多行编辑。强大的快捷命令“可以实时搜索到相应的命令、选项、snippet 和 syntex， 按下回车就可以直接执行，减少了查找的麻烦。即时的文件切换。随心所欲的跳转到任意文件的任意位置。多重选择功能允许在页面中同时存在多个光标。


该编辑器在界面上比较有特色的是支持多种布局和代码缩略图，右侧的文件略缩图滑动条，方便地观察当前窗口在文件的那个位置。也提供了 F11 和 Shift+F11 进入全屏免打扰模式。代码缩略图、多标签页和多种布局设置，在大屏幕或需同时编辑多文件时尤为方便 全屏免打扰模式，更加专心于编辑。代码缩略图的功能在更早的编辑器TextMate中就已经存在，TextMate已经开源。Sublime Text 支持文件夹浏览，可以打开文件夹，在左侧会有导航栏，方便在同时处理多个文件。多个位置同时编辑，按住ctrl，用鼠标选择多个位置，可以同时在对应位置进行相同操作。


SublimeText 还有编辑状态恢复的能力，即当你修改了一个文件，但没有保存，这时退出软件，软件不询问用户是否要保存的，因为无论是用户自发退出还是意外崩溃退出，下次启动软件后，之前的编辑状态都会被完整恢复，就像退出前时一样。

***
##快捷键(win platform)

>	Ctrl+L 选择整行（按住-继续选择下行）   
	Ctrl+KK 从光标处删除至行尾   
	Ctrl+K Backspace 从光标处删除至行首   
	Ctrl+J 合并行（已选择需要合并的多行时）   
	Ctrl+KU 改为大写   
	Ctrl+KL 改为小写   
	Ctrl+D 选择字符串 （按住-继续选择下个相同的字符串）   
	Ctrl+M 光标移动至括号内开始或结束的位置   
	Ctrl+/ 注释整行（如已选择内容，同“Ctrl+Shift+/”效果）   
	Ctrl+Shift+c转换为utf8   
	Ctrl+P 快速搜索输入的文件   
	Ctrl+R 搜索指定文件的函数标签   
	Ctrl+G 跳转到指定行   
	Ctrl+KT 折叠属性   
	Ctrl+K0 展开所有   
	Ctrl+U 软撤销   
	Ctrl+T 词互换   
	Tab 缩进 自动完成   
	Shift+Tab 去除缩进   
	Ctrl+Enter 光标后插入行   
	Ctrl+F2 设置书签   
	F2 下一个书签   
	Shift+F2 上一个书签   
	shift+鼠标右键 列选择   
	Alt+F3 选中文本按下快捷键，即可一次性选择全部的相同文本进行同时编辑   
	Alt+. 闭合当前标签   
	F6 检测语法错误   
	F9 行排序(按a-z)   
	F11 全屏模式   
	Ctrl+Shift+Enter 光标前插入行   
	Ctrl+Shift+[ 折叠代码   
	Ctrl+Shift+] 展开代码   
	Ctrl+Shift+↑ 与上行互换   
	Ctrl+Shift+↓ 与下行互换   
	Ctrl+Shift+A 选择光标位置父标签对儿   
	Ctrl+Shift+D 复制光标所在整行，插入在该行之前   
	ctrl+shift+F 在文件夹内查找，与普通编辑器不同的地方是sublime允许添加多个文件夹进行查找   
	Ctrl+Shift+K 删除整行   
	Ctrl+Shift+L 鼠标选中多行（按下快捷键），即可同时编辑这些行   
	Ctrl+Shift+M 选择括号内的内容（按住-继续选择父括号）   
	Ctrl+Shift+P 打开命令面板   
	Ctrl+Shift+/ 注释已选择内容   
	Ctrl+Shift+Enter 光标前插入行   
	Ctrl+PageDown 、Ctrl+PageUp 文件按开启的前后顺序切换   
	Ctrl+鼠标左键 可以同时选择要编辑的多处文本   
	Shift+鼠标右键（或使用鼠标中键）可以用鼠标进行竖向多行选择   
	Alt+Shift+1~9（非小键盘）屏幕显示相等数字的小窗口   

***
##插件管理

*	1、安装Package Control
>	按Ctrl+`调出console   
	粘贴安装代码（见扩展阅读）到底部命令行并回车：   
	st3 安装package control:

		import urllib.request,os,hashlib; h = 'eb2297e1a458f27d836c04bb0cbaf282' + 'd0e7a3098092775ccb37ca9d6b2e4b7d'; pf = 'Package Control.sublime-package'; ipp = sublime.installed_packages_path(); urllib.request.install_opener( urllib.request.build_opener( urllib.request.ProxyHandler()) ); by = urllib.request.urlopen( 'http://packagecontrol.io/' + pf.replace(' ', '%20')).read(); dh = hashlib.sha256(by).hexdigest(); print('Error validating download (got %s instead of %s), please try manual install' % (dh, h)) if dh != h else open(os.path.join( ipp, pf), 'wb' ).write(by)


	st2 安装package control:

		import urllib2,os,hashlib; h = 'eb2297e1a458f27d836c04bb0cbaf282' + 'd0e7a3098092775ccb37ca9d6b2e4b7d'; pf = 'Package Control.sublime-package'; ipp = sublime.installed_packages_path(); os.makedirs( ipp ) if not os.path.exists(ipp) else None; urllib2.install_opener( urllib2.build_opener( urllib2.ProxyHandler()) ); by = urllib2.urlopen( 'http://packagecontrol.io/' + pf.replace(' ', '%20')).read(); dh = hashlib.sha256(by).hexdigest(); open( os.path.join( ipp, pf), 'wb' ).write(by) if dh == h else None; print('Error validating download (got %s instead of %s), please try manual install' % (dh, h) if dh != h else 'Please restart Sublime Text to finish installation')


	如果在Perferences->package settings中看到package control这一项，则安装成功。    
	可以到官网链接（见扩展阅读）下载Package Control.sublime-package放到sublime安装目录里的data里installed package文件夹（这个文件夹位置可能会不一样）:  


*	2、用Package Control安装其他插件
>	按下Ctrl+Shift+P调出命令面板，输入Package control（或PC）就可以选择插件的安装、管理、删除等操作，因为sublime text 3的插件需要基于pyhone 3编写，所以用sublime text 2的安装方法不管用，可以看看我之前写的一篇文章，[Sublime text 3如何安装package control办法](http://dengo.org/archives/594)。

>	此外，安装sublime text 3的插件还可以在github上下载源文件，解压后改名放到

			C:\Users\Mr.sphenginx(你的电脑名)\AppData\Roaming\Sublime Text 3\Packages 中

>	重启sublime text 3即可生效。

*	3、常用插件

>	additional PHP snippet（代码注释格式化）插件能提示phpdocument格式的代码 ，还能快速输出开源协议， 输入php- 会有提示
	alignment(用于代码格式的自动对齐。)   
	BracketHighlighter (高亮显示匹配的括号、引号和标签)   
	CSS Format （一个css代码格式化插件）   
	ConvertToUTF8：ST2只支持utf8编码，该插件可以显示与编辑 GBK, BIG5, EUC-KR, EUC-JP, Shift_JIS 等编码的文件   
	Clipboard History：剪切板历史   
	DocBlockr 插件，能形成注释块。不用每次敲注释的斜杠或星号。	 
	JS Format(一个JS代码格式化插件)   
	JQuery （jquery 快速开发）   
	Sublime CodeIntel( sublime默认的代码提示只能提示系统函数，用户自己创建的函数、类不能提示。 如果想要提示自己建立的函数。 可以安装sublimecodeintel插件。)   
	WordPress：集成一些WordPress的函数，对于像我这种经常要写WP模版和插件的人特别有用！   
	HtmlTidy：清理与排版你的HTML代码   
	PHPTidy：整理与排版PHP代码   
	YUI Compressor：压缩JS和CSS文件   
	ZenCoding：这货对于前端的同学来说不得了，可以超快速编写HTML文件 (视频演示)   
	其他：Git、SVN等代码版本管理工具

***
Collected by [sphenginx](http://sphenginx.sinaapp.com)