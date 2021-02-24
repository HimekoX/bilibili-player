<?php

class basic
{

    private $cache;

    private $config;

    /**
     * 初始化播放器基础参数
     */
    public function initialize()
    {
        error_reporting(0);
        $this->config = require_once './btjson/config.php';
        require_once './btjson/cache.inc.php';
        require_once './btjson/aes.php';

        if ($_GET['type'] == "clear") {
            //建议把该功能设置在宝塔的定时器内定时情理缓存
            if ($this->config['cacheClearToken'] != $_GET['key']) {//两者秘钥对比是否一致
                exit('No Access');
            }
            $cache = new Cache('./Cache/', $this->config['cacheClearTime']);//清理300秒以前的缓存
            $cache->clean();//开始清理缓存

            echo '缓存清理成功';

        } else {
            $this->Header();
            $this->Buffer();
        }

    }

    /**
     * 生成随机字符串
     * @param int $length
     * @return string
     */
    private function generateRandStr(int $length = 32): string
    {
        $md5 = md5(uniqid(md5((string)time())) . mt_rand(10000, 9999999));
        return substr($md5, 0, $length);
    }

    /**
     * 请求头处理
     */
    private function Header()
    {
        header("Content-type:text/html;charset=utf-8");   //  设置编码
        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');//禁止页面被缓存
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Access-Control-Allow-Origin: *');//跨域
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: x-requested-with,content-type');
        header('Access-Control-Allow-Methods: GET, POST');
    }

    /**
     * 缓存器
     */
    private function Buffer()
    {
        $this->cache = new Cache('./Cache/', $this->config['cacheTime']);//600秒缓存
        $this->FilmProcess();
    }

    /**
     * 影片处理
     * @throws Exception
     */
    private function FilmProcess()
    {
        $data = $_GET;
        $preg = "/^http(s)?:\\/\\/.+/";
        if (empty($data['url'])) {
            throw new Exception('您好像没有输入视频链接地址哦');
        } else {
            if (!preg_match($preg, $data['url'])) {
                $player = false;

                foreach ($this->config['urlSupport'] as $value) {
                    if (strstr($data['url'], $value)) {
                        $player = true;
                    }
                }

                if (!$player) {
                    throw new Exception('恩?,你给我了个我识别不出来的地址做咩?');
                }


            } else {
                $CacheUrl = $this->cache->load(); //装载缓存
            }
        }


        if (empty($CacheUrl)) {

            $urlData = $this->Parsing_library($data);

            if (empty($urlData['url'])) {
                throw new Exception('呜呜呜影像地址无法解析..');
            }

            if (empty($urlData['referrer'])) {
                $urlData['referrer'] = 'Origin';
            }

            if (!empty($urlData['cache'])) {
                $cache = $urlData['cache'];
                if ($cache['switch']) {
                    if (!empty($cache['cacheTime'])) {
                        $cache_video = new Cache('./Cache/', $cache['cacheTime']);
                        $cache_video->write(1, json_encode($urlData));
                    }
                } else {
                    if (!empty($cache['cacheTime'])) {
                        $cache_video = new Cache('./Cache/', $cache['cacheTime']);
                        $cache_video->write(1, json_encode($urlData));
                    }
                }

            } else {
                if ($this->config['cacheSwitch']) {
                    $this->cache->write(1, json_encode($urlData));
                }
            }


        } else {
            $data = json_decode($CacheUrl, true);
            foreach ($data as $key => $val) {
                $urlData[$key] = $val;
            }

        }

        $this->Rendering($urlData);
    }

    /**
     * 播放器选择
     * @param array $url
     * @return string
     */
    private function player(array $url)
    {
        //检测部分无法使用Dp播放的地址转交给CK
        $match = $this->config['ckPlayerMatch'];

        $player = "dplayer";

        foreach ($match as $str) {

            if (strstr($url['url'], $str) == true) {
                $player = "ckplayer";
            }
        }
        return $player;
    }

