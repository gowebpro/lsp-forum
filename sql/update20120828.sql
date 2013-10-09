--
-- Update from 2012.08.28
--

--
-- Table structure for table `prefix_forum`
--

ALTER TABLE `prefix_forum`
	ADD `forum_permissions` text DEFAULT NULL AFTER `forum_password`;


--
-- Table structure for table `prefix_forum_post`
--

ALTER TABLE `prefix_forum_post`
	ADD `post_guest_name` varchar(50) DEFAULT NULL AFTER `post_edit_reason`;


--
-- Table structure for table `prefix_forum_perms`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_perm` (
	`perm_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`perm_name` varchar(250) NOT NULL default '',
	PRIMARY KEY (`perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prefix_forum_perms`
--

INSERT INTO `prefix_forum_perm` (`perm_id`, `perm_name`) VALUES
(1, 'Маска гостей'),
(2, 'Маска пользователей'),
(3, 'Маска администраторов');


--
-- Constraints for table `prefix_forum_post`
--

ALTER TABLE `prefix_forum_post`
	ADD CONSTRAINT `prefix_forum_post_fk` FOREIGN KEY (`topic_id`) REFERENCES `prefix_forum_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Constraints for table `prefix_forum_topic`
--

ALTER TABLE `prefix_forum_topic`
	ADD CONSTRAINT `prefix_forum_topic_fk` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;
