<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\SystemRole;
use App\Model\SystemRoleRouter;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;
use App\Middleware\SystemMiddleware;

/**
 * 角色管理控制器
 * Class SystemRoleController
 * @package App\Controller\System
 * @Controller("/system/role")
 * @Middleware(SystemMiddleware::class)
 */
class SystemRoleController extends SystemBaseController
{

    use QueryServiceQuickly;

    /**
     * 获得角色
     * @PostMapping("/getRoles")
     */
    public function getRoles()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(SystemRole::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setWith(['routers']);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data['data'], $data['total']);
    }


    /**
     * 保存角色
     * @PostMapping("/saveRole")
     * @throws JSONException
     */
    public function saveRole()
    {
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(SystemRole::class);
        $createObjectEntity->setMap($_POST);
        $createObjectEntity->setMiddle('auth', SystemRoleRouter::class, 'router_id', 'role_id');
        $roleId = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$roleId) {
            throw new JSONException("本次操作没有任何更改", 100);
        }
        return $this->ToJson(   200, '成功啦!');
    }

    /**
     * 删除角色
     * @PostMapping("/delRole")
     * @throws JSONException
     */
    public function delRole()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(SystemRole::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~", 100);
        }
        return $this->ToJson(200, '删除成功!');
    }

}
