<?php
include __DIR__ . '/common.php';

$socket = new ZMQSocket (new ZMQContext (), ZMQ::SOCKET_PUSH);
$socket->connect (THUMBNAIL_ADDR);

$socket->sendMulti (
            array (
                'thumbnail',
                realpath ('./test.jpg'),
                50,
                50,
            )
);
echo "Sent request" . PHP_EOL;