    /**
     * 人数统计
     * @param $url
     * @return int
     */
    private function Statistics(string $url)
    {
        $online_log = "./count.dat"; //保存人数的文件,
        $timeout = 130;//30秒内没动作者,认为掉线
        $entries = file($online_log);
        $temp = array();
        for ($i = 0; $i < count($entries); $i++) {
            $entry = explode(",", trim($entries[$i]));
            if (($entry[0] != getenv('REMOTE_ADDR')) && ($entry[1] > time())) {
                array_push($temp, $entry[0] . "," . $entry[1] . "," . $entry[2] . "\n"); //取出其他浏览者的信息,并去掉超时者,保存进$temp
            }
        }
        $argc = [];
        array_push($temp, getenv('REMOTE_ADDR') . "," . (time() + ($timeout)) . "," . md5($url) . "\n"); //更新浏览者的时间

        foreach ($temp as $key => $item) {
            $exp = explode(",", $item);
            if (trim($exp[2]) == md5($url)) {
                $argc[] = $item;
            }
        }

        $users_online = count($temp); //计算总在线人数
        $argc = count($argc);
        $entries = implode("", $temp);
        $fp = fopen($online_log, "w");
        flock($fp, LOCK_EX); //flock() 不能在NFS以及其他的一些网络文件系统中正常工作
        fputs($fp, $entries);
        flock($fp, LOCK_UN);
        fclose($fp);
        //如果要显示全部人请把$argc 换成$users_online
        if ($this->config['allStatistics']) {
            return $users_online;
        } else {
            return $argc;
        }

    }

    /**
     * 播放器渲染
     * @param string $player
     * @param array $data
     */
    private function Rendering(array $data)
    {
        $arrAes = [
            "str_x" => "dvyYRQlnPRCMdQSe",
            "str_y" => $this->generateRandStr(16)
        ];

        $arsUrl = aes::encrypt($data['url'], $arrAes['str_x'], $arrAes['str_y']);

        if (strpos($data['url'], 'm3u8')) {
            $m3u8 = true;
        } elseif (strpos($data['url'], 'flv')) {
            $m3u8 = false;
        }

        if ($data['player'] == 'ckplayer') {
            $arsUrl = $data['url'];
        }

        require_once './btjson/show.class.php';
        $lan = new show('player.php', [
            "url" => $arsUrl,
            "referrer" => $data['referrer'],
            "player" => $data['player'],
            "arrAes" => $arrAes,
            "m3u8" => $m3u8,
            "mobile" => $this->is_mobile(),
            "users_online" => $this->Statistics($data['url'])
        ]);
        $lan->display();
    }

