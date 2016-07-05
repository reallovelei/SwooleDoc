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
短短十来行代码就可以实现一个高性能的websocket server。

## onHandShake

函数原型：
```php
function onHandShake(swoole_http_request $request, swoole_http_response $response);
```

| 参数 | 描述 |
| -- | -- |
| $request | swoole_websocket_server对象 |
| $response | 是一个Http请求对象，包含了客户端发来的握手请求信息 |

说明：

* WebSocket建立连接后进行握手。WebSocket服务器已经内置了handshake，如果用户希望自己进行握手处理，可以设置onHandShake事件回调函数。
* onHandShake函数必须返回true表示握手成功，返回其他值表示握手失败
* onHandShake 事件回调是可选的。

<font color=red> 如果设置onHandShake回调函数后将不会再触发onOpen事件，需要应用代码自行处理，（1.8.1或更高版本可以使用server->defer调用onOpen逻辑）。</font>


---


## onOpen

函数原型：
```php
function onOpen(swoole_websocket_server $server, swoole_http_request $request);
```

| 参数 | 描述 |
| -- | -- |
| $server | swoole_websocket_server对象 |
| $request | 是一个Http请求对象，包含了客户端发来的握手请求信息 |

说明：

* 当有新的WebSocket客户端与本服务建立连接并完成握手后会回调此函数。
* onOpen事件函数中可以调用push向客户端发送数据或者调用close关闭连接。
* onOpen事件回调是可选的。

> 如果在onConnect里有代码，会先执行onConnect里的代码。


---


## onMessage

函数原型：
```php
function onMessage(swoole_websocket_server $server, swoole_websocket_frame $frame)
```

| 参数 | 描述 |
| -- | -- |
| $server | swoole_websocket_server对象 |
| $frame | 是swoole_websocket_frame对象，包含了客户端发来的数据帧信息 |

说明：

* 当服务器收到来自客户端的数据帧时会回调此函数。
* onMessage回调**必须**被设置，未设置服务器将无法启动
。



#### swoole_websocket_frame

这个对象共有4个属性，分别是

| 属性名 | 描述 |
| -- | -- |
| fd | 客户端的socket id,要推给那个客户端就靠它了。 |
| data | 客户端传的数据内容，可以是文本也可以是二进制数据，可以通过opcode的值来判断 |
| opcode | WebSocket的OpCode类型， |
| finish | 表示数据帧是否完整，一个WebSocket请求可能会分成多个数据帧进行发送 |

最常用的应该就是 $frame->fd 和 $frame->data。
<font color=red>> $data 如果是文本类型，编码格式必然是UTF-8，这是WebSocket协议规定的</font>



#### opcode与数据类型
* WEBSOCKET_OPCODE_TEXT = 0x1 ，文本数据
* WEBSOCKET_OPCODE_BINARY = 0x2 ，二进制数据



---








[点击查看](example/websocket)聊天室完整代码样例：