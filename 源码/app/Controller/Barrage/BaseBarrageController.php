<?php

namespace App\Controller\Barrage;

use App\Controller\BarrageBaseController;
use App\Model\BarrageList;
use App\Model\BarrageReport;
use App\Model\Player;
use App\Utils\BasicUtil;
use App\Utils\DefenseUtil;
use Core\extend\exception\JSONException;

/**
 * 弹幕基础控制器
 * Class BaseBarrageController
 * @package App\Controller\Barrage
 * @Controller("/barrage")
 */
class BaseBarrageController extends BarrageBaseController
{

    private $seconds = 1;//请求时间 秒

    private $refresh = 2;//请求次数

    /**
     * API接口(弹幕接口)
     * @RequestMapping("/api")
     * @throws JSONException
     */
    public function api()
    {
        header('Access-Control-Allow-Origin: *');
        $type = BasicUtil::all('ac');

        if (empty($type)) {
            echo "为什么雪是白色?,但是我并不讨厌。";
        }

        if ($type == "dm" && $_SERVER['REQUEST_METHOD'] == "GET") {
            return $this->getBarrageList();
        }

        if ($type == "get" && $_SERVER['REQUEST_METHOD'] == "GET") {
            return $this->getBarrageList();
        }

        if ($type == "dm" && $_SERVER['REQUEST_METHOD'] == "POST") {

            return $this->addBarrage();
        }

        if ($type == "report") {
            return $this->reportBarrage();
        }

    }

    /**
     * 获取视频弹幕列表
     * @throws JSONException
     */
    public function getBarrageList()
    {
        $id = BasicUtil::get('id');

        if (empty($id)) {
            throw new JSONException('error no id', -1);
        }
        if (!empty(BasicUtil::get('key'))) {
            $PlayerData = Player::query()->where('key', BasicUtil::get('key'))->first();
            if (!empty($PlayerData)) {
                $data = BarrageList::query()->where('id', $id)->where('pid', $PlayerData->id)->orderBy('videotime', 'asc')->get();
            } else {
                $data = BarrageList::query()->where('id', $id)->orderBy('videotime', 'asc')->get();
            }
        } else {
            $data = BarrageList::query()->where('id', $id)->orderBy('videotime', 'asc')->get();
        }

        if (empty($data)) throw new JSONException([], 23);

        $arr = [];
        foreach ($data->toArray() as $k => $v) {
            // 请不要随意调换下列数组赋值顺序
            $arr[$k][] = (float)$v['videotime'];  //弹幕出现时间(s)
            $arr[$k][] = (string)$v['type'];   //弹幕样式
            $arr[$k][] = (string)$v['color']; //字体的颜色
            $arr[$k][] = (string)$v['cid'];  //现在是弹幕id，以后可能是发送者id了
            $arr[$k][] = (string)$v['text'];  //弹幕文本
            $arr[$k][] = (string)$v['ip'];  //弹幕ip
            //$arr[$k][] = (string)$v['time'];  //弹幕系统时间
            $arr[$k][] = $date = date('m-d H:i', $v['time']);  //弹幕系统时间
            $arr[$k][] = (string)$v['size'];  //弹幕系统大小
        }

        $length = count($arr);
        if ($length == 0) {
            $mov = "一条弹幕都没有，赶紧来一发吧！";
        } else {
            $mov = "有 $length 条弹幕列队来袭~做好准备吧！";
        }

        $tips = [2, "right", "#fff", "", "$mov","127.0.0.1",date("m-d H:i",time())];
        $tips1 = [6, "top", "#fb7299", "", "祝你观影愉快，有任何问题请到留言进行反馈！","127.0.0.1",date("m-d H:i",time())];

        array_unshift($arr, $tips, $tips1);

        return $this->CustomJson([
            "code" => 23,
            "msg" => "获取成功",
            "danum" => count($arr),
            "danmuku" => $arr,
            "name" => $id,
        ]);

    }

    /**
     * 添加弹幕
     * @throws JSONException
     */
    public function addBarrage()
    {
        DefenseUtil::CCDefense($this->seconds, $this->refresh);
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data)) {
            throw new JSONException('参数错误', -1);
        }

        if (empty($data['id'])) {
            $data['id'] = $data['player'];
        }

        if (empty($data['id'])) {
            throw new JSONException('error no id', -1);
        }

        if (!is_float($data['time'])) {
            $data['time'] = (float)$data['time'];
        }

        if (!is_float($data['time']) && !is_int($data['time'])) {
            throw new JSONException('参数错误', -1);
        }

        if (empty($data['text'])) {
            throw new JSONException('参数错误', -1);
        }
        $arr = [
            "text" => $data['text'],
            "id" => $data['id'],
            "type" => $data['type'],
            "color" => $data['color'],
            "size" => $data['size'],
            "videotime" => $data['time'],
            "referer" => $data['referer'],
            "ip" => BasicUtil::getIp(),
            "time" => time()
        ];

        $arr['pid'] = 0;
        if (!empty(BasicUtil::get('key'))) {
            $PlayerData = Player::query()->where('key', BasicUtil::get('key'))->first();
            if (!empty($PlayerData)) {
                $arr['pid'] = $PlayerData->id;
            }
        }

        BarrageList::query()->insert($arr);

        return $this->ToJson(23, '添加成功');


    }

    /**
     * 举报弹幕
     * @throws JSONException
     */
    public function reportBarrage()
    {
        DefenseUtil::CCDefense($this->seconds, $this->refresh);
        $data = $_GET;

        if (empty($data)) {
            throw new JSONException('参数错误', -1);
        }

        $SqlData = BarrageReport::query()->where('id', $data['title'])->where('text', $data['text'])->first();
        if (empty($SqlData)) {
            BarrageReport::query()->insert([
                "id" => $data['title'],
                "cid" => $data['cid'],
                "text" => $data['text'],
                "type" => $data['type'],
                "time" => time(),
                "ip" => $data['user'],
                "referer" => $data['referer'],
            ]);
        }

        return $this->CustomJson([
            "code" => 23,
            "danmuku" => "举报成功！感谢您为守护弹幕作出了贡献"
        ]);
    }
}