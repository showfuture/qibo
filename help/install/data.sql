INSERT INTO `qb_module` (`id`, `type`, `name`, `pre`, `dirname`, `domain`, `admindir`, `config`, `list`, `admingroup`, `adminmember`, `ifclose`, `ifsys`) VALUES (20, 2, '公告资讯', 'help_', 'help', '', '', 'a:7:{s:12:"list_PhpName";s:18:"list.php?&fid=$fid";s:12:"show_PhpName";s:29:"bencandy.php?&fid=$fid&id=$id";s:8:"MakeHtml";N;s:14:"list_HtmlName1";N;s:14:"show_HtmlName1";N;s:14:"list_HtmlName2";N;s:14:"show_HtmlName2";N;}', 102, '', '', 0, 0);

INSERT INTO `qb_label` (`name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES('', 0, 0, 'help_index_slides', 'rollpic', 0, 'a:7:{s:13:"tplpart_1code";s:587:"<TABLE id="pictable" style="DISPLAY: none">\r\n <TBODY>\r\n<!--\r\nEOT;\r\nforeach($listdb AS $key=>$rs){@extract($rs);\r\nprint <<<EOT\r\n-->\r\n   <tr>\r\n    <td><img src="$picurl"/></td>\r\n    <td> $title</td>\r\n    <td>$url</td>\r\n   </tr>\r\n<!--\r\nEOT;\r\n}\r\nprint <<<EOT\r\n-->\r\n </TBODY>\r\n</TABLE>\r\n<link rel="stylesheet" type="text/css" href="http://www_qibosoft_com/help/images/default/slide.css">\r\n<SCRIPT LANGUAGE="JavaScript" src="http://www_qibosoft_com/help/images/default/slide.js"></SCRIPT>\r\n<SCRIPT LANGUAGE="JavaScript" src="http://www_qibosoft_com/help/images/default/show_slide.js"></SCRIPT>";s:8:"rolltype";s:1:"2";s:5:"width";s:0:"";s:6:"height";s:0:"";s:6:"picurl";a:5:{i:1;s:28:"../help/images/default/1.jpg";i:2;s:28:"../help/images/default/2.jpg";i:3;s:28:"../help/images/default/3.jpg";i:4;s:28:"../help/images/default/4.jpg";i:5;s:28:"../help/images/default/5.jpg";}s:7:"piclink";a:5:{i:1;s:23:"http://www.qibosoft.com";i:2;s:23:"http://bbs.qibosoft.com";i:3;s:23:"http://www.qibosoft.com";i:4;s:23:"http://bbs.qibosoft.com";i:5;s:23:"http://www.qibosoft.com";}s:6:"picalt";a:5:{i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";i:5;s:1:"5";}}', 'a:3:{s:5:"div_w";s:3:"637";s:5:"div_h";s:3:"216";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1345538239, 0, 20, 0, 0, 'green_tpl');
INSERT INTO `qb_label` (`name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES('', 0, 0, 'help_index_h1', 'code', 0, '最新公告信息', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 20, 0, 0, 'green_tpl');
INSERT INTO `qb_label` (`name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES('', 0, 0, 'help_index_t1', 'Info_help_', 1, 'a:36:{s:13:"tplpart_1code";s:65:"<div class="list"><a href="$url" target="_blank">$title</a></div>";s:13:"tplpart_2code";s:0:"";s:3:"SYS";s:2:"wn";s:6:"wninfo";s:5:"help_";s:9:"noReadMid";s:0:"";s:13:"RollStyleType";s:0:"";s:7:"fidtype";s:1:"0";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:7:"newhour";s:2:"24";s:7:"hothits";s:3:"100";s:7:"amodule";N;s:7:"tplpath";s:24:"/common_title/0title.jpg";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:5:"stype";s:1:"t";s:2:"yz";s:1:"1";s:7:"hidefid";N;s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:10:"A.posttime";s:3:"asc";s:4:"DESC";s:6:"levels";s:3:"all";s:7:"rowspan";s:1:"8";s:3:"sql";s:86:" SELECT A.* FROM qb_help_content A  WHERE A.yz=1   ORDER BY A.posttime DESC LIMIT 0,8 ";s:4:"sql2";N;s:7:"colspan";s:1:"1";s:11:"content_num";s:2:"80";s:12:"content_num2";s:3:"120";s:8:"titlenum";s:2:"50";s:9:"titlenum2";s:2:"40";s:10:"titleflood";s:1:"0";s:9:"start_num";s:1:"1";s:10:"c_rolltype";s:1:"0";}', 'a:3:{s:5:"div_w";s:2:"50";s:5:"div_h";s:2:"30";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1345601439, 0, 20, 0, 0, 'green_tpl');
INSERT INTO `qb_label` (`name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES('', 0, 0, 'help_index_h2', 'code', 0, '热门公告信息', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 20, 0, 0, 'green_tpl');
INSERT INTO `qb_label` (`name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES('', 0, 0, 'help_index_t2', 'Info_help_', 1, 'a:36:{s:13:"tplpart_1code";s:65:"<div class="list"><a href="$url" target="_blank">$title</a></div>";s:13:"tplpart_2code";s:0:"";s:3:"SYS";s:2:"wn";s:6:"wninfo";s:5:"help_";s:9:"noReadMid";s:0:"";s:13:"RollStyleType";s:0:"";s:7:"fidtype";s:1:"0";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:7:"newhour";s:2:"24";s:7:"hothits";s:3:"100";s:7:"amodule";N;s:7:"tplpath";s:0:"";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:5:"stype";s:1:"4";s:2:"yz";s:1:"1";s:7:"hidefid";N;s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:6:"A.hits";s:3:"asc";s:4:"DESC";s:6:"levels";s:3:"all";s:7:"rowspan";s:1:"5";s:3:"sql";s:82:" SELECT A.* FROM qb_help_content A  WHERE A.yz=1   ORDER BY A.hits DESC LIMIT 0,5 ";s:4:"sql2";N;s:7:"colspan";s:1:"1";s:11:"content_num";s:2:"80";s:12:"content_num2";s:3:"120";s:8:"titlenum";s:2:"50";s:9:"titlenum2";s:2:"40";s:10:"titleflood";s:1:"0";s:9:"start_num";s:1:"1";s:10:"c_rolltype";s:1:"0";}', 'a:3:{s:5:"div_w";s:2:"50";s:5:"div_h";s:2:"30";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 20, 0, 0, 'green_tpl');

    

# --------------------------------------------------------

#
# 表的结构 `qb_help_comments`
#

DROP TABLE IF EXISTS `qb_help_comments`;
CREATE TABLE `qb_help_comments` (
  `cid` mediumint(7) unsigned NOT NULL auto_increment,
  `id` int(10) unsigned NOT NULL default '0',
  `fid` mediumint(7) unsigned NOT NULL default '0',
  `cuid` mediumint(7) NOT NULL default '0',
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `posttime` int(10) NOT NULL default '0',
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  `icon` tinyint(3) NOT NULL default '0',
  `yz` tinyint(1) NOT NULL default '0',
  `ifcom` tinyint(1) NOT NULL default '0',
  `agree` mediumint(5) NOT NULL default '0',
  `disagree` mediumint(5) NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `aid` (`id`),
  KEY `fid` (`fid`),
  KEY `uid` (`uid`),
  KEY `ifcom` (`ifcom`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# 导出表中的数据 `qb_help_comments`
#

INSERT INTO `qb_help_comments` VALUES (1, 1, 3, 1, 1, 'admin', 1345628561, '大', '127.0.0.1', 0, 1, 0, 0, 0);
INSERT INTO `qb_help_comments` VALUES (2, 1, 3, 1, 1, 'admin', 1345690099, 'fff', '127.0.0.1', 0, 1, 0, 0, 0);

# --------------------------------------------------------

#
# 表的结构 `qb_help_config`
#

DROP TABLE IF EXISTS `qb_help_config`;
CREATE TABLE `qb_help_config` (
  `c_key` varchar(50) NOT NULL default '',
  `c_value` text NOT NULL,
  `c_descrip` text NOT NULL,
  PRIMARY KEY  (`c_key`)
) TYPE=MyISAM;

#
# 导出表中的数据 `qb_help_config`
#

INSERT INTO `qb_help_config` VALUES ('Info_metakeywords', '帮助中心', '');
INSERT INTO `qb_help_config` VALUES ('Info_webOpen', '1', '');
INSERT INTO `qb_help_config` VALUES ('Info_webname', '公告资讯', '');
INSERT INTO `qb_help_config` VALUES ('Info_description', '', '');
INSERT INTO `qb_help_config` VALUES ('module_close', '0', '');
INSERT INTO `qb_help_config` VALUES ('module_pre', 'help_', '');
INSERT INTO `qb_help_config` VALUES ('module_id', '20', '');
INSERT INTO `qb_help_config` VALUES ('Info_PostCommentType', '0', '');
INSERT INTO `qb_help_config` VALUES ('Info_PassCommentType', '0', '');
INSERT INTO `qb_help_config` VALUES ('Info_ShowCommentRows', '', '');

# --------------------------------------------------------

#
# 表的结构 `qb_help_content`
#

DROP TABLE IF EXISTS `qb_help_content`;
CREATE TABLE `qb_help_content` (
  `id` mediumint(7) unsigned NOT NULL auto_increment,
  `title` varchar(150) NOT NULL default '',
  `smalltitle` varchar(100) NOT NULL default '',
  `fid` mediumint(7) unsigned NOT NULL default '0',
  `mid` mediumint(5) NOT NULL default '0',
  `fname` varchar(50) NOT NULL default '',
  `hits` mediumint(7) NOT NULL default '0',
  `pages` smallint(4) NOT NULL default '0',
  `comments` mediumint(7) NOT NULL default '0',
  `posttime` int(10) NOT NULL default '0',
  `list` int(10) NOT NULL default '0',
  `uid` mediumint(7) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `author` varchar(30) NOT NULL default '',
  `copyfrom` varchar(100) NOT NULL default '',
  `copyfromurl` varchar(150) NOT NULL default '',
  `titlecolor` varchar(15) NOT NULL default '',
  `fonttype` tinyint(1) NOT NULL default '0',
  `picurl` varchar(150) NOT NULL default '0',
  `ispic` tinyint(1) NOT NULL default '0',
  `yz` tinyint(1) NOT NULL default '0',
  `yzer` varchar(30) NOT NULL default '',
  `yztime` int(10) NOT NULL default '0',
  `levels` tinyint(2) NOT NULL default '0',
  `levelstime` int(10) NOT NULL default '0',
  `keywords` varchar(100) NOT NULL default '',
  `jumpurl` varchar(150) NOT NULL default '',
  `iframeurl` varchar(150) NOT NULL default '',
  `style` varchar(15) NOT NULL default '',
  `template` varchar(255) NOT NULL default '',
  `target` tinyint(1) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `lastfid` mediumint(7) NOT NULL default '0',
  `money` mediumint(7) NOT NULL default '0',
  `buyuser` text NOT NULL,
  `passwd` varchar(32) NOT NULL default '',
  `allowdown` varchar(150) NOT NULL default '',
  `allowview` varchar(150) NOT NULL default '',
  `editer` varchar(30) NOT NULL default '',
  `edittime` int(10) NOT NULL default '0',
  `begintime` int(10) NOT NULL default '0',
  `endtime` int(10) NOT NULL default '0',
  `description` text NOT NULL,
  `lastview` int(10) NOT NULL default '0',
  `digg_num` mediumint(7) NOT NULL default '0',
  `digg_time` int(10) NOT NULL default '0',
  `forbidcomment` tinyint(1) NOT NULL default '0',
  `ifvote` tinyint(1) NOT NULL default '0',
  `heart` varchar(255) NOT NULL default '',
  `htmlname` varchar(100) NOT NULL default '',
  `city_id` mediumint(7) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `fid` (`fid`),
  KEY `hits` (`hits`,`yz`,`fid`,`ispic`),
  KEY `list` (`list`,`yz`,`fid`,`ispic`),
  KEY `ispic` (`ispic`),
  KEY `uid` (`uid`),
  KEY `levels` (`levels`),
  KEY `digg_num` (`digg_num`),
  KEY `digg_time` (`digg_time`),
  KEY `mid` (`mid`),
  KEY `city_id` (`city_id`),
  KEY `posttime` (`yz`,`posttime`,`fid`,`ispic`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# 导出表中的数据 `qb_help_content`
#

INSERT INTO `qb_help_content` VALUES (1, '关于推广赚取积分的事项详细说明', '', 3, 1, '积分说明', 51, 0, 2, 1345628490, 1749397062, 1, 'admin', '', '', '', '', 0, '', 0, 1, '', 0, 1, 0, '', '', '', '', '', 0, '127.0.0.1', 0, 0, '', '', '', '', '', 0, 0, 0, '', 1346383063, 0, 0, 0, 0, '', '', 0);
INSERT INTO `qb_help_content` VALUES (2, '严禁发布色情及违法相关信息,一经发现,严肃处理,后果自负', '', 7, 1, '注意事项', 3, 0, 0, 1345692494, 1345692494, 1, 'admin', '', '', '', '', 0, '', 0, 1, '', 0, 0, 0, '', '', '', '', '', 0, '127.0.0.1', 0, 0, '', '', '', '', '', 0, 0, 0, '', 1345692849, 0, 0, 0, 0, '', '', 1);
INSERT INTO `qb_help_content` VALUES (3, '欢迎大家注册成为会员,可以享受更多的权限!', '', 2, 1, '会员权限说明', 3, 0, 0, 1345692839, 1345692839, 1, 'admin', '', '', '', '', 0, '', 0, 1, '', 0, 0, 0, '', '', '', '', '', 0, '127.0.0.1', 0, 0, '', '', '', '', '', 0, 0, 0, '', 1346126303, 0, 0, 0, 0, '', '', 1);

# --------------------------------------------------------

#
# 表的结构 `qb_help_content_1`
#

DROP TABLE IF EXISTS `qb_help_content_1`;
CREATE TABLE `qb_help_content_1` (
  `rid` mediumint(7) NOT NULL auto_increment,
  `subhead` varchar(150) NOT NULL default '',
  `id` mediumint(7) NOT NULL default '0',
  `fid` mediumint(7) NOT NULL default '0',
  `uid` mediumint(7) NOT NULL default '0',
  `topic` tinyint(1) NOT NULL default '0',
  `content` mediumtext NOT NULL,
  `orderid` mediumint(7) NOT NULL default '0',
  PRIMARY KEY  (`rid`),
  KEY `aid` (`id`,`topic`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# 导出表中的数据 `qb_help_content_1`
#

INSERT INTO `qb_help_content_1` VALUES (1, '', 1, 3, 1, 1, '<p>大家只要把以下网址</p><p>http://www_qibosoft_com/do/job.php?job=propagandize&amp;uid=1<br /></p><p>转发给你的好友,或者是各大论坛,只要有人访问了,你就可以获取2个积分的奖励</p><p><br /></p><p>如果用户成功注册的话,还将额外得到5个积分的奖励</p><p><br /></p><p>若成功注册的用户再推荐其它用户的话,不仅他可以得到奖励,你同时也会得到奖励,因为他们都将属于你的下线.</p>', 0);
INSERT INTO `qb_help_content_1` VALUES (2, '', 2, 7, 1, 1, '<p>如题所示,一经发现,严肃处理,并提交相关IP来源信息给公安机关等相关部门处理.</p>', 0);
INSERT INTO `qb_help_content_1` VALUES (3, '', 3, 2, 1, 1, '<p>如果有必要的话,欢迎大家升级为VIP会员,权限更多!!</p>', 0);

# --------------------------------------------------------

#
# 表的结构 `qb_help_sort`
#

DROP TABLE IF EXISTS `qb_help_sort`;
CREATE TABLE `qb_help_sort` (
  `fid` mediumint(7) unsigned NOT NULL auto_increment,
  `fup` mediumint(7) unsigned NOT NULL default '0',
  `mid` mediumint(5) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `class` smallint(4) NOT NULL default '0',
  `sons` smallint(4) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '0',
  `admin` varchar(100) NOT NULL default '',
  `list` int(10) NOT NULL default '0',
  `listorder` tinyint(2) NOT NULL default '0',
  `passwd` varchar(32) NOT NULL default '',
  `logo` varchar(150) NOT NULL default '',
  `descrip` text NOT NULL,
  `style` varchar(50) NOT NULL default '',
  `template` text NOT NULL,
  `jumpurl` varchar(150) NOT NULL default '',
  `maxperpage` tinyint(3) NOT NULL default '0',
  `metakeywords` varchar(255) NOT NULL default '',
  `metadescription` varchar(255) NOT NULL default '',
  `allowcomment` tinyint(1) NOT NULL default '0',
  `allowpost` varchar(150) NOT NULL default '',
  `allowviewtitle` varchar(150) NOT NULL default '',
  `allowviewcontent` varchar(150) NOT NULL default '',
  `allowdownload` varchar(150) NOT NULL default '',
  `forbidshow` tinyint(1) NOT NULL default '0',
  `config` text NOT NULL,
  `list_html` varchar(255) NOT NULL default '',
  `bencandy_html` varchar(255) NOT NULL default '',
  `domain` varchar(150) NOT NULL default '',
  `domain_dir` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`fid`),
  KEY `fup` (`fup`),
  KEY `fmid` (`mid`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

#
# 导出表中的数据 `qb_help_sort`
#

INSERT INTO `qb_help_sort` VALUES (1, 0, 1, '新手入门', 1, 3, 1, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '', '', '');
INSERT INTO `qb_help_sort` VALUES (2, 1, 0, '会员权限说明', 2, 0, 0, '', 0, 0, '', '', '', '', 'a:4:{s:4:"head";s:0:"";s:4:"foot";s:0:"";s:4:"list";s:0:"";s:8:"bencandy";s:0:"";}', '', 0, '', '', 1, '3', '', '', '', 0, 'a:7:{s:11:"sonTitleRow";N;s:12:"sonTitleLeng";N;s:9:"cachetime";N;s:12:"sonListorder";N;s:14:"listContentNum";N;s:12:"ListShowType";N;s:11:"field_value";N;}', '', '', '', '');
INSERT INTO `qb_help_sort` VALUES (3, 1, 0, '积分说明', 2, 0, 0, '', 0, 0, '', '', '', '', 'a:4:{s:4:"head";s:0:"";s:4:"foot";s:0:"";s:4:"list";s:0:"";s:8:"bencandy";s:0:"";}', '', 0, '', '', 1, '3', '', '', '', 0, 'a:7:{s:11:"sonTitleRow";N;s:12:"sonTitleLeng";N;s:9:"cachetime";N;s:12:"sonListorder";N;s:14:"listContentNum";N;s:12:"ListShowType";N;s:11:"field_value";N;}', '', '', '', '');
INSERT INTO `qb_help_sort` VALUES (4, 0, 0, '网站信息', 1, 2, 1, '', 0, 0, '', '', '', '', 'a:4:{s:4:"head";s:0:"";s:4:"foot";s:0:"";s:4:"list";s:0:"";s:8:"bencandy";s:0:"";}', '', 0, '', '', 0, '', '', '', '', 0, 'a:7:{s:11:"sonTitleRow";N;s:12:"sonTitleLeng";N;s:9:"cachetime";N;s:12:"sonListorder";N;s:14:"listContentNum";N;s:12:"ListShowType";N;s:11:"field_value";N;}', '', '', '', '');
INSERT INTO `qb_help_sort` VALUES (5, 4, 0, '底部导航', 2, 0, 0, '', 0, 0, '', '', '', '', 'a:4:{s:4:"head";s:0:"";s:4:"foot";s:0:"";s:4:"list";s:0:"";s:8:"bencandy";s:0:"";}', '', 0, '', '', 1, '3', '', '', '', 0, 'a:7:{s:11:"sonTitleRow";N;s:12:"sonTitleLeng";N;s:9:"cachetime";N;s:12:"sonListorder";N;s:14:"listContentNum";N;s:12:"ListShowType";N;s:11:"field_value";N;}', '', '', '', '');
INSERT INTO `qb_help_sort` VALUES (6, 4, 0, '公司动态', 2, 0, 0, '', 0, 0, '', '', '', '', 'a:4:{s:4:"head";s:0:"";s:4:"foot";s:0:"";s:4:"list";s:0:"";s:8:"bencandy";s:0:"";}', '', 0, '', '', 1, '3', '', '', '', 0, 'a:7:{s:11:"sonTitleRow";N;s:12:"sonTitleLeng";N;s:9:"cachetime";N;s:12:"sonListorder";N;s:14:"listContentNum";N;s:12:"ListShowType";N;s:11:"field_value";N;}', '', '', '', '');
INSERT INTO `qb_help_sort` VALUES (7, 1, 0, '注意事项', 2, 0, 0, '', 0, 0, '', '', '', '', 'a:4:{s:4:"head";s:0:"";s:4:"foot";s:0:"";s:4:"list";s:0:"";s:8:"bencandy";s:0:"";}', '', 0, '', '', 1, '3', '', '', '', 0, 'a:7:{s:11:"sonTitleRow";N;s:12:"sonTitleLeng";N;s:9:"cachetime";N;s:12:"sonListorder";N;s:14:"listContentNum";N;s:12:"ListShowType";N;s:11:"field_value";N;}', '', '', '', '');
