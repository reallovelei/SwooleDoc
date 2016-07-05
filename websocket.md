# 8. WebSocket

swoole_websocket_server 继承自 swoole_http_server,所以websocket_server 不仅拥有http_server的回调函数[onRequest](c7.md)。还有 onHandShake[可选] [onOpen](#onopen) [onMessage](#onmessage) 等回调函数，下面一一来介绍。。当然，websocket_server也可以当Http服务器来用。
```php
$server = new swoole_websocket_server("0.0.0.0", 9501);

$server->on('open', function (swoole_websocket_server $server, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
});

$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();
```
-短短十来行代码就可以实现一个高性能的websocket server。
-
-## onHandShake
-
-函数原型：
-```php
-function onHandShake(swoole_http_request $request, swoole_http_response $response);
-```
-
-| 参数 | 描述 |
-| -- | -- |
-| $request | swoole_websocket_server对象 |
-| $response | 是一个Http请求对象，包含了客户端发来的握手请求信息 |
-
-说明：
-
-* WebSocket建立连接后进行握手。WebSocket服务器已经内置了handshake，如果用户希望自己进行握手处理，可以设置onHandShake事件回
调函数。
-* onHandShake函数必须返回true表示握手成功，返回其他值表示握手失败
-* onHandShake 事件回调是可选的。
-
-<font color=red> 如果设置onHandShake回调函数后将不会再触发onOpen事件，需要应用代码自行处理，（1.8.1或更高版本可以使用server->defer调用onOpen逻辑）。</font>





[点击查看](example/websocket)聊天室完整代码样例：