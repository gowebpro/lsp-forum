--
-- Primary Fixes
--

ALTER TABLE `prefix_forum_topic_view`
DROP FOREIGN KEY `prefix_forum_topic_view_fk`;

ALTER TABLE `prefix_forum_topic_view`
ADD CONSTRAINT `prefix_forum_topic_view_fk` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;
