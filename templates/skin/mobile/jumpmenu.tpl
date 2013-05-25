{if $aJumpList}
<form action="{router page='forum'}jump" method="GET">
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}">
	<select name="f" onchange="return ls.forum.jumpMenu(this)">
		<optgroup label="{$aLang.plugin.forum.forums}">
		{foreach from=$aJumpList item=aItem}
			<option value="{$aItem.id}"{if $oForum && $aItem.id == $oForum->getId()} selected="selected"{/if}>{$aItem.title}</option>
		{/foreach}
		</optgroup>
	</select>
</form>
{/if}