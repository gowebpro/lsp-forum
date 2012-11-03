--
-- Table structure for table `prefix_forum_topic_view`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_topic_view` (
	`topic_id` int(11) unsigned NOT NULL,
	`topic_views` int(11) unsigned NOT NULL,
	KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for table `prefix_forum_topic_view`
--
ALTER TABLE `prefix_forum_topic_view`
	ADD CONSTRAINT `prefix_forum_topic_view_fk` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
--  Dumping data for table `prefix_forum_topic_view`
--
INSERT INTO `prefix_forum_topic_view` (`topic_id`, `topic_views`)
SELECT t.`topic_id`, t.`topic_views`
FROM `prefix_forum_topic` as t;

--
-- Drop data for table `prefix_forum_topic`
--
ALTER TABLE `prefix_forum_topic` DROP `topic_views`;