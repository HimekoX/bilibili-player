<?php


namespace App\Utils;


use Core\extend\exception\JSONException;

class Defense
{
    /**
     * CC防御层,高频防刷
     * seconds 时间段[秒]
     * refresh 刷新次数
     * type 类型 [0=>页面检测,1=>JSON提示]
     * @param int $seconds
     * @param int $refresh
     * @param int $type
     * @throws JSONException
     */
    public static function CCDefense(int $seconds = 10, int $refresh = 5, int $type = 0)
    {

        empty($_SERVER['HTTP_VIA']) or exit('Access Denied');

        //设置监控变量
        $cur_time = time();
        if (isset($_SESSION['last_time'])) {
            $_SESSION['refresh_times'] += 1;
        } else {
            $_SESSION['refresh_times'] = 1;
            $_SESSION['last_time'] = $cur_time;
        }
        //处理监控结果
        if ($cur_time - $_SESSION['last_time'] < $seconds) {

            if ($_SESSION['refresh_times'] >= $refresh) {
                if($type == 0){
                    //跳转验证
                    $url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    $msg = mb_convert_encoding("<title>安全检查</title><h3>检测到CC攻击，正在进行浏览器安全检查！</h3>", "UTF-8", "GBK");

                    exit($msg . "<meta http-equiv='refresh' content='5;url={$url}'>");//5是定时跳转的时间，后期可以根据时间段调整跳转时间
                }else{
                    throw new JSONException('请勿频繁请求,以免照成系统拥堵');
                }


            }
        } else {
            $_SESSION['refresh_times'] = 0;
            $_SESSION['last_time'] = $cur_time;
        }
    }
}
