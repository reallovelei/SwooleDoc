# 设置服务器配置

#### 用途
swoole_server->set函数用于设置swoole_server运行时的各项参数。服务器启动后通过$serv->setting来访问set函数设置的参数数组

#### 适用范围及版本限制
 * Swoole 服务端 任何版本

#### 函数原型

```php
function swoole_server->set(array $setting);
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
    'worker_num' => 4,    //worker process num
    'backlog' => 128,   //listen backlog
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
 