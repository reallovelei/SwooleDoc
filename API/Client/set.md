# 设置服务器配置 swoole_client->set

#### 用途
swoole_client->set函数用于设置客户端参数，必须在connect前执行。swoole-1.7.17为客户端提供了类似swoole_server的自动协议处理功能。通过设置一个参数即可完成TCP的自动分包。


#### 适用范围及版本限制

 * Swoole 客户端 任何版本

#### 函数原型

```php

function swoole_client->set(array $setting);

```



#### 注意事项

 * 此函数必须在server->start之前调用

 * 多端口的时候set必须针对不同listner返回的对象进行设置



#### 代码样例



```php

//创建一个server，监听9560端口，多进程模式，提供TCP协议通讯服务

$server = new swoole_server("0.0.0.0",9560,SWOOLE_PROCESS,SWOOLE_SOCK_TCP);

//设置配置参数

$server->set(

 array(

 'reactor_num' => 2, //reactor thread num

 'worker_num' => 4, //worker process num

 'backlog' => 128, //listen backlog

 'max_request' => 50,

 'dispatch_mode' => 1,

));

$server->start();



```



#### 参数说明



参数值都为key=>value方式组织

具体的参数用途及说明请参考以下其他相关知识连接



#### 其它相关知识

 * 多端口监听相关设置限制：[多端口监听]()

 * 服务器配置介绍[服务器配置]()


