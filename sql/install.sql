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
	`forum_quick_reply` tinyint(1) NOT NULL DEFAULT '1',
	`forum_type` tinyint(1) NOT NULL DEFAULT '1',
	`forum_password` varchar(32) DEFAULT NULL,
	`forum_limit_rating_topic` float(9,3) NOT NULL DEFAULT '0.000',
	`forum_redirect_url` varchar(250) DEFAULT '',
	`forum_redirect_on` tinyint(1) NOT NULL DEFAULT '0',
	`forum_redirect_hits` int(11) NOT NULL DEFAULT '0',
	`forum_count_topic` int(11) NOT NULL DEFAULT '0',
	`forum_count_post` int(11) NOT NULL DEFAULT '0',
	`last_post_id` int(11) unsigned DEFAULT NULL,
	PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table structure for table `prefix_forum_moderator`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_moderator` (
	`moderator_id` int(11) NOT NULL auto_increment,
	`forum_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`moderator_login` varchar(50) NOT NULL default '',
	`moderator_view_ip` tinyint(1) default NULL,
	`moderator_allow_readonly` tinyint(1) default NULL,
	`moderator_allow_delete_post` tinyint(1) default NULL,
	`moderator_allow_delete_topic` tinyint(1) default NULL,
	`moderator_allow_move_post` tinyint(1) default NULL,
	`moderator_allow_move_topic` tinyint(1) default NULL,
	`moderator_allow_openclose_topic` tinyint(1) default NULL,
	`moderator_allow_pin_topic` tinyint(1) default NULL,
	`moderator_is_active` tinyint(1) default '1',
	`moderator_hash` varchar(250) default '',
	PRIMARY KEY (`moderator_id`),
	KEY forum_id (`forum_id`),
	KEY user_id (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table structure for table `prefix_forum_moderator_rel`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_moderator_rel` (
	`moderator_id` int(11) unsigned NOT NULL,
	`forum_id` int(11) unsigned NOT NULL,
	UNIQUE KEY `moderator_id_forum_id` (`moderator_id`,`forum_id`),
	KEY `moderator_id` (`moderator_id`),
	KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `prefix_forum_post`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_post` (
	`post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`topic_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`post_user_ip` varchar(20) NOT NULL DEFAULT '',
	`post_date_add` datetime NOT NULL,
	`post_date_edit` datetime NOT NULL,
	`post_title` varchar(255) DEFAULT NULL,
	`post_text` text NOT NULL,
	`post_text_source` text NOT NULL,
	`post_text_hash` varchar(32) NOT NULL,
	`post_new_topic` tinyint(1) NOT NULL default '0',
	`post_editor_id` int(11) unsigned DEFAULT NULL,
	`post_edit_reason` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`post_id`),
	KEY `topic_id` (`topic_id`),
	KEY `user_id` (`user_id`),
	KEY `post_text_hash` (`post_text_hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_topic`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_topic` (
	`topic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`forum_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`topic_user_ip` varchar(20) NOT NULL DEFAULT '',
	`topic_title` varchar(255) NOT NULL,
	`topic_description` varchar(255) DEFAULT NULL,
	`topic_date_add` datetime NOT NULL,
	`topic_date_edit` datetime DEFAULT NULL,
	`topic_state` int(11) NOT NULL DEFAULT '0',
	`topic_pinned` int(11) NOT NULL DEFAULT '0',
	`topic_views` int(11) NOT NULL,
	`topic_count_post` int(11) NOT NULL DEFAULT '0',
	`first_post_id` int(11) unsigned DEFAULT NULL,
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
-- Constraints for table `prefix_forum_moderator_rel`
--

--
-- Constraints for table `prefix_forum_moderator`
--
ALTER TABLE `prefix_forum_moderator`
	ADD CONSTRAINT `prefix_forum_moderator_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_moderator_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
