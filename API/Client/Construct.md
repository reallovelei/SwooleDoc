# 构造函数swoole_client::__construct
#### 用途
创建一个swoole client资源对象.

#### 适用范围及版本限制 
* Swoole 任何版本 
* PHP-FPM / CLI 均可使用

#### 函数原型
```php
swoole_client->__construct(int $sock_type, int $is_sync = SWOOLE_SOCK_SYNC, string $key);
```

#### 参数
|参数|类型|必填|默认值|用途及注意事项|
|-----|-----|----|---|----------------------------|
| sock_type | Int |Y|无| 表示socket的类型，如TCP/UDPCP6/UDP6、UnixSock Stream/Dgram |
| is_sync | Int |N| SWOOLE_SOCK_SYNC | 表示同步阻塞还是异步非阻塞，默认为同步阻塞 |
| key | String |N| IP:PORT |用于长连接的Key，默认使用IP:PORT作为key。相同key的连接会被复用 |

 #### 代码样例 
```php
//使用同步阻塞 创建一个TCP的client$client = new swoole_client(SWOOLE_SOCK_TCP);$client->connect("192.168.1.38", 9501, 0);
``` 
#### 注意事项 
* 如果server启用了SSL加密，那么new client的时候 sock_type参数需要 | SWOOLE_SSL 来启用SSL加密。 
* 可以使用swoole提供的宏来之指定类型，请参考 [Swoole常量定义](Const.md)

## 在php-fpm/apache中创建长连接
----
```php
$cli = new swoole_client(SWOOLE_TCP | SWOOLE_KEEP);
```
sock_type参数加入SWOOLE_KEEP标志后，创建的TCP连接在PHP请求结束或者调用$cli->close时并不会关闭。下一次执行connect调用时会复用上一次创建的连接。长连接保存的方式默认是以ServerHost:ServerPort为key的。可以再第3个参数内指定key。 
#### 注意事项 
* SWOOLE_KEEP 只允许用于同步客户端
* swoole_client在unset时会自动调用close方法关闭socket 
* 异步模式unset时会自动关闭socket并从epoll事件轮询中移除SWOOLE_KEEP 
* 长连接模式在1.6.12后可用，长连接的$key参数在1.7.5后增加

## 在swoole_server中使用swoole_client
---- 
* 必须在事件回调函数中使用swoole_client，不能在swoole_server->start前创建 如在onWorkerStart、onRecv等回调函数中。
* swoole_server可以用任何语言编写的 socket client来连接。同样swoole_client也可以去连接任何语言编写的socket server。