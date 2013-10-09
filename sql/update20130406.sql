--
-- Update from 2013.04.06
--

--
-- Table structure for table `prefix_forum_post`
--

ALTER TABLE `prefix_forum_post`
	ADD `post_parent_id` int(11) unsigned NOT NULL DEFAULT '0' AFTER `user_id`;