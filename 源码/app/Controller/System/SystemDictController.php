<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\SystemDict;
use App\Quickly\QueryServiceQuickly;
use App\Service\impl\SystemDictService;
use App\Service\SystemDictServiceInterface;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;

/**
 * 系统字典控制器
 * Class SystemDictController
 * @package App\Controller\System
 * @Controller("/system/dict")
 * @Middleware(SystemMiddleware::class)
 */
class SystemDictController extends SystemBaseController
{
    use QueryServiceQuickly;

    /**
     * @Inject()
     * @var SystemDictServiceInterface
     */
    public $SystemDictService;

    /**
     * 获取字典数据
     * @PostMapping("/getDict")
     * @throws JSONException
     */
    public function getDict()
    {

        if(empty(BasicUtil::all('dict'))){
            throw new JSONException("字典数据不能为空",100);
        }

        $dict =  $this->SystemDictService->getDict(BasicUtil::all('dict'));

//        if ($dict == null) {
//            throw new JSONException("字段数据不支持该格式",100);
//        }

        return $this->ToJson(200, null, $dict);
    }

    /**
     * 获取字典数据列表
     * @PostMapping("/getDicts")
     */
    public function getDicts()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(SystemDict::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data['data'],$data['total']);
    }

    /**
     * 保存字典数据
     * @PostMapping("/saveDict")
     * @throws JSONException
     */
    public function saveDict()
    {
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(SystemDict::class);
        $createObjectEntity->setMap($_POST);
        $roleId = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$roleId) {
            throw new JSONException("本次操作没有任何更改",100);
        }
        return $this->ToJson(200, '成功啦!');
    }

    /**
     * 删除字典
     * @PostMapping("/delDict")
     * @throws JSONException
     */
    public function delDict()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(SystemDict::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~",100);
        }
        return $this->ToJson(200, '删除成功!');
    }
}
