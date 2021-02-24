<?php

use Core\Drive;

$config = Drive::$config['Redis'];

$arr = [
    'host' => $config['hostName'],
    'port' => $config['hostPort'],
];

if (!empty($config['passWord'])) {
    $arr['password'] = $config['passWord'];
}

return $arr;