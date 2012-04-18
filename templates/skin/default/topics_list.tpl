{foreach from=$aTopics item=oTopic}
	{assign var="oUser" value=$oTopic->getUser()}
	{assign var="oPost" value=$oTopic->getPost()}
	{assign var="oPoster" value=$oPost->getUser()}
	<tr>
		<td class="iconCol">
			<a class="bbl{if $oTopic->getPinned()} info{/if}{if $oTopic->getState()} close{/if}" href="{router page='forum'}topic/{$oTopic->getId()}"></a>
		</td>
		<td class="mainCol">
			<h3 class="clear_fix">
				{if $oTopic->getPinned()==1}
					{$aLang.forum_topic_pinned}:
				{/if}
				<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>
				{include file="$sTemplatePathPlugin/paging_post.tpl" aPaging=$oTopic->getPaging()}
			</h3>
			<p class="details">{$oTopic->getDescription()|wordwrap:30:" ":true }</p>
			<span class="author"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></span>
		</td>
		<td class="answers">{$oTopic->getCountPost()}</td>
		<td class="views">{$oTopic->getViews()}</td>
		<td class="lastMsg">
			{if $oPoster}
			<div><span class="date">{date_format date=$oPost->getDateAdd() format='d.m.Y, H:i'}</span></div>
			<div><span class="small"><a href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{$aLang.forum_header_last_post}</a></span></div>
			<span class="author">
				<a href="{$oPoster->getUserWebPath()}"><img src="{$oPoster->getProfileAvatarPath(24)}" /></a>
				<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}</a>
			</span>
			{/if}
		</td>
	</tr>
{/foreach}