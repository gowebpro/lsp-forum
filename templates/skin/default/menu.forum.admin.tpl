<ul class="nav nav-pills">
	<li{if $sMenuSubItemSelect=='main'} class="active"{/if}><a href="{router page='forum'}admin/"><div>{$aLang.plugin.forum.acp_main}</div></a></li>
	<li{if $sMenuSubItemSelect=='forums'} class="active"{/if}><a href="{router page='forum'}admin/forums/"><div>{$aLang.plugin.forum.forums}</div></a></li>
	<li{if $sMenuSubItemSelect=='perms'} class="active"{/if}><a href="{router page='forum'}admin/perms/"><div>{$aLang.plugin.forum.perms}</div></a></li>
 
	{hook run='menu_forum_admin_item'}
	{hook run='menu_forum_admin'}
</ul>