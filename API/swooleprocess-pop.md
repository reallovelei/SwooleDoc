# **swoole\_process-&gt;pop**

从队列中提取数据。

```
string swoole_process->pop(int $maxsize = 8192);

```

* $maxsize表示获取数据的最大尺寸，默认为8192
* 操作成功会返回提取到的数据内容，失败返回false
* 如果队列中没有数据，pop\(\)方法会阻塞等待

