<table class="table table-forums">
	<thead>
		<tr>
			<th class="cell-name" colspan="2">{$aLang.forum|lower}</th>
			<th class="cell-counter ta-c">{$aLang.forum_header_topics|lower}</th>
			<th class="cell-counter ta-c">{$aLang.forum_header_answers|lower}</th>
			<th class="cell-last-post">{$aLang.forum_header_last_post|lower}</th>
		</tr>
	</thead>
	<tbody>
	{if count($aForums) > 0}
		{foreach from=$aForums item=oForum}
			{assign var="oPost" value=$oForum->getPost()}
			{assign var='aSubForums' value=$oForum->getChildren()}
			<tr>
				<td class="cell-icon">
					<a class="bbl" href="{$oForum->getUrlFull()}"></a>
				</td>
				<td class="cell-name">
					<h3><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a></h3>
					<p class="details">{$oForum->getDescription()|escape:'html'|nl2br}</p>
					{if $aSubForums}
					<p class="details">
						<strong>{$aLang.forum_subforums}:</strong>
						{foreach from=$aSubForums item=oSubForum name=subforums}
						<a href="{$oSubForum->getUrlFull()}">{$oSubForum->getTitle()}</a>{if !$smarty.foreach.subforums.last}, {/if}
						{/foreach}
					</p>
					{/if}
				</td>
				{if $oForum->getRedirectOn()}
				<td class="cell-counter ta-c" colspan="3"><strong>{$aLang.forum_redirect_hits}</strong>: {$oForum->getRedirectHits()}</td>
				{else}
				<td class="cell-counter ta-c">{$oForum->getCountTopic()}</td>
				<td class="cell-counter ta-c">{$oForum->getCountPost()}</td>
				<td class="cell-last-post">
					{if $oPost}
						{assign var="oTopic" value=$oPost->getTopic()}
						{assign var="oPoster" value=$oPost->getUser()}
						<p class="details">
							<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|wordwrap:30:" ":true}</a>
							<a class="link-to-msg" title="{$aLang.forum_to_last_post}" href="{router page='forum'}topic/{$oTopic->getId()}/lastpost"></a>
						</p>
						<span class="author">
							<a href="{$oPoster->getUserWebPath()}"><img src="{$oPoster->getProfileAvatarPath(24)}" /></a>
							<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}</a>
						</span>
						<span class="date">@ {date_format date=$oPost->getDateAdd()}</span>
					{/if}
				</td>
				{/if}
			</tr>
		{/foreach}
	{else}
		<tr>
			<td colspan="5">
				<div class="empty">{$aLang.forums_no}</div>
			</td>
		</tr>
	{/if}
	</tbody>
</table>