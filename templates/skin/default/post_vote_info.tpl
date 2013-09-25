{**
 * Содержимое тултипа с информацией о голосовании за сообщение
 *}

<div class="tip-arrow"></div>
<ul class="tooltip-content" data-type="tooltip-content">
	<ul class="vote-topic-info">
		<li><i class="icon-plus icon-white"></i> {$oPost->getCountVoteUp()}</li>
		<li><i class="icon-minus icon-white"></i> {$oPost->getCountVoteDown()}</li>
		<li><i class="icon-eye-open icon-white"></i> {$oPost->getCountVoteAbstain()}</li>
		<li><i class="icon-asterisk icon-white"></i> {$oPost->getCountVote()}</li>

		{hook run='forum_post_show_vote_stats' post=$oPost}
	</ul>
</ul>