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
				<div class="author">
					<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(48)}" title="{$aLang.plugin.forum.header_author}: {$oUser->getLogin()}" /></a>
				</div>
				{if $oTopic->getPinned()==1}
					<span class="badge">{$aLang.plugin.forum.topic_pinned}</span>
				{/if}
				<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>
				{include file="$sTemplatePathForum/paging_post.tpl" aPaging=$oTopic->getPaging()}
			</h4>
			{if $oTopic->getDescription()}
			<p class="lighter">
				<small>{$oTopic->getDescription()}</small>
			</p>
			{/if}
			<p>
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
			<div class="author">
				{if $oPoster}
					<a href="{$oPoster->getUserWebPath()}"><img src="{$oPoster->getProfileAvatarPath(48)}" title="{$aLang.plugin.forum.post_writer}: {$oPoster->getLogin()}" /></a>
				{else}
					<a href="{router page='forum'}topic/{$oTopic->getId()}/lastpost"><img src="{cfg name='path.static.skin'}/images/avatar_male_48x48.png" title="{$aLang.plugin.forum.post_writer}: {$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}" /></a>
				{/if}
			</div>
			<ul class="last-post">
				<li>
				{if $oPoster}
					<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}</a>
				{else}
					<a href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}</a>
				{/if}
				</li>
				<li><a class="date" title="{$aLang.plugin.forum.post_last_view}" href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{date_format date=$oPost->getDateAdd() day="day H:i" format="j F Y, H:i"}</a></li>
			</ul>
		</td>
	</tr>
{/foreach}