# **swoole\_process::wait**

回收结束运行的子进程。

```
array swoole_process::wait(bool $blocking = true);
$result = array('code' => 0, 'pid' => 15001, 'signal' => 15);

```

* $blocking 参数可以指定是否阻塞等待，默认为阻塞
* 操作成功会返回返回一个数组包含子进程的PID、退出状态码、被哪种信号KILL
* 失败返回false

> 子进程结束必须要执行wait进行回收，否则子进程会变成僵尸进程
> 
> $blocking 仅在1.7.10以上版本可用

## **在异步信号回调中执行wait**

```
swoole_process::signal(SIGCHLD, function($sig) {
  //必须为false，非阻塞模式
  while($ret =  swoole_process::wait(false)) {
      echo "PID={$ret['pid']}\n";
  }
});

```

* 信号发生时可能同时有多个子进程退出
* 必须循环执行wait直到返回false

