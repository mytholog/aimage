<?php

define ('THUMBNAIL_ADDR', 'tcp://127.0.0.1:5000');
define ('COLLECTOR_ADDR', 'tcp://127.0.0.1:5001');

class Worker {

    private $in;
    private $out;

    public function __construct ($in_addr, $out_addr)
    {
        $context = new ZMQContext ();

        $this->in = new ZMQSocket ($context, ZMQ::SOCKET_PULL);
        $this->in->bind ($in_addr);

        $this->out = new ZMQSocket ($context, ZMQ::SOCKET_PUSH);
        $this->out->connect ($out_addr);
    }

    public function work () {
        while ($command = $this->in->recvMulti ()) {
            if (isset ($this->commands [$command [0]])) {
                echo "Received work" . PHP_EOL;

                $callback = $this->commands [$command [0]];

                array_shift ($command);
                $response = call_user_func_array ($callback, $command);

                if (is_array ($response))
                    $this->out->sendMulti ($response);
                else
                    $this->out->send ($response);
            }
            else {
                error_log ("There is no registered worker for {$command [0]}");
            }
        }
    }

    public function register ($command, $callback)
    {
        $this->commands [$command] = $callback;
    }
}
