# **swoole\_process-&gt;exec**

执行一个外部程序，此函数是exec系统调用的封装。

```
bool swoole_process->exec(string $execfile, array $args)

```

* $execfile指定可执行文件的绝对路径，如 "\/usr\/bin\/python"
* $args是一个数组，是exec的参数列表，如 array\('test.py', 123\)，相当与python test.py 123

执行成功后，当前进程的代码段将会被新程序替换。子进程脱变成另外一套程序。父进程与当前进程仍然是父子进程关系。

父进程与新进程之间可以通过可以通过标准输入输出进行通信，必须启用标准输入输出重定向。

> $execfile必须使用绝对路径，否则会报文件不存在错误
> 
> 由于exec系统调用会使用指定的程序覆盖当前程序，子进程需要读写标准输出与父进程进行通信
> 
> 如果未指定redirect\_stdin\_stdout = true，执行exec后子进程与父进程无法通信



