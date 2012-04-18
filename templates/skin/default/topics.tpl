<div class="forumHeader forumHeader-sectionPage clear_fix">
	<div class="leftBg">
		<h2>{$oForum->getTitle()}</h2>
	</div>
	<div class="rightBg">
		<span class="answers">{$aLang.forum_header_answers|lower}</span>
		<span class="views">{$aLang.forum_header_views|lower}</span>
		<span class="lastMsg">{$aLang.forum_header_last_post|lower}</span>
	</div>
</div>

<div class="tableContainer clear_fix">
	<table class="forumBody forumBody-sectionPage">
	{if count($aPinned) > 0}
		<tr>
			<td colspan="5">
				<strong>{$aLang.forum_topics_pinned}</strong>
			</td>
		</tr>
		{include file="$sTemplatePathPlugin/topics_list.tpl" aTopics=$aPinned}
	{/if}
	{if count($aTopics) > 0}
		<tr>
			<td colspan="5">
				<strong>{$aLang.forum_topics_forum}</strong>
			</td>
		</tr>
		{include file="$sTemplatePathPlugin/topics_list.tpl"}
	{/if}
	{if !$aPinned and !$aTopics}
		<tr>
			<td colspan="5">
				<div class="empty">{$aLang.forum_empty}</div>
			</td>
		</tr>
	{/if}
	</table>
</div>