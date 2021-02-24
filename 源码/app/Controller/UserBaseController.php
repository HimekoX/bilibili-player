<?php

namespace App\Controller;

abstract class UserBaseController
{
    /**
     * JSON数据
     * @param int $code
     * @param string|null $message
     * @param null $data
     * @param null $count
     * @return string
     */
    protected function ToJson(int $code, string $message = null, $data = null, $count = null): string
    {
        header('Content-type: application/json');

        $content = ['code' => $code];
        $message ? $content['msg'] = $message : null;
        $data ? $content['data'] = $data : null;
        $count ? $content['count'] = $count : null;

        return json_encode($content);
    }
}