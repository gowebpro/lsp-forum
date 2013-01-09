--
-- Table structure for table `prefix_forum_marker`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_marker` (
	`user_id` int(11) unsigned NOT NULL,
	`forum_id` int(11) unsigned NOT NULL,
	`marker_date` datetime DEFAULT NULL,
	`marker_read_array` mediumtext,
	`marker_count_item` int(11) NOT NULL DEFAULT '0',
	`marker_unread_item` int(11) NOT NULL DEFAULT '0',
	UNIQUE KEY `user_id_forum_id` (`user_id`,`forum_id`),
	KEY `user_id` (`user_id`),
	KEY `forum_id` (`forum_id`),
	KEY `marker_date` (`marker_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for table `prefix_forum_marker`
--
ALTER TABLE `prefix_forum_marker`
	ADD CONSTRAINT `prefix_forum_marker_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_marker_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `prefix_forum` ADD `forum_icon` varchar(250) DEFAULT NULL AFTER `forum_count_post`;
