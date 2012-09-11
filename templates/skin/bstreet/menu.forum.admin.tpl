<ul class="nav nav-pills">
	<li{if $sMenuSubItemSelect=='main'} class="active"{/if}><div class="strelka"></div><a href="{router page='forum'}admin/">{$aLang.plugin.forum.acp_main}</a></li>
	<li{if $sMenuSubItemSelect=='forums'} class="active"{/if}><div class="strelka"></div><a href="{router page='forum'}admin/forums/">{$aLang.plugin.forum.forums}</a></li>
	<li{if $sMenuSubItemSelect=='perms'} class="active"{/if}><div class="strelka"></div><a href="{router page='forum'}admin/perms/">{$aLang.plugin.forum.perms}</a></li>
 
	{hook run='menu_forum_admin_item'}
</ul>

{hook run='menu_forum_admin'}