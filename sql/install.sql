--
-- Table structure for table `prefix_forum`
--

CREATE TABLE IF NOT EXISTS `prefix_forum` (
	`forum_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`forum_parent_id` int(11) unsigned NOT NULL DEFAULT '0',
	`forum_title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
	`forum_description` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
	`forum_url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
	`forum_moder` varchar(250) CHARACTER SET utf8 NOT NULL,
	`forum_sort` int(11) NOT NULL DEFAULT 0,
	`forum_can_post` tinyint(1) NOT NULL DEFAULT '0',
	`forum_status` tinyint(1) NOT NULL DEFAULT '0',
	`forum_password` varchar(32) default NULL,
	`forum_redirect_url` varchar(250) default '',
	`forum_redirect_on` tinyint(1) NOT NULL default '0',
	`forum_redirect_hits` int(11) NOT NULL default '0',
	`forum_count_topic` int(11) NOT NULL DEFAULT '0',
	`forum_count_post` int(11) NOT NULL DEFAULT '0',
	`last_post_id` int(11) unsigned DEFAULT NULL,
	`last_user_id` int(11) unsigned DEFAULT NULL,
	`last_topic_id` int(11) unsigned DEFAULT NULL,
	PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table structure for table `prefix_forum_post`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_post` (
	`post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`topic_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`post_user_ip` varchar(20) NOT NULL default '',
	`post_date_add` datetime NOT NULL,
	`post_date_edit` datetime NOT NULL,
	`post_title` varchar(255) default NULL,
	`post_text` text NOT NULL,
	`post_text_source` text NOT NULL,
	PRIMARY KEY (`post_id`),
	KEY topic_id (`topic_id`),
	KEY user_id (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_topic`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_topic` (
	`topic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`forum_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`topic_title` varchar(255) NOT NULL,
	`topic_url` varchar(255) NOT NULL,
	`topic_date` datetime NOT NULL,
	`topic_status` int(11) NOT NULL DEFAULT '0',
	`topic_position` int(11) NOT NULL DEFAULT '0',
	`topic_views` int(11) NOT NULL,
	`topic_count_post` int(11) NOT NULL DEFAULT '0',
	`last_post_id` int(11) unsigned DEFAULT NULL,
	PRIMARY KEY (`topic_id`),
	KEY `forum_id` (`forum_id`),
	KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_read`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_read` (
	`user_id` int(11) unsigned NOT NULL,
	`topic_id` int(11) unsigned NOT NULL,
	`post_id` int(11) unsigned NOT NULL,
	`read_date` datetime NOT NULL,
	UNIQUE KEY `user_id_topic_id_post_id` (`topic_id`,`user_id`,`post_id`),
	KEY `user_id` (`user_id`),
	KEY `topic_id` (`topic_id`),
	KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Constraints for table `prefix_forum_post`
--
ALTER TABLE `prefix_forum_post`
	ADD CONSTRAINT `prefix_forum_post_fk` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_post_fk1` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prefix_forum_topic`
--
ALTER TABLE `prefix_forum_topic`
	ADD CONSTRAINT `prefix_forum_topic_fk` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_topic_fk2` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prefix_forum_read`
--
ALTER TABLE `prefix_forum_read`
	ADD CONSTRAINT `prefix_forum_read_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_read_fk1` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_read_fk2` FOREIGN KEY (`post_id`) REFERENCES `prefix_forum_post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;
