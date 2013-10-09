--
-- Update from 2012.05.01
--

ALTER TABLE `prefix_forum_post`
	ADD `post_new_topic` tinyint(1) NOT NULL default '0' AFTER `post_text_hash`;
