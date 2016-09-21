swoole-1.7.2增加了一个进程管理模块，用来替代PHP的pcntl扩展。

## **PHP自带的pcntl，存在很多不足，如**

* pcntl没有提供进程间通信的功能
* pcntl不支持重定向标准输入和输出
* pcntl只提供了fork这样原始的接口，容易使用错误
* swoole\_process提供了比pcntl更强大的功能，更易用的API，使PHP在多进程编程方面更加轻松。

## **swoole\_process提供了如下特性：**

* swoole\_process提供了基于unixsock的进程间通信，使用很简单只需调用write\/read或者push\/pop即可
* swoole\_process支持重定向标准输入和输出，在子进程内echo不会打印屏幕，而是写入管道，读键盘输入可以重定向为管道读取数据
* swoole\_process允许用于fpm\/apache的Web请求中
* 配合swoole\_event模块，创建的PHP子进程可以异步的事件驱动模式
* swoole\_process提供了exec接口，创建的进程可以执行其他程序，与原PHP父进程之间可以方便的通信

> 1.8.0或更高swoole\_process只能在cli（命令行）环境中使用

