<?php

namespace App\Controller;

abstract class ParsingBaseController
{
    /**
     * 自定义JSON数据
     * @param $data
     * @return false|string
     */
    protected function CustomJson($data)
    {
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');//跨域

        return json_encode($data);
    }
}