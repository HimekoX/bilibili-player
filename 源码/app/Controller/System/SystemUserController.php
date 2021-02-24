<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\SystemUser;
use App\Model\SystemUserRole;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use App\Utils\CategoryUtil;
use App\Utils\StringUtil;
use Core\extend\exception\JSONException;
use App\Middleware\SystemMiddleware;
/**
 * 用户控制器
 * Class SystemUserController
 * @package App\Controller\System
 * @Controller("/system/user")
 * @Middleware(SystemMiddleware::class)
 */
class SystemUserController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取菜单列表
     * @PostMapping("/getMenu")
     */
    public function getMenu()
    {
        $menus = CategoryUtil::generateTree(BasicUtil::session('user')['menus'], 'id', 'pid', 'list');
        return $this->ToJson(200, 'success', $menus);
    }

    /**
     * 获取我的信息
     * @PostMapping("/getMeInfo")
     */
    public function getMeInfo()
    {
        return $this->ToJson(200, 'success', BasicUtil::session('user'));
    }

    /**
     * 修改我的信息
     * @PostMapping("/editMeInfo")
     */
    public function editMeInfo()
    {
        $user = BasicUtil::session('user');

        $avatarUrl = BasicUtil::post('avatarUrl');
        $nickname = BasicUtil::post('nickname');
        $phone = BasicUtil::post('phone');

        $userData = SystemUser::query()->find($user['id']);

        if (BasicUtil::post('pass') != '') {
            $userData->salt = StringUtil::generateRandStr(32);
            $userData->pass = StringUtil::generatePassword(BasicUtil::post('pass'), $userData->salt);
        }

        $userData->face = $avatarUrl;
        $userData->nickname = $nickname;
        $userData->phone = $phone;
        $userData->save();

        return $this->ToJson(200, '修改成功');
    }

    /**
     * 获取全部用户
     * @PostMapping("/getUsers")
     */
    public function getUsers()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(SystemUser::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setWith(['roles']);
        $queryTemplateEntity->setMiddle('roles', 'system_user', 'system_user_role', 'role_id', 'user_id');
        $queryTemplateEntity->setWhere($_POST);
        $queryTemplateEntity->setField(['id', 'user', 'face', 'login_date', 'create_date', 'status', 'login_ip']);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data['data'], $data['total']);
    }

    /**
     * 保存用户
     * @PostMapping("/saveUser")
     * @throws JSONException
     */
    public function saveUser()
    {
        $map = $_POST;
        $map['roles'] = (array)$map['roles']; //如果是空，这里会强制转为数组
        if ($map['pass'] != '') {
            $map['salt'] = StringUtil::generateRandStr(32);
            $map['pass'] = StringUtil::generatePassword($map['pass'], $map['salt']);
        }
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(SystemUser::class);
        $createObjectEntity->setMap($map);
        $createObjectEntity->setCreateDate('create_date');
        $createObjectEntity->setMiddle('roles', SystemUserRole::class, 'role_id', 'user_id');
        $roleId = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$roleId) {
            throw new JSONException("本次操作没有任何更改");
        }
        return $this->ToJson(200, '成功啦!');
    }

    /**
     * 删除用户
     * @PostMapping("/delUser")
     * @throws JSONException
     */
    public function delUser()
    {
        $list = $_POST['list'];
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(SystemUser::class);
        $deleteBatchEntity->setList($list);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~",100);
        }
        return $this->ToJson(200, '删除成功!');
    }

    /**
     * 退出用户
     * @PostMapping("/logout")
     */
    public function logout()
    {
        $_SESSION['user'] = null;
        return $this->ToJson(200, '退出登录');
    }
}
