--
-- Update from 2016.12.10
--

ALTER TABLE `prefix_forum_user`
	ADD `mark_all` INT(11) DEFAULT NULL,
	ADD `mark_forum` text DEFAULT NULL,
	ADD `mark_topic` text DEFAULT NULL,
	ADD `mark_topic_rel` text DEFAULT NULL;

