<?php


namespace App\Service\impl;

use App\Model\User;
use App\Service\UserAuthServiceInterface;
use App\Utils\DateUtil;
use App\Utils\StringUtil;
use Core\extend\exception\JSONException;

class UserAuthService implements UserAuthServiceInterface
{
    /**
     * 登录模块
     * @param array $data
     * @param string $address
     * @throws JSONException
     */
    public function LoginAuth(array $data, string $address)
    {
        if (empty($data)) {
            throw new JSONException('数据出现异常', 100);
        }

        $user = User::query()->where("user", $data['user'])->first();

        if (empty($user)) {
            throw new JSONException('用户不存在', 100);
        }

        $password = StringUtil::generatePassword($data['pass'], $user->salt);

        if ($user->pass != $password) {
            throw new JSONException("密码错误", 100);
        }

        if ($user->status != 1) {
            throw new JSONException("您的账号已被停用", 100);
        }

        $_SESSION['users'] = $user->toArray();

        $user->login_time = DateUtil::current();//更新登录时间
        $user->login_ip = $address;//更新登录IP
        $user->save();
    }
}