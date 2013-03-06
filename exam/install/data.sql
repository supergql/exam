INSERT INTO `qb_module` (`id`, `type`, `name`, `pre`, `dirname`, `domain`, `admindir`, `config`, `list`, `admingroup`, `adminmember`, `ifclose`) VALUES (17, 2, '考试模块', 'exam_', 'exam', '', '', 'a:7:{s:12:"list_PhpName";s:18:"list.php?&fid=$fid";s:12:"show_PhpName";s:29:"bencandy.php?&fid=$fid&id=$id";s:8:"MakeHtml";N;s:14:"list_HtmlName1";N;s:14:"show_HtmlName1";N;s:14:"list_HtmlName2";N;s:14:"show_HtmlName2";N;}', 0, '', '', 0);




# --------------------------------------------------------

#
# 表的结构 `qb_exam_cache`
#

DROP TABLE IF EXISTS `qb_exam_cache`;
CREATE TABLE `qb_exam_cache` (
  `uid` mediumint(7) NOT NULL default '0',
  `form_id` int(7) NOT NULL default '0',
  `jointime` int(10) NOT NULL default '0',
  KEY `uid` (`uid`),
  KEY `form_id` (`form_id`)
) TYPE=HEAP;

#
# 导出表中的数据 `qb_exam_cache`
#


# --------------------------------------------------------

#
# 表的结构 `qb_exam_config`
#

DROP TABLE IF EXISTS `qb_exam_config`;
CREATE TABLE `qb_exam_config` (
  `c_key` varchar(50) NOT NULL default '',
  `c_value` text NOT NULL,
  `c_descrip` text NOT NULL,
  PRIMARY KEY  (`c_key`)
) TYPE=MyISAM;

#
# 导出表中的数据 `qb_exam_config`
#

INSERT INTO `qb_exam_config` VALUES ('Info_delpaper', '0', '');
INSERT INTO `qb_exam_config` VALUES ('module_close', '0', '');
INSERT INTO `qb_exam_config` VALUES ('Info_webname', '考试模块', '');
INSERT INTO `qb_exam_config` VALUES ('Info_webOpen', '1', '');
INSERT INTO `qb_exam_config` VALUES ('module_pre', 'exam_', '');
INSERT INTO `qb_exam_config` VALUES ('module_id', '17', '');

# --------------------------------------------------------

#
# 表的结构 `qb_exam_form`
#

