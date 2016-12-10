{if $aPageSessions}
<div class="forum-sess">
	<h4>
		{if $sEvent == 'topic'}
    	    {$aLang.plugin.forum.sessions_event_topic_title}
		{else}
    	    {$aLang.plugin.forum.sessions_event_forum_title}
		{/if}
	</h4>

	<p>
		{if $iPageUsers}
			{$iPageUsers|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')} {$iPageUsers|declension:$aLang.plugin.forum.users_declension:'russian'|lower}
		{/if}
		{if $iPageUsers && $iPageGuest}
			{$aLang.plugin.forum.and}
		{/if}
		{if $iPageGuest}
			{$iPageGuest|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')} {$iPageGuest|declension:$aLang.plugin.forum.guest_declension:'russian'|lower}
		{/if}
	</p>

	<div class="forum-userlist">
		{foreach $aPageSessions as $oSession}
			{$oSessionUser = $oSession->getUser()}
			{if $oSessionUser}
				<span><a href="{$oSessionUser->getUserWebPath()}"><img src="{$oSessionUser->getProfileAvatarPath(24)}" alt="{$oSessionUser->getLogin()|escape:'html'}" />{$oSessionUser->getLogin()|escape:'html'}</a></span>
			{/if}
			{if $iPageUsers > $oSession@index+1}, {/if}
		{/foreach}
	</div>
</div>
{/if}