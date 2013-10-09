--
-- Update from 2012.04.18
--

ALTER TABLE `prefix_forum`
	DROP `forum_status`,
	DROP `last_user_id`,
	DROP `last_topic_id`;

ALTER TABLE `prefix_forum_post`
	ADD `post_text_hash` varchar(32) NOT NULL AFTER `post_text_source`,
	ADD INDEX (`post_text_hash`);

ALTER TABLE `prefix_forum_topic`
	DROP `topic_url`,
	DROP `topic_date`,
	DROP `topic_status`,
	DROP `topic_position`,
	ADD `topic_description` varchar(255) DEFAULT NULL AFTER `topic_title`,
	ADD `topic_date_add` datetime NOT NULL AFTER `topic_description`,
	ADD `topic_date_edit` datetime DEFAULT NULL AFTER `topic_date_add`,
	ADD `topic_state` int(11) NOT NULL DEFAULT '0' AFTER `topic_date_edit`,
	ADD `topic_pinned` int(11) NOT NULL DEFAULT '0' AFTER `topic_state`,
	ADD `first_post_id` int(11) unsigned DEFAULT NULL AFTER `topic_count_post`;
