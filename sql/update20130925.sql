--
-- Update from 2013.09.25
--

ALTER TABLE `prefix_forum_post`
	ADD `post_rating` float(9,3) NOT NULL DEFAULT '0.000',
	ADD `post_count_vote` int(11) unsigned NOT NULL DEFAULT '0',
	ADD `post_count_vote_up` int(11) NOT NULL DEFAULT '0',
	ADD `post_count_vote_down` int(11) NOT NULL DEFAULT '0',
	ADD `post_count_vote_abstain` int(11) NOT NULL DEFAULT '0';
