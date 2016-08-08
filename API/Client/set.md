# 设置服务器配置 swoole_client->set

#### 用途
swoole_client->set函数用于设置客户端参数，必须在connect前执行。swoole-1.7.17为客户端提供了类似swoole_server的自动协议处理功能。通过设置一个参数即可完成TCP的自动分包。


#### 适用范围及版本限制

 * Swoole 客户端 任何版本

#### 函数原型

```php

function swoole_client->set(array $setting);

```



#### 示例1 结束符检测

```php
$client->set(
    array( 
        'open_eof_check' => true, 
        'package_eof' => "\r\n\r\n", 
        'package_max_length' => 1024 * 1024 * 2, 
    )
);

```

#### 示例2 长度检测
```php
$client->set(
    array(
        'open_length_check'      => 1,
        'package_length_type'    => 'N',
        'package_length_offset'  => 0,
        'package_body_offset'    => 4,
        'package_max_length'     => 2000000,
    )
);

```
#### 示例3 设置Socket缓存区尺寸
```php
$client->set(
     array(
        'socket_buffer_size'  => 1024*1024*2, //2M缓存区
    )
);
```
>  包括socket底层操作系统缓存区、应用层接收数据内存缓存区、应用层发送数据内存缓冲区

#### 示例4 关闭Nagle合并算法

```php
$client->set(
    array( 
        'open_tcp_nodelay' => true, 
    )
);

```

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


