<ul class="forum-list">
{if count($aForums) > 0}
	{foreach from=$aForums item=oForum}
		{if $oForum->getAllowShow()}
			{assign var='oPost' value=$oForum->getPost()}
			{assign var='aSubForums' value=$oForum->getChildren()}
			<li{if !$oForum->getRead() && !$oForum->getRedirectOn()} class="unread"{/if}>
				<a class="forum-icon{if !$oForum->getType()} archive{/if}" href="{$oForum->getUrlFull()}">
					<img src="{$oForum->getIconPath()}" alt="icon" {if !$oForum->getRedirectOn()}title="{if $oForum->getRead()}{$aLang.plugin.forum.forum_read}{else}{$aLang.plugin.forum.forum_unread}{/if}"{/if}/>
				</a>
				<h3>
					<a href="{$oForum->getUrlFull()}">{$oForum->getTitle()|escape:'html'}</a>
				</h3>
				{if $aSubForums}
				<p>
					<strong>{$aLang.plugin.forum.subforums}:</strong>
					{foreach from=$aSubForums item=oSubForum name=subforums}
						{if $oSubForum->getAllowShow()}
							{if !$smarty.foreach.subforums.first && !$smarty.foreach.subforums.last}, {/if}
							<a href="{$oSubForum->getUrlFull()}">{$oSubForum->getTitle()|escape:'html'}</a>
						{/if}
					{/foreach}
				</p>
				{/if}
				{if $oForum->getRedirectOn()}
				<p>
					<em>{$oForum->getRedirectHits()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')} {$oForum->getRedirectHits()|declension:$aLang.plugin.forum.redirect_hits_declension:'russian'|lower}</em>
				</p>
				{else}
				<p>
					{$oForum->getCountTopic()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oForum->getCountTopic()|declension:$aLang.plugin.forum.topics_declension:'russian'|lower}
					{$oForum->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oForum->getCountPost()|declension:$aLang.plugin.forum.posts_declension:'russian'|lower}
				</p>
				{if $oPost}
					<p>
						{assign var="oTopic" value=$oPost->getTopic()}
						{assign var="oPoster" value=$oPost->getUser()}
						{$aLang.plugin.forum.post_last}
						{if $oPoster}
							<a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()|escape:'html'}</a>,
						{else}
							<a href="{$oTopic->getUrlFull()}lastpost">{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()|escape:'html'}</a>,
						{/if}
						{if $oForum->getAllowRead() && $oForum->getAutorization()}
							<a class="date" title="{$aLang.plugin.forum.post_last_view}" href="{$oTopic->getUrlFull()}lastpost">
								<time datetime="{date_format date=$oPost->getDateAdd() format='c'}" title="{date_format date=$oPost->getDateAdd() format='j F Y, H:i'}">
									{date_format date=$oPost->getDateAdd() format="j F Y, H:i"}
								</time>
							</a>
						{else}
							<span title="{$aLang.plugin.forum.post_last_view}">
								<time datetime="{date_format date=$oPost->getDateAdd() format='c'}" title="{date_format date=$oPost->getDateAdd() format='j F Y, H:i'}">
									{date_format date=$oPost->getDateAdd() format="j F Y, H:i"}
								</time>
							</span>
						{/if}
					</p>
				{/if}
				{/if}
				{if !$oForum->getAllowRead() || !$oForum->getAutorization()}}
					<i title="{$aLang.plugin.forum.forum_closed}" class="icon-blog-private"></i>
				{/if}
			</li>
		{/if}
	{/foreach}
{else}
	<div class="notice-empty">
		{$aLang.plugin.forum.clear}
	</div>
{/if}
</table>