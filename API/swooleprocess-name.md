# **swoole\_process-&gt;name**

修改进程名称。此函数是swoole\_set\_process\_name的别名。

```
bool swoole_process::name(string $new_process_name);
$process->name("php server.php: worker");

```

> 此方法在swoole-1.7.9以上版本可用
> 
> name方法应当在start之后的子进程回调函数中使用

