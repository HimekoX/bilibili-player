<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\User;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use App\Utils\StringUtil;
use Core\extend\exception\JSONException;
use App\Middleware\SystemMiddleware;

/**
 * 用户端控制器
 * Class SystemUsersController
 * @package App\Controller\System
 * @Controller("/system/users")
 * @Middleware(SystemMiddleware::class)
 */
class SystemUsersController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取全部用户
     * @PostMapping("/getUsers")
     */
    public function getUsers()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(User::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setWhere($_POST);
        $queryTemplateEntity->setField(['id', 'user', 'nick', 'face', 'login_time', 'create_time', 'status', 'mailbox', 'phone', 'login_ip']);
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

        if (!empty($map['pass'])) {
            $map['salt'] = StringUtil::generateRandStr(32);
            $map['pass'] = StringUtil::generatePassword($map['pass'], $map['salt']);
        }else{
            unset($map['pass']);
        }

        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(User::class);
        $createObjectEntity->setMap($map);
        $createObjectEntity->setCreateDate('create_time');
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
        $deleteBatchEntity->setModel(User::class);
        $deleteBatchEntity->setList($list);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~",100);
        }
        return $this->ToJson(200, '删除成功!');
    }

}