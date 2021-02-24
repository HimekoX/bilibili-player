<?php

namespace App\Controller\Index;

use App\Controller\IndexBaseController;
use App\Model\BarrageParsing;
use App\Model\Player;
use App\Model\PlayerRightMenu;
use App\Quickly\QueryServiceQuickly;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;

/**
 * 播放器API控制器
 * Class PlayerApiController
 * @package App\Controller\Index
 * @Controller("/player/api")
 */
class PlayerApiController extends IndexBaseController
{
    use QueryServiceQuickly;

    /**
     * 获取播放器配置
     * @RequestMapping("/getPlayerConfig")
     */
    public function getPlayerConfig()
    {
        $data = Player::query()->where('key', BasicUtil::all("key"))->where('player_status', 1)->first();

        if (empty($data)) {
            return $this->ToJson(100, "获取配置失败,请查看状态是否启动");
        }

        $Right = PlayerRightMenu::query()->where('pid', $data->id)->orderBy('rank', 'desc')->get();
        if ($data->player_random_av != 0) {
            $randAv = (int)BarrageParsing::query()->inRandomOrder()->first()->av;
        } else {
            if (!empty($data->player_random_av_content)) {
                $randAv = (int)$data->player_random_av_content;
            }
        }

        $data['right'] = $Right;
        $data['randAv'] = $randAv;

        unset($data['id']);
        unset($data['title']);
        unset($data['key']);
        return $this->ToJson(200, null, $data);
    }
}