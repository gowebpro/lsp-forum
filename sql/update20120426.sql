--
-- Update from 2012.04.23
--

ALTER TABLE `prefix_forum_topic`
	ADD `topic_user_ip` varchar(20) NOT NULL default '' AFTER `user_id`;
