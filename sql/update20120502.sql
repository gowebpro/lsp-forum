--
-- Update from 2012.05.02
--

ALTER TABLE `prefix_forum`
	ADD `forum_limit_rating_topic` float(9,3) NOT NULL DEFAULT '0.000' AFTER `forum_password`;

ALTER TABLE `prefix_forum_post`
	ADD `post_editor` int(11) unsigned default NULL AFTER `post_new_topic`,
	ADD `post_editor_id` int(11) unsigned DEFAULT NULL AFTER `post_editor`,
	ADD `post_edit_reason` varchar(255) default NULL AFTER `post_editor_id`;
