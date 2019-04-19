-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2019-04-19 03:45:34
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `conch`
--

-- --------------------------------------------------------

--
-- 表的结构 `ad`
--

CREATE TABLE `ad` (
  `ad_id` int(11) NOT NULL,
  `ad_type` tinyint(1) NOT NULL COMMENT '类型（0：轮播图；1：侧边栏）',
  `ad_sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序',
  `ad_img` varchar(255) COLLATE utf8_bin NOT NULL,
  `upload_time` datetime DEFAULT NULL COMMENT '上传时间',
  `ad_state` tinyint(1) NOT NULL COMMENT '状态（0：隐藏；1：显示）'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `ad`
--

INSERT INTO `ad` (`ad_id`, `ad_type`, `ad_sort`, `ad_img`, `upload_time`, `ad_state`) VALUES
(1, 0, 3, '1.jpg', '2019-03-12 00:00:00', 0),
(2, 0, 2, '2.jpg', '2019-03-24 00:00:00', 0),
(3, 0, 1, '5c973d273076e.jpeg', '2019-03-24 16:17:43', 0),
(22, 1, 0, '5c99c1d6cc273.jpg', '2019-03-26 14:08:22', 0),
(21, 1, 0, '5c99bfd0210f1.png', '2019-03-26 13:59:44', 1),
(12, 0, 5, '5c97b3489aecd.jpg', '2019-03-25 00:41:44', 1),
(11, 0, 4, '5c97b3489a8ef.png', '2019-03-25 00:41:44', 1),
(17, 0, 3, '5c97b35debbf7.jpeg', '2019-03-25 00:42:05', 1),
(18, 0, 2, '5c97b35ded3cd.png', '2019-03-25 00:42:05', 1),
(19, 0, 1, '5c97b35deda51.jpg', '2019-03-25 00:42:05', 1),
(20, 0, 8, '5c97b35df1a73.jpg', '2019-03-25 00:42:05', 1),
(23, 1, 0, '5c99c26bd05bb.jpg', '2019-03-26 14:10:51', 0),
(24, 1, 0, '5cb6fc040c893.jpg', '2019-04-17 18:12:20', 1);

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL COMMENT '标识',
  `admin_account` varchar(11) COLLATE utf8_bin NOT NULL COMMENT '账号',
  `admin_password` varchar(18) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `admin_type` tinyint(1) NOT NULL COMMENT '类型（0：超管，1：班管）'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='管理员表';

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_account`, `admin_password`, `admin_type`) VALUES
(1, '111', '111', 1),
(2, '123', '123', 1),
(3, '222', '222', 1),
(4, '666', '666', 0),
(5, '13840801970', '123', 1),
(6, '15048991119', '123', 1);

-- --------------------------------------------------------

--
-- 表的结构 `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL COMMENT '标识',
  `class_img` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `class_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '班级名',
  `class_phone` varchar(15) COLLATE utf8_bin NOT NULL,
  `class_info` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '班级简介',
  `class_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '上课时间',
  `class_position` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `class_state` tinyint(1) NOT NULL COMMENT '状态（0：待审核，1：已通过，2：未通过）',
  `class_creatTime` date DEFAULT NULL COMMENT '创立时间',
  `apply_time` date DEFAULT NULL,
  `class_license` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '营业执照',
  `type_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL COMMENT '管理员id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='班级表';

--
-- 转存表中的数据 `classes`
--

