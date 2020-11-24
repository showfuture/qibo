INSERT INTO `qb_module` (`id`, `type`, `name`, `pre`, `dirname`, `domain`, `admindir`, `config`, `list`, `admingroup`, `adminmember`, `ifclose`) VALUES (16, 2, '黄页店铺', 'hy_', 'hy', '', '', 'a:7:{s:12:"list_PhpName";s:18:"list.php?&fid=$fid";s:12:"show_PhpName";s:29:"bencandy.php?&fid=$fid&id=$id";s:8:"MakeHtml";N;s:14:"list_HtmlName1";N;s:14:"show_HtmlName1";N;s:14:"list_HtmlName2";N;s:14:"show_HtmlName2";N;}', 101, '', '', 0);


INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_1', 'rollpic', 0, 'a:6:{s:8:"rolltype";s:1:"0";s:5:"width";s:3:"250";s:6:"height";s:3:"170";s:6:"picurl";a:2:{i:1;s:32:"label/1_20101123121104_vcrd7.jpg";i:2;s:32:"label/1_20101123121109_ud6ep.jpg";}s:7:"piclink";a:2:{i:1;s:1:"#";i:2;s:1:"#";}s:6:"picalt";a:2:{i:1;s:0:"";i:2;s:0:"";}}', 'a:3:{s:5:"div_w";s:3:"248";s:5:"div_h";s:3:"168";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290488506, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_10', 'Info_hy_', 1, 'a:28:{s:13:"tplpart_1code";s:737:"<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable table1">\r\n                  <tr>\r\n                    \r\n                <td class="img"><span>$i</span><a href="$webdb[www_url]/home/?uid=$uid" target="_blank"><img src="$picurl" onerror="this.src=\'$webdb[www_url]/images/default/nopic.jpg\'" width="60" height="45" border="0"/></a></td>\r\n                    <td class="word">\r\n                    	<div class="t"><a href="$webdb[www_url]/home/?uid=$uid" target="_blank">$title</a></div>\r\n                        <div class="c">关注度 <span>$hits</span> 次</div>\r\n                        <div class="c">点评数 {$dianping}  条</div>\r\n                    </td>\r\n                  </tr>\r\n                </table>";s:13:"tplpart_2code";s:0:"";s:3:"SYS";s:7:"company";s:7:"typefid";N;s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:11:"content_num";s:2:"80";s:7:"newhour";s:2:"24";s:7:"hothits";s:2:"30";s:7:"tplpath";s:0:"";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:8:"moduleid";N;s:5:"stype";s:1:"p";s:2:"yz";s:3:"all";s:8:"renzheng";s:3:"all";s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:3:"rid";s:3:"asc";s:4:"DESC";s:6:"levels";s:3:"all";s:7:"rowspan";s:1:"4";s:3:"sql";s:90:"SELECT * FROM qb_hy_company  WHERE city_id=\'$GLOBALS[city_id]\'  ORDER BY rid DESC LIMIT 4 ";s:7:"colspan";s:1:"1";s:8:"titlenum";s:2:"20";s:10:"titleflood";s:1:"0";}', 'a:3:{s:5:"div_w";s:3:"180";s:5:"div_h";s:3:"262";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1292061088, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_11', 'article', 1, 'a:32:{s:13:"tplpart_1code";s:106:"   <div class="listb l$i"><a href="$url" target="_blank">$title</a><span>{$time_m} -{$time_d}</span></div>";s:13:"tplpart_2code";s:212:"<div class="lista l0">\r\n                        <div class="t"><a href="$url" target="_blank">$title</a></div>\r\n                        <div class="c">$content</div>\r\n                    </div>\r\n                 ";s:3:"SYS";s:7:"artcile";s:13:"RollStyleType";s:0:"";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:7:"newhour";s:2:"24";s:7:"hothits";s:3:"100";s:7:"amodule";s:1:"0";s:7:"tplpath";s:24:"/common_zh_pic/zh_pc.jpg";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:5:"stype";s:1:"t";s:2:"yz";s:1:"1";s:7:"hidefid";N;s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:6:"A.list";s:3:"asc";s:4:"DESC";s:6:"levels";s:3:"all";s:7:"rowspan";s:1:"6";s:3:"sql";s:197:" SELECT A.*,A.aid AS id,R.content FROM qb_article A LEFT JOIN qb_reply R ON A.aid=R.aid   WHERE A.yz=1 AND A.city_id=\'$GLOBALS[city_id]\'  AND A.mid=\'0\'   AND R.topic=1 ORDER BY A.list DESC LIMIT 7 ";s:4:"sql2";N;s:7:"colspan";s:1:"1";s:11:"content_num";s:2:"80";s:12:"content_num2";s:3:"100";s:8:"titlenum";s:2:"40";s:9:"titlenum2";s:2:"36";s:10:"titleflood";s:1:"0";s:10:"c_rolltype";s:1:"0";}', 'a:3:{s:5:"div_w";s:3:"303";s:5:"div_h";s:3:"249";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1292061078, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_15', 'article', 1, 'a:32:{s:13:"tplpart_1code";s:66:"<div class="list"><a href="$url" target="_blank">$title</a></div> ";s:13:"tplpart_2code";s:0:"";s:3:"SYS";s:7:"artcile";s:13:"RollStyleType";s:0:"";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:7:"newhour";s:2:"24";s:7:"hothits";s:3:"100";s:7:"amodule";s:1:"0";s:7:"tplpath";s:0:"";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:5:"stype";s:1:"4";s:2:"yz";s:1:"1";s:7:"hidefid";N;s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:6:"A.list";s:3:"asc";s:4:"DESC";s:6:"levels";s:3:"all";s:7:"rowspan";s:1:"2";s:3:"sql";s:136:" SELECT A.*,A.aid AS id FROM qb_article A  WHERE A.yz=1 AND A.city_id=\'$GLOBALS[city_id]\'  AND A.mid=\'0\'   ORDER BY A.list DESC LIMIT 2 ";s:4:"sql2";N;s:7:"colspan";s:1:"1";s:11:"content_num";s:2:"80";s:12:"content_num2";s:3:"120";s:8:"titlenum";s:2:"34";s:9:"titlenum2";s:2:"40";s:10:"titleflood";s:1:"0";s:10:"c_rolltype";s:1:"0";}', 'a:3:{s:5:"div_w";s:3:"178";s:5:"div_h";s:2:"44";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1292061098, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_16', 'article', 1, 'a:32:{s:13:"tplpart_1code";s:66:"<div class="list"><a href="$url" target="_blank">$title</a></div> ";s:13:"tplpart_2code";s:0:"";s:3:"SYS";s:7:"artcile";s:13:"RollStyleType";s:0:"";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:7:"newhour";s:2:"24";s:7:"hothits";s:3:"100";s:7:"amodule";s:1:"0";s:7:"tplpath";s:0:"";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:5:"stype";s:1:"4";s:2:"yz";s:1:"1";s:7:"hidefid";N;s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:6:"A.list";s:3:"asc";s:4:"DESC";s:6:"levels";s:3:"all";s:7:"rowspan";s:1:"3";s:3:"sql";s:102:" SELECT A.*,A.aid AS id FROM qb_article A  WHERE A.yz=1  AND A.mid=\'0\'   ORDER BY A.list DESC LIMIT 3 ";s:4:"sql2";N;s:7:"colspan";s:1:"1";s:11:"content_num";s:2:"80";s:12:"content_num2";s:3:"120";s:8:"titlenum";s:2:"36";s:9:"titlenum2";s:2:"40";s:10:"titleflood";s:1:"0";s:10:"c_rolltype";s:1:"0";}', 'a:3:{s:5:"div_w";s:3:"180";s:5:"div_h";s:2:"60";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290491634, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_17', 'article', 1, 'a:32:{s:13:"tplpart_1code";s:66:"<div class="list"><a href="$url" target="_blank">$title</a></div> ";s:13:"tplpart_2code";s:0:"";s:3:"SYS";s:7:"artcile";s:13:"RollStyleType";s:0:"";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:7:"newhour";s:2:"24";s:7:"hothits";s:3:"100";s:7:"amodule";s:1:"0";s:7:"tplpath";s:0:"";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:5:"stype";s:1:"4";s:2:"yz";s:1:"1";s:7:"hidefid";N;s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:6:"A.list";s:3:"asc";s:3:"ASC";s:6:"levels";s:3:"all";s:7:"rowspan";s:1:"3";s:3:"sql";s:101:" SELECT A.*,A.aid AS id FROM qb_article A  WHERE A.yz=1  AND A.mid=\'0\'   ORDER BY A.list ASC LIMIT 3 ";s:4:"sql2";N;s:7:"colspan";s:1:"1";s:11:"content_num";s:2:"80";s:12:"content_num2";s:3:"120";s:8:"titlenum";s:2:"36";s:9:"titlenum2";s:2:"40";s:10:"titleflood";s:1:"0";s:10:"c_rolltype";s:1:"0";}', 'a:3:{s:5:"div_w";s:3:"179";s:5:"div_h";s:2:"60";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290491643, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_18', 'code', 0, '	<div><a href="#" target="_blank">客户服务中心</a></div>\r\n            <div><a href="#" target="_blank">在线提问</a></div>', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:2:"87";s:5:"div_h";s:2:"40";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290491723, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_19', 'code', 0, '商家资讯', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_2', 'pic', 0, 'a:4:{s:6:"imgurl";s:32:"label/1_20101123121155_ihnbv.jpg";s:7:"imglink";s:1:"#";s:5:"width";s:3:"115";s:6:"height";s:2:"60";}', 'a:3:{s:5:"div_w";s:3:"113";s:5:"div_h";s:2:"58";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290488513, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_20', 'code', 0, '最新商家', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_21', 'code', 0, '今日公告', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_22', 'code', 0, '商情快报', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_23', 'code', 0, '商家新闻', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_25', 'member', 1, 'a:20:{s:9:"tplpart_1";s:637:"<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable table1">\r\n                  <tr>\r\n                    <td class="img"><a href="$webdb[www_url]/member/homepage.php?uid=$uid" target="_blank"><img src="$picurl" onerror="this.src=\'$webdb[www_url]/images/default/noface.gif\'" width="45" height="45"/></a></td>\r\n                    <td class="word">\r\n                    	<div class="t"><a href="$webdb[blog_url]/index.php?uid=$uid" target="_blank">$username</a></div>\r\n                        <div class="c">注册日期:$posttime</div>\r\n                    </td>\r\n                  </tr>\r\n                </table>";s:13:"tplpart_1code";s:637:"<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable table1">\r\n                  <tr>\r\n                    <td class="img"><a href="$webdb[www_url]/member/homepage.php?uid=$uid" target="_blank"><img src="$picurl" onerror="this.src=\'$webdb[www_url]/images/default/noface.gif\'" width="45" height="45"/></a></td>\r\n                    <td class="word">\r\n                    	<div class="t"><a href="$webdb[blog_url]/index.php?uid=$uid" target="_blank">$username</a></div>\r\n                        <div class="c">注册日期:$posttime</div>\r\n                    </td>\r\n                  </tr>\r\n                </table>";s:13:"tplpart_2code";s:0:"";s:7:"group_1";s:0:"";s:7:"group_2";s:0:"";s:13:"RollStyleType";s:0:"";s:7:"tplpath";s:0:"";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:5:"stype";s:1:"4";s:2:"yz";s:3:"all";s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:7:"regdate";s:3:"asc";s:4:"DESC";s:6:"levels";N;s:7:"rowspan";s:1:"4";s:3:"sql";s:157:" SELECT D.*,D.username AS title,D.icon AS picurl,D.introduce AS content,D.regdate AS posttime FROM qb_memberdata D  WHERE 1  ORDER BY D.regdate DESC LIMIT 4 ";s:7:"colspan";s:1:"1";s:8:"titlenum";s:2:"20";s:10:"titleflood";s:1:"0";}', 'a:3:{s:5:"div_w";s:3:"180";s:5:"div_h";s:3:"238";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290494104, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_26', 'code', 0, '会员动态', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_3', 'pic', 0, 'a:4:{s:6:"imgurl";s:32:"label/1_20101123121111_d03vt.jpg";s:7:"imglink";s:1:"#";s:5:"width";s:3:"115";s:6:"height";s:2:"60";}', 'a:3:{s:5:"div_w";s:3:"113";s:5:"div_h";s:2:"60";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290488521, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_30', 'mysql', 1, 'a:22:{s:13:"tplpart_1code";s:115:"<div class="list l$i"><span><a href="/f/list.php?fid=$fid" target="_blank">$title</a></span><em>{$NUM}条</em></div>";s:13:"tplpart_2code";s:0:"";s:3:"SYS";s:5:"mysql";s:13:"RollStyleType";s:0:"";s:7:"newhour";N;s:7:"hothits";N;s:7:"tplpath";s:0:"";s:6:"DivTpl";i:1;s:5:"stype";s:1:"4";s:7:"rowspan";s:2:"10";s:3:"sql";s:144:"SELECT COUNT( * ) AS NUM, fname AS title, fid FROM `qb_fenlei_content` WHERE city_id=\'$GLOBALS[city_id]\' GROUP BY fid ORDER BY NUM DESC LIMIT 10";s:7:"colspan";s:1:"1";s:8:"titlenum";s:2:"20";s:9:"titlenum2";s:2:"40";s:10:"titleflood";s:1:"0";s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:11:"content_num";s:2:"80";s:12:"content_num2";s:3:"120";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";}', 'a:3:{s:5:"div_w";s:3:"176";s:5:"div_h";s:3:"220";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1292994548, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_31', 'code', 0, '分类热门栏目', 'a:4:{s:9:"html_edit";N;s:5:"div_w";s:0:"";s:5:"div_h";s:0:"";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 0, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_4', 'pic', 0, 'a:4:{s:6:"imgurl";s:32:"label/1_20101123131120_6g6lw.gif";s:7:"imglink";s:1:"#";s:5:"width";s:3:"176";s:6:"height";s:2:"60";}', 'a:3:{s:5:"div_w";s:2:"89";s:5:"div_h";s:2:"59";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290488536, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_5', 'pic', 0, 'a:4:{s:6:"imgurl";s:32:"label/1_20101123131113_owuft.gif";s:7:"imglink";s:1:"#";s:5:"width";s:3:"176";s:6:"height";s:2:"60";}', 'a:3:{s:5:"div_w";s:3:"177";s:5:"div_h";s:2:"60";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290491294, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_6', 'pic', 0, 'a:4:{s:6:"imgurl";s:32:"label/1_20101123131157_sdv3g.png";s:7:"imglink";s:1:"#";s:5:"width";s:3:"176";s:6:"height";s:2:"60";}', 'a:3:{s:5:"div_w";s:3:"176";s:5:"div_h";s:2:"58";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290491303, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_7', 'Info_hy_', 1, 'a:28:{s:13:"tplpart_1code";s:327:"<div class="listcompany">\r\n			<a href="$webdb[www_url]/home/?uid=$uid" target="_blank" class="img"><img src="$picurl" onerror="this.src=\'$webdb[www_url]/images/default/nopic.jpg\'" width="120" height="90" border="0"/></a> \r\n              <a href="$webdb[www_url]/home/?uid=$uid" target="_blank" class="t">$title</a>\r\n			  </div>";s:13:"tplpart_2code";s:0:"";s:3:"SYS";s:7:"company";s:7:"typefid";N;s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:11:"content_num";s:2:"80";s:7:"newhour";s:2:"24";s:7:"hothits";s:2:"30";s:7:"tplpath";s:0:"";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:8:"moduleid";N;s:5:"stype";s:1:"p";s:2:"yz";s:3:"all";s:8:"renzheng";s:3:"all";s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:3:"rid";s:3:"asc";s:4:"DESC";s:6:"levels";s:3:"all";s:7:"rowspan";s:2:"10";s:3:"sql";s:91:"SELECT * FROM qb_hy_company  WHERE city_id=\'$GLOBALS[city_id]\'  ORDER BY rid DESC LIMIT 10 ";s:7:"colspan";s:1:"1";s:8:"titlenum";s:2:"24";s:10:"titleflood";s:1:"0";}', 'a:3:{s:5:"div_w";s:3:"762";s:5:"div_h";s:3:"256";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1292061082, 0, 16, 0, 0, 'default');
INSERT INTO `qb_label` (`lid`, `name`, `ch`, `chtype`, `tag`, `type`, `typesystem`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`, `pagetype`, `module`, `fid`, `if_js`, `style`) VALUES ('', '', 0, 0, 'hy_8', 'article', 1, 'a:32:{s:13:"tplpart_1code";s:65:"<div class="list"><a href="$url" target="_blank">$title</a></div>";s:13:"tplpart_2code";s:543:"<table width="100%" border="0" cellspacing="0" cellpadding="0">\r\n                  <tr>\r\n                    \r\n                <td class="img"><a href="$url" target="_blank"><img src="$picurl" onerror="this.src=\'$webdb[www_url]/images/default/nopic.jpg\'" width="60" height="45" border="0"/></a></td>\r\n                    <td>\r\n                    	<div class="t"><a href="$url" target="_blank">$title</a></div>\r\n                        <div class="c">$content</div>\r\n                    </td>\r\n                  </tr>\r\n                </table>";s:3:"SYS";s:7:"artcile";s:13:"RollStyleType";s:0:"";s:8:"rolltype";s:10:"scrollLeft";s:8:"rolltime";s:1:"3";s:11:"roll_height";s:2:"50";s:5:"width";s:3:"250";s:6:"height";s:3:"187";s:7:"newhour";s:2:"24";s:7:"hothits";s:3:"100";s:7:"amodule";s:1:"0";s:7:"tplpath";s:24:"/common_zh_pic/zh_pc.jpg";s:6:"DivTpl";i:1;s:5:"fiddb";N;s:5:"stype";s:1:"t";s:2:"yz";s:1:"1";s:7:"hidefid";N;s:10:"timeformat";s:11:"Y-m-d H:i:s";s:5:"order";s:6:"A.list";s:3:"asc";s:4:"DESC";s:6:"levels";s:3:"all";s:7:"rowspan";s:1:"6";s:3:"sql";s:163:" SELECT A.*,A.aid AS id,R.content FROM qb_article A LEFT JOIN qb_reply R ON A.aid=R.aid   WHERE A.yz=1  AND A.mid=\'0\'   AND R.topic=1 ORDER BY A.list DESC LIMIT 7 ";s:4:"sql2";s:175:" SELECT A.*,A.aid AS id,R.content FROM qb_article A LEFT JOIN qb_reply R ON A.aid=R.aid  WHERE A.yz=1  AND A.mid=\'0\'  AND A.ispic=1 AND R.topic=1 ORDER BY A.list DESC LIMIT 1 ";s:7:"colspan";s:1:"1";s:11:"content_num";s:2:"80";s:12:"content_num2";s:2:"30";s:8:"titlenum";s:2:"28";s:9:"titlenum2";s:2:"26";s:10:"titleflood";s:1:"0";s:10:"c_rolltype";s:1:"0";}', 'a:3:{s:5:"div_w";s:3:"173";s:5:"div_h";s:3:"207";s:11:"div_bgcolor";s:0:"";}', 0, 0, 1, 'admin', 1290490669, 0, 16, 0, 0, 'default');
  

DROP TABLE IF EXISTS `qb_hy_company`;
CREATE TABLE `qb_hy_company` (
  `rid` mediumint(7) NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `host` varchar(32) NOT NULL default '',
  `fname` varchar(100) NOT NULL default '',
  `uid` mediumint(7) NOT NULL default '0',
  `username` varchar(32) NOT NULL default '',
  `renzheng` tinyint(1) NOT NULL default '0',
  `is_agent` tinyint(1) NOT NULL default '0',
  `is_vip` tinyint(1) NOT NULL default '0',
  `posttime` int(10) NOT NULL default '0',
  `list` int(10) NOT NULL default '0',
  `listorder` int(10) NOT NULL default '0',
  `picurl` varchar(255) NOT NULL default '',
  `gz` varchar(248) NOT NULL default '',
  `yz` tinyint(1) NOT NULL default '0',
  `yzer` varchar(32) NOT NULL default '',
  `yztime` int(10) NOT NULL default '0',
  `hits` int(10) NOT NULL default '0',
  `levels` tinyint(2) NOT NULL default '0',
  `levelstime` int(10) NOT NULL default '0',
  `lastview` int(10) NOT NULL default '0',
  `content` text NOT NULL,
  `province_id` mediumint(7) NOT NULL default '0',
  `city_id` mediumint(7) NOT NULL default '0',
  `zone_id` mediumint(7) NOT NULL default '0',
  `street_id` mediumint(7) NOT NULL default '0',
  `qy_cate` varchar(32) NOT NULL default '',
  `qy_saletype` varchar(48) NOT NULL default '',
  `qy_regmoney` int(10) NOT NULL default '0',
  `qy_createtime` varchar(64) NOT NULL default '',
  `qy_regplace` varchar(128) NOT NULL default '',
  `qy_address` varchar(248) NOT NULL default '',
  `qy_postnum` varchar(8) NOT NULL default '',
  `qy_pro_ser` varchar(248) NOT NULL default '',
  `my_buy` varchar(248) NOT NULL default '',
  `my_trade` varchar(32) NOT NULL default '',
  `qy_contact` varchar(16) NOT NULL default '',
  `qy_contact_zhiwei` varchar(16) NOT NULL default '',
  `qy_contact_sex` int(1) NOT NULL default '1',
  `qy_contact_tel` varchar(248) NOT NULL default '',
  `qy_contact_mobile` varchar(248) NOT NULL default '',
  `qy_contact_fax` varchar(248) NOT NULL default '',
  `qy_contact_email` varchar(248) NOT NULL default '',
  `qy_website` varchar(248) NOT NULL default '',
  `qq` varchar(248) NOT NULL default '',
  `msn` varchar(248) NOT NULL default '',
  `skype` varchar(248) NOT NULL default '',
  `ww` varchar(248) NOT NULL default '',
  `bd_pics` varchar(248) NOT NULL default '',
  `toptime` int(10) NOT NULL default '0',
  `if_homepage` tinyint(4) NOT NULL default '0',
  `permit_pic` varchar(100) NOT NULL default '',
  `guo_tax_pic` varchar(100) NOT NULL default '',
  `di_tax_pic` varchar(100) NOT NULL default '',
  `organization_pic` varchar(100) NOT NULL default '',
  `idcard_pic` varchar(100) NOT NULL default '',
  `gg_maps` varchar(50) NOT NULL default '',
  `dianping` mediumint(7) NOT NULL default '0',
  `dianpingtime` int(10) NOT NULL default '0',
  PRIMARY KEY  (`rid`),
  KEY `uid` (`uid`),
  KEY `levels` (`levels`,`posttime`),
  KEY `yz` (`yz`,`posttime`),
  KEY `toptime` (`toptime`),
  KEY `city_id` (`city_id`,`levels`,`levelstime`),
  KEY `renzheng` (`renzheng`),
  KEY `host` (`host`)
) TYPE=MyISAM AUTO_INCREMENT=33 ;

#
# 导出表中的数据 `qb_hy_company`
#

INSERT INTO `qb_hy_company` VALUES (17, '广州协天软件科技有限公司', '', '螺纹钢,普线,带钢,热板卷,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷', 1, 'admin', 3, 0, 0, 1282284007, 0, 0, 'homepage/logo/1/1_20101102091111_ybuoq.gif', '', 1, '', 1282284007, 584, 1, 1282719160, 0, '&nbsp;&nbsp;&nbsp;&nbsp;齐博CMS是中国领先的开源CMS平台与服务提供商，长期专注于互联网高性能平台及技术解决方案的研发，公司人员70%以上为技术人员，拥有中国专业的Web应用平台技术研发团队，齐博CMS拥有广泛的社会影响力，为国内应用最广泛的系统之一，也是中国南方PHP领域最大的开源系统提供方。<br /><br /><a style="FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #990000">发展历程</a><br />&nbsp;&nbsp;&nbsp;&nbsp;自2003年10月齐博CMS V1.0面世至今，已形成面向广大站长的V系列和面向媒体报刊门户、政府电子政务的Sharp系列（简称S系列），S系列以千万级海量数据应用媒体报刊、政府站群应用中形成良好的品牌口碑，以“核心+系统+模块+插件”架构体系，成为国内高性能、模块化的开源PHP系统。涉及政府电子政务、媒体新闻门户、大型企业信息化、站群系统、电子商务B2B及企业内部OA等海量数据高端互联网应用，已为三十余万用户提供了应用平台。 ', 0, 1, 0, 0, '个人独资企业', '服务型', 100, '2007-10-02', '广东省广州市天河区', '1111', '000222', 'CMS整站程序 电子商务程序 地方门户程序 分类信息系统', 'PHP人才', '数码、电脑及网络配件', '张生', '总裁', 0, '020', '15920222222', '0106665555', '0342@fdsg.cn', 'http://112', '65284322', '125@erw.cn', '', '1451', '', 0, 1, 'company/renzheng/1_20101016111001_krbfo.jpg', 'company/renzheng/1_20101016111026_ienzi.jpg', 'company/renzheng/1_20101016111030_dbedh.jpg', 'company/renzheng/1_20101016111032_g2s7m.jpg', 'company/renzheng/1_20101016111035_nlvue.jpg', '39.95231950026053,116.51824951171875', 4, 1290495942);
INSERT INTO `qb_hy_company` VALUES (22, '瑞安市锻造实业公司', '', '螺纹钢,带钢,冷轧板,模具板,无缝管,H型钢,焊线,不锈板卷', 27, 'test1', 0, 0, 0, 1288661741, 0, 0, 'homepage/logo/1/27_20101102091141_e1uuj.jpg', '', 1, '', 1288661741, 5, 1, 1288663982, 0, '    公司创办于1992年，占地5000平方米，建筑面积8900平方米，以复杂机械零件的精密模锻件锻造生产为主,并进行锻件的机械加工和硬质合金工具的钎焊。   供应机械零件（汽摩配）锻件、起重吊钩、五金工具、钎焊硬质合金工具。如随车工具、G字夹、汽车摩托车齿轮及叉臂轴类锻件。', 0, 1, 0, 0, '个体经营', '生产型', 999, '2010-11-03', '广东省', '', '', '钢材', '钢', '机械及行业设备', '张生', '', 0, '020555444', '', '', 'gfds@afds.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (23, '宁波市鄞州塘溪红龙五金工具厂', '', '螺纹钢,带钢,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷,矿石,硅铁', 28, 'test2', 0, 0, 0, 1288662180, 0, 0, 'homepage/logo/1/logo_28_20101102091100_6jeu7.jpg', '', 1, '', 1288662180, 1, 1, 1288663984, 0, '    本厂是一家拥有十多年历史，专业生产园林工具刀片（系列修枝机刀片）的厂家 。  本厂依靠科技进步，通过本厂技术人员的刻苦攻关，现开发出多款具有先进水平的高硬度，高韧性的系列产品。基本解决了国内刀片厂家有韧性没硬度，有硬度没韧性的技术困局，大大提高了刀片的使用寿命。 得到很多国内外客商的首肯，直接出口欧洲和美国。  本厂产品由进料到成品基本做到全线产品一体生产，所有零配件无外加工。质量，产能得到了最高最大化。现竭诚邀请您来电，来函。我们将以最大的热情期待您的光临。', 0, 1, 0, 0, '个体经营', '生产型', 900, '2010-11-13', '宁波', '', '', '钢索', '钢', '机械及行业设备', '牛生', '', 0, '0205544447', '', '', 'fds@ds.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (24, '南京绿友纸浆模塑有限公司', '', '螺纹钢,带钢,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷,矿石,硅铁', 29, 'test3', 0, 0, 0, 1288662327, 0, 0, 'homepage/logo/1/29_20101102091127_bcl6e.jpg', '', 1, '', 1288662327, 2, 1, 1288663984, 0, '   南京绿友纸浆模塑有限公司是由中国包装新技术开发包宁公司改制组建而成，继续从事包宁公司的纸浆模塑技术研究、设备制造、新品推广的专业公司，具有独立法人资格、科、工、贸一体化、外向型股份制企业。   公司围绕纸浆模塑技术开发设有技术开发部、模具中心、机械加工厂、新品示范厂、工程安装部等部门，从事纸塑技术开发的专业工程技术人员占35%，高级工程师3人(其中一名因在纸浆模塑方面有特殊贡献、享受国务院特殊津贴并颁发证书)，工程师8人，技术力量雄厚，设施齐全，具有独立自主的开发研究、试验示范、生产销售的经济实体。绿友公司集中了包宁公司最优秀的人才，全面继承、加速研究、全面开发了纸浆模塑技术，因此，在纸浆模塑领域保持了技术最全面、设备最先进、品种最齐全的优势！', 0, 1, 0, 0, '个体经营', '生产型', 600, '2010-11-06', '上海', '', '', '玻璃幕墙', '玻璃', '机械及行业设备', '黄生', '', 0, '0204448554', '', '', 'fdsg@sda.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (25, '上海烈力轴承制造有限公司', '', '螺纹钢,普线,带钢,热板卷,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷', 30, 'test4', 0, 0, 0, 1288662567, 0, 0, 'homepage/logo/1/30_20101102091127_ibn2r.jpg', '', 1, '', 1288662567, 1, 1, 1288663985, 0, '    浙江双飞无油轴承有限公司，是中国专业生产滑动轴承系列产品的龙头企业；浙江省“AAA”级守合同、重信用企业；浙江省高新技术企业；ISO9001和QS9000质量体系认证单位。 公司有一支强劲的新产品研发队伍和完善的试验设施，被列为浙江省技术中心。产品50%以上出口德国、意大利、日本、新加坡、美国、加拿大、台湾等20多个国家和地区， 已经创造了良好的国际信誉。   公司目前主要产品有：SF系列无油润滑轴承、JF双金属轴承、FB青铜轴承、JDB镶嵌固体润滑轴承等12个系列16000多个品种，适应：高温、高速等各种场合的使用。公司有完善的检测设备，保证100%的合格产品提供给顾客，让每位“ZOB”', 0, 1, 0, 0, '个体经营', '生产型', 600, '2010-11-04', '上海', '', '', '生铁', '铁', '机械及行业设备', '李生', '', 0, '02054477877', '', '', 'fds@sda.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (26, '温州天旺五金有限公司', '', '螺纹钢,普线,带钢,冷轧板,船板,H型钢,焊线,不锈板卷,矿石', 31, 'test5', 0, 0, 0, 1288662786, 0, 0, 'homepage/logo/1/31_20101102091106_ijzou.jpg', '', 1, '', 1288662786, 0, 1, 1288663985, 0, '    我司是专业生产日用五金、机电配件、塑胶制品、紧固件等产品的出口外向型企业，是中国较早开发DIY家用五金组合系列产品的知名企业。企业创立至今始终坚持走质量效益型之路，强化全面管理和有效经营，注重企业形象和产品形象，产品远销世界各地，深得国内外客户信赖和赞誉。在纷繁复杂的市场竟争中，始终坚守诚信、勇于创新。  我司根据自身发展需求和市场发展趋势，将制造、生产的日用五金、标准件、非标准件、紧固件、塑胶制品、机电配件等产品，分为两大市场板块，其中DIY家用五金套装已形成30个系列近1000个品种，凭借严格质量管理和出众的设计理念，产品在国际市场（尤其是欧美、东南亚市场）形成良好的销售势头，市场占有', 0, 1, 0, 0, '个体经营', '生产型', 300, '2010-11-06', '深圳', '', '', '布', '灰布', '机械及行业设备', '何生', '', 0, '0204544744', '', '', 'fds@fsa.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (27, '常州市武进天力电动工具厂', '', '螺纹钢,带钢,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷,矿石,硅铁', 32, 'test6', 0, 0, 0, 1288662947, 0, 0, 'homepage/logo/1/32_20101102091147_9pqhn.jpg', '', 1, '', 1288662947, 1, 1, 1288663986, 0, '  浙江双飞无油轴承有限公司，是中国专业生产滑动轴承系列产品的龙头企业；浙江省“AAA”级守合同、重信用企业；浙江省高新技术企业；ISO9001和QS9000质量体系认证单位。 公司有一支强劲的新产品研发队伍和完善的试验设施，被列为浙江省技术中心。产品50%以上出口德国、意大利、日本、新加坡、美国、加拿大、台湾等20多个国家和地区， 已经创造了良好的国际信誉。   公司目前主要产品有：SF系列无油润滑轴承、JF双金属轴承、FB青铜轴承、JDB镶嵌固体润滑轴承等12个系列16000多个品种，适应：高温、高速等各种场合的使用。公司有完善的检测设备，保证100%的合格产品提供给顾客，让每位“ZOB”的顾客满意。   我们严格按照 ISO-TS16949 的质量体系，从原材料投入、模具制造、成形、烧结…等直到服务，全过程加以控制。操作工首先进行自检，专职检验人员进行巡回检，每道工序都进行严格把关，每道工序都做到有据可查。同时以先进的检测设备保证了产品100%的出厂合格率！', 0, 1, 0, 0, '个体经营', '生产型', 300, '2010-11-04', '', '', '', '', '', '机械及行业设备', '刘生', '', 0, '020544777', '', '', 'fda@dsa.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (28, '丽图数码科技（深圳）有限公司', '', '螺纹钢,带钢,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷,矿石,硅铁', 33, 'test7', 0, 0, 0, 1288663129, 0, 0, 'homepage/logo/1/33_20101102091149_ofqqf.jpg', '', 1, '', 1288663129, 1, 1, 1288663987, 0, '   专业从事一体化速印机印刷耗材设计开发和制造的外商独资企业，公司享有独立的进出口权，提供了和外商直接自由的贸易平台。公司拥有5000平方米的现代化厂房，配合全封闭的无尘、恒温、恒湿的生产车间。生产设备全部采用电脑化自动控制。先进的生产工艺流程，保证了产品卓越的品质，并率先于2003年通过了ISO9001-2000质量管理体系认证。公司始终遵循“以客户为本，以品质取胜，以服务领先”的发展理念。坚持产品的专业化，细致化的经营模拟。通过不断努力，不懈追求，充分满足客户的个性化要求，赢得了客户的充分认可与肯定，使公司成为国内同行中最具知名度的供应商。', 0, 1, 0, 0, '个体经营', '生产型', 600, '2010-11-13', '深圳', '', '', '', '', '机械及行业设备', '何生', '', 0, '02087744454', '', '', 'dfsafs@dsa.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (29, '深圳市大中实业发展有限公司', '', '螺纹钢,带钢,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷,矿石,硅铁', 34, 'test8', 0, 0, 0, 1288663299, 0, 0, 'homepage/logo/1/34_20101102101139_apfdl.jpg', '', 1, '', 1288663299, 5, 1, 1288663987, 0, '    一家集产品开发、设计、生产与销售于一体，较早从事五金、弹簧、消费电子类研发、生产与销售，拥有进出口经营权的高科技民营企业。公司实力雄厚，研发技术成熟，采用国际先进的管理模式，产品质量过硬、销售网络完善，售后服务优质。 　　本公司现拥有厂房面积600平方米，固定资产500多万元，员工60多人，其中工程技术人员有10人，年销售额500多万元，公司已通过ISO9001-2000质量体系认证，并在目前已推广ISO/TS16949-2002体系的运行。有一套完备的产品质量检测设备和检验员队伍，确保产品质量的稳定可靠，在用户中有较高的质量信誉。 ', 0, 1, 0, 0, '个体经营', '生产型', 100, '', '深圳市', '', '', '五金', '弹簧', '机械及行业设备', '黄生', '', 0, '02054787741', '', '', 'fsgfd@dsa.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (30, '海盐中凌铸造有限责任公司', '', '螺纹钢,带钢,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷,矿石,硅铁', 35, 'test9', 0, 0, 0, 1288663462, 0, 0, 'homepage/logo/1/35_20101102101122_jvufs.jpg', '', 1, '', 1288663462, 1, 1, 1288663988, 0, '    海盐中凌铸造有限责任公司地处浙江省海盐县，东依上海80公里，西距杭州65公里，南邻风景秀丽的南北湖风景区，北连嘉兴市区，离沪杭高速公路王店出口处7公里，水陆交通十分便利。公司在全体员工十多年来的默默耕耘下，讫今已拥有资产300万美元，占地面积30000平方米，其中厂房20000多平方米，各类生产设备120余台套，有齐全的理化检测设备及先进的质量管理体系，主要设备有250KG中频电炉3套及熔模精密铸造流水线三条，10吨级铸钢件热处理炉三个，各类机加工设备80余台。目前企业员工130名，其中各类工程技术人员38名', 0, 1, 0, 0, '个体经营', '生产型', 300, '2010-11-06', '浙江省海盐县', '', '', '铁', '生铁', '机械及行业设备', '黄生', '', 0, '02045789654', '', '', 'safsa@dfsa.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (31, '东莞市华尔赛弹簧制造有限公司', '', '螺纹钢,带钢,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷,矿石,硅铁', 36, 'test10', 0, 0, 0, 1288663617, 0, 0, 'homepage/logo/1/36_20101102101157_jugc3.jpg', '', 1, '', 1288663617, 1, 1, 1288663988, 0, '     是一家集生产、研发、销售和服务于一体的综合型弹簧生产企业。公司位于广东省东莞市黄江镇，距莞深高速公路3公里，东莞火车站10公里左右，交通十分便捷。公司占地2000平方米，拥有全套一流的生产、检测设备，有目前国内最选进的十毫米以下的CNC数控自动弹簧机，可生产弹簧线径最小0.08MM-10MM，是东莞市首家拥有可以生产10mm以下线径的CNC弹簧机械；弹簧处理网带式连续回火炉，清洗机。弹簧检测设备仪器齐全，如：二次元投影仪、扭力测试机、压拉力测试机、盐雾测试机等，全面有效地控制了弹簧的质量。华尔赛主导产品有各类精密弹簧，车件，铆钉，螺丝，五金冲压件。产品广泛用于电子、电器、玩具、锁具、文具、童车、自行车、礼品、工艺品、厨卫具、照相机、打印机、办公设备、精密设备、各类交通工具等。现我司的生产的弹簧产品如：离合器弹簧、复合弹簧、启动弹簧、回位弹簧、座垫弹簧等 已迈入汽车行业。', 0, 1, 0, 0, '个体经营', '生产型', 350, '2010-11-04', '东莞市', '', '', '钢材', '钢', '机械及行业设备', '刘生', '', 0, '02054484444', '', '', 'fsdafd@sa.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);
INSERT INTO `qb_hy_company` VALUES (32, '广州金栢叶床具制品有限公司', '', '螺纹钢,带钢,冷轧板,船板,无缝管,H型钢,焊线,不锈板卷,矿石,硅铁', 37, 'test11', 0, 0, 0, 1288663816, 0, 0, 'homepage/logo/1/37_20101102101116_xmwaa.jpg', '', 1, '', 1288663816, 32, 1, 1288663989, 0, '    前身“广州恒基（床垫）弹簧厂”，是专业生产床垫、床垫弹簧网的厂家。风雨十五年，一步一脚印，发展至今天，拥有厂房五千多平方米，多条先进的弹簧、床垫生产线及压缩设备。 大批技艺超群的生产技术工人，产品开发研究人员 ，严格的质量体系。严格按照ISO9001：2000质量体系，ISO14000环境体系标准运行，产品通过中国国家质量认证，美国CFR1633标准及英国BS5852标准，为生产世界级品牌产品有坚实保证。目前，金栢叶公司生产的床垫、床垫芯产品可经压缩包装处理，方便世界各地客商的运输及仓储。凭借多年生产床垫弹簧出口世界各地的经验，集全球多家名牌床垫之技术精华，经研究人员精心研究设计，创造出纯中国制造的高端品牌床垫——“金栢叶”系列产品。', 0, 1, 0, 0, '个体经营', '生产型', 200, '2010-11-04', '广州', '', '', '猪油', '生猪油', '机械及行业设备', '林生', '', 0, '0205447777', '', '', 'dfsaf@dsa.cn', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', 0, 0);

# --------------------------------------------------------

#
# 表的结构 `qb_hy_company_fid`
#

DROP TABLE IF EXISTS `qb_hy_company_fid`;
CREATE TABLE `qb_hy_company_fid` (
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `fid` mediumint(7) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`fid`)
) TYPE=MyISAM;

#
# 导出表中的数据 `qb_hy_company_fid`
#

INSERT INTO `qb_hy_company_fid` VALUES (1, 11);
INSERT INTO `qb_hy_company_fid` VALUES (1, 12);
INSERT INTO `qb_hy_company_fid` VALUES (1, 21);
INSERT INTO `qb_hy_company_fid` VALUES (1, 22);
INSERT INTO `qb_hy_company_fid` VALUES (1, 33);
INSERT INTO `qb_hy_company_fid` VALUES (1, 46);
INSERT INTO `qb_hy_company_fid` VALUES (1, 59);
INSERT INTO `qb_hy_company_fid` VALUES (1, 73);
INSERT INTO `qb_hy_company_fid` VALUES (1, 87);
INSERT INTO `qb_hy_company_fid` VALUES (1, 105);
INSERT INTO `qb_hy_company_fid` VALUES (27, 11);
INSERT INTO `qb_hy_company_fid` VALUES (27, 21);
INSERT INTO `qb_hy_company_fid` VALUES (27, 33);
INSERT INTO `qb_hy_company_fid` VALUES (27, 48);
INSERT INTO `qb_hy_company_fid` VALUES (27, 59);
INSERT INTO `qb_hy_company_fid` VALUES (27, 73);
INSERT INTO `qb_hy_company_fid` VALUES (27, 87);
INSERT INTO `qb_hy_company_fid` VALUES (27, 105);
INSERT INTO `qb_hy_company_fid` VALUES (28, 11);
INSERT INTO `qb_hy_company_fid` VALUES (28, 21);
INSERT INTO `qb_hy_company_fid` VALUES (28, 33);
INSERT INTO `qb_hy_company_fid` VALUES (28, 46);
INSERT INTO `qb_hy_company_fid` VALUES (28, 59);
INSERT INTO `qb_hy_company_fid` VALUES (28, 73);
INSERT INTO `qb_hy_company_fid` VALUES (28, 87);
INSERT INTO `qb_hy_company_fid` VALUES (28, 105);
INSERT INTO `qb_hy_company_fid` VALUES (28, 119);
INSERT INTO `qb_hy_company_fid` VALUES (28, 136);
INSERT INTO `qb_hy_company_fid` VALUES (29, 11);
INSERT INTO `qb_hy_company_fid` VALUES (29, 21);
INSERT INTO `qb_hy_company_fid` VALUES (29, 33);
INSERT INTO `qb_hy_company_fid` VALUES (29, 46);
INSERT INTO `qb_hy_company_fid` VALUES (29, 59);
INSERT INTO `qb_hy_company_fid` VALUES (29, 73);
INSERT INTO `qb_hy_company_fid` VALUES (29, 87);
INSERT INTO `qb_hy_company_fid` VALUES (29, 105);
INSERT INTO `qb_hy_company_fid` VALUES (29, 119);
INSERT INTO `qb_hy_company_fid` VALUES (29, 136);
INSERT INTO `qb_hy_company_fid` VALUES (30, 11);
INSERT INTO `qb_hy_company_fid` VALUES (30, 12);
INSERT INTO `qb_hy_company_fid` VALUES (30, 21);
INSERT INTO `qb_hy_company_fid` VALUES (30, 22);
INSERT INTO `qb_hy_company_fid` VALUES (30, 33);
INSERT INTO `qb_hy_company_fid` VALUES (30, 46);
INSERT INTO `qb_hy_company_fid` VALUES (30, 59);
INSERT INTO `qb_hy_company_fid` VALUES (30, 73);
INSERT INTO `qb_hy_company_fid` VALUES (30, 87);
INSERT INTO `qb_hy_company_fid` VALUES (30, 105);
INSERT INTO `qb_hy_company_fid` VALUES (31, 11);
INSERT INTO `qb_hy_company_fid` VALUES (31, 12);
INSERT INTO `qb_hy_company_fid` VALUES (31, 21);
INSERT INTO `qb_hy_company_fid` VALUES (31, 33);
INSERT INTO `qb_hy_company_fid` VALUES (31, 46);
INSERT INTO `qb_hy_company_fid` VALUES (31, 73);
INSERT INTO `qb_hy_company_fid` VALUES (31, 87);
INSERT INTO `qb_hy_company_fid` VALUES (31, 105);
INSERT INTO `qb_hy_company_fid` VALUES (31, 119);
INSERT INTO `qb_hy_company_fid` VALUES (32, 11);
INSERT INTO `qb_hy_company_fid` VALUES (32, 21);
INSERT INTO `qb_hy_company_fid` VALUES (32, 33);
INSERT INTO `qb_hy_company_fid` VALUES (32, 46);
INSERT INTO `qb_hy_company_fid` VALUES (32, 59);
INSERT INTO `qb_hy_company_fid` VALUES (32, 73);
INSERT INTO `qb_hy_company_fid` VALUES (32, 87);
INSERT INTO `qb_hy_company_fid` VALUES (32, 105);
INSERT INTO `qb_hy_company_fid` VALUES (32, 119);
INSERT INTO `qb_hy_company_fid` VALUES (32, 136);
INSERT INTO `qb_hy_company_fid` VALUES (33, 11);
INSERT INTO `qb_hy_company_fid` VALUES (33, 21);
INSERT INTO `qb_hy_company_fid` VALUES (33, 33);
INSERT INTO `qb_hy_company_fid` VALUES (33, 46);
INSERT INTO `qb_hy_company_fid` VALUES (33, 59);
INSERT INTO `qb_hy_company_fid` VALUES (33, 73);
INSERT INTO `qb_hy_company_fid` VALUES (33, 87);
INSERT INTO `qb_hy_company_fid` VALUES (33, 105);
INSERT INTO `qb_hy_company_fid` VALUES (33, 119);
INSERT INTO `qb_hy_company_fid` VALUES (33, 136);
INSERT INTO `qb_hy_company_fid` VALUES (34, 11);
INSERT INTO `qb_hy_company_fid` VALUES (34, 21);
INSERT INTO `qb_hy_company_fid` VALUES (34, 33);
INSERT INTO `qb_hy_company_fid` VALUES (34, 46);
INSERT INTO `qb_hy_company_fid` VALUES (34, 59);
INSERT INTO `qb_hy_company_fid` VALUES (34, 73);
INSERT INTO `qb_hy_company_fid` VALUES (34, 87);
INSERT INTO `qb_hy_company_fid` VALUES (34, 105);
INSERT INTO `qb_hy_company_fid` VALUES (34, 119);
INSERT INTO `qb_hy_company_fid` VALUES (34, 136);
INSERT INTO `qb_hy_company_fid` VALUES (35, 11);
INSERT INTO `qb_hy_company_fid` VALUES (35, 21);
INSERT INTO `qb_hy_company_fid` VALUES (35, 33);
INSERT INTO `qb_hy_company_fid` VALUES (35, 46);
INSERT INTO `qb_hy_company_fid` VALUES (35, 59);
INSERT INTO `qb_hy_company_fid` VALUES (35, 73);
INSERT INTO `qb_hy_company_fid` VALUES (35, 87);
INSERT INTO `qb_hy_company_fid` VALUES (35, 105);
INSERT INTO `qb_hy_company_fid` VALUES (35, 119);
INSERT INTO `qb_hy_company_fid` VALUES (35, 136);
INSERT INTO `qb_hy_company_fid` VALUES (36, 11);
INSERT INTO `qb_hy_company_fid` VALUES (36, 21);
INSERT INTO `qb_hy_company_fid` VALUES (36, 33);
INSERT INTO `qb_hy_company_fid` VALUES (36, 46);
INSERT INTO `qb_hy_company_fid` VALUES (36, 59);
INSERT INTO `qb_hy_company_fid` VALUES (36, 73);
INSERT INTO `qb_hy_company_fid` VALUES (36, 87);
INSERT INTO `qb_hy_company_fid` VALUES (36, 105);
INSERT INTO `qb_hy_company_fid` VALUES (36, 119);
INSERT INTO `qb_hy_company_fid` VALUES (36, 136);
INSERT INTO `qb_hy_company_fid` VALUES (37, 11);
INSERT INTO `qb_hy_company_fid` VALUES (37, 21);
INSERT INTO `qb_hy_company_fid` VALUES (37, 33);
INSERT INTO `qb_hy_company_fid` VALUES (37, 46);
INSERT INTO `qb_hy_company_fid` VALUES (37, 59);
INSERT INTO `qb_hy_company_fid` VALUES (37, 73);
INSERT INTO `qb_hy_company_fid` VALUES (37, 87);
INSERT INTO `qb_hy_company_fid` VALUES (37, 105);
INSERT INTO `qb_hy_company_fid` VALUES (37, 119);
INSERT INTO `qb_hy_company_fid` VALUES (37, 136);

# --------------------------------------------------------

#
# 表的结构 `qb_hy_config`
#

DROP TABLE IF EXISTS `qb_hy_config`;
CREATE TABLE `qb_hy_config` (
  `c_key` varchar(50) NOT NULL default '',
  `c_value` text NOT NULL,
  `c_descrip` text NOT NULL,
  PRIMARY KEY  (`c_key`)
) TYPE=MyISAM;

#
# 导出表中的数据 `qb_hy_config`
#

INSERT INTO `qb_hy_config` VALUES ('Info_webOpen', '1', '');
INSERT INTO `qb_hy_config` VALUES ('sort_layout', '1,5#3,8,7#2,4,6#', '');
INSERT INTO `qb_hy_config` VALUES ('module_id', '16', '');
INSERT INTO `qb_hy_config` VALUES ('gg_map_api', 'ABQIAAAAlNgPp05cAGeYiuhUaYZaQxT2hWcVQgqOjltVi_oi0-IXnv8sfRRB0xK-_hJ6X9fvCiWkheAw1gnL8Q', '');
INSERT INTO `qb_hy_config` VALUES ('vipselfdomain', '', '');
INSERT INTO `qb_hy_config` VALUES ('vipselfdomaincannot', '', '');
INSERT INTO `qb_hy_config` VALUES ('creat_home_money', '0', '');
INSERT INTO `qb_hy_config` VALUES ('module_pre', 'hy_', '');
INSERT INTO `qb_hy_config` VALUES ('Index_listsortnum', '3', '');
INSERT INTO `qb_hy_config` VALUES ('module_close', '0', '');
INSERT INTO `qb_hy_config` VALUES ('Info_webname', '黄页模块', '');

# --------------------------------------------------------

#
# 表的结构 `qb_hy_dianping`
#

DROP TABLE IF EXISTS `qb_hy_dianping`;
CREATE TABLE `qb_hy_dianping` (
  `cid` mediumint(7) unsigned NOT NULL auto_increment,
  `cuid` int(7) NOT NULL default '0',
  `type` tinyint(2) NOT NULL default '0',
  `id` mediumint(7) unsigned NOT NULL default '0',
  `fid` mediumint(7) unsigned NOT NULL default '0',
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `posttime` int(10) NOT NULL default '0',
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  `icon` tinyint(3) NOT NULL default '0',
  `yz` tinyint(1) NOT NULL default '0',
  `fen1` smallint(4) NOT NULL default '0',
  `fen2` smallint(4) NOT NULL default '0',
  `fen3` smallint(4) NOT NULL default '0',
  `fen4` smallint(4) NOT NULL default '0',
  `fen5` smallint(4) NOT NULL default '0',
  `flowers` smallint(4) NOT NULL default '0',
  `egg` smallint(4) NOT NULL default '0',
  `price` mediumint(5) NOT NULL default '0',
  `keywords` varchar(100) NOT NULL default '',
  `keywords2` varchar(100) NOT NULL default '',
  `fen6` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`cid`),
  KEY `type` (`type`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# 导出表中的数据 `qb_hy_dianping`
#

INSERT INTO `qb_hy_dianping` VALUES (3, 1, 0, 1, 0, 1, 'admin', 1290066331, '太好了!!', '127.0.0.1', 0, 1, 1, 3, 5, 4, 0, 0, 0, 52, '', '', '');
INSERT INTO `qb_hy_dianping` VALUES (4, 1, 0, 1, 0, 1, 'admin', 1290495895, '好商家,很讲诚信!', '127.0.0.1', 0, 1, 1, 1, 2, 4, 2, 0, 0, 23, '', '', '');
INSERT INTO `qb_hy_dianping` VALUES (5, 1, 0, 1, 0, 1, 'admin', 1290495930, '下次还会再来的.太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!太好了!!<br>', '127.0.0.1', 0, 1, 4, 4, 3, 3, 2, 0, 0, 23, '', '', '');
INSERT INTO `qb_hy_dianping` VALUES (6, 1, 0, 1, 0, 1, 'admin', 1290495942, '好商家,很讲诚信!<br>好商家,很讲诚信!<br>好商家,很讲诚信!<br>好商家,很讲诚信!<br>好商家,很讲诚信!<br>好商家,很讲诚信!<br>好商家,很讲诚信!<br>好商家,很讲诚信!<br>好商家,很讲诚信!<br>好商家,很讲诚信!<br>', '127.0.0.1', 0, 1, 4, 4, 3, 3, 2, 0, 0, 23, '', '', '');

# --------------------------------------------------------

#
# 表的结构 `qb_hy_friendlink`
#

DROP TABLE IF EXISTS `qb_hy_friendlink`;
CREATE TABLE `qb_hy_friendlink` (
  `ck_id` int(10) unsigned NOT NULL auto_increment,
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `username` varchar(16) NOT NULL default '',
  `companyName` varchar(64) NOT NULL default '',
  `title` varchar(128) NOT NULL default '',
  `url` varchar(248) NOT NULL default '',
  `description` text NOT NULL,
  `yz` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ck_id`),
  KEY `uid` (`uid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# 导出表中的数据 `qb_hy_friendlink`
#


# --------------------------------------------------------

#
# 表的结构 `qb_hy_guestbook`
#

DROP TABLE IF EXISTS `qb_hy_guestbook`;
CREATE TABLE `qb_hy_guestbook` (
  `id` int(7) NOT NULL auto_increment,
  `cuid` mediumint(7) NOT NULL default '0',
  `uid` int(7) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ip` varchar(15) NOT NULL default '',
  `content` text NOT NULL,
  `yz` tinyint(1) NOT NULL default '0',
  `posttime` int(16) NOT NULL default '0',
  `list` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `cuid` (`cuid`),
  KEY `uid` (`uid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# 导出表中的数据 `qb_hy_guestbook`
#


# --------------------------------------------------------

#
# 表的结构 `qb_hy_home`
#

DROP TABLE IF EXISTS `qb_hy_home`;
CREATE TABLE `qb_hy_home` (
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `username` varchar(32) NOT NULL default '',
  `style` varchar(32) NOT NULL default '',
  `index_left` varchar(248) NOT NULL default '',
  `index_right` varchar(248) NOT NULL default '',
  `listnum` text NOT NULL,
  `banner` varchar(248) NOT NULL default '',
  `bodytpl` varchar(8) NOT NULL default 'left',
  `renzheng_show` tinyint(1) NOT NULL default '0',
  `visitor` text NOT NULL,
  `hits` mediumint(7) NOT NULL default '0',
  `head_menu` text NOT NULL,
  UNIQUE KEY `uid` (`uid`)
) TYPE=MyISAM;

#
# 导出表中的数据 `qb_hy_home`
#

INSERT INTO `qb_hy_home` VALUES (1, 'admin', 'vip_1', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";s:1:"4";s:7:"visitor";s:2:"10";s:8:"newslist";s:2:"10";s:10:"friendlink";s:2:"10";s:10:"Mguestbook";s:2:"10";s:9:"Mnewslist";s:2:"10";s:8:"Mvisitor";s:2:"40";}', '', '', 0, '0	127.0.0.1	1289819988\r\n9	fdsafsdw	1282633598', 584, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (30, 'test4', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '', 1, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (29, 'test3', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '1	admin	1288845790', 2, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (28, 'test2', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '', 1, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (27, 'test1', 'red', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";s:1:"4";s:7:"visitor";s:2:"10";s:8:"newslist";s:2:"10";s:10:"friendlink";s:2:"10";s:10:"Mguestbook";s:2:"10";s:9:"Mnewslist";s:2:"10";s:8:"Mvisitor";s:2:"40";}', '', '', 0, '', 5, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (31, 'test5', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '', 0, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (32, 'test6', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '', 1, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (33, 'test7', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '', 1, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (34, 'test8', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '1	admin	1288761162', 5, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (35, 'test9', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '', 1, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (36, 'test10', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '', 1, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');
INSERT INTO `qb_hy_home` VALUES (37, 'test11', 'default', 'base,tongji,news,ck', 'info', 'a:7:{s:9:"guestbook";i:4;s:7:"visitor";i:10;s:8:"newslist";i:10;s:10:"friendlink";i:10;s:10:"Mguestbook";i:10;s:8:"Mvisitor";i:40;s:9:"Mnewslist";i:10;}', '', 'left', 0, '1	admin	1291712588', 32, 'a:9:{i:0;a:4:{s:5:"title";s:8:"商家首页";s:3:"url";s:1:"?";s:5:"order";s:2:"10";s:6:"ifshow";i:1;}i:1;a:4:{s:5:"title";s:8:"商家介绍";s:3:"url";s:7:"?m=info";s:5:"order";s:1:"9";s:6:"ifshow";i:1;}i:2;a:4:{s:5:"title";s:8:"商家新闻";s:3:"url";s:7:"?m=news";s:5:"order";s:1:"8";s:6:"ifshow";i:1;}i:11;a:4:{s:5:"title";s:8:"商家产品";s:3:"url";s:7:"?m=shop";s:5:"order";s:1:"7";s:6:"ifshow";i:1;}i:12;a:4:{s:5:"title";s:8:"促销信息";s:3:"url";s:9:"?m=coupon";s:5:"order";s:1:"5";s:6:"ifshow";i:1;}i:13;a:4:{s:5:"title";s:8:"招聘信息";s:3:"url";s:6:"?m=job";s:5:"order";s:1:"4";s:6:"ifshow";i:1;}i:4;a:4:{s:5:"title";s:8:"图片展示";s:3:"url";s:7:"?m=pics";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:14;a:4:{s:5:"title";s:8:"顾客点评";s:3:"url";s:11:"?m=dianping";s:5:"order";s:1:"2";s:6:"ifshow";i:1;}i:8;a:4:{s:5:"title";s:8:"联系方式";s:3:"url";s:12:"?m=contactus";s:5:"order";s:1:"1";s:6:"ifshow";i:1;}}');

# --------------------------------------------------------

#
# 表的结构 `qb_hy_mysort`
#

DROP TABLE IF EXISTS `qb_hy_mysort`;
CREATE TABLE `qb_hy_mysort` (
  `ms_id` int(10) unsigned NOT NULL auto_increment,
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `sortname` char(32) NOT NULL default '',
  `fup` int(10) unsigned NOT NULL default '0',
  `listorder` int(8) unsigned NOT NULL default '0',
  `ctype` tinyint(1) NOT NULL default '1',
  `hits` int(8) unsigned NOT NULL default '0',
  `best` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ms_id`),
  KEY `uid` (`uid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# 导出表中的数据 `qb_hy_mysort`
#


# --------------------------------------------------------

#
# 表的结构 `qb_hy_news`
#

DROP TABLE IF EXISTS `qb_hy_news`;
CREATE TABLE `qb_hy_news` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `title` varchar(150) NOT NULL default '',
  `content` text NOT NULL,
  `hits` mediumint(7) NOT NULL default '0',
  `posttime` int(10) unsigned NOT NULL default '0',
  `list` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `titlecolor` varchar(15) NOT NULL default '',
  `fonttype` tinyint(1) NOT NULL default '0',
  `picurl` varchar(150) NOT NULL default '',
  `ispic` tinyint(1) NOT NULL default '0',
  `yz` tinyint(1) NOT NULL default '0',
  `levels` tinyint(1) NOT NULL default '0',
  `keywords` varchar(100) NOT NULL default '',
  `bd_pics` varchar(248) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `posttime` (`posttime`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# 导出表中的数据 `qb_hy_news`
#


# --------------------------------------------------------

#
# 表的结构 `qb_hy_pic`
#

DROP TABLE IF EXISTS `qb_hy_pic`;
CREATE TABLE `qb_hy_pic` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `psid` int(10) unsigned NOT NULL default '0',
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `username` varchar(32) NOT NULL default '',
  `title` varchar(128) NOT NULL default '',
  `url` varchar(248) NOT NULL default '',
  `level` tinyint(1) NOT NULL default '0',
  `yz` tinyint(1) NOT NULL default '0',
  `posttime` int(10) unsigned NOT NULL default '0',
  `isfm` tinyint(1) NOT NULL default '0',
  `orderlist` mediumint(5) NOT NULL default '0',
  `type` varchar(8) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `uid` (`uid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# 导出表中的数据 `qb_hy_pic`
#


# --------------------------------------------------------

#
# 表的结构 `qb_hy_picsort`
#

DROP TABLE IF EXISTS `qb_hy_picsort`;
CREATE TABLE `qb_hy_picsort` (
  `psid` int(10) unsigned NOT NULL auto_increment,
  `psup` int(10) unsigned NOT NULL default '0',
  `name` varchar(16) NOT NULL default '',
  `remarks` varchar(248) NOT NULL default '',
  `uid` mediumint(7) unsigned NOT NULL default '0',
  `username` varchar(16) NOT NULL default '',
  `level` tinyint(1) NOT NULL default '0',
  `posttime` int(10) unsigned NOT NULL default '0',
  `orderlist` mediumint(4) unsigned NOT NULL default '0',
  `faceurl` varchar(248) NOT NULL default '',
  PRIMARY KEY  (`psid`),
  KEY `uid` (`uid`,`orderlist`)
) TYPE=MyISAM AUTO_INCREMENT=23 ;

#
# 导出表中的数据 `qb_hy_picsort`
#

INSERT INTO `qb_hy_picsort` VALUES (1, 0, '产品图库', '记录产品多方面图片资料', 27, 'test1', 0, 1288661741, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (2, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 27, 'test1', 0, 1288661741, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (3, 0, '产品图库', '记录产品多方面图片资料', 28, 'test2', 0, 1288662180, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (4, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 28, 'test2', 0, 1288662180, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (5, 0, '产品图库', '记录产品多方面图片资料', 29, 'test3', 0, 1288662327, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (6, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 29, 'test3', 0, 1288662327, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (7, 0, '产品图库', '记录产品多方面图片资料', 30, 'test4', 0, 1288662567, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (8, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 30, 'test4', 0, 1288662567, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (9, 0, '产品图库', '记录产品多方面图片资料', 31, 'test5', 0, 1288662786, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (10, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 31, 'test5', 0, 1288662786, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (11, 0, '产品图库', '记录产品多方面图片资料', 32, 'test6', 0, 1288662947, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (12, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 32, 'test6', 0, 1288662947, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (13, 0, '产品图库', '记录产品多方面图片资料', 33, 'test7', 0, 1288663129, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (14, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 33, 'test7', 0, 1288663129, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (15, 0, '产品图库', '记录产品多方面图片资料', 34, 'test8', 0, 1288663299, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (16, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 34, 'test8', 0, 1288663299, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (17, 0, '产品图库', '记录产品多方面图片资料', 35, 'test9', 0, 1288663462, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (18, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 35, 'test9', 0, 1288663462, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (19, 0, '产品图库', '记录产品多方面图片资料', 36, 'test10', 0, 1288663617, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (20, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 36, 'test10', 0, 1288663617, 1, '');
INSERT INTO `qb_hy_picsort` VALUES (21, 0, '产品图库', '记录产品多方面图片资料', 37, 'test11', 0, 1288663816, 2, '');
INSERT INTO `qb_hy_picsort` VALUES (22, 0, '资质说明', '荣誉证书，获奖证书，营业执照', 37, 'test11', 0, 1288663816, 1, '');

# --------------------------------------------------------

#
# 表的结构 `qb_hy_sort`
#

DROP TABLE IF EXISTS `qb_hy_sort`;
CREATE TABLE `qb_hy_sort` (
  `fid` mediumint(7) unsigned NOT NULL auto_increment,
  `fup` mediumint(7) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `mid` smallint(4) NOT NULL default '0',
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
  `metatitle` varchar(250) NOT NULL default '',
  `metakeywords` varchar(255) NOT NULL default '',
  `metadescription` varchar(255) NOT NULL default '',
  `allowcomment` tinyint(1) NOT NULL default '0',
  `allowpost` varchar(150) NOT NULL default '',
  `allowviewtitle` varchar(150) NOT NULL default '',
  `allowviewcontent` varchar(150) NOT NULL default '',
  `allowdownload` varchar(150) NOT NULL default '',
  `forbidshow` tinyint(1) NOT NULL default '0',
  `config` mediumtext NOT NULL,
  `index_show` tinyint(1) NOT NULL default '0',
  `contents` mediumint(4) NOT NULL default '0',
  `tableid` varchar(30) NOT NULL default '',
  `dir_name` varchar(50) NOT NULL default '',
  `ifcolor` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`fid`)
) TYPE=MyISAM AUTO_INCREMENT=73 ;

#
# 导出表中的数据 `qb_hy_sort`
#

INSERT INTO `qb_hy_sort` VALUES (1, 0, '餐饮美食', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (2, 0, '休闲娱乐', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (3, 0, '旅游酒店', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (4, 0, '便民服务', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (5, 0, '美容保健', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (6, 0, '房产家居', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (7, 0, '购物', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (8, 0, '医疗健康', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (9, 0, '咨询中介', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (10, 0, '教育培训', 0, 1, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (11, 1, '西餐厅', 0, 2, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (12, 1, '牛排馆', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (13, 1, '韩国料理', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (14, 1, '火锅/砂锅', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (15, 1, '日本料理', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (16, 1, '自助餐厅', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (17, 1, '海鲜', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (18, 1, '土菜/农家菜', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (19, 1, '快餐/小吃', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (20, 1, '批萨/意大利菜', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (21, 2, '歌舞厅', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (22, 2, 'KTV', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (23, 2, '体育场所', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (24, 2, '音乐厅', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (25, 2, '休闲娱乐场所', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (26, 3, '旅馆/旅社/宿舍', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (27, 3, '签证服务', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (28, 3, '景点景区', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (29, 3, '住宿预订', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (30, 3, '连锁型宾馆酒店', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (31, 4, '电脑/数码维修维护', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (32, 4, '二手/回收', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (33, 4, '婚庆服务', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (34, 4, '摄影/摄像/冲洗', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (35, 4, '营业厅', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (36, 4, '婚庆庆典/摄影摄像', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (37, 4, '搬家/搬运', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (38, 5, '成人用品', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (39, 5, '保健品', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (40, 5, '美甲', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (41, 5, '减肥', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (42, 6, '照明灯饰', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (43, 6, '装修装璜服务', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (44, 6, '家居店', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (45, 6, '商铺', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (46, 6, '商务房产', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (47, 7, '鞋帽/箱包/皮具', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (48, 7, '综合市场', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (49, 7, '批发和零售', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (50, 7, '婴幼儿用品', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (51, 7, '服装市场', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (52, 7, '超市便利', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (53, 7, '礼品/工艺品', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (54, 8, '妇幼医院', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (55, 8, '心理咨询', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (56, 8, '女性健康', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (57, 8, '整容整形', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (58, 10, '教育培训学校', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (59, 10, '电脑培训', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (60, 10, '驾校/陪练', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (61, 10, '辅导班', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (62, 10, '学术/科研', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (63, 10, '成人教育', 0, 2, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', '', 0, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (64, 9, '中介服务咨询服务', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (65, 9, '鉴定中心/评估', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (66, 9, '出国/移民', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (67, 9, '留学', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (68, 9, '招聘服务', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (69, 9, '婚介/交友', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (70, 9, '工商代理', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (71, 9, '会计师事务所', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
INSERT INTO `qb_hy_sort` VALUES (72, 9, '法律咨询/诉讼', 0, 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', '', 1, '', '', '', '', 0, '', 0, 0, '', '', 0);
