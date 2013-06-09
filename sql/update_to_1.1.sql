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

ALTER TABLE `prefix_forum` ADD `forum_icon` varchar(250) DEFAULT NULL AFTER `forum_count_post`;
ALTER TABLE `prefix_forum` ADD `last_post_date` datetime DEFAULT NULL;
ALTER TABLE `prefix_forum_post` ADD `post_parent_id` int(11) unsigned NOT NULL DEFAULT '0' AFTER `user_id`;
ALTER TABLE `prefix_forum_topic` ADD `last_post_date` datetime DEFAULT NULL;