INSERT INTO `classes` (`class_id`, `class_img`, `class_name`, `class_phone`, `class_info`, `class_time`, `class_position`, `class_state`, `class_creatTime`, `apply_time`, `class_license`, `type_id`, `admin_id`) VALUES
(1, '5c9def892f314.jpg', '华尔街英语(国贸中心)', '123123', '华尔街英语已在全球27个国家和地区拥有400多家中心，其总部设在美国马里兰州巴尔的摩。华尔街英语独特的教学方法，帮助全球300多万名学员成功提升英语能力。 从2000年开始，华尔街英语进入中国市场以来，已在北京、上海、广州、深圳、天津、青岛、杭州、南京、佛山、无锡、苏州开设了82家学习中心，均采用公司直营的管理方式，从而确保每家学习中心都能向学员提供高品质的学习体验。', '周一至周日 10:00-21:30', '北京市朝阳区国贸商城3期', 2, NULL, '2019-03-01', '1.jpg', 1, 1),
(2, '5c9eef334e8a8.jpg', '大象吉他俱乐部(双井店)', '111', '大象吉他，成立于2008年，专注于1对1高品质的吉他教学，我们为你提供专属的专业课程与教学方法，我们会站在你的角度配合你，支持你，和你一起尝试，实践，找到你享受音乐的方法，用你喜欢的方式学会你喜欢的乐器，开启你的音乐之旅。', '周一至周日 09:00-21:00', '北京市朝阳区首城国际-C座', 1, NULL, '2019-03-21', '1.jpg', 6, 1),
(3, '5c9dece64666e.jpg', '翰达音乐教育', '13840801970', '大连翰达音乐教育有限公司 在社会各界 鼎力支持下，发展成为集乐器专 卖、艺术培训、艺术考级、乐器 维修为一体的综合连锁经营的模 式，是行业中冉冉升起的一颗新 星。 翰达音乐教育提供高雅的消费环境和完善的服务功能;代理了国内外众多知名的乐器品牌，在保证产品质量的同时，建立了完善的售后服务体系，配备了专业的维修技术人员，让消费者享受到一站式的服务。', '123', '大连市金州区西山小区131-23号', 1, NULL, '2019-03-21', '1.jpg', 5, 2),
(4, '5c9ded577397a.jpg', 'Times piano时代成人钢琴学院(人民路教学中心)', '123123', '“时代钢琴”专注成人钢琴教育，教学中心环境优雅，设备高端，我们创编了一套真正适合成人学琴以及区别于传统钢琴教学的先进教材。拥有专业针对成人学琴的教学模式和教学体系，采用钢琴教学6S服务，让成人在合理的时间内不具乏味的掌握钢琴演奏技巧。课程分为兴趣课和专业类，可满足不同钢琴爱好者的需求。教学宗旨强调：专注、专业、实用，时代钢琴专注成人钢琴教育，因为专注，所以专业。', '周一至周日 12:00-21:00', '大连市中山区大连时代广场-A座', 1, NULL, '2019-03-13', '1.jpg', 8, 2),
(5, '5c9dedbb882b4.jpg', '艺林现代音乐艺术中心', '13840801970', '艺林现代音乐中心成立2005年，承办各种音乐知识的培训和讲座，拥有专业讲师和学员300余人，参加各种演出以及比赛，获得各界的一致好评，今后我们将更加努力，以求打造大连音乐普及和交流的业界精品。', '周一至周五 09:30-19:00 周六,周日 08:00-19:00', '大连市西岗区奥林匹克广场', 1, NULL, '2019-03-16', '5c910c4b58a95.jpg', 6, 2),
(6, '5c9dee8ce6d8f.jpg', '樱花国际日语大连分校', '123123', '“樱花国际日语” 是由新世界教育集团（日语红蓝宝书编著方、日语JTEST考级上海新世界考点）从日本引进的日本教育高端私人定制服务机构。 2007年2月在国内开设中心，在北、上、广等全国34个城市，开设了48家学习中心。 品牌在日本东京设立分公司，学校，留学生星级公寓。提供一站式赴日留学、游学、在日本学习期间住宿及各类后续留学保障服务。致力专业日本教育已十年。', '周一至周五 09:00-21:00 周六,周日 09:00-19:00', '大连市中山区天安国际大厦', 1, NULL, '2019-03-25', '5c986efacd799.png', 2, 2),
(7, '5c9dcb6a92d96.jpg', '新动态国际英语(罗斯福天兴店)', '13840801970', '新动态国际英语创立于2004年，现为武汉锦绣长江教育发展有限公司旗下的高端英语培训品牌。多年来致力于英语教学的有效性与实用性研究，秉承“语言学习是一个技能培养的过程”这一理念，引进全球领先的多媒体互动课程，并针对中国人学习英语的习惯和难点，成功推出新一代最适合中国人的“5i高效互动学习系统”，为学员构建多维度、立体化的O2O学习模式，全面提升英语学习者的英语技能和水平，真正帮助学员实现国际交往的无障碍沟通。', '周一至周日 09:00-12:00', '大连市沙河口区apm大连晟际物业管理有限公司(罗斯福天兴店)1层', 2, NULL, '2019-03-29', '5c9dbd564adfe.jpg', 1, 5),
(8, '5c9deb1168271.jpg', '韦博英语(罗斯福天兴中心)', '13840801970', '韦博英语创立于1998年，以英语口语培训为核心，为6周岁以上人群提供以实用为导向的中外教结合英语课程及相关服务。产品线包括：通用英语、青少英语、在线英语、出国考试英语。 基于科学严谨的学习方法和丰富多元的学习形式，韦博通过创造开放融合的学习环境和广泛联结的学习氛围，实现英语素养的渐进提升，带来融入生活的英语体验，从而让语言能力助力自在分享，让语言能量激发共同坚持。 目前，韦博英语在全国60多个城市拥有150多所培训中心，帮助近百万名学员自信说英语。', '周六,周日 16:00-19:00', '大连市沙河口区韦博英语(罗斯福中心)', 1, NULL, '2019-03-29', '5c9deb1167af6.jpg', 1, 5),
(9, '5c9ef1382283d.jpg', '北京韩亚韩国语学校', '13840801970', '北京韩亚韩国语学校隶属于东方韩亚（中国）教育机构，1996年成立于仅与韩国一水之隔的山东省烟台市。从业十多年来韩亚学校一直专注致力于韩国语教育，通过不断地发展和努力现已成为全国规模最大的专业韩国语培训学校。韩亚学校在北京、上海、广州、烟台等地设有分校，以培养出专业韩国语人才近万人，得到了学员与家长的一致认可。韩亚韩语学校拥有多年授课经验的专业教师团队、独特的课程与教学管理、五星级教学环境与先进的多媒体设施，目前已成为全国最受欢迎的专业韩国语学校。', '周一至周日 09:00-21:00', '北京市朝阳区建外SOHO西区-12号楼', 1, NULL, '2019-03-30', '5c9ef138215a2.jpg', 3, 3),
(10, '5c9f520bbfce1.jpg', '百灵鸟唱歌培训(月坛店)', '15048991119', '北京市四海盛轩文化传播有限公司旗下百灵鸟唱歌培训成立于2010年，是在北京市工商局注册的专业声乐技术培训企业，也是北京市第一家成人一对一，第一家以KTV为教学场地的唱歌培训机构，同时也是北京麦乐迪餐饮娱乐管理有限公司指定战略合作伙伴，企业至今已有近10年的历史，教授万余名学员。这里的声乐老师全是行业的精英，她们热爱歌唱，热爱授课，热爱帮助你发掘美丽声音，完成音乐梦想。 ', '周一至周日 11:00-20:00', '北京市西城区月坛大厦-北门', 1, NULL, '2019-03-30', '5c9f520bbf297.jpg', 5, 6),
(11, '5cb6a9407e639.jpg', '美上美学', '13840801970', '美上美学 （MaySun MayShine）是有信雅达文化艺术发展有限公司在艺术领域深耕五年之际，打造的高端美学教育平台。以“传递美学信仰”为使命，以“传播艺术美学、人文美学、生活美学”为目标，签约中国八大美院、九大艺术院校的专业师资，并邀请国际顶级艺术、人文、形象等各领域大师，共同开启最富有价值的美学教育平台。浙江信雅达文化艺术发展有限公司是有信雅达集团（600571）投资创建的、浙江省内收割专注于当代中国书画艺术的展示交流、教育推广、销售经营、艺术策划及资本运作与一体的大型综合艺术机构。', '周一至周日 10:00-21:00', '大连市西岗区奥林匹克广场', 1, NULL, '2019-04-17', '5cb6a9407d6c2.jpg', 10, 5),
(12, '5cb6d4b28d48b.jpg', '南鲸画室·专注成人美术教育', '15048991119', '南鲸画室是专业美术培训基地，画室以成人美术培训为核心，画室教师均美术科班出身，具有很高的专业素养，并在多年的教学中，积累了一套科学的教学方法，针对不同学员的个性特点与实际需求，为学员量身制定学习内容，注重在学习方法上追求效率。画室现开设有初高中美术兴趣班，成人基础班，成人零基础油画班。学习内容包含：油画、素描、水粉、速写、水彩、设计、手绘、插画漫画"', '周一至周日 09:00-21:00', '大连市沙河口区天兴罗斯福公寓', 2, NULL, '2019-04-17', '5cb6d4b28ccd5.jpg', 10, 6),
(13, '5cb7d6ad54671.jpg', '444', '15048991119', '141234123', '周一至周日 10:00-21:00', '大连市甘井子区大连海事大学', 0, NULL, '2019-04-18', '5cb7d6ad53da3.jpg', 27, 6),
(14, '5cb7d6da6b6ca.jpg', '444', '15048991119', '141234123', '周一至周日 10:00-21:00', '大连市甘井子区大连海事大学', 0, NULL, '2019-04-18', '5cb7d6da6ac3b.jpg', 27, 6),
(15, '5cb7d6fc31257.jpg', '444', '15048991119', '141234123', '周一至周日 10:00-21:00', '大连市甘井子区大连市体育中心体育场', 0, NULL, '2019-04-18', '5cb7d6fc30b0d.jpg', 0, 6);

