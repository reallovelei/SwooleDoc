# 构造函数

#### 用途
创建一个swoole server资源对象.

#### 适用范围及版本限制
Swoole 任何版本

#### 函数原型

```php
$serv = new swoole_server(string $host, int $port, int $mode = SWOOLE_PROCESS,
    int $sock_type = SWOOLE_SOCK_TCP);
```

#### 参数
|参数|类型|必填|默认值|用途及注意事项|
|-----|-----|----|---|----------------------------|
|host|String|Y|无|服务器监听IP地址，用0.0.0.0或0:0:0:0:0:0:0:0表示监听所有地址|
|port|Int|Y|无|服务器监听端口，取值范围为1~65535|
|mode|Int|N|SWOOLE_PROCESS|服务器运行模式，目前有三种运行模式|
|sock_type|Int|N|SWOOLE_SOCK_TCP|Socket类型支持：TCP/UDP、TCP6/UDP6、UnixSock Stream/Dgram 6种|


> * 监听端口小于1024需要Root权限，不推荐使用低于1024端口
> * 如果期望监听的端口被其它服务占用server->start会失败
> * 1.7.11后增加了对Unix Socket的支持
> * 构造函数中的参数与swoole_server::addlistener中是完全相同
> * Swoole1.6版本之后PHP版本去掉了线程模式，原因是php的内存管理器在多线程下容易发生错误
> * SWOOLE_BASE模式没有进程管理进程，如果使用了Process需要自行Kill
> * 线程模式仅供C++中使用
> * BASE模式在1.6.4版本之后也可是使用多进程，设置worker_num来启用

#### 代码样例
```php
//创建一个server，监听9560端口，多进程模式，提供TCP协议通讯服务
$server = new swoole_server("0.0.0.0",9560,SWOOLE_PROCESS,SWOOLE_SOCK_TCP);
$server->start();

```

#### 其它相关知识
 * 如果需要启用加密通讯请参考：[SSL启用]()
 * Unix Socket使用介绍：[Unix Socket支持]()
 * 高并发性能服务必须优化Linux内核：[Linux内核优化]()
 * mode属性介绍：[服务端三种运行模式介绍]()