-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2019-02-27 07:02:23
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
-- 表的结构 `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL COMMENT '标识',
  `admin_account` int(11) NOT NULL COMMENT '账号',
  `admin_password` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '密码'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_account`, `admin_password`) VALUES
(1, 123, '123'),
(2, 321, '321');

-- --------------------------------------------------------

--
-- 表的结构 `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL COMMENT '标识',
  `classBegin_time` datetime NOT NULL COMMENT '上课时间',
  `finishClass_time` datetime NOT NULL COMMENT '下课时间',
  `user_id` int(11) NOT NULL COMMENT '普通用户id',
  `class_id` int(11) NOT NULL COMMENT '班级id'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL COMMENT '标识',
  `class_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '姓名',
  `class_peopleNumber` int(11) NOT NULL COMMENT '班级人数',
  `class_info` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '简介',
  `class_time` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '上课时间',
  `class_position` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '位置',
  `class_state` tinyint(1) NOT NULL COMMENT '状态(0：待审核，1：正常，2：冻结)',
  `account` int(11) NOT NULL COMMENT '辅导班管理员账号',
  `password` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '辅导班管理员密码'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `class_peopleNumber`, `class_info`, `class_time`, `class_position`, `class_state`, `account`, `password`) VALUES
(1, '123', 12, '321', '08:00:00 - 09:00:00', '北京市朝阳区二十一世纪饭店', 1, 211, '211'),
(4, '贝壳2', 15, '1231232123', '08:00:00 - 09:00:00', '北京市朝阳区来广营-地铁站', 2, 123, '123'),
(5, '1123', 23, '123', '02:00:00 - 05:00:00', '北京市北京市123路', 1, 22, '22'),
(6, '123', 23, '123123', '03:00:00 - 08:00:00', '北京市朝阳区卡布其诺-122号楼', 0, 333, '333');

-- --------------------------------------------------------

--
-- 表的结构 `classphotos`
--

CREATE TABLE `classphotos` (
  `classPhoto_id` int(11) NOT NULL COMMENT '标识',
  `classPhoto_url` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '照片路径',
  `updatetime` datetime NOT NULL COMMENT '上传时间',
  `ulass_id` int(11) NOT NULL COMMENT '班级id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `collections`
--

CREATE TABLE `collections` (
  `collection_id` int(11) NOT NULL COMMENT '标识',
  `post_id` int(11) NOT NULL COMMENT '帖子id',
  `user_id` int(11) NOT NULL COMMENT '用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL COMMENT '标识',
  `comment_content` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '评论内容',
  `comment_time` date NOT NULL COMMENT '评论时间',
  `anonymity` tinyint(1) NOT NULL COMMENT '是否匿名',
  `comments_praiseNumber` int(11) NOT NULL COMMENT '点赞数',
  `post_id` int(11) NOT NULL COMMENT '帖子id',
  `user_id` int(11) NOT NULL COMMENT '用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `courseware`
--

CREATE TABLE `courseware` (
  `courseware_id` int(11) NOT NULL COMMENT '标识',
  `courseware_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '课件名',
  `update_time` datetime NOT NULL COMMENT '上传时间',
  `courseware_url` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '课件路径',
  `user_id` int(11) NOT NULL COMMENT '老师id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `evaluation`
--

CREATE TABLE `evaluation` (
  `evaluation_id` int(11) NOT NULL COMMENT '标识',
  `evaluation_content` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '评价内容',
  `evaluation_time` datetime NOT NULL COMMENT '评价时间',
  `from_id` int(11) NOT NULL COMMENT '评价用户id',
  `to_id` int(11) DEFAULT NULL COMMENT '被评价用户id',
  `class_id` int(11) DEFAULT NULL COMMENT '班级id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `leaves`
--

CREATE TABLE `leaves` (
  `leave_id` int(11) NOT NULL COMMENT '标识',
  `application_time` datetime NOT NULL COMMENT '申请时间',
  `leave_time` date NOT NULL COMMENT '请假时间',
  `reasons` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '请假理由',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `class_id` int(11) NOT NULL COMMENT '班级id',
  `user_id` int(11) NOT NULL COMMENT '普通用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL COMMENT '标识',
  `notification_connect` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '通知内容',
  `notification_time` datetime NOT NULL COMMENT '通知时间',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  `user_id` int(11) NOT NULL COMMENT '用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL COMMENT '标识',
  `post_title` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `post_content` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '帖子内容',
  `anonymity` tinyint(1) NOT NULL COMMENT '是否匿名',
  `post_time` datetime NOT NULL COMMENT '发帖时间',
  `post_browseNumber` int(11) NOT NULL DEFAULT '0' COMMENT '浏览数',
  `post_collectionNumber` int(11) NOT NULL DEFAULT '0' COMMENT '收藏数',
  `post_praiseNumber` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数',
  `user_id` int(11) NOT NULL COMMENT '用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `register`
--

CREATE TABLE `register` (
  `register_id` int(11) NOT NULL COMMENT '标识',
  `register_time` datetime NOT NULL COMMENT '报名时间',
  `class_id` int(11) NOT NULL COMMENT '班级id',
  `user_id` int(11) NOT NULL COMMENT '普通用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `teaching`
--

CREATE TABLE `teaching` (
  `teach_id` int(11) NOT NULL COMMENT '标识',
  `teach_time` date NOT NULL COMMENT '任教时间',
  `user_id` int(11) NOT NULL COMMENT '老师id',
  `class_id` int(11) NOT NULL COMMENT '班级id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `teaching`
--

INSERT INTO `teaching` (`teach_id`, `teach_time`, `user_id`, `class_id`) VALUES
(1, '2019-02-19', 1, 1),
(2, '2019-02-20', 2, 5);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT '标识',
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '姓名',
  `user_phone` int(11) NOT NULL COMMENT '手机号',
  `user_password` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `user_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '头像',
  `user_type` tinyint(1) NOT NULL COMMENT '用户类型(0:普通用户;1:老师)',
  `user_info` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '简介'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_phone`, `user_password`, `user_img`, `user_type`, `user_info`) VALUES
(1, '李老师', 122, '122', '1.jpg', 1, '数学老师'),
(2, '王老师', 133, '133', '2.jpg', 1, '语文王老师');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `classphotos`
--
ALTER TABLE `classphotos`
  ADD PRIMARY KEY (`classPhoto_id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`collection_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `courseware`
--
ALTER TABLE `courseware`
  ADD PRIMARY KEY (`courseware_id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`evaluation_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`register_id`);

--
-- Indexes for table `teaching`
--
ALTER TABLE `teaching`
  ADD PRIMARY KEY (`teach_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `classphotos`
--
ALTER TABLE `classphotos`
  MODIFY `classPhoto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `collections`
--
ALTER TABLE `collections`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `courseware`
--
ALTER TABLE `courseware`
  MODIFY `courseware_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `leaves`
--
ALTER TABLE `leaves`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `register`
--
ALTER TABLE `register`
  MODIFY `register_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识';
--
-- 使用表AUTO_INCREMENT `teaching`
--
ALTER TABLE `teaching`
  MODIFY `teach_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标识', AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
