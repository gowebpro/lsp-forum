<ul class="nav nav-pills">
	<li{if $sMenuSubItemSelect=='main'} class="active"{/if}><a href="{router page='forum'}admin/"><div>{$aLang.forum_acp_main}</div></a></li>
	<li{if $sMenuSubItemSelect=='forums'} class="active"{/if}><a href="{router page='forum'}admin/forums/"><div>{$aLang.forums}</div></a></li>

	{hook run='menu_forum_admin_item'}
</ul>

{hook run='menu_forum_admin'}