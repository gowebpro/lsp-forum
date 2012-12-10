--
-- Table structure for table `prefix_forum_marker`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_marker` (
	`marker_type` varchar(32) NOT NULL,
	`user_id` int(11) unsigned DEFAULT NULL,
	`last_post_id` int(11) unsigned DEFAULT NULL,
	`marker_date` datetime DEFAULT NULL,
	`marker_read_array` mediumtext,
	UNIQUE KEY `marker_key` (`marker_type`, `user_id`),
	KEY `marker_last_update` (`marker_last_update`),
	KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `prefix_forum` ADD `forum_icon` varchar(250) DEFAULT NULL AFTER `forum_count_post`;
