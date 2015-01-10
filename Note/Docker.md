#Docker

***
###前言

尽管之前久闻Docker的大名了，但是天资愚钝，对其到底是个啥东西一直摸不清，最近花了一段时间整理了一下，算是整理出一点头绪来。

Docker的英文本意是“搬运工”，在程序员的世界里，Docker搬运的是集装箱（Container），集装箱里装的是任意类型的App，开发者通过Docker可以将App变成一种标准化的、可移植的、自管理的组件，可以在任何主流系统中开发、调试和运行。最重要的是，它不依赖于任何语言、框架或系统。

[官网](https://www.docker.com/whatisdocker/)的介绍是这样的：
>	Docker is an open platform for developers and sysadmins to build, ship, and run distributed applications....

其实看完这句话还是不明白究竟是啥的，下面就慢慢解释。不过长话短说的话，把他想象成一个用了一种新颖方式实现的超轻量虚拟机，在大概效果上也是正确的。当然在实现的原理和应用上还是和VM有巨大差别的，并且专业的叫法是应用容器（Application Container）。


###为啥要用容器？

那么应用容器长什么样子呢，一个做好的应用容器长得就好像一个装好了一组特定应用的虚拟机一样。比如我现在想用MySQL那我就找个装好MySQL的容器，运行起来，那么我就可以使用 MySQL了。

那么我直接装个 MySQL不就好了，何必还需要这个容器这么诡异的概念？话是这么说，可是你要真装MySQL的话可能要再装一堆依赖库，根据你的操作系统平台和版本进行设置，有时候还要从源代码编译报出一堆莫名其妙的错误，可不是这么好装。而且万一你机器挂了，所有的东西都要重新来，可能还要把配置在重新弄一遍。但是有了容器，你就相当于有了一个可以运行起来的虚拟机，只要你能运行容器，MySQL的配置就全省了。而且一旦你想换台机器，直接把这个容器端起来，再放到另一个机器就好了。硬件，操作系统，运行环境什么的都不需要考虑了。

在公司中的一个很大的用途就是可以保证线下的开发环境、测试环境和线上的生产环境一致。当年在 Baidu 经常碰到这样的事情，开发把东西做好了给测试去测，一般会给一坨代码和一个介绍上线步骤的上线单。结果代码在测试机跑不起来，开发就跑来跑去看问题，一会儿啊这个配置文件忘了提交了，一会儿啊这个上线命令写错了。找到了一个 bug 提上去，开发一看，啊我怎么又忘了把这个命令写在上线单上了。类似的事情在上线的时候还会发生，变成啊你这个软件的版本和我机器上的不一样……在 Amazon 的时候，由于一个开发直接担任上述三个职位，而且有一套自动化部署的机制所以问题会少一点，但是上线的时候大家还是胆战心惊。

若果利用容器的话，那么开发直接在容器里开发，提测的时候把整个容器给测试，测好了把改动改在容器里再上线就好了。通过容器，整个开发、测试和生产环境可以保持高度的一致。

此外容器也和VM一样具有着一定的隔离性，各个容器之间的数据和内存空间相互隔离，可以保证一定的安全性。

###那为啥不用VM？

那么既然容器和 VM 这么类似为啥不直接用 VM 还要整出个容器这么个概念来呢？Docker 容器相对于 VM 有以下几个优点：

>	启动速度快，容器通常在一秒内可以启动，而 VM 通常要更久   
>	资源利用率高，一台普通 PC 可以跑上千个容器，你跑上千个 VM 试试  
>	性能开销小， VM 通常需要额外的 CPU 和内存来完成 OS 的功能，这一部分占据了额外的资源  

为啥相似的功能在性能上会有如此巨大的差距呢，其实这和他们的设计的理念是相关的:
>	VM 的 Hypervisor 需要实现对硬件的虚拟化，并且还要搭载自己的操作系统，自然在启动速度和资源利用率以及性能上有比较大的开销。

>	Docker 几乎就没有什么虚拟化的东西，并且直接复用了 Host 主机的 OS，在 Docker Engine 层面实现了调度和隔离重量一下子就降低了好几个档次。 Docker 的容器利用了  LXC，管理利用了  namespaces 来做权限的控制和隔离，  cgroups 来进行资源的配置，并且还通过  aufs 来进一步提高文件系统的资源利用率。

>	其中的 aufs 是个很有意思的东西，是  UnionFS 的一种。他的思想和 git 有些类似，可以把对文件系统的改动当成一次 commit 一层层的叠加。这样的话多个容器之间就可以共享他们的文件系统层次，每个容器下面都是共享的文件系统层次，上面再是各自对文件系统改动的层次，这样的话极大的节省了对存储的需求，并且也能加速容器的启动。


###背景

*	由PaaS到Container

2013年2月，前Gluster的CEO Ben Golub和dotCloud的CEO Solomon Hykes坐在一起聊天时，Solomon谈到想把dotCloud内部使用的Container容器技术单独拿出来开源，然后围绕这个技术开一家新公司提供技术支持。28岁的Solomon在使用python开发dotCloud的PaaS云时发现，使用 LXC(Linux Container) 技术可以打破产品发布过程中应用开发工程师和系统工程师两者之间无法轻松协作发布产品的难题。这个Container容器技术可以把开发者从日常部署应用的繁杂工作中解脱出来，让开发者能专心写好程序；从系统工程师的角度来看也是一样，他们迫切需要从各种混乱的部署文档中解脱出来，让系统工程师专注在应用的水平扩展、稳定发布的解决方案上。他们越深入交谈，越觉得这是一次云技术的变革，紧接着在2013年3月Docker 0.1发布，拉开了基于云计算平台发布产品方式的变革序幕。

*	简介

Docker 是 Docker.Inc 公司开源的一个基于 LXC技术之上构建的Container容器引擎， 源代码托管在 [GitHub](https://github.com/docker/docker) 上, 基于Go语言并遵从Apache2.0协议开源。 Docker在2014年6月召开DockerConf 2014技术大会吸引了IBM、Google、RedHat等业界知名公司的关注和技术支持，无论是从 GitHub 上的代码活跃度，还是Redhat宣布在RHEL7中正式支持Docker, 都给业界一个信号，这是一项创新型的技术解决方案。 就连 Google 公司的 Compute Engine 也支持 docker 在其之上运行, 国内“BAT”先锋企业百度Baidu App Engine(BAE)平台也是以Docker作为其PaaS云基础。

Docker产生的目的就是为了解决以下问题:

>	1) 环境管理复杂: 从各种OS到各种中间件再到各种App，一款产品能够成功发布，作为开发者需要关心的东西太多，且难于管理，这个问题在软件行业中普遍存在并需要直接面对。Docker可以简化部署多种应用实例工作，比如Web应用、后台应用、数据库应用、大数据应用比如Hadoop集群、消息队列等等都可以打包成一个Image部署。

>	2) 云计算时代的到来: AWS的成功, 引导开发者将应用转移到云上, 解决了硬件管理的问题，然而软件配置和管理相关的问题依然存在 (AWS cloudformation是这个方向的业界标准, 样例模板可参考这里)。Docker的出现正好能帮助软件开发者开阔思路，尝试新的软件管理方法来解决这个问题。

