<section class="forum-item-wrapper">
	<div class="forum-item-actions">
		{if $bFirst}
			<i class="js-tip-help icon-arrow-up action-disabled"></i>
		{else}
			<a class="js-tip-help icon-arrow-up" title="{$aLang.plugin.forum.sort_up} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/up/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
		{/if}
		{if $bLast}
			<i class="js-tip-help icon-arrow-down action-disabled"></i>
		{else}
			<a class="js-tip-help icon-arrow-down" title="{$aLang.plugin.forum.sort_down} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/down/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
		{/if}
		{if $bRefreshEnable}
			<a class="js-tip-help icon-refresh" title="{$aLang.plugin.forum.refresh}" href="{router page='forum'}admin/forums/refresh/{$oForum->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
		{/if}
		<a class="js-tip-help icon-eye-open" title="{$aLang.plugin.forum.perms}" href="{router page='forum'}admin/forums/perms/{$oForum->getId()}"></a>
		<a class="js-tip-help icon-edit" title="{$aLang.plugin.forum.edit}" href="{router page='forum'}admin/forums/edit/{$oForum->getId()}"></a>
		<a class="js-tip-help icon-remove" title="{$aLang.plugin.forum.delete}" href="{router page='forum'}admin/forums/delete/{$oForum->getId()}"></a>
	</div>
	<div class="forum-item-main">
		<img class="forum-item-icon" src="{$oForum->getIconPath(32)}" alt="{$oForum->getTitle()}" />
		<span class="forum-item-title">{$oForum->getTitle()}</span>
	</div>
	{if $bModerList}
	<span class="js-forum-moder-toogler js-tip-help fl-r icon-plus-sign" id="toggler-moder-list-{$oForum->getId()}" title="{$aLang.plugin.forum.moderators_list}"></span>
	<span class="forum-moder-list" id="moder-list-{$oForum->getId()}" style="display:none">
		{include file="$sTemplatePathForum/actions/ActionForum/admin/list_moderators.tpl"}
	</span>
	{/if}
</section>