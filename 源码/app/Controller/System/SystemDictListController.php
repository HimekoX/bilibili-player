<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\SystemDictList;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;
use App\Middleware\SystemMiddleware;

/**
 * 系统字典列表控制器
 * Class SystemDictListController
 * @package App\Controller\System
 * @Controller("/system/dict/list")
 * @Middleware(SystemMiddleware::class)
 */
class SystemDictListController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取字典内列表
     * @PostMapping("/getDictLists")
     */
    public function getDictLists()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(SystemDictList::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setWhere(['equal-dict_id' => BasicUtil::all("id")]);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data['data'],$data['total']);
    }

    /**
     * 保存数据子典内列表数据
     * @PostMapping("/saveDictValue")
     * @throws JSONException
     */
    public function saveDictValue()
    {
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(SystemDictList::class);
        $createObjectEntity->setMap($_POST);
        $createObjectEntity->setCreateDate("create_date");
        $roleId = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$roleId) {
            throw new JSONException("本次操作没有任何更改",100);
        }
        return $this->ToJson(200, '成功啦!');
    }

    /**
     * 删除字典内数据
     * @PostMapping("/delDictValue")
     * @throws JSONException
     */
    public function delDictValue()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(SystemDictList::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~",100);
        }
        return $this->ToJson(200, '删除成功!');
    }
}