<?php


namespace App\Controller\System;


use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\BarrageParsing;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use App\Middleware\SystemMiddleware;
use Core\extend\exception\JSONException;

/**
 * 随机弹幕AV库
 * Class BarrageParsingController
 * @package App\Controller\System
 * @Controller("/system/barrage/parsing")
 * @Middleware(SystemMiddleware::class)
 */
class BarrageParsingController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取全部AV号列表
     * @PostMapping("/getParsingList")
     */
    public function getParsingList()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(BarrageParsing::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data['data'], $data['total']);
    }

    /**
     * 保存AV号数据
     * @PostMapping("/saveParsing")
     */
    public function saveParsing()
    {
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(BarrageParsing::class);
        $createObjectEntity->setMap($_POST);
        $roleId = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$roleId) {
            throw new JSONException("本次操作没有任何更改", 100);
        }
        return $this->ToJson(200, '成功啦!');
    }

    /**
     * 删除AV号数据
     * @PostMapping("/delParsing")
     * @throws JSONException
     */
    public function delParsing()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(BarrageParsing::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~", 100);
        }
        return $this->ToJson(200, '删除成功!');
    }
}