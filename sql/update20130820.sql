--
-- Update from 2013.08.20
--

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


ALTER TABLE `prefix_forum_post`
	ADD `post_extra` text DEFAULT NULL AFTER `post_guest_name`;