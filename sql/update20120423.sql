--
-- Update from 2012.04.23
--

ALTER TABLE `prefix_forum`
	ADD `forum_quick_reply` tinyint(1) NOT NULL DEFAULT '1' AFTER `forum_can_post`,
	ADD `forum_type` tinyint(1) NOT NULL DEFAULT '1' AFTER `forum_quick_reply`;
