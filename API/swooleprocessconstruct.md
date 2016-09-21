创建子进程

```
int swoole_process::__construct(mixed $function, $redirect_stdin_stdout = false, $create_pipe = true);

```

* $function，子进程创建成功后要执行的函数
* $redirect\_stdin\_stdout，重定向子进程的标准输入和输出。 启用此选项后，在进程内echo将不是打印屏幕，而是写入到管道。读取键盘输入将变为从管道中读取数据。 默认为阻塞读取。
* $create\_pipe，是否创建管道，启用$redirect\_stdin\_stdout后，此选项将忽略用户参数，强制为true 如果子进程内没有进程间通信，可以设置为false

> $process对象在销毁时会自动关闭管道，子进程内如果监听了管道会收到CLOSE事件
> 
> 1.7.22或更高版本允许设置管道的类型，默认为`SOCK_STREAM`流式
> 
> 参数`$create_pipe`为2时，管道类型将设置为`SOCK_DGRAM`

## **在子进程中创建swoole\_server**

可以在swoole\_process创建的子进程中swoole\_server服务器程序，但为了安全必须在$process-&gt;start创建进程后，调用$worker-&gt;exec执行server的代码。

```
<?php
$process = new swoole_process('callback_function', true);
$pid = $process->start();

function callback_function(swoole_process $worker)
{
    $worker->exec('/usr/local/bin/php', array(__DIR__.'/swoole_server.php'));
}

swoole_process::wait();
```

