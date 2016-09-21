# **swoole\_process::signal**

设置异步信号监听。

```
bool swoole_process::signal(int $signo, mixed $callback);

```

* 此方法基于signalfd和eventloop是异步IO，不能用于同步程序中
* 同步阻塞的程序可以使用pcntl扩展提供的pcntl\_signal
* $callback如果为null，表示移除信号监听

使用举例：

```
swoole_process::signal(SIGTERM, function($signo) {
     echo "shutdown.";
});

```

> swoole\_server中不能设置SIGTERM和SIGALAM信号
> 
> swoole\_process::signal在swoole-1.7.9以上版本可用
> 
> 信号移除特性仅在1.7.21或更高版本可用



