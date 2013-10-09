--
-- Update from 2012.08.26
--

DROP TABLE IF EXISTS `prefix_forum_read`;
DROP TABLE IF EXISTS `prefix_forum_readonly`;

--
-- Table structure for table `prefix_forum_readonly`
--

CREATE TABLE `prefix_forum_readonly` (
	`readonly_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`moder_id` int(11) unsigned NOT NULL,
	`post_id` int(11) unsigned NOT NULL,
	`readonly_date` datetime NOT NULL,
	`readonly_line` datetime NOT NULL,
	`readonly_comment` varchar(250) default NULL,
	`readonly_activ` tinyint(1) NOT NULL default '1',
	PRIMARY KEY `readonly_id`,
	KEY `user_id` (`user_id`),
	KEY `moder_id` (`moder_id`),
	KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for table `prefix_forum_readonly`
--

ALTER TABLE `prefix_forum_readonly`
	ADD CONSTRAINT `prefix_forum_readonly_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_readonly_fk1` FOREIGN KEY (`moder_id`) REFERENCES `prefix_forum_moderator` (`moderator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_readonly_fk2` FOREIGN KEY (`post_id`) REFERENCES `prefix_forum_post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Table structure for table `prefix_forum_moderator`
--

ALTER TABLE `prefix_forum_moderator`
	MODIFY `moderator_id` int(11) unsigned NOT NULL auto_increment,
	ADD `moderator_allow_edit_post` tinyint(1) default NULL AFTER `moderator_allow_readonly`,
	ADD `moderator_allow_edit_topic` tinyint(1) default NULL AFTER `moderator_allow_edit_post`;

--
-- Constraints for table `prefix_forum_readonly`
--

ALTER TABLE `prefix_forum_moderator_rel`
	ADD CONSTRAINT `prefix_forum_moderator_rel_fk` FOREIGN KEY (`moderator_id`) REFERENCES `prefix_forum_moderator` (`moderator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_moderator_rel_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;
