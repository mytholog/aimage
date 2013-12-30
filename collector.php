<?php
include __DIR__ . '/common.php';

$socket = new ZMQSocket (new ZMQContext (), ZMQ::SOCKET_PULL);
$socket->bind (COLLECTOR_ADDR);

echo "Waiting for events.." . PHP_EOL;
while (($message = $socket->recvMulti ())) {
    var_dump ($message);
}