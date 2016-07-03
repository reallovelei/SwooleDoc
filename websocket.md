# 8. WebSocket

swoole_websocket_server 继承自 swoole_http_server,所以websocket_server 不仅拥有http_server的回调函数[onRequest](c7.md)。还有 onHandShake onOpen onMessage 等回调函数，下面一一来介绍。。当然，websocket_server也可以当Http服务器来用。

[点击查看](example/websocket)聊天室完整代码样例：