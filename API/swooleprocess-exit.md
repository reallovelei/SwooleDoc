# **swoole\_process-&gt;exit**

退出子进程

```
int swoole_process->exit(int $status=0);

```

$status是退出进程的状态码，如果为0表示正常结束，会继续执行PHP的shutdown\_function，其他扩展的清理工作。

如果$status不为0，表示异常退出，会立即终止进程。不再执行PHP的shutdown\_function，其他扩展的清理工作。

在父进程中，执行swoole\_process::wait可以得到子进程退出的事件和状态码。

