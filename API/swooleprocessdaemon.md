# **swoole\_process::daemon**

使当前进程脱变为一个守护进程。

```
bool swoole_process::daemon(bool $nochdir = false, bool $noclose = false);

```

* $nochdir，为true表示不修改当前目录。默认false表示将当前目录切换到“\/”
* $noclose，默认false表示将标准输入和输出重定向到\/dev\/null

> 此函数在1.7.5-stable版本后可用

