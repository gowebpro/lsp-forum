<table class="table table-topics">
{if count($aPinned) > 0}
	<tr>
		<td class="cell-subtitle" colspan="6">
			{$aLang.forum_topics_pinned}
		</td>
	</tr>
	{include file="$sTemplatePathPlugin/topics_list.tpl" aTopics=$aPinned}
{/if}
{if count($aTopics) > 0}
	<tr>
		<td class="cell-subtitle" colspan="6">
			{$aLang.forum_topics_forum}
		</td>
	</tr>
	{include file="$sTemplatePathPlugin/topics_list.tpl"}
{/if}
{if !$aPinned and !$aTopics}
	<tr>
		<td colspan="6">
			<div class="empty">{$aLang.forum_empty}</div>
		</td>
	</tr>
{/if}
</table>