-- --------------------------------------------------------

--
-- 表的结构 `classify`
--

CREATE TABLE `classify` (
  `classify_id` int(11) NOT NULL,
  `classify_name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `classify`
--

INSERT INTO `classify` (`classify_id`, `classify_name`) VALUES
(1, '语言培训'),
(2, '音乐培训'),
(3, '美术培训'),
(4, '升学辅导'),
(5, '留学'),
(6, '成人学历提升'),
(7, '职业培训'),
(8, '驾校'),
(9, '其他');

-- --------------------------------------------------------

--
-- 表的结构 `collection`
--

CREATE TABLE `collection` (
  `collection_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `collection_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='收藏表';

--
-- 转存表中的数据 `collection`
--

INSERT INTO `collection` (`collection_id`, `class_id`, `user_id`, `collection_time`) VALUES
(10, 7, 1, '2019-04-13 18:06:25'),
(3, 6, 2, '2019-04-10 17:34:18'),
(9, 6, 1, '2019-04-13 18:06:18'),
(5, 2, 1, '2019-04-13 11:48:42'),
(8, 3, 1, '2019-04-13 16:44:00'),
(11, 8, 3, '2019-04-15 12:50:48'),
(12, 1, 3, '2019-04-15 14:22:26');

-- --------------------------------------------------------

--
-- 表的结构 `enrollform`
--

CREATE TABLE `enrollform` (
  `enrollForm_id` int(11) NOT NULL COMMENT '标识',
  `enrollForm_time` datetime NOT NULL COMMENT '报名时间',
  `class_id` int(11) NOT NULL COMMENT '班级id',
  `user_id` int(11) NOT NULL COMMENT '用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='报名表';

--
-- 转存表中的数据 `enrollform`
--

INSERT INTO `enrollform` (`enrollForm_id`, `enrollForm_time`, `class_id`, `user_id`) VALUES
(1, '2019-04-03 15:53:49', 3, 1),
(2, '2019-04-15 12:43:58', 1, 3),
(3, '2019-04-15 12:47:53', 2, 3),
(4, '2019-04-15 12:49:41', 6, 3),
(5, '2019-04-15 12:50:44', 8, 3),
(6, '2019-04-15 14:23:25', 1, 1),
(7, '2019-04-15 14:32:55', 7, 1),
(8, '2019-04-16 22:32:07', 1, 5),
(9, '2019-04-16 23:04:01', 7, 5),
(10, '2019-04-17 10:33:27', 5, 5);

-- --------------------------------------------------------

--
-- 表的结构 `evaluation`
--

CREATE TABLE `evaluation` (
  `evaluation_id` int(11) NOT NULL COMMENT '标识',
  `evaluation_content` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '评价内容',
  `evaluation_time` datetime NOT NULL COMMENT '评价时间',
  `score_xg` double NOT NULL DEFAULT '5',
  `score_sz` double NOT NULL DEFAULT '5',
  `score_hj` double NOT NULL DEFAULT '5',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `class_id` int(11) NOT NULL COMMENT '班级id',
  `agreeNumber` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='评价表';

--
-- 转存表中的数据 `evaluation`
--

INSERT INTO `evaluation` (`evaluation_id`, `evaluation_content`, `evaluation_time`, `score_xg`, `score_sz`, `score_hj`, `user_id`, `class_id`, `agreeNumber`) VALUES
(2, '老师很专业，帮我的朋友指出了困扰了他很久的问题，现在他的问题已经有了明确的认识', '2019-04-07 16:41:20', 5, 5, 5, 1, 3, 0),
(3, '老师很棒 教的很到位 强烈推荐', '2019-04-07 16:51:58', 4, 4.5, 4, 1, 3, 0),
(4, '课程很满意 第一次学习 就遇到了这么好的地方 真的是很好 建议每个小朋友大朋友都学习一下音乐 丰盛一下自己 让自己与众不同 成为人群中的焦点 \r\n课程种类也蛮多的 老师涉及的领域很多 肯定有你想学的一个 发呆得意 我觉得这家挺好的的', '2019-04-07 16:53:51', 5, 5, 5, 1, 3, 0),
(5, '', '2019-04-15 12:44:14', 4, 5, 4.5, 3, 1, 0),
(9, '想学', '2019-04-15 12:48:13', 4, 4.5, 5, 3, 2, 0),
(10, '环境很nice', '2019-04-15 12:50:06', 5, 4.5, 5, 3, 6, 0),
(11, '效果显著', '2019-04-15 12:51:04', 4.5, 4, 4.5, 3, 8, 0),
(14, '不错不错，很好很好', '2019-04-17 10:34:26', 5, 5, 5, 5, 5, 0);

-- --------------------------------------------------------

--
-- 表的结构 `photos`
--

CREATE TABLE `photos` (
  `photo_id` int(11) NOT NULL,
  `photo_img` varchar(255) COLLATE utf8_bin NOT NULL,
  `uploadTime` datetime NOT NULL,
  `photo_state` tinyint(1) NOT NULL COMMENT '状态（0：不显示，1：显示）',
  `class_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `photos`
--

INSERT INTO `photos` (`photo_id`, `photo_img`, `uploadTime`, `photo_state`, `class_id`) VALUES
(1, '5c933e01da5ad.jpg', '2019-03-21 15:32:17', 1, 3),
(2, '5c933e01ead28.png', '2019-03-21 15:32:17', 1, 3),
(3, '5c933e0203452.jpg', '2019-03-21 15:32:18', 1, 3),
(4, '5c933e020d909.jpeg', '2019-03-21 15:32:18', 1, 3),
(5, '5c933e28904d5.jpg', '2019-03-21 15:32:56', 1, 3),
(6, '5c933e2897cda.png', '2019-03-21 15:32:56', 1, 3),
(7, '5c933e28a3345.jpeg', '2019-03-21 15:32:56', 1, 3),
(8, '5c933e48d1d91.jpg', '2019-03-21 15:33:28', 1, 3),
(9, '5c933e48dfbb9.jpg', '2019-03-21 15:33:28', 1, 3),
(29, '5caac769492ba.jpg', '2019-04-08 12:00:41', 1, 4),
(22, '5c93425359c81.png', '2019-03-21 15:50:43', 1, 3),
(24, '5c986d9940920.png', '2019-03-25 13:56:41', 1, 3),
(25, '5c986d994d97c.jpg', '2019-03-25 13:56:41', 1, 3),
(26, '5c986d995e9c6.jpeg', '2019-03-25 13:56:41', 1, 3),
(27, '5c986d9972c07.jpg', '2019-03-25 13:56:41', 1, 3),
(28, '5caac7693f06c.jpg', '2019-04-08 12:00:41', 1, 4),
(30, '5caac76953d01.jpg', '2019-04-08 12:00:41', 1, 4),
(31, '5caac7695e312.jpg', '2019-04-08 12:00:41', 1, 4),
(32, '5caac8a5b2e02.jpg', '2019-04-08 12:05:57', 1, 4),
(33, '5caac8a5bafbe.jpg', '2019-04-08 12:05:57', 1, 4),
(34, '5caac8a5c433b.jpg', '2019-04-08 12:05:57', 1, 4),
(35, '5caac8a5cc7df.jpg', '2019-04-08 12:05:57', 1, 4);

-- --------------------------------------------------------

--
-- 表的结构 `smscode`
--

CREATE TABLE `smscode` (
  `id` int(8) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `code` int(4) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `smscode`
--

INSERT INTO `smscode` (`id`, `mobile`, `code`, `create_time`, `update_time`) VALUES
(3, '13840801970', 4764, '2019-03-23 18:24:56', '2019-04-18 19:07:46'),
(5, '15048991119', 3432, '2019-03-23 19:46:25', '2019-03-30 12:55:28'),
(9, '18042641786', 9419, '2019-04-16 22:29:07', '2019-04-16 22:30:28'),
(7, '15542561711', 5690, '2019-03-24 12:38:15', '2019-03-24 12:38:15'),
(8, '15904943990', 8864, '2019-03-25 13:58:59', '2019-03-25 13:58:59');

-- --------------------------------------------------------

--
-- 表的结构 `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL COMMENT '标识',
  `teacher_name` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '老师名',
  `teacher_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '老师头像',
  `teacher_start` date DEFAULT NULL,
  `teacher_professional` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '老师专业',
  `teacher_info` varchar(255) COLLATE utf8_bin NOT NULL,
  `teacher_state` tinyint(1) NOT NULL COMMENT '状态（0：冻结，1：正常）',
  `class_id` int(11) NOT NULL COMMENT '班级id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='老师表';

--
-- 转存表中的数据 `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `teacher_name`, `teacher_img`, `teacher_start`, `teacher_professional`, `teacher_info`, `teacher_state`, `class_id`) VALUES
(1, '戴老师', '5c90a48225e70.jpeg', '2016-12-14', '硬笔字666', '北京一横子丰文化传播有限公司高级培训师,北京一横子丰文化传播有限公司高级培训师,北京一横子丰文化传播有限公司高级培训师,北京一横子丰文化传播有限公司高级培训师,', 0, 3),
(3, '刘老师', '5c906ce95632a.png', '2017-01-25', '软笔书法', '123123', 1, 3),
(4, '王老师', '5c987c4fc5721.jpg', '2019-03-06', '软笔书法', '软笔书法', 1, 3),
(5, '李老师', '5c987cb9b326d.jpg', '2017-03-08', '国画', '国画', 1, 3),
(6, '张老师', '5c9882dae2ef9.jpg', '2013-10-10', '软笔书法', '张老师', 1, 3),
(7, '123', '5c9883e2bfb66.jpg', '2017-03-08', '131', '12321', 1, 3),
(8, '金老师', '5c999d404788f.jpg', '2018-03-06', '基础日语', '基础日语基础日语基础日语基础日语基础日语', 1, 1),
(9, '111', '5c9dc8714d167.png', '2015-04-10', '初中英语', '1231231', 1, 7),
(10, '杨老师', '5cb743bf04208.png', '2015-01-16', '素描', '多年教学经验', 1, 11);

-- --------------------------------------------------------

--
-- 表的结构 `types`
--

CREATE TABLE `types` (
  `type_id` int(11) NOT NULL,
  `classify_id` int(11) NOT NULL,
  `type_name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `types`
--

INSERT INTO `types` (`type_id`, `classify_id`, `type_name`) VALUES
(1, 1, '英语'),
(2, 1, '日语'),
(3, 1, '韩语'),
(4, 1, '其他'),
(5, 2, '乐理声乐'),
(6, 2, '名族乐器'),
(7, 2, '西洋管乐器'),
(8, 2, '西洋键盘乐器'),
(9, 2, '其他'),
(10, 3, '绘画培训'),
(11, 3, '书法培训'),
(12, 3, '其他'),
(13, 4, '小学辅导'),
(14, 4, '艺考'),
(15, 4, '考研'),
(16, 4, '初中辅导'),
(17, 4, '高中辅导'),
(18, 5, '留学考试'),
(19, 5, '留学申请'),
(20, 7, '会计'),
(21, 7, 'IT/互联网'),
(22, 7, '司法培训'),
(23, 7, '公务员培训'),
(24, 7, '教师从业'),
(25, 7, '医疗护理从业'),
(26, 7, '其他'),
(27, 6, '成人学历提升'),
(28, 6, '其他');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT '标识',
  `user_name` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `user_phone` varchar(11) COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `user_password` varchar(18) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `user_img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '照片',
  `user_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0：冻结，1：正常）'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户表';

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_phone`, `user_password`, `user_img`, `user_state`) VALUES
(1, 'LLL', '13840801970', '123', '5cb040c2ccfb9.png', 1),
(2, 'lhx', '15048991119', '123', 'default.jpg', 1),
(3, '昊然滴滴八元', '15542561711', '123', 'default.jpg', 1),
(4, '111', '15904943990', '111', 'default.jpg', 1),
(5, '宋建', '18042641786', '123', 'default.jpg', 1);

-- --------------------------------------------------------

--
-- 表的结构 `videos`
--

CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL,
  `video_name` int(11) NOT NULL,
  `video_url` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad`
--
ALTER TABLE `ad`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `classify`
--
ALTER TABLE `classify`
  ADD PRIMARY KEY (`classify_id`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`collection_id`);

--
-- Indexes for table `enrollform`
--
ALTER TABLE `enrollform`
  ADD PRIMARY KEY (`enrollForm_id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`evaluation_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`);

--
-- Indexes for table `smscode`
--
ALTER TABLE `smscode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `ad`
--
ALTER TABLE `ad`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- 使用表AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `classify`
--
ALTER TABLE `classify`
  MODIFY `classify_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `collection`
--
ALTER TABLE `collection`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `enrollform`
--
ALTER TABLE `enrollform`
  MODIFY `enrollForm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- 使用表AUTO_INCREMENT `smscode`
--
ALTER TABLE `smscode`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `types`
--
ALTER TABLE `types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
