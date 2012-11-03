<table class="table table-forums">
{if count($aForums) > 0}
	{foreach from=$aForums item=oForum}
		{if $oForum->getAllowShow()}
			{assign var="oPost" value=$oForum->getPost()}
			{assign var='aSubForums' value=$oForum->getChildren()}
			{assign var='aModerators' value=$oForum->getModerators()}
			<tr>
				<td class="cell-icon">
					<a class="forum-icon{if !$oForum->getType()} archive{/if}" href="{$oForum->getUrlFull()}"></a>
				</td>
				<td class="cell-name">
					<h3><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a></h3>
					<p class="details">{$oForum->getDescription()|escape:'html'|nl2br}</p>
					{if $aSubForums}
					<p class="details">
						<strong>{$aLang.plugin.forum.subforums}:</strong>
						{foreach from=$aSubForums item=oSubForum name=subforums}
							{if $oSubForum->getAllowShow()}
							<a href="{$oSubForum->getUrlFull()}">{$oSubForum->getTitle()}</a>{if !$smarty.foreach.subforums.last}, {/if}
							{/if}
						{/foreach}
					</p>
					{/if}
					{if $aModerators}
					<p class="details">
						<strong>{$aModerators|@count|declension:$aLang.plugin.forum.moderators_declension:'russian'}:</strong>
						{foreach from=$aModerators item=oModerator name=moderators}
						<em>{$oModerator->getLogin()}</em>{if !$smarty.foreach.moderators.last}, {/if}
						{/foreach}
					</p>
					{/if}
				</td>
				{if $oForum->getRedirectOn()}
				<td class="ta-c" colspan="2"><span class="lighter"><em>{$oForum->getRedirectHits()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')} {$oForum->getRedirectHits()|declension:$aLang.plugin.forum.redirect_hits_declension:'russian'|lower}</span></p></td>
				{else}
				<td class="cell-stats ta-r">
					<ul>
						<li><strong>{$oForum->getCountTopic()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oForum->getCountTopic()|declension:$aLang.plugin.forum.topics_declension:'russian'|lower}</li>
						<li><strong>{$oForum->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oForum->getCountPost()|declension:$aLang.plugin.forum.posts_declension:'russian'|lower}</li>
					</ul>
				</td>
				<td class="cell-post">
					{if $oPost}
						{assign var="oTopic" value=$oPost->getTopic()}
						{assign var="oPoster" value=$oPost->getUser()}
						<ul class="last-post">
							{if $oForum->getAllowRead() && $oForum->getAutorization()}
							<li><a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a></li>
							{else}
							<li><em>{$aLang.plugin.forum.forum_closed}</em></li>
							{/if}
							<li>
								{$aLang.plugin.forum.post_writer}:
								<span class="author user-avatar">
									{if $oPoster}
										<a href="{$oPoster->getUserWebPath()}"><img src="{$oPoster->getProfileAvatarPath(24)}" title="{$oPoster->getLogin()}" /></a>
										<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}</a>
									{else}
										<a href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}</a>
									{/if}
								</span>
							</li>
							{if $oForum->getAllowRead() && $oForum->getAutorization()}
							<li><a class="date" title="{$aLang.plugin.forum.post_last_view}" href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{date_format date=$oPost->getDateAdd()}</a></li>
							{else}
							<li><span title="{$aLang.plugin.forum.post_last_view}">{date_format date=$oPost->getDateAdd()}</span></li>
							{/if}
						</ul>
					{/if}
				</td>
				{/if}
			</tr>
		{/if}
	{/foreach}
{else}
	<tr>
		<td colspan="5">
			<div class="empty">{$aLang.plugin.forum.clear}</div>
		</td>
	</tr>
{/if}
</table>