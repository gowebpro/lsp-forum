<table class="table table-topics">
{if count($aPinned) > 0}
	<tr>
		<th class="cell-subtitle" colspan="6">
			{$aLang.plugin.forum.topics_pinned}
		</th>
	</tr>
	{include file="$sTemplatePathPlugin/topics_list.tpl" aTopics=$aPinned}
{/if}
{if count($aTopics) > 0}
	<tr>
		<th class="cell-subtitle" colspan="6">
			{$aLang.plugin.forum.topics_forum}
		</th>
	</tr>
	{include file="$sTemplatePathPlugin/topics_list.tpl"}
{/if}
{if !$aPinned and !$aTopics}
	<tr>
		<td colspan="6">
			<div class="empty">{$aLang.plugin.forum.empty}</div>
		</td>
	</tr>
{/if}
</table>