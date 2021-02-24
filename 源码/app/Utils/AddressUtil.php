<?php
declare(strict_types=1);

namespace App\Utils;


/**
 * Class AddressUtil
 * @package App\Utils
 */
class AddressUtil
{
    /**
     * 获取IP归属地
     * @param string $ip
     * @return string
     */
    public static function getLocation(string $ip): string
    {
        $contents =  RequestUtil::curl_request("http://api.ip138.com/query/?ip={$ip}&token=866de101d7c3b422a303c6d44304aef7");

        $body = json_decode($contents, true);

        $address = '';

        for ($i = 0; $i < 4; $i++) {
            $address .= $body['data'][$i];
        }

        return $address;
    }
}