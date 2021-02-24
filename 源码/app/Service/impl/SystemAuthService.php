<?php


namespace App\Service\impl;

use App\Model\SystemUser;
use App\Service\SystemAuthServiceInterface;
use App\Utils\DateUtil;
use App\Utils\StringUtil;
use Core\extend\exception\JSONException;

class SystemAuthService implements SystemAuthServiceInterface
{
    /**
     * 登录模块
     * @inheritDoc
     * @throws JSONException
     */
    public function LoginAuth(array $data, string $address)
    {
        if (empty($data)) {
            throw new JSONException('数据出现异常', 100);
        }

        $user = SystemUser::query()->where("user", $data['user'])->first();

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

        $_SESSION['user'] = $user->toArray();

        $user->login_date = DateUtil::current();//更新登录时间
        $user->login_ip = $address;//更新登录IP
        $user->save();

        return StringUtil::generateRandStr(32);
    }
}