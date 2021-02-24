<?php

namespace App\Controller\System;


use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\SystemConfig;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;
use App\Middleware\SystemMiddleware;

/**
 * 系统配置控制器
 * Class SystemConfigController
 * @package App\Controller\System
 * @Controller("/system/config")
 * @Middleware(SystemMiddleware::class)
 */
class SystemConfigController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取配置
     * @PostMapping("/getConfigs")
     */
    public function getConfigs()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(SystemConfig::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data['data'], $data['total']);
    }
    /**
     * 获取单独配置
     * @PostMapping("/getConfig")
     */
    public function getConfig()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(SystemConfig::class);
        $queryTemplateEntity->setWhere(['equal-name' => BasicUtil::all("name")]);
        $queryTemplateEntity->setPaginate(false);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data[0]);
    }

    /**
     * 保存配置
     * @PostMapping("/saveConfig")
     * @throws JSONException
     */
    public function saveConfig()
    {
        $map = $_POST;
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(SystemConfig::class);
        $createObjectEntity->setMap($map);
        $configId = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$configId) {
            throw new JSONException("本次操作没有任何更改", 100);
        }
        return $this->ToJson(200, '保存成功');
    }

    /**
     * 删除配置
     * @PostMapping("/delConfig")
     * @throws JSONException
     */
    public function delConfig()
    {
        $list = $_POST['list'];
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(SystemConfig::class);
        $deleteBatchEntity->setList($list);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~", 100);
        }
        return $this->ToJson(200, '删除成功!');
    }
}
