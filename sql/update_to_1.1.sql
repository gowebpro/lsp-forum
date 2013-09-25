--
-- Table structure for table `prefix_forum_file`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_file` (
	`file_id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned DEFAULT NULL,
	`file_name` varchar(255) NOT NULL,
	`file_path` varchar(255) NOT NULL,
	`file_size` int(11) NOT NULL,
	`file_extension` varchar(40) DEFAULT NULL,
	`file_text` text,
	`file_target_tmp` varchar(40) DEFAULT NULL,
	`file_download` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`file_id`),
	KEY `user_id` (`user_id`),
	KEY `file_target_tmp` (`file_target_tmp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `prefix_forum_file_rel`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_file_rel` (
	`file_id` int(11) unsigned NOT NULL,
	`post_id` int(11) unsigned NOT NULL,
	UNIQUE KEY `file_id_post_id` (`file_id`,`post_id`),
	KEY `file_id` (`file_id`),
	KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `prefix_forum_marker`
--

DROP TABLE IF EXISTS `prefix_forum_marker`;
CREATE TABLE IF NOT EXISTS `prefix_forum_marker` (
	`user_id` int(11) unsigned NOT NULL,
	`forum_id` int(11) unsigned NOT NULL,
	`mark_date` datetime DEFAULT NULL,
	UNIQUE KEY `user_id_forum_id` (`user_id`,`forum_id`),
	KEY `user_id` (`user_id`),
	KEY `forum_id` (`forum_id`),
	KEY `mark_date` (`mark_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `prefix_forum_marker_topic`
--
DROP TABLE IF EXISTS `prefix_forum_marker_topic`;
CREATE TABLE IF NOT EXISTS `prefix_forum_marker_topic` (
	`user_id` int(11) unsigned NOT NULL,
	`topic_id` int(11) unsigned NOT NULL,
	`forum_id` int(11) unsigned NOT NULL,
	`mark_date` datetime DEFAULT NULL,
	UNIQUE KEY `user_id_forum_id_topic_id` (`user_id`,`forum_id`,`topic_id`),
	KEY `user_id` (`user_id`),
	KEY `topic_id` (`topic_id`),
	KEY `forum_id` (`forum_id`),
	KEY `mark_date` (`mark_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for table `prefix_forum_marker`
--
ALTER TABLE `prefix_forum_marker`
	ADD CONSTRAINT `prefix_forum_marker_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_marker_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `prefix_forum_marker_topic`
	ADD CONSTRAINT `prefix_forum_marker_topic_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_marker_topic_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_marker_topic_fk2` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `prefix_forum`
	ADD `forum_icon` varchar(250) DEFAULT NULL AFTER `forum_count_post`,
	ADD `forum_options` text DEFAULT NULL AFTER `forum_icon`,
	ADD `last_post_date` datetime DEFAULT NULL;

ALTER TABLE `prefix_forum_post`
	ADD `post_parent_id` int(11) unsigned NOT NULL DEFAULT '0' AFTER `user_id`,
	ADD `post_rating` float(9,3) NOT NULL DEFAULT '0.000',
	ADD `post_count_vote` int(11) unsigned NOT NULL DEFAULT '0',
	ADD `post_count_vote_up` int(11) NOT NULL DEFAULT '0',
	ADD `post_count_vote_down` int(11) NOT NULL DEFAULT '0',
	ADD `post_count_vote_abstain` int(11) NOT NULL DEFAULT '0',
	ADD `post_extra` text DEFAULT NULL AFTER `post_guest_name`;

ALTER TABLE `prefix_forum_topic` ADD `last_post_date` datetime DEFAULT NULL;
