{assign var='aModerators' value=$oForum->getModerators()}

{if $aModerators}
	{foreach from=$aModerators item=oModerator name=moderators}
		{$oModerator->getLogin()}
		<a class="js-tip-help icon-edit" title="{$aLang.plugin.forum.moderator_edit}" href="#" onclick="return ls.forum.admin.editModerator('{$oModerator->getHash()}');"></a>
		<a class="js-tip-help icon-remove" title="{$aLang.plugin.forum.moderator_del}" href="#" onclick="return ls.forum.admin.delModerator('{$oModerator->getHash()}');"></a>
		{if !$smarty.foreach.moderators.last}, {/if}
	{/foreach}
{else}
	{$aLang.plugin.forum.moderators_empty}
{/if}
<br />
<a href="#" onclick="return ls.forum.admin.addModerator('{$oForum->getId()}')" class="link-dotted">{$aLang.plugin.forum.moderator_add}</a>
