<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use App\Service\SystemAuthServiceInterface;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;

/**
 * 系统认证控制器
 * Class SystemLoginController
 * @package App\Controller\System
 * @Controller("/system/auth")
 */
class SystemAuthController extends SystemBaseController
{
    /**
     * @Inject()
     * @var SystemAuthServiceInterface
     */
    public $SystemAuthServer;
    /**
     * 后台登录
     * @PostMapping("/login")
     */
    public function login()
    {
        $token = $this->SystemAuthServer->LoginAuth($_POST,BasicUtil::getIp());
        return $this->ToJson(200,'登录成功',['access_token'=>$token]);
    }
}