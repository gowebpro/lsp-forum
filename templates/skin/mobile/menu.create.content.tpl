{if $sCurrentViewMode == '1'}
	{if $sMenuItemSelect=='forum' && $sMenuSubItemSelect=='add'}
		{$aLang.block_create} {$aLang.plugin.forum.create_menu_topic}
	{/if}

{elseif $sCurrentViewMode == '2'}
	<li{if $sMenuItemSelect=='forum' && $sMenuSubItemSelect=='add'} class="active"{/if}><a href="{router page='forum'}topic/add/">{$aLang.block_create} {$aLang.plugin.forum.create_menu_topic}</a></li>

{/if}