<?php

namespace Core;

use Core\extend\exception\JSONException;
use Predis\Client;

class Redis
{
    /**
     * 载入Redis运行环境
     * @return Client
     * @throws JSONException
     */
    public static function start()
    {
        if(Drive::$config['Redis_Status']){
            return new Client(require HOME_DIR . 'core/config/redis.php');
        }else{
            throw new JSONException('Redis配置已经被关闭,请设置后再次尝试',100);
        }

    }
}