# **swoole\_process-&gt;write**

向管道内写入数据。

```
int swoole_process->write(string $data);

```

* $data的长度在Linux系统下最大不超过8K，MacOS\/FreeBSD下最大不超过2K
* 在子进程内调用write，主进程会收到数据
* 在主进程内调用write，子进程会收到数据

swoole底层使用Unix Socket实现通信，UnixSocket是内核实现的全内存通信，无任何IO消耗。在1进程write，1进程read，每次读写1024字节数据的测试中，100万次通信仅需1.02秒。

管道通信默认的方式是流式，`write`写入的数据在`read`可能会被底层合并。可以设置`swoole_process`构造函数的第三个参数为`2`改变为数据报式。

> MacOS\/FreeBSD可以设置`net.local.dgram.maxdgram`内核参数修改最大长度

## **异步模式**

如果进程内使用了异步IO，比如`swoole_event_add`，进程内执行write操作将变为异步模式。swoole底层会监听可写事件，自动完成管道写入。

异步模式下如果SOCKET缓存区已满，Swoole的处理逻辑请参考 [swoole\_event\_write](http://wiki.swoole.com/wiki/page/372.html)

## **同步模式**

进程内未使用任何异步IO，当前管道为同步阻塞模式，如果缓存区已满，将阻塞等待直到write操作完成。

