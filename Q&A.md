# 常见问题


---


## 如何判断连接是否为WebSocket客户端


-----

通过使用$server->connection_info获取连接信息，返回的数组中有一项为 websocket_status，根据此状态可以判断是否为WebSocket客户端。
```php
var_dump($server->connection_info($fd));
```

* WEBSOCKET_STATUS_CONNECTION = 1，连接进入等待握手
* WEBSOCKET_STATUS_HANDSHAKE = 2，正在握手
* WEBSOCKET_STATUS_FRAME = 3，已握手成功等待浏览器发送数据帧



