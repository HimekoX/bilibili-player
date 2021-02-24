<?php
//缓存开关(建议开启)
$cacheSwitch = true;
//缓存时间(单位秒)[默认缓存600秒]
$cacheTime = 600;
//缓存清理秘钥,请通过播放器入口输入?type=clear&key=你的安全秘钥 清理
$cacheClearToken = "123456";
//缓存清理时间(单位秒)[清理300秒以前的缓存数据]
$cacheClearTime = 300;

//在线统计开关
$allStatistics = true;//统计总在线人数,设置成false为单条地址在线人数

//URL支持,列如?url=7a6d6103-2fb7-4f61-9461-6544d4c87452-qqwy 微云ID
//需要在下方写入支持匹配,否则无法播放
$urlSupport = [
    "-yywy",
    "-qqwy",
    "-yh",
    "xigua",
    "_",
    "_TZK"
];

//支持Dp原生解析的url,将不会通过解析口进入
//match 匹配字符串数据
//referrer协议,空默认Origin
//可选 Origin,never,no-referrer
$dpPlayerNative = [
    [
        "match" => ".m3u8",
        "referrer" => "Origin"
    ], [
        "match" => ".mp4",
        "referrer" => "Origin"
    ], [
        "match" => ".flv",
        "referrer" => "Origin"
    ], [
        "match" => "pan.cuan.la",
        "referrer" => "Origin"
    ], [
        "match" => "pan.metct.com",
        "referrer" => "Origin"
    ], [
        "match" => "jx.dd0820.com",
        "referrer" => "Origin"
    ], [
        "match" => "quan.qq.com",
        "referrer" => "Origin"
    ],[
        "match" => ".m3u",
        "referrer" => "Origin"
    ]
];

//检测部分无法使用Dp播放的地址转交给CK播放
//下方写匹配数据 url传入数据 列如
//http://www.miguvideo.com/mgs/website/prd/detail.html?cid=679919978
//将会使用ckPlayer进行播放
$ckPlayerMatch = [
    "fun.tv",
    "miguvideo.com",
    "tv.sohu.com",
    "film.sohu.com"
];

//请按照下方写法
//title = 解析标题
//match = 匹配值 * 通用 多个匹配以 “|”切割
//cache = ["switch"=>(true|开,false|关),"cacheTime"=>"300"] 缓存开关以及单独缓存时间
//player = 特殊解析口,列如地址中含有双?url=,以及需要使用到特殊referrer(true|开,false|关)
//referrer = 特殊功能,player必须为true,该功能需要在群内询问好处理
//url = 解析接口
//spare_url = 备用解析接口
//.m3u8 .mp4 .flv 以外匹的地址会读取该配置
$Parsing = [
        [
        "title" => "解析接口",
        "match" => "",//全局匹配,如果单独匹配无法匹配出来 将会通过 * 值匹配的接口
        "player" => true,//特殊功能,列如想设置referrer需要启动
        "url" => "https://m3u8.tv.janan.net/json.php?url=",//主接口,依旧支持备用接口
        "referrer" => [
           "default" => "never", //默认头禁止来源no-referrer
            "no-referrer" => []
        ]
    ],

    [
        "title" => "解析接口",
        "match" => "qiyi.com|le.com|pptv.com|",//匹配值“|”多个拼接
        "url" => "https://m3u8.tv.janan.net/json.php?url="
   
    ],[
        "title" => "咪咕解析接口",
        "match" => "miguvideo.com|tv.sohu.com|film.sohu.com",//全局匹配,如果单独匹配无法匹配出来 将会通过 * 值匹配的接口
        "player" => true,//特殊功能,列如想设置referrer需要启动
        "url" => "https://m3u8.tv.janan.net/json.php?url=",//主接口,依旧支持备用接口
        "referrer" => [
           "default" => "never", //默认头禁止来源no-referrer
            "no-referrer" => []
        ]

    
    ],[
        "title" => "芒果解析接口",
        "match" => "xigua",//全局匹配,如果单独匹配无法匹配出来 将会通过 * 值匹配的接口
        "player" => false,//特殊功能,列如想设置referrer需要启动
        "url" => "https://m3u8.tv.janan.net/json.php?url=",//主接口,依旧支持备用接口
        "referrer" => [
        "default" => "no-referrer", //默认头禁止来源no-referrer
         ]
    ],[
        "title" => "微云解析接口",
        "match" => "_10044|_TZK|_11385|_THK|_TZR",//全局匹配,如果单独匹配无法匹配出来 将会通过 * 值匹配的接口
        "player" => false,//特殊功能,列如想设置referrer需要启动
        "url" => "https://m3u8.tv.janan.net/json.php?url=",//主接口,依旧支持备用接口
        "referrer" => [
        "default" => "no-referrer", //默认头禁止来源no-referrer
         ]         
    ],[
        
        "title" => "西瓜解析接口",
        "match" => "mgtv.com|youku.com|v.qq.com|iqiyi.com",//全局匹配,如果单独匹配无法匹配出来 将会通过 * 值匹配的接口
        "player" => true,//特殊功能,列如想设置referrer需要启动
        "url" => "https://m3u8.tv.janan.net/json.php?url=",//主接口,依旧支持备用接口
        "referrer" => [
           "default" => "origin", //默认头禁止来源no-referrer
            "no-referrer" => [
                "ixigua"
            ]
        ]
    ]
];

return [
    "cacheSwitch" => $cacheSwitch,
    "cacheTime" => $cacheTime,
    "cacheClearToken" => $cacheClearToken,
    "cacheClearTime" => $cacheClearTime,
    "allStatistics" => $allStatistics,
    "urlSupport" => $urlSupport,
    "ckPlayerMatch" => $ckPlayerMatch,
    "dpPlayerNative" => $dpPlayerNative,
    "Parsing" => $Parsing
];