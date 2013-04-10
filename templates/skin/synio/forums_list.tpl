<div class="fContainer">
	<table class="table table-forums">
	{if count($aForums) > 0}
		{foreach from=$aForums item=oForum}
			{if $oForum->getAllowShow()}
				{assign var='oPost' value=$oForum->getPost()}
				{assign var='oMarker' value=$oForum->getMarker()}
				{assign var='aSubForums' value=$oForum->getChildren()}
				{assign var='aModerators' value=$oForum->getModerators()}
				<tr{if !($oMarker && $oMarker->checkRead()) && !$oForum->getRedirectOn()} class="unread"{/if}>
					<td class="cell-icon">
						<a class="forum-icon{if !$oForum->getType()} archive{/if}" href="{$oForum->getUrlFull()}"><img src="{$oForum->getIconPath()}" alt="icon" {if !$oForum->getRedirectOn()}title="{if !($oMarker && $oMarker->checkRead())}{$aLang.plugin.forum.forum_unread}{else}{$aLang.plugin.forum.forum_read}{/if}"{/if}/></a>
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
						<p class="details userlist">
							<strong>{$aModerators|@count|declension:$aLang.plugin.forum.moderators_declension:'russian'}:</strong>
							{foreach from=$aModerators item=oModerator name=moderators}
								{assign var='oUserModer' value=$oModerator->getUser()}
								<a href="{$oUserModer->getUserWebPath()}"><img src="{$oUserModer->getProfileAvatarPath(24)}" title="{$oUserModer->getLogin()}" /></a>
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
							<div class="author">
								{if $oPoster}
									<a href="{$oPoster->getUserWebPath()}"><img src="{$oPoster->getProfileAvatarPath(48)}" title="{$aLang.plugin.forum.post_writer}: {$oPoster->getLogin()}" /></a>
								{else}
									<a href="{$oTopic->getUrlFull()}lastpost"><img src="{cfg name='path.static.skin'}/images/avatar_male_48x48.png" title="{$aLang.plugin.forum.post_writer}: {$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}" /></a>
								{/if}
							</div>
							<ul class="last-post">
								<li>
									{if $oForum->getAllowRead() && $oForum->getAutorization()}
										<a href="{$oTopic->getUrlFull()}newpost">{$oTopic->getTitle()}</a>
									{else}
										<em>{$aLang.plugin.forum.forum_closed}</em>
									{/if}
								</li>
								<li>
									{$aLang.plugin.forum.post_writer}:
									{if $oPoster}
										<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}</a>
									{else}
										<a href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}</a>
									{/if}
								</li>
								<li>
									{if $oForum->getAllowRead() && $oForum->getAutorization()}
										<a class="date" title="{$aLang.plugin.forum.post_last_view}" href="{router page='forum'}topic/{$oTopic->getId()}/lastpost">{date_format date=$oPost->getDateAdd()}</a>
									{else}
										<span title="{$aLang.plugin.forum.post_last_view}">{date_format date=$oPost->getDateAdd()}</span>
									{/if}
								</li>
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
</div>