DROP TABLE IF EXISTS `qb_exam_form`;
CREATE TABLE `qb_exam_form` (
  `id` mediumint(7) NOT NULL auto_increment,
  `type` tinyint(1) NOT NULL default '0',
  `fid` mediumint(6) NOT NULL default '0',
  `name` varchar(150) NOT NULL default '',
  `config` text NOT NULL,
  `uid` mediumint(7) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ifshare` tinyint(1) NOT NULL default '0',
  `ifclose` tinyint(1) NOT NULL default '0',
  `creattime` int(10) NOT NULL default '0',
  `list` int(10) NOT NULL default '0',
  `recommend` tinyint(1) NOT NULL default '0',
  `levelstime` int(10) NOT NULL default '0',
  `yz` tinyint(1) NOT NULL default '0',
  `joins` mediumint(7) NOT NULL default '0',
  `money` smallint(4) NOT NULL default '0',
  `iftruename` tinyint(1) NOT NULL default '1',
  `ifclass` tinyint(1) NOT NULL default '1',
  `ifnumber` tinyint(1) NOT NULL default '1',
  `totaltime` mediumint(3) NOT NULL default '0',
  `allowjoin` varchar(255) NOT NULL default '',
  `begintime` int(10) NOT NULL default '0',
  `endtime` int(10) NOT NULL default '0',
  `hidefen` tinyint(1) NOT NULL default '0',
  `content` text NOT NULL,
  `hits` mediumint(7) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `joins` (`joins`),
  KEY `recommend` (`recommend`),
  KEY `money` (`money`),
  KEY `fid` (`fid`),
  KEY `uid` (`uid`)
) TYPE=MyISAM AUTO_INCREMENT=30 ;

#
# 导出表中的数据 `qb_exam_form`
#

INSERT INTO `qb_exam_form` VALUES (18, 0, 3, '一年级期中考试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1283154319, 0, 0, 0, 0, 0, 0, 1, 1, 1, 30, '', 0, 0, 1, '', 0);
INSERT INTO `qb_exam_form` VALUES (19, 0, 30, '北京市2009年度人力资源联考试题', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289193980, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 0);
INSERT INTO `qb_exam_form` VALUES (20, 0, 29, '广东省2003年度教师资格水平测试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289193992, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 0);
INSERT INTO `qb_exam_form` VALUES (21, 0, 26, '2000年全国报关员考试水平测试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289193999, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 0);
INSERT INTO `qb_exam_form` VALUES (22, 0, 23, '二零零五年度初级会计职称水平测试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289194006, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 2);
INSERT INTO `qb_exam_form` VALUES (23, 0, 3, '2008年政法干警司法考试第一卷', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289194013, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 3);
INSERT INTO `qb_exam_form` VALUES (24, 0, 17, '2009年度上半年英语四级全国联考', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289194021, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 1);
INSERT INTO `qb_exam_form` VALUES (25, 0, 15, '2010年度微软认证水平测试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289194028, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '3,4,8,9,10', 0, 0, 0, '', 0);
INSERT INTO `qb_exam_form` VALUES (26, 0, 13, '全国联考计算机二级入门水平测试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289194035, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 1);
INSERT INTO `qb_exam_form` VALUES (27, 0, 11, '初一语文第一学期期中考试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289194043, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 0);
INSERT INTO `qb_exam_form` VALUES (28, 0, 10, 'SEO推广水平测试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289194050, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 4);
INSERT INTO `qb_exam_form` VALUES (29, 0, 5, '初级站长了解互联网的入门知识考试', 'a:1:{s:5:"fendb";a:9:{i:1;s:2:"30";i:2;s:2:"10";i:3;s:2:"10";i:4;s:2:"10";i:5;s:2:"10";i:6;s:2:"10";i:7;s:2:"10";i:8;s:2:"10";i:9;s:2:"10";}}', 1, 'admin', 0, 0, 1289201702, 0, 0, 0, 1, 1, 0, 1, 1, 1, 0, '', 0, 0, 0, '', 33);

# --------------------------------------------------------

#
# 表的结构 `qb_exam_form_element`
#

DROP TABLE IF EXISTS `qb_exam_form_element`;
CREATE TABLE `qb_exam_form_element` (
  `element_id` int(7) NOT NULL auto_increment,
  `form_id` mediumint(7) NOT NULL default '0',
  `title_id` mediumint(7) NOT NULL default '0',
  `list` int(10) NOT NULL default '0',
  PRIMARY KEY  (`element_id`),
  KEY `form_id` (`form_id`),
  KEY `title_id` (`title_id`),
  KEY `list` (`list`)
) TYPE=MyISAM AUTO_INCREMENT=121 ;

#
# 导出表中的数据 `qb_exam_form_element`
#

INSERT INTO `qb_exam_form_element` VALUES (1, 18, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (2, 18, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (3, 18, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (4, 18, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (5, 18, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (6, 18, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (7, 18, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (8, 18, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (9, 18, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (10, 18, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (11, 19, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (12, 19, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (13, 19, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (14, 19, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (15, 19, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (16, 19, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (17, 19, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (18, 19, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (19, 19, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (20, 19, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (21, 20, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (22, 20, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (23, 20, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (24, 20, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (25, 20, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (26, 20, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (27, 20, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (28, 20, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (29, 20, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (30, 20, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (31, 21, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (32, 21, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (33, 21, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (34, 21, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (35, 21, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (36, 21, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (37, 21, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (38, 21, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (39, 21, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (40, 21, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (41, 22, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (42, 22, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (43, 22, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (44, 22, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (45, 22, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (46, 22, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (47, 22, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (48, 22, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (49, 22, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (50, 22, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (51, 23, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (52, 23, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (53, 23, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (54, 23, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (55, 23, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (56, 23, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (57, 23, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (58, 23, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (59, 23, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (60, 23, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (61, 24, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (62, 24, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (63, 24, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (64, 24, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (65, 24, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (66, 24, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (67, 24, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (68, 24, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (69, 24, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (70, 24, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (71, 25, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (72, 25, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (73, 25, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (74, 25, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (75, 25, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (76, 25, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (77, 25, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (78, 25, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (79, 25, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (80, 25, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (81, 26, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (82, 26, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (83, 26, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (84, 26, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (85, 26, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (86, 26, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (87, 26, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (88, 26, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (89, 26, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (90, 26, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (91, 27, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (92, 27, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (93, 27, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (94, 27, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (95, 27, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (96, 27, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (97, 27, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (98, 27, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (99, 27, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (100, 27, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (101, 28, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (102, 28, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (103, 28, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (104, 28, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (105, 28, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (106, 28, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (107, 28, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (108, 28, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (109, 28, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (110, 28, 22, 0);
INSERT INTO `qb_exam_form_element` VALUES (111, 29, 15, 0);
INSERT INTO `qb_exam_form_element` VALUES (112, 29, 6, 0);
INSERT INTO `qb_exam_form_element` VALUES (113, 29, 23, 0);
INSERT INTO `qb_exam_form_element` VALUES (114, 29, 8, 0);
INSERT INTO `qb_exam_form_element` VALUES (115, 29, 9, 0);
INSERT INTO `qb_exam_form_element` VALUES (116, 29, 19, 0);
INSERT INTO `qb_exam_form_element` VALUES (117, 29, 20, 0);
INSERT INTO `qb_exam_form_element` VALUES (118, 29, 12, 0);
INSERT INTO `qb_exam_form_element` VALUES (119, 29, 13, 0);
INSERT INTO `qb_exam_form_element` VALUES (120, 29, 22, 0);

# --------------------------------------------------------

#
# 表的结构 `qb_exam_sort`
#

DROP TABLE IF EXISTS `qb_exam_sort`;
CREATE TABLE `qb_exam_sort` (
  `fid` mediumint(7) unsigned NOT NULL auto_increment,
  `fup` mediumint(7) unsigned NOT NULL default '0',
  `name` varchar(200) NOT NULL default '',
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
  PRIMARY KEY  (`fid`),
  KEY `fup` (`fup`)
) TYPE=MyISAM AUTO_INCREMENT=31 ;

#
# 导出表中的数据 `qb_exam_sort`
#

INSERT INTO `qb_exam_sort` VALUES (1, 0, '初中生试卷', 1, 2, 1, '', 0, 0, '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', 0, 'a:4:{s:11:"sonTitleRow";N;s:12:"sonTitleLeng";N;s:9:"cachetime";N;s:12:"sonListorder";N;}', '', '');
INSERT INTO `qb_exam_sort` VALUES (12, 0, '计算机等级考试', 1, 3, 1, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (13, 12, '计算机二级', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (3, 1, '初一数学试卷', 2, 0, 0, '', 0, 0, '', '', '', '', 'N;', '', 0, '', '', 0, '', '', '', '', 0, 'a:4:{s:11:"sonTitleRow";N;s:12:"sonTitleLeng";N;s:9:"cachetime";N;s:12:"sonListorder";N;}', '', '');
INSERT INTO `qb_exam_sort` VALUES (4, 0, '互联网', 1, 2, 1, '', 10, 0, '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', 0, 'b:0;', '', '');
INSERT INTO `qb_exam_sort` VALUES (5, 4, '互联网入门', 2, 0, 0, '', 10, 0, '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', 0, 'b:0;', '', '');
INSERT INTO `qb_exam_sort` VALUES (11, 1, '初一语文', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', 0, 'b:0;', '', '');
INSERT INTO `qb_exam_sort` VALUES (10, 4, 'SEO推广', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 0, '', '', '', '', 0, 'b:0;', '', '');
INSERT INTO `qb_exam_sort` VALUES (14, 12, '计算机一级', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (15, 12, '微软认证', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (16, 0, '外语考试', 1, 2, 1, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (17, 16, '英语四级', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (18, 16, '托福考试', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (19, 0, '公务员考试', 1, 2, 1, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (20, 19, '政法干警', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (21, 19, '事业单位', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (22, 0, '财务类', 1, 2, 1, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (23, 22, '初级会计职称', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (24, 22, '注册会计师', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (25, 0, '外贸类', 1, 2, 1, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (26, 25, '报关员考试', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (27, 25, '物流师考', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (28, 0, '职业资格考试', 1, 2, 1, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (29, 28, '教师资格', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');
INSERT INTO `qb_exam_sort` VALUES (30, 28, '人力资源', 2, 0, 0, '', 0, 0, '', '', '', '', '', '', 0, '', '', 1, '', '', '', '', 0, '', '', '');

# --------------------------------------------------------

#
# 表的结构 `qb_exam_student`
#

DROP TABLE IF EXISTS `qb_exam_student`;
CREATE TABLE `qb_exam_student` (
  `student_id` int(7) NOT NULL auto_increment,
  `student_uid` mediumint(7) NOT NULL default '0',
  `student_name` varchar(30) NOT NULL default '',
  `student_truename` varchar(30) NOT NULL default '',
  `aclass` varchar(30) NOT NULL default '',
  `number` varchar(30) NOT NULL default '',
  `form_id` mediumint(7) NOT NULL default '0',
  `total_fen` smallint(4) NOT NULL default '0',
  `posttime` int(10) NOT NULL default '0',
  `yz` tinyint(1) NOT NULL default '0',
  `totaltime` mediumint(7) NOT NULL default '0',
  PRIMARY KEY  (`student_id`),
  KEY `form_id` (`form_id`),
  KEY `student_uid` (`student_uid`,`yz`),
  KEY `total_fen` (`total_fen`,`totaltime`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# 导出表中的数据 `qb_exam_student`
#

INSERT INTO `qb_exam_student` VALUES (1, 1, 'admin', '', '', '', 28, 46, 1289268119, 0, 0);
INSERT INTO `qb_exam_student` VALUES (2, 1, 'admin', '', '', '', 20, 46, 1289268462, 1, 0);
INSERT INTO `qb_exam_student` VALUES (3, 1, 'admin', '', '', '', 29, 0, 1289367714, 0, 1);
INSERT INTO `qb_exam_student` VALUES (4, 2, '张生', '', '', '', 29, 90, 1289268462, 0, 0);

# --------------------------------------------------------

#
# 表的结构 `qb_exam_student_title`
#

DROP TABLE IF EXISTS `qb_exam_student_title`;
CREATE TABLE `qb_exam_student_title` (
  `st_id` int(7) NOT NULL auto_increment,
  `title_id` mediumint(7) NOT NULL default '0',
  `student_id` mediumint(7) NOT NULL default '0',
  `form_id` mediumint(7) NOT NULL default '0',
  `answer` text NOT NULL,
  `fen` smallint(3) NOT NULL default '0',
  `comment` text NOT NULL,
  PRIMARY KEY  (`st_id`)
) TYPE=MyISAM AUTO_INCREMENT=20 ;

#
# 导出表中的数据 `qb_exam_student_title`
#

INSERT INTO `qb_exam_student_title` VALUES (1, 15, 1, 28, 'a', 0, '');
INSERT INTO `qb_exam_student_title` VALUES (2, 6, 1, 28, 'c', 15, '');
INSERT INTO `qb_exam_student_title` VALUES (3, 23, 1, 28, 'a\nb', 5, '');
INSERT INTO `qb_exam_student_title` VALUES (4, 8, 1, 28, 'b', 10, '');
INSERT INTO `qb_exam_student_title` VALUES (5, 9, 1, 28, '7\n12\n', 6, '');
INSERT INTO `qb_exam_student_title` VALUES (6, 19, 1, 28, '1', 0, '');
INSERT INTO `qb_exam_student_title` VALUES (7, 20, 1, 28, '2', 10, '');
INSERT INTO `qb_exam_student_title` VALUES (8, 13, 1, 28, '12\r\n011', 0, '');
INSERT INTO `qb_exam_student_title` VALUES (9, 22, 1, 28, '21\r\n10', 0, '');
INSERT INTO `qb_exam_student_title` VALUES (10, 15, 2, 20, 'd', 0, '');
INSERT INTO `qb_exam_student_title` VALUES (11, 6, 2, 20, 'c', 15, '');
INSERT INTO `qb_exam_student_title` VALUES (12, 23, 2, 20, 'a\nb', 5, '');
INSERT INTO `qb_exam_student_title` VALUES (13, 8, 2, 20, 'b', 10, '');
INSERT INTO `qb_exam_student_title` VALUES (14, 9, 2, 20, '7\n12\n', 6, '');
INSERT INTO `qb_exam_student_title` VALUES (15, 19, 2, 20, 'abc', 0, '');
INSERT INTO `qb_exam_student_title` VALUES (16, 20, 2, 20, '2', 10, '');
INSERT INTO `qb_exam_student_title` VALUES (17, 13, 2, 20, 'fd\r\nwf', 0, '');
INSERT INTO `qb_exam_student_title` VALUES (18, 22, 2, 20, 'wfds\r\nwfds', 0, '');
INSERT INTO `qb_exam_student_title` VALUES (19, 9, 3, 29, '\n\n', 0, '');

# --------------------------------------------------------

#
# 表的结构 `qb_exam_title`
#

DROP TABLE IF EXISTS `qb_exam_title`;
CREATE TABLE `qb_exam_title` (
  `id` mediumint(7) NOT NULL auto_increment,
  `fid` smallint(4) NOT NULL default '0',
  `type` tinyint(2) NOT NULL default '0',
  `question` text NOT NULL,
  `config` text NOT NULL,
  `answer` text NOT NULL,
  `uid` mediumint(7) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `ifshare` tinyint(1) NOT NULL default '1',
  `yz` tinyint(1) NOT NULL default '0',
  `difficult` tinyint(1) NOT NULL default '0',
  `star` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `fid` (`fid`),
  KEY `yz` (`yz`),
  KEY `difficult` (`difficult`),
  KEY `star` (`star`)
) TYPE=MyISAM AUTO_INCREMENT=24 ;

#
# 导出表中的数据 `qb_exam_title`
#

INSERT INTO `qb_exam_title` VALUES (6, 3, 1, '3+3=? ', '4\r\n5\r\n6\r\n7', 'c', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (4, 3, 1, '2+3=? ', '2\r\n3\r\n4\r\n5', 'd', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (7, 3, 2, '下面哪个是整数 ', '2\r\n3\r\n4.5\r\n2.3', 'a,b', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (8, 3, 3, '1+1=3是正确的吗? ', '正确\r\n错误', 'b', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (9, 3, 4, '3+4=( )，3+9=( )，5+9=( )这三个等式都是加法运算。 ', '', '7\r\n12\r\n14', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (10, 3, 5, '请把以下数字由大到小排序', '12\r\n23\r\n56\r\n3\r\n7', 'cbaed', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (11, 3, 6, '1+2+3+4=?', '', '10', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (12, 3, 7, '请例出小于10能被2整除的数? ', '', '2,4,6,8', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (13, 3, 8, '齐博软件与齐博CMS是同一个概念吗?齐博软件包含哪些产品?', '', '', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (14, 3, 9, '请列出齐博软件曾经开发过的模块系统?', '', '', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (15, 5, 1, '齐博软件的公司地址在哪里?', '广州\r\n上海\r\n北京\r\n杭州', 'a', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (16, 5, 2, '齐博CMS曾经使用过的品牌名称有哪些?', '菁菁整站\r\nphp168\r\n齐博CMS\r\n龙城CMS', 'a,b,c', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (17, 5, 3, '齐博软件包含OA系统吗?', '正确\r\n错误', 'b', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (18, 5, 4, '齐博CMS的创始人是谁(),他的真实姓名是叫什么()?', '', '龙城\r\n李芳俊', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (19, 5, 5, '请把以下网站的创建日期从早到晚的顺序排一下?----直接填字母如abcdef： ', '新浪网\r\n开心网\r\n齐博网', 'acb', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (20, 5, 6, '1+1=', '', '2', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (21, 5, 7, '请你列出齐博软件有哪些主打产品?', '', '', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (22, 5, 9, '齐博软件如何能够更快的帮助广大站长营利?请你列出一些可行性的方案', '', '', 1, 'admin', 1, 0, 0, 0);
INSERT INTO `qb_exam_title` VALUES (23, 5, 2, '齐博软件包含哪些系统?', 'CMS整站系统\r\n分类信息系统\r\n地方门户系统\r\nB2B电子商务系统', 'a,b,c,d', 1, 'admin', 1, 0, 0, 0);
