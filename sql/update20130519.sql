--
-- Update from 2013.05.19
--

--
-- Table structure for table `prefix_forum_user`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_user` (
	`user_id` int(11) unsigned NOT NULL,
	`user_post_count` int(11) unsigned NOT NULL,
	`user_last_mark` datetime DEFAULT NULL,
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Constraints for table `prefix_forum_user`
--
ALTER TABLE `prefix_forum_user`
	ADD CONSTRAINT `prefix_forum_user_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
