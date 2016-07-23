# 注册事件回调 swoole_server->on

#### 用途
注册Server的事件回调函数。

#### 适用范围及版本限制
 * 适用于任何版本的swoole
 * php-fpm 方式并不支持server

#### 函数原型
```php
bool swoole_server->on(string $event, mixed $callback);
```

#### 参数
|参数|类型|必填|默认值|用途及注意事项|
|-----|-----|----|---|----------------------------|
|event|string|yes|--|回调的名称, 大小写不敏感，具体内容参考回调函数列表，事件名称字符串不要加on|
|callback|mixed|yes|--|回调的PHP函数，可以是函数名的字符串，类静态方法，对象方法数组，匿名函数。|


#### 注意事项
 * 回调的名称大小写不敏感，不要加on
 * 请在server->start之前执行


#### 代码样例

```php
$serv = new swoole_server("127.0.0.1", 9501);
$serv->on('connect', function ($serv, $fd){
    echo "Client:Connect.\n";
});
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, 'Swoole: '.$data);
    $serv->close($fd);//非长连接请求可以返回结果后直接关闭，长连接请求close执行无任何效果
});
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});
$serv->start();
```

#### 其它相关知识
 * [相关事件回调列表及介绍]()
 