# **swoole\_process-&gt;close**

用于关闭创建的好的管道。

```
bool swoole_process->close();

```

有一些特殊的情况swoole\_process对象无法释放，如果持续创建进程会导致连接泄漏。调用此函数就可以直接关闭管道，释放资源。



