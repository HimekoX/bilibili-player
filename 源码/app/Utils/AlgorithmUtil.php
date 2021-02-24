<?php


namespace App\Utils;

use Core\Drive;

class AlgorithmUtil
{

    /**
     * AES/CBC 加密
     * @param $data
     * @param $encryptKey
     * @param $localIV
     * @return string
     */
    public static function encrypt($data, $encryptKey = null, $localIV = null)
    {
        $Algorithm = Drive::$config['Algorithm'];

        if (empty($encryptKey)) {
            $encryptKey = $Algorithm['key'];
        }

        if (empty($localIV)) {
            $localIV = $Algorithm['ikey'];
        } else {
            if (strlen($localIV) != 16) {
                $localIV = $Algorithm['ikey'];
            }
        }

        return base64_encode(openssl_encrypt($data, 'aes-128-cbc', $encryptKey, OPENSSL_RAW_DATA, $localIV));

    }

    /**
     * AES/CBC 解密
     * @param $data
     * @param $encryptKey
     * @param $localIV
     * @return bool|string
     */
    public static function decrypt($data, $encryptKey = null, $localIV = null)
    {
        $Algorithm = Drive::$config['Algorithm'];

        if (empty($encryptKey)) {
            $encryptKey = $Algorithm['key'];
        }
        if (empty($localIV)) {
            $localIV = $Algorithm['ikey'];
        } else {
            if (strlen($localIV) != 16) {
                $localIV = $Algorithm['ikey'];
            }
        }

        return openssl_decrypt(base64_decode($data), 'aes-128-cbc', $encryptKey, 1, $localIV);
    }


    /**
     * 框架独立算法
     * $string 字符串
     * $operation 加密/解密 0 : 1
     * $key 自定义密文
     * $expiry 时间周期(秒)
     * @param $string
     * @param string $operation
     * @param string $key
     * @param int $expiry
     * @return bool|mixed|string
     */
    public static function small($string, $operation = '1', $key = '', $expiry = 0)
    {
        if (empty($key)) {
            $data = Drive::$config['Algorithm'];
            $key = $data['key'];
        }

        if ($operation == '1') {
            $string = str_replace("@", "+", $string);
        }
        $key2 = md5($key); // md5混淆
        $ckey_length = 4;
        $key = md5($key ? $key : 'behind');
        $key2 = md5($key2 ? $key2 . time() : time() . rand(rand(0, 5000), rand(5000, 10000)));
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == '1' ? substr($string, 0, $ckey_length) : substr(md5(time() . $key2), 0, 4)) : '';
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        $string = $operation == '1' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey [$i] = ord($cryptkey [$i % $key_length]);
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box [$i] + $rndkey [$i]) % 256;
            $tmp = $box [$i];
            $box [$i] = $box [$j];
            $box [$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box [$a]) % 256;
            $tmp = $box [$a];
            $box [$a] = $box [$j];
            $box [$j] = $tmp;
            $result .= chr(ord($string [$i]) ^ ($box [($box [$a] + $box [$j]) % 256]));
        }
        if ($operation == '1') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            $ks = $keyc . str_replace('=', '', base64_encode($result));
            return str_replace("+", "@", $ks);
        }
    }
}