    /**
     * 判断手机/电脑设备
     */
    private function is_mobile()
    {
        //获取USER AGENT
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        //分析数据
        $is_pc = (strpos($agent, 'windows nt')) ? true : false;
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_ipad = (strpos($agent, 'iPad')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;  //输出数据

        if ($is_iphone || $is_ipad || $is_android) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 载入解析库
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    private function Parsing_library(array $data)
    {
        $p_player = $this->player($data);

        //播放器原生支持
        $arr = $this->config['dpPlayerNative'];

        $data['player'] = $p_player;
        foreach ($arr as $item) {
            if (strstr($data['url'], $item['match']) == true) {
                $data['referrer'] = $item['referrer'];
                return $data;//获取播放链接
            }
        }

        foreach ($this->config['Parsing'] as $datum) {
            $str = explode('|', $datum['match']);
            foreach ($str as $key => $value) {
                if (strstr($data['url'], $value) == true) {
                    $data = $this->Parsing($data, $datum);
                    $data['player'] = $p_player;
                    if (!empty($datum['cache'])) {
                        $data['cache'] = $datum['cache'];
                    }
                    if (!empty($data['url'])) {
                        return $data;
                    }
                }
            }

        }

        foreach ($this->config['Parsing'] as $datum) {
            if ($datum['match'] == "*") {
                $data = $this->ParsingAll($data, $datum);
                $data['player'] = $p_player;
                if (!empty($datum['cache'])) {
                    $data['cache'] = $datum['cache'];
                }
                if (!empty($data['url'])) {
                    return $data;
                }
            }
        }

        throw new Exception('片源无法解析也无法播放哦~');
    }

    /**
     * 解析数据
     * @param $data
     * @param $datum
     * @param null $url
     * @return array|null[]
     */
    private function Parsing($data, $datum, $url = null)
    {
        if (!empty($url)) {
            $datum['url'] = $url;
        }

        $Packets = json_decode($this->put_curl($datum['url'] . $data['url']), true);

        if (empty($Packets['url'])) {
            if (!empty($datum['spare_url'])) {
                if (empty($url)) {
                    return $this->Parsing($data, $datum, $datum['spare_url']);
                }
            }
            return ["url" => null];
        }

        if ($datum['player'] == true) {

            $Packets = explode("?url=", $Packets['url']);

            if (!empty($datum['referrer'])) {
                $referrer = $datum['referrer'];

                if (!empty($referrer['no-referrer'])) {
                    $referrerRR = false;
                    $reData = "";

                    foreach ($referrer['no-referrer'] as $key => $item) {
                        if (strstr($Packets[0], (string)$item) == true) {
                            $referrerRR = true;
                        } else if (strstr($Packets[1], (string)$item) == true) {
                            $referrerRR = true;
                        }
                    }
                }

                if (!$referrerRR) {
                    $reData = $referrer['default'];
                } else {
                    $reData = "no-referrer";
                }

            }

            $arr = [];

            if (!empty($reData)) {
                $arr['referrer'] = $reData;
            }
            if (!empty($Packets[1])) {
                $arr['url'] = $Packets[1];
                return $arr;
            } else {

                $arr['url'] = $Packets[0];
                return $arr;
            }

        } else {

            if (!empty($Packets['url'])) {
                return ["url" => $Packets['url']];
            }
        }
    }

    /**
     * 解析数据*号匹配值
     * @param $data
     * @param $datum
     * @param null $url
     * @return array|null[]
     */
    private function ParsingAll($data, $datum, $url = null)
    {
        if (!empty($url)) {
            $datum['url'] = $url;
        }

        $Packets = json_decode($this->put_curl($datum['url'] . $data['url']), true);

        if (empty($Packets['url'])) {
            if (!empty($datum['spare_url'])) {
                if (empty($url)) {
                    return $this->ParsingAll($data, $datum, $datum['spare_url']);
                }
            }
            return ["url" => null];
        }

        if ($datum['player'] == true) {

            $Packets = explode("?url=", $Packets['url']);

            if (!empty($datum['referrer'])) {
                $referrer = $datum['referrer'];

                if (!empty($referrer['no-referrer'])) {

                    $referrerRR = false;
                    $reData = "";

                    foreach ($referrer['no-referrer'] as $key => $item) {
                        if (strstr($Packets[0], (string)$item) == true) {
                            $referrerRR = true;
                        } else if (strstr($Packets[1], (string)$item) == true) {
                            $referrerRR = true;
                        }
                    }
                }

                if (!$referrerRR) {
                    $reData = $referrer['default'];
                } else {
                    $reData = "no-referrer";
                }

            }
            $arr = [];

            if (!empty($reData)) {
                $arr['referrer'] = $reData;
            }
            if (!empty($Packets[1])) {
                $arr['url'] = $Packets[1];
                return $arr;
            } else {
                $arr['url'] = $Packets[0];
                return $arr;
            }

        } else {
            if (!empty($Packets['url'])) {
                return ["url" => $Packets['url'],"referrer"=>"Origin"];
            }
        }
    }

    /**
     * 网络请求
     * @param $url
     * @param int $type
     * @param string $post_data
     * @param string $ua
     * @param string $cookie
     * @param bool $redirect
     */
    private function put_curl($url, $type = 0, $post_data = '', $ua = '', $cookie = '', $redirect = true)
    {
        $refere = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $header = array("Referer:" . $refere, "User-Agent:" . $_SERVER['HTTP_USER_AGENT']);
        // 初始化cURL
        $curl = curl_init();
        // 设置网址
        curl_setopt($curl, CURLOPT_URL, $url);
        // 设置UA
        if (empty($ua) == false) {
            $header[] = 'User-Agent:' . $_SERVER['HTTP_USER_AGENT'];
        }
        // 设置Cookie
        if (empty($cookie) == false) {
            $header[] = 'Cookie:' . $cookie;
        }
        // 设置请求头
        if (empty($ua) == false or empty($cookie) == false or empty($header) == false) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        // 设置POST数据
        if ($type == 1) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        }
        // 设置重定向
        if ($redirect == false) {
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        }
        //允许执行的最长秒数
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        // 过SSL验证证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        // 将头部作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, false);
        // 设置以变量形式存储返回数据
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // 请求并存储数据
        $return = curl_exec($curl);
        // 分割头部和身体
        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == '200') {
            $return_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $return_header = substr($return, 0, $return_header_size);
            $return_data = substr($return, $return_header_size);
        }
        // 关闭cURL
        curl_close($curl);
        // 返回数据
        return $return;
    }
}