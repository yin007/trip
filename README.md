# 途倍趣平台安装文档

## 环境要求
适用对象
适用于熟悉ECS、Linux系统、vim基本添加和删除命令，需要快速搭建平台的用户。

项目配置
本教程使用的软件版本信息如下：

操作系统： CentOS 7.2 64位

Apache：2.4.6

MySQL：5.7

PHP：7.2

Composer：1.8.5

搭建工具：宝塔

本教程使用的阿里云ECS实例硬件配置如下：

CPU：2 vCPU

内存：4 GiB

网络类型：VPC

##端口配置
配置服务器访问端口
登陆阿里云后台，选择对应的ecs服务器
选择网络和安全->安全组->配置规则->添加安全组规则
添加可访问端口: 8888/6789/678/1022/1021/443/80/3369
添加安全组规则输入框如下图：
最终配置完成后可访问端口列表

## 搭建流程
获取当前系统版本信息
运行安装命令
可以直接用服务器IP：8888端口访问
安装服务器环境
配置网站域名
上传网站源文件到根目录
安装网站
配置微信接口

## 详细步骤
步骤一：获取当前系统版本信息
1.使用root权限，进入服务器 命令： cat /etc/issue


步骤二：运行安装命令
Centos安装命令

yum install -y wget && wget -O install.shhttp://download.bt.cn/install/install.sh && sh install.sh

Ubuntu/Deepin安装命令

wget -O install.shhttp://download.bt.cn/install/install-ubuntu.sh && sudo bash install.sh

Debian安装命令

wget -O install.shhttp://download.bt.cn/install/install-ubuntu.sh && bash install.sh

Fedora安装命令

wget -O install.shhttp://download.bt.cn/install/install.sh && bash install.sh

运行centos安装命令

输入：yes

输入：y

显示出账号和密码，表示宝塔已经安装成功



步骤三：可直接访问服务器ip：8888端口访问
打开网页，输入：http://ip:8888进入宝塔登录面板，
用上面的账号密码登陆

如不能访问，服务器是阿里云，则需要在ecs上开放8888端口
详细流程参见端口配置章节！

步骤四：安装服务器的环境
根据环境的需求，安装配置服务器的环境，配置完成之后，选择编译安装，直接应用于生产环境



步骤五：配置网站域名


输入域名查看

步骤六：上传网站文件到根目录
步骤七：解析域名
进入域名后台，解析一个二级域名wechat.thinkwindtech.com到IP

步骤八：进入网站安装页面
访问wechat.thinkwindtech.com，点击完成网站安装即可。

步骤九：配置微信接口
进入微信支付后台，添加支付授权目录


## 后台使用教程
后台登录地址：https://wechat.thinkwindtech.com/zdzx.php/index/login
用户名：fly
初始密码：123456

## 接口说明
详细接口说明请参见：http://fly.dev.whbpkj.com/api.html
公共接口
GET[加载初始化/api/common/init]
POST[上传文件/api/common/upload]
优惠券接口
GET[优惠券列表/api/coupon/index]
设备接口
GET[设备列表/api/equipment/index]
GET[设备分类/api/equipment/category]
首页接口
GET[首页/api/index/index]
GET[设备详情/api/index/equidetail]
GET[下单地址/api/index/equiaddress]
GET[门店列表/api/index/address]
GET[飞机航班列表/api/index/hb]
GET[立即租赁/api/index/zu]
GET[确认订单/api/index/order]
GET[分享链接地址/api/index/fen]
微信支付完成的回调
GET[公众号支付/api/notify/wxpayjs]
GET[退款回调/api/notify/refund_notify]
订单中心
GET[获取订单/api/order/index]
GET[确认下单页面/api/order/orderconfirm]
GET[订单详情/api/order/orderdetail]
GET[领取设备/api/order/orderreceive]
GET[取消订单/api/order/ordercancel]
GET[删除订单/api/order/orderdel]
GET[归还设备/api/order/orderend]
其他接口
GET[意见反馈/api/other/content]
GET[常见问题/api/other/wenti]
GET[关于我们/api/other/my]
GET[我的消息/api/other/message]
GET[消息详情页./api/other/detail]
门店接口
GET[门店详情/api/shop/index]
购物车
GET[添加购物车/api/shop_car/index]
GET[购物车列表/api/shop_car/car]
GET[购物车付款/api/shop_car/carpay]
GET[修改数量/api/shop_car/carnum]
GET[删除购物车产品/api/shop_car/delete]
手机短信接口
GET[发送验证码/api/sms/send]
GET[检测验证码/api/sms/check]
会员接口
GET[会员中心/api/user/index]
GET[会员登录/api/user/login]
GET[手机验证码登录/api/user/mobilelogin]
GET[注册会员/api/user/register]
GET[注销登录/api/user/logout]
GET[修改会员个人信息/api/user/profile]
GET[修改手机号/api/user/changemobile]
GET[第三方登录/api/user/third]
GET[更改密码/api/user/resetpwd]
GET[用户资料/api/user/user]
GET[获取身份信息/api/user/card]
GET[绑定身份/api/user/bindcard]
验证接口
GET[检测邮箱/api/validate/check_email_available]
GET[检测用户名/api/validate/check_username_available]
GET[检测手机/api/validate/check_mobile_available]
GET[检测手机/api/validate/check_mobile_exist]
GET[检测邮箱/api/validate/check_email_exist]
GET[检测手机验证码/api/validate/check_sms_correct]
GET[检测邮箱验证码/api/validate/check_ems_correct]
微信支付
GET[立即支付/api/wechat_pay/wxpayjs]