>	3) 虚拟化手段的变化: 云时代采用标配硬件来降低成本，采用虚拟化手段来满足用户按需分配的资源需求以及保证可用性和隔离性。然而无论是KVM还是Xen，在 Docker 看来都在浪费资源，因为用户需要的是高效运行环境而非OS, GuestOS既浪费资源又难于管理, 更加轻量级的LXC更加灵活和快速。

>	4) LXC的便携性: LXC在 Linux 2.6 的 Kernel 里就已经存在了，但是其设计之初并非为云计算考虑的，缺少标准化的描述手段和容器的可便携性，决定其构建出的环境难于分发和标准化管理(相对于KVM之类image和snapshot的概念)。Docker就在这个问题上做出了实质性的创新方法。

Docker是PaaS供应商dotCloud开源的一个基于LXC 的高级容器引擎，源代码托管在 GitHub 上, 基于Go语言开发并遵从Apache 2.0协议开源。Docker提供了一种在安全、可重复的环境中自动部署软件的方式，它的出现拉开了基于云计算平台发布产品方式的变革序幕。

不久前Docker 1.0的发布，意味着Docker自身已经转变为一个分发应用的开放平台。如今的Docker已经备受青睐，云服务提供商，包括微软、 IBM 、 Rackspace 、 Google 以及其他主要的 Linux 提供商如 Canonical 和 Red Hat ，都已经开始支持 Docker 。

有了前面的这些介绍，应该对 Docker 到底是啥有些了解了吧， Docker 是 用 Go 语言编写的，源代码托管在 github 而且居然只有 1W 行就完成了这些功能。如果想尝试一下的话可以看 [官方介绍](https://docs.docker.com/introduction/understanding-docker/)了，应该上手会容易一些了。洒家也是新手，如有错误欢迎拍砖指正。

附：

U can visit [tech.uc.cn](http://tech.uc.cn/?p=2726) for more info.

点击下载 [docker_practise.pdf](http://pan.baidu.com/s/1qWodYCs)

***
Collected by [sphenginx](http://sphenginx.sinaapp.com)