<?php


namespace App\Utils;


use Core\extend\exception\JSONException;

class DefenseUtil
{
    /**
     * CC防御层,高频防刷
     * seconds 时间段[秒]
     * refresh 刷新次数
     * @param int $seconds
     * @param int $refresh
     * @throws JSONException
     */
    public static function CCDefense(int $seconds = 10, int $refresh = 5)
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
                throw new JSONException('请勿频繁请求,以免照成系统拥堵',-1);
            }
        } else {
            $_SESSION['refresh_times'] = 0;
            $_SESSION['last_time'] = $cur_time;
        }
    }
}
