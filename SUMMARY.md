# Summary
* [1. 入门指引](Guide.md)
  * [1.1 基础模块及概念简介](Introduce.md)
    * [1.1.1 同步异步基础](SyncAsync.md)
      * [1.1.1.1 EvenLoop方式协程](CoroutineEventloop.md)
      * [1.1.1.2 多进程方式协程](CoroutineProcess.md)
      * [1.1.1.3 会阻塞的函数](CoroutineBlockFunction.md)
      * [1.1.1.4 半协程函数介绍](CoroutineIntroduce.md) # 介绍yield swoole_select
    * [1.1.2 多进程管理](ProcessManage.md)
      * [1.1.2.1 进程创建及监控](ProcessCreateMonitor.md)
      * [1.1.2.2 进程间的通讯](ProcessCommunicate.md)
      * [1.1.2.3 进程间的数据共享](ProcessDataShare.md)
    * [1.1.3 跨进程间调用及通讯](RemoteProcessComm.md)
      * [1.1.3.1 Task异步调用](RemoteTaskComm.md)
      * [1.1.3.2 Process通讯](RemoteProcessComm.md)
      * [1.1.3.3 队列](RemoteQueue.md)
    * [1.1.5 异步数据驱动](AsyncDriver.md)
      * [1.1.5.1 异步Mysql](AsyncMysql.md)
      * [1.1.5.2 异步Redis](AsyncRedis.md)
      * [1.1.5.3 异步Http/WebSocket](AsyncWeb.md)
      * [1.1.5.4 异步File](AsyncIO.md) 
    * [1.1.6 对外服务端口](ListenServer.md)
      * [1.1.6.1 HTTP 服务监听](ListenServerHttp.md)
      * [1.1.6.2 WebSocket 服务监听](ListenServerWebSocket.md)
      * [1.1.6.3 TCP 服务监听](ListenServerTCP.md)
      * [1.1.6.4 UDP 服务监听](ListenServerUDP.md)
    * [1.1.7 定时器](Timer.md)
  * [1.2 扩展编译安装](CompileInstall.md)
  * [1.3 性能优化](OptimizeParam.md)
    * [1.3.1 系统参数优化](OptimizeLinux.md)
    * [1.3.2 代码优化](OptimzeCode.md) # 并行调用、异步调用
  * [1.4 通讯协议](ProtocolDesign.md)
  * [1.6 系统架构](Architecture.md)
  * [1.7 版权声明](CopyRight.md)
  * [1.8 开发人员](developer.md)
  * [1.9 社区管理人员]()
* [2. Server](c2.md)

* [3. Client](c3.md)

* [4. Process](c4.md)

* [5. AsyncIO](c5.md)

* [6. Memory](c6.md)

* [7. HttpServer](c7.md)

* [8. WebSocket](c8.md)

* [9. 高级](c9.md)

* [10. 其他](c10.md)