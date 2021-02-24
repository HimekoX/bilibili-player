<?php
$config['Debug'] = false;//Debug模式 启动/关闭
/**
 * 数据库配置项
 */
$config["Mysql_Status"] = true; //启动状态
if($config["Mysql_Status"]){
    $config["Mysql"] = [
        "driver" => "mysql",//数据库类型
        "host" => "localhost",//数据库链接地址
        "database" => "sql_jx_360mb_net",//数据库库名称
        "username" => "sql_jx_360mb_net",//数据库账号
        "password" => "2kcPNNkB5HDw4kk2",//数据库密码
        "charset" => "utf8mb4",//数据库编码
        "collation" => "utf8mb4_unicode_ci",//请勿修改
        "prefix" => "small_",//数据库前缀
    ];
}

/**
 * Redis配置项
 */
$config["Redis_Status"] = false; //启动状态
if($config["Redis_Status"]){
    $config["Redis"] = [
        "hostName" => "127.0.0.1",//Redis链接地址
        "hostPort" => "6379",//Redis链接端口
        "passWord" => "glp2019..",//Redis密码
    ];

}

/**
 * 加密配置项
 */
$config["Algorithm"] = [
    "key" => "small",
    "ikey" => "a871211c7e7ed732",//确保16位
];

/**
 * 系统上传配置文件
 */
$config['Upload'] = [
    "suffix"=> ["png", "jpg", "jpeg", "gif"],
    "size"=> 10000,//单位Mb
];

return $config;