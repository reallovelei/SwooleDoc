# **swoole\_process-&gt;start**

执行fork系统调用，启动进程。

```
int swoole_process->start();

```

创建成功返回子进程的PID，创建失败返回false。可使用swoole\_errno和swoole\_strerror得到错误码和错误信息。

* $process-&gt;pid 属性为子进程的PID
* $process-&gt;pipe 属性为管道的文件描述符

> 执行后子进程会保持父进程的内存和资源，如父进程内创建了一个redis连接，那么在子进程会保留此对象，所有操作都是对同一个连接进行的。

## **注意事项**

因为子进程会继承父进程的内存和IO句柄，所以如果父进程要创建多个子进程，务必要等待创建完毕后再使用`swoole_event_add`\/`异步swoole_client`\/`定时器`\/`信号`等异步IO函数。

错误的代码

```
$workers = [];
$worker_num = 3;//创建的进程数

for($i=0;$i<$worker_num ; $i++){
    $process = new swoole_process('process');
    $pid = $process->start();
    $workers[$pid] = $process;
    //子进程也会包含此事件
    swoole_event_add($process->pipe, function ($pipe) use($process){
    $data = $process->read();
        echo "RECV: " . $data.PHP_EOL;
    });
}


function process(swoole_process $process){// 第一个处理
    $process->write($process->pid);
    echo $process->pid,"\t",$process->callback .PHP_EOL;
}

```

正确的代码：

```
$workers = [];
$worker_num = 3;//创建的进程数

for($i=0;$i<$worker_num ; $i++){
    $process = new swoole_process('process');
    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach($workers as $process){
    //子进程也会包含此事件
    swoole_event_add($process->pipe, function ($pipe) use($process){
    $data = $process->read();
        echo "RECV: " . $data.PHP_EOL;
    });
}

function process(swoole_process $process){// 第一个处理
    $process->write($process->pid);
    echo $process->pid,"\t",$process->callback .PHP_EOL;
}
```

