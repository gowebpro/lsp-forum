<ul class="menu">
	<li{if $sMenuItemSelect=='forum'} class="active"{/if}>
		<a href="{router page='forum'}">{$aLang.forums}</a>
		{if $sMenuItemSelect=='forum'}
		<ul class="sub-menu">
			{if $oUserCurrent}
			<li{if $sEvent=='unread'} class="active"{/if}><a href="{router page='forum'}unread">{$aLang.forum_not_reading}</a></li>
			{/if}
		</ul>
		{/if}
	</li>
	{if $oUserCurrent && $oUserCurrent->isAdministrator()}
	<li{if $sMenuItemSelect=='admin'} class="active"{/if}>
		<a href="{router page='forum'}admin">{$aLang.forum_acp}</a>
		{if $sMenuItemSelect=='admin'}
		<ul class="sub-menu">
			<li{if $sMenuSubItemSelect=='main'} class="active"{/if}><a href="{router page='forum'}admin/">{$aLang.forum_acp_main}</a></li>
			<li{if $sMenuSubItemSelect=='forums'} class="active"{/if}><a href="{router page='forum'}admin/forums/">{$aLang.forums}</a></li>
		</ul>
		{/if}
	</li>
	{/if}
</ul>