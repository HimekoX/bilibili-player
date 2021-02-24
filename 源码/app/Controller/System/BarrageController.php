<?php


namespace App\Controller\System;


use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Middleware\SystemMiddleware;
use App\Model\BarrageList;
use App\Model\BarrageReport;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;

/**
 * 弹幕管理系统
 * Class BarrageController
 * @package App\Controller\System
 * @Middleware(SystemMiddleware::class)
 * @Controller("/system/barrage")
 */
class BarrageController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取弹幕列表
     * @PostMapping("/getBarrageList")
     */
    public function getBarrageList()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(BarrageList::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setOrder('cid', 'desc');
        $queryTemplateEntity->setWhere($_POST);
        $queryTemplateEntity->setPaginate(true);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        $arr = [];
        foreach ($data['data'] as $key => $datum) {
            $arr[$key] = $datum;
            $arr[$key]['id'] = $datum['cid'];
            $arr[$key]['cid'] = $datum['id'];
        }

        return $this->ToJson(200, null, $arr, $data['total']);
    }

    /**
     * 修改弹幕信息
     * @PostMapping("/saveBarrage")
     */
    public function saveBarrage()
    {
        $data = $_POST;

        $Barrage = BarrageList::query()->where('cid', $data['id'])->first();

        unset($data['id']);

        foreach ($data as $key => $datum) {
            $Barrage[$key] = $datum;
        }
        $Barrage->save();

        return $this->ToJson(200, '成功啦!');
    }

    /**
     * 删除弹幕
     * @PostMapping("/delBarrage")
     * @throws JSONException
     */
    public function delBarrage()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(BarrageList::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~", 100);
        }
        return $this->ToJson(200, '删除成功!');
    }


    /**
     * 获取弹幕列表
     * @PostMapping("/getReportList")
     */
    public function getReportList()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(BarrageReport::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setOrder('cid', 'desc');
        $queryTemplateEntity->setWhere($_POST);
        $queryTemplateEntity->setPaginate(true);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        $arr = [];
        foreach ($data['data'] as $key => $datum) {
            $arr[$key] = $datum;
            $arr[$key]['id'] = $datum['cid'];
            $arr[$key]['cid'] = $datum['id'];
        }

        return $this->ToJson(200, null, $arr, $data['total']);
    }

    /**
     * 删除举报(误报)
     * @PostMapping("/delReport")
     * @throws JSONException
     */
    public function delReport()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(BarrageReport::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("操作不成功~", 100);
        }
        return $this->ToJson(200, '操作成功!');
    }

}