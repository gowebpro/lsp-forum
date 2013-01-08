{foreach from=$aTopics item=oTopic}
	{assign var='oUser' value=$oTopic->getUser()}
	{assign var='oPost' value=$oTopic->getPost()}
	{assign var='oPoster' value=$oPost->getUser()}
	{assign var='oMarker' value=$oForum->getMarker()}
	<tr id="topic-{$oTopic->getId()}"{if !($oMarker && $oMarker->checkTopic($oTopic))} class="unread"{/if}>
		<td class="cell-icon">
			<a class="topic-icon{if $oTopic->getPinned()} pinned{/if}{if $oTopic->getState()} close{/if}" href="{router page='forum'}topic/{$oTopic->getId()}" title="{if !($oMarker && $oMarker->checkTopic($oTopic))}{$aLang.plugin.forum.topic_unread}{else}{$aLang.plugin.forum.topic_read}{/if}"></a>
		</td>
		<td class="cell-name">
			<h4>
				{if $oTopic->getPinned()==1}
					{$aLang.plugin.forum.topic_pinned}:
				{/if}
				<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>
				{include file="$sTemplatePathPlugin/paging_post.tpl" aPaging=$oTopic->getPaging()}
			</h4>
			{if $oTopic->getDescription()}
			<p class="lighter">
				<small>{$oTopic->getDescription()}</small>
			</p>
			{/if}
			<p>
				{$aLang.plugin.forum.header_author}:
				<span class="author"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></span>,
				{date_format date=$oTopic->getDateAdd()}
			</p>
		</td>
		<td class="cell-stats ta-r">
			<ul>
				<li><strong>{$oTopic->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oTopic->getCountPost()|declension:$aLang.plugin.forum.posts_declension:'russian'|lower}</li>
				<li><strong>{$oTopic->getViews()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oTopic->getViews()|declension:$aLang.plugin.forum.views_declension:'russian'|lower}</li>
			</ul>
		</td>
		<td class="cell-post">
			<ul class="last-post">
				<li><a class="date" title="{$aLang.plugin.forum.post_last_view}" href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{date_format date=$oPost->getDateAdd() format='d.m.Y, H:i'}</a></li>
				<li>
					{$aLang.plugin.forum.post_writer}:
					<span class="author">
						{if $oPoster}
							<a href="{$oPoster->getUserWebPath()}"><img src="{$oPoster->getProfileAvatarPath(24)}" title="{$oPoster->getLogin()}" /></a>
							<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}</a>
						{else}
							<a href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}</a>
						{/if}
					</span>
				</li>
			</ul>
		</td>
	</tr>
{/foreach}