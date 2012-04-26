{foreach from=$aTopics item=oTopic}
	{assign var="oUser" value=$oTopic->getUser()}
	{assign var="oPost" value=$oTopic->getPost()}
	{assign var="oPoster" value=$oPost->getUser()}
	<tr id="topic-{$oTopic->getId()}">
		<td class="cell-icon">
			<a class="topic-icon{if $oTopic->getPinned()} pinned{/if}{if $oTopic->getState()} close{/if}" href="{router page='forum'}topic/{$oTopic->getId()}"></a>
		</td>
		<td class="cell-name">
			<h4>
				{if $oTopic->getPinned()==1}
					{$aLang.forum_topic_pinned}:
				{/if}
				<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>
				{include file="$sTemplatePathPlugin/paging_post.tpl" aPaging=$oTopic->getPaging()}
			</h4>
			<p>
				{$aLang.forum_header_author}:
				<span class="author"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></span>,
				{date_format date=$oTopic->getDateAdd()}
			</p>
			{if $oTopic->getDescription()}
			<p class="lighter">
				{$oTopic->getDescription()|wordwrap:30:" ":true }
			</p>
			{/if}
		</td>
		<td class="cell-stats ta-r">
			<ul>
				<li><strong>{$oTopic->getCountPost()}</strong> {$oTopic->getCountPost()|declension:$aLang.forum_posts_declension:'russian'|lower}</li>
				<li><strong>{$oTopic->getViews()}</strong> {$oTopic->getViews()|declension:$aLang.forum_views_declension:'russian'|lower}</li>
			</ul>
		</td>
		<td class="cell-post">
			{if $oPoster}
			<ul class="last-post">
				<li><a class="date" title="{$aLang.forum_header_last_post}" href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{date_format date=$oPost->getDateAdd() format='d.m.Y, H:i'}</a></li>
				<li>
					{$aLang.forum_header_author}:
					<span class="author">
						<a href="{$oPoster->getUserWebPath()}"><img src="{$oPoster->getProfileAvatarPath(24)}" title="{$oPoster->getLogin()}" /></a>
						<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}
					</span>
				</li>
			</ul>
			{/if}
		</td>
	</tr>
{/foreach}