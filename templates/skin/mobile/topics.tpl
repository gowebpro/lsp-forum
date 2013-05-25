<ul class="topic-list">
{if count($aPinned) > 0}
	<li class="topic-subtitle">
		{$aLang.plugin.forum.topics_pinned}
	</li>
	{include file="$sTemplatePathForum/topics_list.tpl" aTopics=$aPinned}
{/if}
{if count($aTopics) > 0}
	<li class="topic-subtitle">
		{$aLang.plugin.forum.topics_forum}
	</li>
	{include file="$sTemplatePathForum/topics_list.tpl"}
{/if}
{if !$aPinned and !$aTopics}
	<li>
		<div class="notice-empty">
			{$aLang.plugin.forum.empty}
		</div>
	</li>
{/if}
</table>