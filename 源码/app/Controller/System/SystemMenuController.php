<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Model\SystemRouter;
use App\Quickly\QueryServiceQuickly;
use Core\extend\exception\JSONException;
use App\Middleware\SystemMiddleware;

/**
 * 系统菜单控制器
 * Class SystemMenuController
 * @package App\Controller\System
 * @Controller("/system/menu")
 * @Middleware(SystemMiddleware::class)
 */
class SystemMenuController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取菜单数据
     * @PostMapping("/getMenus")
     */
    public function getMenus()
    {
        $all = SystemRouter::query()->orderBy('rank', 'ASC')->get();
        return $this->ToJson(200, 'success', $all, count($all));
    }

    /**
     * 保存菜单数据
     * @PostMapping("/saveMenu")
     * @throws JSONException
     */
    public function saveMenu()
    {
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(SystemRouter::class);
        $createObjectEntity->setMap($_POST);
        $save = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$save) {
            throw new JSONException("本次操作没有任何更改",100);
        }
        return $this->ToJson(200, '成功啦!');
    }


    /**
     * 删除菜单数据
     * @PostMapping("/delMenu")
     * @throws JSONException
     */
    public function delMenu()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(SystemRouter::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~",100);
        }
        return $this->ToJson(200, '删除成功!');
    }
}
