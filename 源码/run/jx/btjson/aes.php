<?php


class aes
{
    /**
     * AES/CBC 加密
     * @param $data
     * @param $encryptKey
     * @param $localIV
     * @return string
     */
    public static function encrypt($data, $encryptKey, $localIV)
    {
        if (PHP_VERSION >= 7.1) {
            //php7.1新版本加密
            return base64_encode(openssl_encrypt($data, 'aes-128-cbc', $encryptKey, OPENSSL_RAW_DATA, $localIV));
        } else {
            //php7.1以下版本加密
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, $localIV);
            mcrypt_generic_init($module, $encryptKey, $localIV);
            $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $pad = $block - (strlen($data) % $block);
            $data .= str_repeat(chr($pad), $pad);
            $encrypted = mcrypt_generic($module, $data);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
            return base64_encode($encrypted);
        }
    }

    /**
     * AES/CBC 解密
     * @param $data
     * @param $encryptKey
     * @param $localIV
     * @return bool|string
     */
    public static function decrypt($data, $encryptKey, $localIV)
    {
        if (PHP_VERSION >= 7.1) {
            //php7.1新版本解密
            return openssl_decrypt(base64_decode($data), 'aes-128-cbc', $encryptKey, 1, $localIV);
        } else {
            //php7.1以下版本解密
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, $localIV);
            mcrypt_generic_init($module, $encryptKey, $localIV);
            $data = mdecrypt_generic($module, base64_decode($data));
            $data = str_replace("", "", $data);
            return $data;
        }
    }
}