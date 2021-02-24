-- MySQL dump 10.13  Distrib 5.6.48, for Linux (x86_64)
--
-- Host: localhost    Database: bilibili
-- ------------------------------------------------------
-- Server version	5.6.48-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `small_barrage_list`
--

DROP TABLE IF EXISTS `small_barrage_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_barrage_list` (
  `id` varchar(32) NOT NULL COMMENT '弹幕池id',
  `cid` int(8) NOT NULL AUTO_INCREMENT COMMENT '弹幕id',
  `pid` int(8) DEFAULT '0' COMMENT '应用pid',
  `type` varchar(128) NOT NULL COMMENT '弹幕类型',
  `text` varchar(128) NOT NULL COMMENT '弹幕内容',
  `color` varchar(128) NOT NULL COMMENT '弹幕颜色',
  `size` varchar(128) NOT NULL COMMENT '弹幕大小',
  `videotime` float(24,3) NOT NULL COMMENT '时间点',
  `ip` varchar(128) NOT NULL COMMENT '用户ip',
  `time` int(10) NOT NULL COMMENT '发送时间',
  `referer` text NOT NULL COMMENT '弹幕来源网址',
  PRIMARY KEY (`cid`) USING BTREE,
  KEY `id` (`id`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  CONSTRAINT `small_barrage_list_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `small_player` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_barrage_list`
--

LOCK TABLES `small_barrage_list` WRITE;
/*!40000 ALTER TABLE `small_barrage_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `small_barrage_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_barrage_parsing`
--

DROP TABLE IF EXISTS `small_barrage_parsing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_barrage_parsing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `av` varchar(128) DEFAULT NULL COMMENT '弹幕av号',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注信息',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='弹幕解析库';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_barrage_parsing`
--

LOCK TABLES `small_barrage_parsing` WRITE;
/*!40000 ALTER TABLE `small_barrage_parsing` DISABLE KEYS */;
INSERT INTO `small_barrage_parsing` VALUES (1,'17416502','B站Av号'),(2,'84021218','B站Av号 48W条');
/*!40000 ALTER TABLE `small_barrage_parsing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_barrage_report`
--

DROP TABLE IF EXISTS `small_barrage_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_barrage_report` (
  `cid` int(8) NOT NULL COMMENT '弹幕ID',
  `id` varchar(128) NOT NULL COMMENT '弹幕池id',
  `text` varchar(128) NOT NULL COMMENT '举报内容',
  `type` varchar(128) NOT NULL COMMENT '举报类型',
  `time` varchar(128) NOT NULL COMMENT '举报时间',
  `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '发送弹幕的IP地址',
  `referer` text NOT NULL COMMENT '弹幕来源网址',
  PRIMARY KEY (`text`) USING BTREE,
  KEY `id` (`id`) USING BTREE,
  KEY `cid` (`cid`) USING BTREE,
  CONSTRAINT `small_barrage_report_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `small_barrage_list` (`cid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_barrage_report`
--

LOCK TABLES `small_barrage_report` WRITE;
/*!40000 ALTER TABLE `small_barrage_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `small_barrage_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_player`
--

DROP TABLE IF EXISTS `small_player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_player` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '播放器颜色',
  `title` varchar(64) NOT NULL COMMENT '播放器名称',
  `key` varchar(32) NOT NULL COMMENT '集群唯一键',
  `player_video_info` tinyint(2) NOT NULL DEFAULT '0' COMMENT '播放器右键视频信息显示0=关闭,1=开启',
  `player_random_av` tinyint(2) NOT NULL COMMENT '随机AV号(AV库取) 0=关闭,1=开启',
  `player_random_av_content` varchar(64) DEFAULT NULL COMMENT '自定义AV号',
  `player_background` varchar(164) DEFAULT NULL COMMENT '背景图片',
  `player_color` varchar(64) NOT NULL COMMENT '播放器颜色',
  `player_autoplay` tinyint(2) NOT NULL DEFAULT '0' COMMENT '播放器自动播放0=关闭,1=开启',
  `player_barrage_switch` tinyint(2) NOT NULL DEFAULT '0' COMMENT '弹幕开关0=关闭,1=开启',
  `player_barrage_block` varchar(255) DEFAULT NULL COMMENT '弹幕屏蔽字符',
  `player_barrage_interval` tinyint(2) NOT NULL DEFAULT '1' COMMENT '弹幕发送间隔',
  `player_barrage_etiquette` varchar(12) DEFAULT NULL COMMENT '弹幕礼仪文字',
  `player_barrage_etiquette_address` varchar(32) DEFAULT NULL COMMENT '弹幕礼仪地址',
  `player_logo` varchar(255) DEFAULT NULL COMMENT 'LOGO外链地址',
  `player_wait_time` tinyint(2) NOT NULL DEFAULT '2' COMMENT '播放器加载等待时间',
  `player_advertising_switch` tinyint(2) NOT NULL DEFAULT '0' COMMENT '暂停广告开关0=关闭,1=开启',
  `player_advertising_image_address` varchar(255) DEFAULT NULL COMMENT '暂停广告图片地址',
  `player_advertising_address` varchar(128) DEFAULT NULL COMMENT '暂停广告地址',
  `player_marquee_occlude` varchar(6) DEFAULT NULL COMMENT '播放器跑马灯遮挡层',
  `player_marquee_customize` text COMMENT '播放器自定义跑马灯',
  `player_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '播放器状态0=关闭,1=开启',
  PRIMARY KEY (`id`,`key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_player`
--

LOCK TABLES `small_player` WRITE;
/*!40000 ALTER TABLE `small_player` DISABLE KEYS */;
INSERT INTO `small_player` VALUES (16,'测试播放器','xlblog',1,0,'','','#b90df8',0,1,'操ABCDEFGHIJKLMNOPQRSTUVWSYZabcdefghijklmnopqrstuvwsyz',3,'弹幕礼仪','https://www.5mrk.com','',3,1,'https://s3.ax1x.com/2020/12/27/r5KlaF.jpg','http://baidu.com','','<br><marquee width=850 scrollamount=5> <FONT face=楷体_GB2312 color=#ff0000 size=3><STRONG>◆温馨警告:请自行辨别视频中的广告，以免上当受骗◆ <FONT face=楷体_GB2312 color=#0fb4ee size=3><STRONG>文明发弹幕，营造一个和谐的观影氛围</FONT></STRONG></a> </marquee>',1);
/*!40000 ALTER TABLE `small_player` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_player_right_menu`
--

DROP TABLE IF EXISTS `small_player_right_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_player_right_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '应用id',
  `title` varchar(20) DEFAULT NULL COMMENT '标题',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `rank` smallint(6) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  CONSTRAINT `small_player_right_menu_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `small_player` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_player_right_menu`
--

LOCK TABLES `small_player_right_menu` WRITE;
/*!40000 ALTER TABLE `small_player_right_menu` DISABLE KEYS */;
INSERT INTO `small_player_right_menu` VALUES (6,16,'百度一下','http://www.baidu.com',1),(7,16,'小梁博客','http://xlblog.net/admin',10);
/*!40000 ALTER TABLE `small_player_right_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_system_config`
--

DROP TABLE IF EXISTS `small_system_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_system_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(42) NOT NULL COMMENT '键',
  `name` varchar(128) NOT NULL COMMENT '配置名称',
  `options` text NOT NULL COMMENT '配置选项',
  `public` tinyint(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `key` (`key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_system_config`
--

LOCK TABLES `small_system_config` WRITE;
/*!40000 ALTER TABLE `small_system_config` DISABLE KEYS */;
INSERT INTO `small_system_config` VALUES (1,'播放器默认推荐配置','player_default','{\"player_advertising_address\":\"http://baidu.com\",\"player_advertising_image_address\":\"https://img10.360buyimg.com/ddimg/jfs/t1/133888/15/2798/61297/5ef5cd54E69f6dc60/93231446b43a6b1b.jpg\",\"player_advertising_switch\":1,\"player_autoplay\":0,\"player_video_info\":1,\"player_random_av\":0,\"player_random_av_content\":\"\",\"player_barrage_block\":\"操ABCDEFGHIJKLMNOPQRSTUVWSYZabcdefghijklmnopqrstuvwsyz\",\"player_barrage_etiquette\":\"弹幕礼仪\",\"player_barrage_etiquette_address\":\"https://www.5mrk.com\",\"player_barrage_interval\":3,\"player_barrage_switch\":0,\"player_color\":\"#775e80\",\"player_logo\":\"https://cdn.jsdelivr.net/gh/lelege/bilibili/img/logo.png\",\"player_marquee_customize\":\"\",\"player_marquee_occlude\":\"\",\"player_wait_time\":3}',1);
/*!40000 ALTER TABLE `small_system_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_system_dict`
--

DROP TABLE IF EXISTS `small_system_dict`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_system_dict` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '字典名称',
  `code` varchar(42) NOT NULL COMMENT '字典编号',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_system_dict`
--

LOCK TABLES `small_system_dict` WRITE;
/*!40000 ALTER TABLE `small_system_dict` DISABLE KEYS */;
INSERT INTO `small_system_dict` VALUES (1,'菜单管理_权限类型','system_menu_type','权限类型'),(5,'用户管理_用户状态','system_user_status','用户状态');
/*!40000 ALTER TABLE `small_system_dict` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_system_dict_list`
--

DROP TABLE IF EXISTS `small_system_dict_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_system_dict_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '数据名称',
  `dict_id` int(10) unsigned NOT NULL COMMENT '字典ID',
  `val` varchar(64) NOT NULL COMMENT '数据值',
  `status` tinyint(4) NOT NULL COMMENT '状态:0=停用,1=启用',
  `rank` smallint(5) unsigned NOT NULL COMMENT '排序',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `dict_id` (`dict_id`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `rank` (`rank`) USING BTREE,
  CONSTRAINT `small_system_dict_list_ibfk_1` FOREIGN KEY (`dict_id`) REFERENCES `small_system_dict` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_system_dict_list`
--

LOCK TABLES `small_system_dict_list` WRITE;
/*!40000 ALTER TABLE `small_system_dict_list` DISABLE KEYS */;
INSERT INTO `small_system_dict_list` VALUES (1,'菜单',1,'0',1,0,'2020-01-03 20:59:47'),(2,'按钮/权限',1,'1',1,1,'2020-01-05 15:02:28'),(5,'正常',5,'1',1,0,'2020-01-06 16:33:49'),(6,'封禁',5,'0',1,0,'2020-07-16 03:39:25');
/*!40000 ALTER TABLE `small_system_dict_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_system_role`
--

DROP TABLE IF EXISTS `small_system_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_system_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(18) NOT NULL COMMENT '角色名称',
  `status` tinyint(3) unsigned NOT NULL COMMENT '角色状态:0=停用,1=启用',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_system_role`
--

LOCK TABLES `small_system_role` WRITE;
/*!40000 ALTER TABLE `small_system_role` DISABLE KEYS */;
INSERT INTO `small_system_role` VALUES (1,'超级管理员',1),(2,'管理员',1);
/*!40000 ALTER TABLE `small_system_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_system_role_router`
--

DROP TABLE IF EXISTS `small_system_role_router`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_system_role_router` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `router_id` int(10) unsigned NOT NULL COMMENT '权限id',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色id',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `router_id` (`router_id`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `small_system_role_router_ibfk_1` FOREIGN KEY (`router_id`) REFERENCES `small_system_router` (`id`) ON DELETE CASCADE,
  CONSTRAINT `small_system_role_router_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `small_system_role` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4367 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_system_role_router`
--

LOCK TABLES `small_system_role_router` WRITE;
/*!40000 ALTER TABLE `small_system_role_router` DISABLE KEYS */;
INSERT INTO `small_system_role_router` VALUES (4246,1,1),(4247,2,1),(4248,30,1),(4249,31,1),(4250,32,1),(4251,3,1),(4252,4,1),(4253,33,1),(4254,34,1),(4255,5,1),(4256,6,1),(4257,27,1),(4258,28,1),(4259,29,1),(4260,7,1),(4261,8,1),(4262,11,1),(4263,16,1),(4264,9,1),(4265,10,1),(4266,21,1),(4267,22,1),(4268,23,1),(4269,24,1),(4270,25,1),(4271,26,1),(4272,17,1),(4273,18,1),(4274,19,1),(4275,20,1),(4276,35,1),(4277,36,1),(4278,37,1),(4279,38,1),(4280,48,1),(4281,151,1),(4282,142,1),(4283,143,1),(4284,144,1),(4285,145,1),(4286,146,1),(4287,147,1),(4288,148,1),(4289,149,1),(4290,150,1),(4291,152,1),(4292,153,1),(4293,154,1),(4294,156,1),(4295,157,1),(4296,158,1),(4297,155,1),(4298,159,1),(4299,160,1),(4300,161,1),(4301,162,1),(4302,163,1),(4303,164,1),(4335,1,2),(4336,2,2),(4337,30,2),(4338,31,2),(4339,32,2),(4340,3,2),(4341,4,2),(4342,33,2),(4343,34,2),(4344,151,2),(4345,142,2),(4346,143,2),(4347,144,2),(4348,145,2),(4349,146,2),(4350,147,2),(4351,148,2),(4352,149,2),(4353,150,2),(4354,152,2),(4355,153,2),(4356,154,2),(4357,156,2),(4358,157,2),(4359,158,2),(4360,155,2),(4361,159,2),(4362,160,2),(4363,161,2),(4364,162,2),(4365,163,2),(4366,164,2);
/*!40000 ALTER TABLE `small_system_role_router` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_system_router`
--

DROP TABLE IF EXISTS `small_system_router`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_system_router` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL COMMENT '权限路径',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级权限',
  `name` varchar(18) NOT NULL COMMENT '权限名称',
  `status` tinyint(4) NOT NULL COMMENT '状态:0=停用,1=启用',
  `face` varchar(128) DEFAULT NULL COMMENT '图标',
  `type` tinyint(4) NOT NULL COMMENT '类型:0=菜单,1=路由权限/按钮',
  `rank` smallint(6) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_system_router`
--

LOCK TABLES `small_system_router` WRITE;
/*!40000 ALTER TABLE `small_system_router` DISABLE KEYS */;
INSERT INTO `small_system_router` VALUES (1,'dashboard',0,'仪表盘',1,'layui-icon-home',0,0),(2,'console',1,'控制台',1,'layui-icon-water',0,0),(3,'/system/user/getMeInfo',32,'获取自己的信息',1,'layui-icon-water',1,0),(4,'/system/user/getMenu',32,'获取菜单列表',1,'layui-icon-water',1,0),(5,'system',0,'系统管理',1,'layui-icon-set',0,5),(6,'user',5,'用户管理',1,'',0,1),(7,'menu',5,'菜单管理',1,'',0,5),(8,'/system/menu/getMenus',7,'获取全部菜单',1,NULL,1,0),(9,'dict',5,'数据字典',1,'',0,6),(10,'/system/dict/getDict',9,'获取字典数据',1,NULL,1,0),(11,'/system/menu/saveMenu',7,'保存菜单',1,NULL,1,0),(16,'/system/menu/delMenu',7,'删除菜单',1,'',1,0),(17,'role',5,'角色管理',1,'',0,2),(18,'/system/role/getRoles',17,'获取权限列表',1,'',1,0),(19,'/system/role/saveRole',17,'保存角色',1,'',1,0),(20,'/system/role/delRole',17,'删除角色',1,'',1,0),(21,'/system/dict/getDicts',9,'获取全部字典数据',1,'',1,0),(22,'/system/dict/saveDict',9,'保存数据字典',1,'',1,0),(23,'/system/dict/delDict',9,'删除字典',1,'',1,0),(24,'/system/dict/list/getDictLists',9,'获取数据列表',1,'',1,0),(25,'/system/dict/list/saveDictValue',9,'保存字典数据值',1,'',1,0),(26,'/system/dict/list/delDictValue',9,'删除字典数据',1,'',1,0),(27,'/system/user/getUsers',6,'获取用户列表',1,'',1,0),(28,'/system/user/saveUser',6,'保存用户',1,'',1,0),(29,'/system/user/delUser',6,'删除用户',1,'',1,0),(30,'other',1,'其他功能',0,'',0,3),(31,'/system/other/upload',30,'文件上传',1,NULL,1,0),(32,'personal',1,'个人中心',0,'',0,4),(33,'/system/user/editMeInfo',32,'修改资料',1,'',1,0),(34,'/system/user/logout',32,'安全注销',1,NULL,1,0),(35,'config',5,'配置管理',1,'',0,7),(36,'/system/config/getConfigs',35,'获取配置列表',1,NULL,1,0),(37,'/system/config/saveConfig',35,'保存配置',1,NULL,1,0),(38,'/system/config/delConfig',35,'删除配置',1,NULL,1,0),(48,'/system/config/getPrivatelyConfig',35,'获取键配置',1,NULL,1,0),(142,'player',0,'集群管理',1,'layui-icon-template-1',0,1),(143,'list',142,'管理列表',1,'',0,0),(144,'/system/player/getPlayerList',143,'获取集群列表',1,'',1,0),(145,'/system/player/savePlayer',143,'保存集群信息',1,'',1,0),(146,'/system/player/delPlayer',143,'删除集群信息',1,'',1,0),(147,'/system/player/getPlayerConfig',143,'获取应用配置',1,'',1,0),(148,'#',142,'配置管理',0,'',0,0),(149,'/system/player/rightmenu/getRightMenuList',148,'获取右键菜单列表',1,'',1,0),(150,'/system/player/rightmenu/saveRightMenu',148,'保存右键菜单',1,'',1,0),(151,'/system/config/getConfig',1,'获取单独配置',1,'',1,0),(152,'/system/player/rightmenu/delRightMenu',148,'删除右键菜单数据',1,'',1,0),(153,'barrage',0,'弹幕系统',1,'layui-icon-chat',0,2),(154,'list',153,'弹幕列表',1,'',0,0),(155,'report',153,'举报列表',1,'',0,1),(156,'/system/barrage/getBarrageList',154,'获取弹幕列表',1,'',1,0),(157,'/system/barrage/delBarrage',154,'删除弹幕',1,'',1,2),(158,'/system/barrage/saveBarrage',154,'保存弹幕',1,'',1,0),(159,'/system/barrage/getReportList',155,'获取举报列表',1,'',1,0),(160,'/system/barrage/delReport',155,'误报删除',1,'',1,0),(161,'randBarrage',153,'弹幕AV库',1,'',0,2),(162,'/system/barrage/parsing/getParsingList',161,'获取弹幕AV列表',1,'',1,0),(163,'/system/barrage/parsing/saveParsing',161,'保存AV数据',1,'',1,0),(164,'/system/barrage/parsing/delParsing',161,'删除AV数据',1,'',1,0);
/*!40000 ALTER TABLE `small_system_router` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_system_user`
--

DROP TABLE IF EXISTS `small_system_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_system_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(18) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `face` varchar(128) DEFAULT NULL COMMENT '头像',
  `phone` varchar(13) DEFAULT NULL COMMENT '手机号',
  `nickname` varchar(24) DEFAULT NULL COMMENT '呢称',
  `salt` varchar(32) NOT NULL,
  `login_date` datetime DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `login_ip` varchar(16) DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '状态:0=停用,1=启用',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `user` (`user`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_system_user`
--

LOCK TABLES `small_system_user` WRITE;
/*!40000 ALTER TABLE `small_system_user` DISABLE KEYS */;
INSERT INTO `small_system_user` VALUES (1,'admin','e7629fd037f78d219f176f03f861a1bd','/runtime/upload/202007311922532498752.jpg','13800138000','小奈绪','e6632bccadfb62f2113cb3b4c82dac89','2020-12-27 12:17:05','2020-08-14 14:21:18','223.74.39.186',1),(2,'Administrator','fce89e80e9cb31f2cd08c3ddc4bd834a','/runtime/upload/202008112159076195090.jpg','','','6ba0f9080e292b66530908ff9a969df4','2020-08-14 15:02:04','2020-08-14 15:03:29','123.150.145.250',0);
/*!40000 ALTER TABLE `small_system_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `small_system_user_role`
--

DROP TABLE IF EXISTS `small_system_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `small_system_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `role_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `small_system_user_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `small_system_role` (`id`) ON DELETE CASCADE,
  CONSTRAINT `small_system_user_role_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `small_system_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_system_user_role`
--

LOCK TABLES `small_system_user_role` WRITE;
/*!40000 ALTER TABLE `small_system_user_role` DISABLE KEYS */;
INSERT INTO `small_system_user_role` VALUES (84,1,2),(85,2,1);
/*!40000 ALTER TABLE `small_system_user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-27 12:25:40
