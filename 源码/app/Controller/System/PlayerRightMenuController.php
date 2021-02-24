<?php


namespace App\Controller\System;


use App\Controller\SystemBaseController;
use App\Entity\CreateObjectEntity;
use App\Entity\DeleteBatchEntity;
use App\Entity\QueryTemplateEntity;
use App\Model\PlayerRightMenu;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use App\Middleware\SystemMiddleware;
use Core\extend\exception\JSONException;

/**
 * 播放器右键菜单管理
 * Class PlayerRightMenuController
 * @package App\Controller\System
 * @Controller("/system/player/rightmenu")
 * @Middleware(SystemMiddleware::class)
 */
class PlayerRightMenuController extends SystemBaseController
{

    use QueryServiceQuickly;

    /**
     * 获取右键菜单列表
     * @RequestMapping("/getRightMenuList")
     */
    public function getRightMenuList()
    {
        $queryTemplateEntity = new QueryTemplateEntity();
        $queryTemplateEntity->setModel(PlayerRightMenu::class);
        $queryTemplateEntity->setLimit((int)BasicUtil::post('limit'));
        $queryTemplateEntity->setPage((int)BasicUtil::post('page'));
        $queryTemplateEntity->setPaginate(true);
        $queryTemplateEntity->setOrder('rank','desc');
        $queryTemplateEntity->setWhere(['equal-pid' => BasicUtil::all("id")]);
        $data = $this->findTemplateAll($queryTemplateEntity)->toArray();
        return $this->ToJson(200, null, $data['data'], $data['total']);
    }

    /**
     * 保存右键菜单列表
     * @PostMapping("/saveRightMenu")
     */
    public function saveRightMenu()
    {
        $arr = $_POST;
        $pid = BasicUtil::all('pid');
        if(!empty($pid)){
            $arr['pid'] = $pid;
        }
        $createObjectEntity = new CreateObjectEntity();
        $createObjectEntity->setModel(PlayerRightMenu::class);
        $createObjectEntity->setMap($arr);
        $roleId = $this->createOrUpdateTemplate($createObjectEntity);
        if (!$roleId) {
            throw new JSONException("本次操作没有任何更改", 100);
        }
        return $this->ToJson(200, '成功啦!');
    }

    /**
     * 删除播右键菜单数据
     * @PostMapping("/delRightMenu")
     * @throws JSONException
     */
    public function delRightMenu()
    {
        $deleteBatchEntity = new DeleteBatchEntity();
        $deleteBatchEntity->setModel(PlayerRightMenu::class);
        $deleteBatchEntity->setList($_POST['list']);
        $count = $this->deleteTemplate($deleteBatchEntity);
        if ($count == 0) {
            throw new JSONException("一个也没有删除成功~", 100);
        }
        return $this->ToJson(200, '删除成功!');
    }
}