--
-- Table structure for table `prefix_forum`
--

CREATE TABLE IF NOT EXISTS `prefix_forum` (
	`forum_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`forum_parent_id` int(11) unsigned NOT NULL DEFAULT '0',
	`forum_title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
	`forum_description` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
	`forum_url` varchar(50) NOT NULL DEFAULT '',
	`forum_url_full` varchar(254) NOT NULL,
	`forum_sort` int(11) NOT NULL DEFAULT 0,
	`forum_can_post` tinyint(1) NOT NULL DEFAULT '0',
	`forum_quick_reply` tinyint(1) NOT NULL DEFAULT '1',
	`forum_type` tinyint(1) NOT NULL DEFAULT '1',
	`forum_password` varchar(32) DEFAULT NULL,
	`forum_permissions` text DEFAULT NULL,
	`forum_limit_rating_topic` float(9,3) NOT NULL DEFAULT '0.000',
	`forum_redirect_url` varchar(250) DEFAULT '',
	`forum_redirect_on` tinyint(1) NOT NULL DEFAULT '0',
	`forum_redirect_hits` int(11) NOT NULL DEFAULT '0',
	`forum_count_topic` int(11) NOT NULL DEFAULT '0',
	`forum_count_post` int(11) NOT NULL DEFAULT '0',
	`forum_icon` varchar(250) DEFAULT NULL,
	`last_post_id` int(11) unsigned DEFAULT NULL,
	PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_marker`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_marker` (
	`user_id` int(11) unsigned DEFAULT NULL,
	`forum_id` int(11) unsigned DEFAULT NULL,
	`marker_date` datetime DEFAULT NULL,
	`marker_read_array` mediumtext,
	`marker_count_item` int(11) DEFAULT '0',
	UNIQUE KEY `user_id_forum_id` (`user_id`,`forum_id`),
	KEY `user_id` (`user_id`),
	KEY `forum_id` (`forum_id`),
	KEY `marker_date` (`marker_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_moderator`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_moderator` (
	`moderator_id` int(11) unsigned NOT NULL auto_increment,
	`forum_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`moderator_login` varchar(50) NOT NULL DEFAULT '',
	`moderator_view_ip` tinyint(1) DEFAULT NULL,
	`moderator_allow_readonly` tinyint(1) DEFAULT NULL,
	`moderator_allow_edit_post` tinyint(1) DEFAULT NULL,
	`moderator_allow_edit_topic` tinyint(1) DEFAULT NULL,
	`moderator_allow_delete_post` tinyint(1) DEFAULT NULL,
	`moderator_allow_delete_topic` tinyint(1) DEFAULT NULL,
	`moderator_allow_move_post` tinyint(1) DEFAULT NULL,
	`moderator_allow_move_topic` tinyint(1) DEFAULT NULL,
	`moderator_allow_openclose_topic` tinyint(1) DEFAULT NULL,
	`moderator_allow_pin_topic` tinyint(1) DEFAULT NULL,
	`moderator_is_active` tinyint(1) DEFAULT '1',
	`moderator_hash` varchar(250) DEFAULT '',
	PRIMARY KEY (`moderator_id`),
	KEY forum_id (`forum_id`),
	KEY user_id (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_perms`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_perm` (
	`perm_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`perm_name` varchar(250) NOT NULL DEFAULT '',
	PRIMARY KEY (`perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prefix_forum_perm`
--

INSERT INTO `prefix_forum_perm` (`perm_id`, `perm_name`) VALUES
(1, 'Маска гостей'),
(2, 'Маска пользователей'),
(3, 'Маска администраторов');

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_post`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_post` (
	`post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`topic_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`post_user_ip` varchar(20) NOT NULL DEFAULT '',
	`post_date_add` datetime NOT NULL,
	`post_date_edit` datetime DEFAULT NULL,
	`post_title` varchar(255) DEFAULT NULL,
	`post_text` longtext NOT NULL,
	`post_text_source` longtext NOT NULL,
	`post_text_hash` varchar(32) NOT NULL,
	`post_new_topic` tinyint(1) NOT NULL DEFAULT '0',
	`post_editor_id` int(11) unsigned DEFAULT NULL,
	`post_edit_reason` varchar(255) DEFAULT NULL,
	`post_guest_name` varchar(50) DEFAULT NULL,
	PRIMARY KEY (`post_id`),
	KEY `topic_id` (`topic_id`),
	KEY `user_id` (`user_id`),
	KEY `post_text_hash` (`post_text_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
	`topic_views` int(11) NOT NULL DEFAULT '0',
	`topic_count_post` int(11) NOT NULL DEFAULT '0',
	`first_post_id` int(11) unsigned DEFAULT NULL,
	`last_post_id` int(11) unsigned DEFAULT NULL,
	PRIMARY KEY (`topic_id`),
	KEY `forum_id` (`forum_id`),
	KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_topic_view`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_topic_view` (
	`topic_id` int(11) unsigned NOT NULL,
	`topic_views` int(11) unsigned NOT NULL,
	KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix_forum_readonly`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_readonly` (
	`readonly_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`moder_id` int(11) unsigned NOT NULL,
	`post_id` int(11) unsigned NOT NULL,
	`readonly_date` datetime NOT NULL,
	`readonly_line` datetime NOT NULL,
	`readonly_comment` varchar(250) DEFAULT NULL,
	`readonly_activ` tinyint(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`readonly_id`),
	KEY `user_id` (`user_id`),
	KEY `moder_id` (`moder_id`),
	KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


--
-- Constraints for table `prefix_forum_marker`
--
ALTER TABLE `prefix_forum_marker`
	ADD CONSTRAINT `prefix_forum_marker_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_marker_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prefix_forum_moderator`
--
ALTER TABLE `prefix_forum_moderator`
	ADD CONSTRAINT `prefix_forum_moderator_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_moderator_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prefix_forum_moderator_rel`
--
ALTER TABLE `prefix_forum_moderator_rel`
	ADD CONSTRAINT `prefix_forum_moderator_rel_fk` FOREIGN KEY (`moderator_id`) REFERENCES `prefix_forum_moderator` (`moderator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_moderator_rel_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prefix_forum_post`
--
ALTER TABLE `prefix_forum_post`
	ADD CONSTRAINT `prefix_forum_post_fk` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prefix_forum_topic`
--
ALTER TABLE `prefix_forum_topic`
	ADD CONSTRAINT `prefix_forum_topic_fk` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prefix_forum_topic_view`
--
ALTER TABLE `prefix_forum_topic_view`
	ADD CONSTRAINT `prefix_forum_topic_view_fk` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prefix_forum_readonly`
--
ALTER TABLE `prefix_forum_readonly`
	ADD CONSTRAINT `prefix_forum_readonly_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_readonly_fk1` FOREIGN KEY (`moder_id`) REFERENCES `prefix_forum_moderator` (`moderator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_readonly_fk2` FOREIGN KEY (`post_id`) REFERENCES `prefix_forum_post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;
