<?php
// 运行说明如下:
ini_set("display_errors", "On");
error_reporting(E_ALL);
//restore_exception_handler();
//restore_error_handler();

class Chat {

    public $ws = null;
    public $type = null;  // 消息类型
    public static $count = 0;

    // 泳道隔离 避免某一类型处理较慢 影响到其他类型的处理
    public $type_task_cnt = array(
        101 => 3, // 101类型 有3个进程处理
        201 => 2, // 201类型 有2个进程处理
        301 => 1, // 301类型 有1个进程处理
    );



    //public $public_service; // public 目录下的ChatService 避免重复 new
    public static $server; // swoole server 在rabbitmq的回调函数里使用

    public $type_base = array(); // 每种类型的task_id基础数值

    // task 里最后一次 时间
    public static $last_timer = array();

    public $config = array(
        'worker_num' => 1,
        //'task_worker_num' => 8,
        'task_ipc_mode' => 1,
        'max_request' => 0,
        'dispatch_mode' => 2, //uid dispatch
        'daemonize' => 0,

        //如果你的网站是https的需要配置证书
        //'ssl_key_file' => '/home/ssl/s1.key',
        //'ssl_cert_file' => '/home/ssl/s1.crt',
        'log_file' =>'/tmp/chat.log',
    );



    public function initCnt() {
        $num = $task_num = 0;
        foreach ($this->type_task_cnt as $type => $cnt) {
            $this->type_base[$type] = $task_num;
            //??? self::$cnt[$key] = 0;
            //$this->redis->hset('cnt', $key, 0);  // 初始化每种类型的计数都是0
            $task_num += $cnt;
        }
        $this->config['task_worker_num'] = $task_num;
        //$this->ws = new ChatWsService();
    }

    // 根据消息类型 获得taskId
    public function getTaskId($type) {
        $cnt = $this->type_task_cnt[$type];
        $tid = rand(1, $cnt);
        $tid = $tid + $this->type_base[$type] - 1;
        return $tid;
    }

    public function pushData($data, $server, $curfd = 0) {
        foreach ($server->connections as $fd) {
            if ($fd == $curfd) continue;
            echo "current fd {$fd} \n";
            if (!self::$server->push($fd, json_encode($data))) {
                $this->ws->close($fd);
            }
        }
    }

    public function process($msg, $server) {
        //获取信息
        $data = json_decode($msg->body, true);
        if (empty($data))
            return 0;
        $function = isset($data['function']) ? $data['function'] : 'publish';
        $data['push_time'] = time();

        $mUser = new GayUser();
        $mb = new Broadcast();

        $user = $mUser->userBaseInfo($data['userId']);
        $data['headimgurl'] = $user['headimgurl'];
        $data['nickname'] = $user['nickname'];
        $data['level'] = $user['level'];

        $chatService = new ChatService();
        $rs = $chatService->$function($data);

        if (isset($rs['p1'])) {
            $data['p1'] = $rs['p1'];
        }

        if (isset($rs['p2'])) {
            $data['p2'] = $rs['p2'];
        }

        $data['id'] = isset($rs['id']) ? $rs['id'] : 0;

        $msg->ack();
        $this->pushData($data, $server);

    }

    public function start() {

        global $server;
        //$server = new swoole_websocket_server("0.0.0.0", 9508, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
        $server = new swoole_websocket_server("0.0.0.0", 9508);
        self::$server = $server;
        $this->initCnt();
        $server->set($this->config);


        $server->on('WorkerStart', function (swoole_websocket_server $server, $worker_id) {

            if ($server->taskworker === true) {
                echo "work_id is {$worker_id} i'm task \n";
                //$rs = Yii::app()->amqp->getInstance('JybChatEx')->consume('JybChatQueue', 'process', $this, $server);
            }
        });

        $server->on('connect', function (swoole_server $server, $fd, $from_id) {
//echo "connect \n";
        });

        $server->on('open', function (swoole_websocket_server $server, $request) {
//echo "on open \n";
           $cnt = count($server->connections);
           $this->pushData(array('onlineCnt' => $cnt), $server);
            echo "server: handshake success with fd{$request->fd} online {$cnt}\n";
        });


        $server->on('task', function (swoole_server $serv, $task_id, $from_id, $data) {
            echo "task \n";
            //$rs = Yii::app()->amqp->getInstance('JybChatEx')->consume('JybChatQueue', 'process', $this);
        });

        $server->on('finish', function (swoole_server $serv, $task_id, $data) {
            echo "finish {$task_id} \n";
        });


        $server->on('message', function (swoole_websocket_server $server, $frame) {
            $data = json_decode($frame->data, true);
 //var_dump($data);
            echo "当前服务器共有 ".count($server->connections). " 个连接\n";

            $this->ws->map[$frame->fd] = $data;
            $this->ws->server = $server;
            // 统一在worker里处理了
            $rs = $this->ws->client($frame->fd);

            $key = $this->ws->type_fd_key. ChatWsService::MSGTYPE_BROADCAST_JYB;
            //$fds = $this->ws->getTable($key);
            //echo "redis中 共有 ".count($fds). " 个连接\n";

        });

        $server->on('close', function ($server, $fd) {
            Yii::log("callback close \n");
            $cnt = count($server->connections);
echo " on close \n";
            $this->pushData(array('onlineCnt' => $cnt), $server, $fd);
            echo "online {$cnt} \n";
            //$this->ws->close($fd);
        });

        $server->start();
    }

    public function getOnlineCnt() {
        return $cnt;
    }

}

$obj = new Chat();
//var_dump($obj->type_task_cnt); die;
$obj->start();

