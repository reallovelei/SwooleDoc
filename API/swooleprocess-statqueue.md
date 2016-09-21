# **swoole\_process-&gt;statQueue**

查看消息队列状态。

```
array swoole_process->statQueue();

```

* 返回一个数组，包括2项信息
* queue\_num 队列中的任务数量
* queue\_bytes 队列数据的总字节数

```
array(
  "queue_num" => 10,
  "queue_bytes" => 161,
);
```

