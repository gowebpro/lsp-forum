--
-- Update from 2012.09.20
--

--
-- Table structure for table `prefix_forum`
--

ALTER TABLE `prefix_forum`
	DROP `forum_moder`;

--
-- Table structure for table `prefix_forum_post`
--

ALTER TABLE `prefix_forum_post`
	MODIFY `post_date_edit` datetime DEFAULT NULL,
	MODIFY `post_text` longtext NOT NULL,
	MODIFY `post_text_source` longtext NOT NULL;

ALTER TABLE prefix_forum_topic`
	MODIFY `topic_views` int(11) NOT NULL DEFAULT '0';
