--
-- Update from 2016.12.10
--

ALTER TABLE `prefix_forum_user`
	ADD `mark_all` datetime DEFAULT NULL,
	ADD `mark_forum` text DEFAULT NULL,
  ADD `mark_topic` text DEFAULT NULL;
