<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\Player;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use App\Middleware\SystemMiddleware;
use Core\extend\exception\JSONException;

/**
 * 播放器控制器
 * Class PlayerController
 * @package App\Controller\System
 * @Controller("/system/player")
 * @Middleware(SystemMiddleware::class)
 */
class PlayerController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取播放器集群列表
     * @PostMapping("/getPlayerList")
     */
    public function getPlayerList()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(Player::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data['data'], $data['total']);
    }


    /**
     * 获取播放器信息
     * @PostMapping("/getPlayerConfig")
     */
    public function getPlayerConfig()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(Player::class);
        $queryTemplateEntity->setWhere(['equal-id' => BasicUtil::all("id")]);
        $queryTemplateEntity->setPaginate(false);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data[0]);
    }

    /**
     * 保存播放器集群数据
     * @PostMapping("/savePlayer")
     */
    public function savePlayer()
    {
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(Player::class);
        $createObjectEntity->setMap($_POST);
        $roleId = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$roleId) {
            throw new JSONException("本次操作没有任何更改", 100);
        }
        return $this->ToJson(200, '成功啦!');
    }

    /**
     * 删除播放器内数据
     * @PostMapping("/delPlayer")
     * @throws JSONException
     */
    public function delPlayer()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(Player::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~", 100);
        }
        return $this->ToJson(200, '删除成功!');
    }
}