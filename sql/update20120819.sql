--
-- Update from 2012.08.19
--

--
-- Table structure for table `prefix_forum_moderator`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_moderator` (
	`moderator_id` int(11) NOT NULL auto_increment,
	`forum_id` int(11) unsigned NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`moderator_login` varchar(50) NOT NULL default '',
	`moderator_view_ip` tinyint(1) default NULL,
	`moderator_allow_readonly` tinyint(1) default NULL,
	`moderator_allow_delete_post` tinyint(1) default NULL,
	`moderator_allow_delete_topic` tinyint(1) default NULL,
	`moderator_allow_move_post` tinyint(1) default NULL,
	`moderator_allow_move_topic` tinyint(1) default NULL,
	`moderator_allow_openclose_topic` tinyint(1) default NULL,
	`moderator_allow_pin_topic` tinyint(1) default NULL,
	`moderator_is_active` tinyint(1) default '1',
	`moderator_hash` varchar(250) default '',
	PRIMARY KEY (`moderator_id`),
	KEY forum_id (`forum_id`),
	KEY user_id (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table structure for table `prefix_forum_moderator_rel`
--

CREATE TABLE IF NOT EXISTS `prefix_forum_moderator_rel` (
	`moderator_id` int(11) unsigned NOT NULL,
	`forum_id` int(11) unsigned NOT NULL,
	UNIQUE KEY `moderator_id_forum_id` (`moderator_id`,`forum_id`),
	KEY `moderator_id` (`moderator_id`),
	KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;`;


--
-- Constraints for table `prefix_forum_moderator_rel`
--

--
-- Constraints for table `prefix_forum_moderator`
--
ALTER TABLE `prefix_forum_moderator`
	ADD CONSTRAINT `prefix_forum_moderator_fk` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `prefix_forum_moderator_fk1` FOREIGN KEY (`forum_id`) REFERENCES `prefix_forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE;
