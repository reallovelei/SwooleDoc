# **swoole\_process-&gt;useQueue**

启用消息队列作为进程间通信。

```
bool swoole_process->useQueue(int $msgkey = 0, int $mode = 2);

```

useQueue方法接受2个可选参数。

* $msgkey是消息队列的key，默认会使用ftok\(**FILE**\)
* $mode通信模式，默认为2，表示争抢模式，所有创建的子进程都会从队列中取数据
* 如果创建消息队列失败，会返回false。可使用swoole\_strerror\(swoole\_errno\(\)\) 得到错误码和错误信息。

> 使用模式2后，创建的子进程无法进行单独通信，比如发给特定子进程。
> 
> $process对象并未执行start，也可以执行push\/pop向队列推送\/提取数据
> 
> 消息队列通信方式与管道不可公用。消息队列不支持EventLoop，使用消息队列后只能使用同步阻塞模式

