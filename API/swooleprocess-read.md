# **swoole\_process-&gt;read**

从管道中读取数据。

```
int swoole_process->read(int $buffer_size=8192);

```

* $buffer\_size是缓冲区的大小，默认为8192，最大不超过64K
* 默认read操作为流式的，write\/read的大小并不一致

> 这里是同步阻塞读取的，可以使用[swoole\_event\_add](http://wiki.swoole.com/wiki/page/119.html)将管道加入到事件循环中，变为异步模式

示例：

```
function callback_function_async(swoole_process $worker)
{
    $GLOBALS['worker'] = $worker;
    swoole_event_add($worker->pipe, function($pipe) {
        $worker = $GLOBALS['worker'];
        $recv = $worker->read();

        echo "From Master: $recv\n";

        //send data to master
        $worker->write("hello master\n");

        sleep(2);

        $worker->exit(0);
    });
}

```



