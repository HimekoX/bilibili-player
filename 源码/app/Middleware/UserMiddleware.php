<?php


namespace App\Middleware;

use App\Model\User;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;
use Core\lib\socket\MiddlewareInterface;

class UserMiddleware implements MiddlewareInterface
{

    public function handle(): void
    {
        $user = BasicUtil::session('users');

        if (empty($user)) {
            throw new JSONException('验证数据失败,请重新登录', 1001);
        }

        $userData = User::query()->where('id', $user['id'])->first();

        if ($user['pass'] != $userData->pass) {
            throw new JSONException('账号密码发生了改变', 1001);
        }

        $userData = $userData->toArray();

        $_SESSION['users'] = $userData;
    }
}