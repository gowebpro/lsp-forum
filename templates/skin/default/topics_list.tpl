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
			{if $oTopic->getDescription()}
			<p class="details">{$oTopic->getDescription()|wordwrap:30:" ":true }</p>
			{/if}
		</td>
		<td class="cell-counter ta-c">{$oTopic->getCountPost()}</td>
		<td class="cell-author ta-c">
			<span class="author">
				<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(24)}" /></a>
				<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
			</span>
		</td>
		<td class="cell-counter ta-c">{$oTopic->getViews()}</td>
		<td class="cell-last-post">
			{if $oPoster}
			<div><span class="date">{date_format date=$oPost->getDateAdd() format='d.m.Y, H:i'}</span></div>
			<a href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{$aLang.forum_header_last_post}</a>
			<span class="author">
				<a href="{$oPoster->getUserWebPath()}"><img src="{$oPoster->getProfileAvatarPath(24)}" /></a>
				<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}</a>
			</span>
			{/if}
		</td>
	</tr>
{/foreach}