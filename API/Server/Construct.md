# 构造函数

## 函数原型

```php
$serv = new swoole_server(string $host, int $port, int $mode = SWOOLE_PROCESS,
    int $sock_type = SWOOLE_SOCK_TCP);
```

## 用途
创建一个swoole server资源对象,通过这个对象能够创建一个Sever服务监听指定端口对外提供通讯服务

## 适用范围及版本限制
Swoole 任何版本

## 参数
| 参数 | 类型 | 必填 | 默认值 | 用途及注意事项 |
|-----|-----|--|---|----------------------------:|
|host|String|Y|无|服务器监听IP地址，适用0.0.0.0或0:0:0:0:0:0:0:0表示监听所有地址|
|port|Int|Y|无|服务器监听端口，取值范围为1~65535|
|mode|Int|N|SWOOLE_PROCESS(推荐)|服务器运行模式，目前有三种运行模式|
|sock_type|Int|N|SWOOLE_SOCK_TCP|Socket类型支持：TCP/UDP、TCP6/UDP6、UnixSock Stream/Dgram 6种|

## 注意事项
 * 监听端口小于1024需要Root权限（不推荐）
 * 如果端口被占用server->start会失败
 * 1.7.11后才增加了对Unix Socket的支持
 * 构造函数中的参数与swoole_server::addlistener中是完全相同的

## 代码样例

## 其它相关知识
 * 如果需要启用加密通讯请参考：[SSL启用]()
 * Unix Socket使用介绍：[Unix Socket支持]()
 * 高并发性能服务必须优化Linux内核：[Linux内核优化]()
 * mode属性介绍：[服务端三种运行模式介绍]()