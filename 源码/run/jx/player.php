<?php
if ($player == 'dplayer' || $mobile == true) {
    echo '<!DOCTYPE html>
<html lang="zh-CN">
';
} else {
    echo '<html lang="zh-CN">
';
}
?>
<head>
    <meta charset="UTF-8">
    <title>360模板吧云解析系统</title>
    <meta name="description" content="免费视频弹幕播放器，这里有最及时的动漫，最棒的ACG氛围，最有创意的Up主。大家可以在这里找到许多欢乐。">
    <meta name="keywords"
          content="Bilibili,哔哩哔哩,哔哩哔哩动画,哔哩哔哩弹幕网,弹幕视频,B站,弹幕,字幕,AMV,MAD,MTV,ANIME,追新番,新番动漫,新番吐槽,巡音,镜音双子,千本樱,初音MIKU,舞蹈MMD,MIKUMIKUDANCE,洛天依原创曲,洛天依翻唱曲,洛天依投食歌,洛天依MMD,vocaloid家族,OST,BGM,动漫歌曲,日本动漫音乐,宫崎骏动漫音乐,动漫音乐推荐,燃系mad,治愈系mad,MAD MOVIE,MAD高燃">
    <meta name="viewport"
          content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1,viewport-fit=cover">
    <meta name="renderer" content="webkit"> <!-- 启用360浏览器的极速模式(webkit) -->
    <meta name="theme-color" content="#de698c">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="x5-fullscreen" content="true" /><meta name="x5-page-mode" content="app"  /> <!-- X5  全屏处理 -->
    <meta name="full-screen" content="yes" /><meta name="browsermode" content="application" />  <!-- UC 全屏应用模式 -->
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="applicable-device" content="mobile">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/btjson/player@latest/aes.js"></script>
    <script>var bt_token = "<?php echo $arrAes['str_y'];?>"; </script>
    <?php

    if ($referrer == "no-referrer") {
        echo '<meta name="referrer" content="no-referrer">';
    } elseif ($referrer == "never") {
        echo '<meta name="referrer" content="never">';
    } else {
        echo '<meta name="referrer" content="Origin">';
    }

    if ($player == 'dplayer' || $mobile == true) {
        echo '<script src="https://cdn.jsdelivr.net/npm/blueimp-md5@2.9.0/js/md5.js"></script>
        <link rel="stylesheet" href="js/shendu.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="js/shendu.min.js"></script>
        <script type="text/javascript" src="js/shenduplayer.min.js"></script>
        <script type="text/javascript" src="https://lib.baomitu.com/layer/3.1.1/mobile/layer.js"></script>';
    } else {
        echo '
<style type="text/css">body,html,.video{background-color:#000;padding: 0;margin: 0;width:100%;height:100%;}</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/p2p-ckplayer@0.4.0/ckplayer/ckplayer.js"></script>';
    }

    if ($m3u8) {//如过你们喜欢使用P2P加速，可参考:https://www.cdnbye.com/cn/
        echo '<script type="text/javascript" src="https://lib.baomitu.com/hls.js/8.0.0-beta.3/hls.min.js"></script>';//视频解码，已调用CDN；本地调用：js/hls.min.js
    } else {
        echo '<script type="text/javascript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/flv.js/dist/flv.min.js"></script>';//视频解码,已调用CDN；本地调用：js/flv.min.js
    }
    ?>
</head>
<body>
<?php

if ($player == 'dplayer' || $mobile == true) {
    echo '<div id="player" style="position:absolute;left:0px;top:0px;"></div>
<div id="ADplayer" style="position:absolute;left:0px;top:0px;"></div>
<div id="ADtip" style="position:absolute;left:0px;top:0px;"></div>
<script>
var up = {
    "ServerApi": "https://jx.360mb.net",//服务器域名配置
    "ServerKey": "shendutv",//应用密钥
	"usernum":"' . $users_online . '",//在线人数
	"mylink":"",
	"diyid":[0,"lele",1]//自定义弹幕id
	}
var config = {
	"api":"https://jx.360mb.net",//弹幕接口   前面架设自己的域名 防止后台弹幕库报错    例如   https://jx.360mb.net
	"key": "shendutv",//应用KEY码,如果不填将获取全部弹幕信息(填写后指定应用弹幕)
	"url":"' . $url . '",//视频链接
	"sid":"' . $_GET['sid'] . '",//集数id
	"pic":"' . $_GET['pic'] . '",//视频封面
	"title":"' . $_GET['name'] . '",//视频标题
	"next":"' . $_GET['next'] . '",//下一集链接
	"user": "' . $_GET['user'] . '",//用户名
	"group": "' . $_GET['group'] . '",//用户组
	}
lele.start()
</script>';
} else {
    echo '<div class="huiv"></div>
<script type="text/javascript">var huiid = "' . $url . '"; </script>
<script type="text/javascript" src="js/ckplayerx/player.js"></script>';
}
?>
</body>
</html>