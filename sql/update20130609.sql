--
-- Update from 2013.06.09
--

ALTER TABLE `prefix_forum`
	ADD `last_post_date` datetime DEFAULT NULL,
	ADD INDEX (`last_post_id`);

ALTER TABLE `prefix_forum_topic`
	ADD `last_post_date` datetime DEFAULT NULL,
	ADD INDEX (`last_post_id`);


DROP TABLE IF EXISTS `prefix_forum_marker`;
DROP TABLE IF EXISTS `prefix_forum_marker_topic`;

--
-- Table structure for table `prefix_forum_marker`
--

CREATE TABLE `prefix_forum_marker` (
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

CREATE TABLE `prefix_forum_marker_topic` (
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

ALTER TABLE `prefix_forum_marker`
	ADD CONSTRAINT `prefix_forum_marker_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_marker_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `prefix_forum_marker_topic`
	ADD CONSTRAINT `prefix_forum_marker_topic_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_marker_topic_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_marker_topic_fk2` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;
