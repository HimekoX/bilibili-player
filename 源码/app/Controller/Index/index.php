<?php

namespace App\Controller\Index;

/**
 * Class index
 * @package App\Controller\Index
 * @Controller("/")
 */
class index
{
    /**
     * 首页
     * @RequestMapping("/")
     */
    public function home()
    {
        return 'SmallPro Ver-1.0.0';
    }
}