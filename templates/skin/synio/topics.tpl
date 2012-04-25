<table class="table table-topics">
	<thead>
		<tr>
			<th class="cell-name" colspan="2"></th>
			<th class="cell-counter ta-c">{$aLang.forum_header_answers|lower}</th>
			<th class="cell-author ta-c">{$aLang.forum_header_author|lower}</th>
			<th class="cell-counter ta-c">{$aLang.forum_header_views|lower}</th>
			<th class="cell-last-post">{$aLang.forum_header_last_post|lower}</th>
		</tr>
	</thead>
	<tbody>
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
	</tbody>
</table>