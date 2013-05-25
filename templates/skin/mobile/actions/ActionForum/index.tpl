{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.plugin.forum.forums}</h2>

<div class="forums">
	{if $aCategories}
		{foreach from=$aCategories item=oCategory}
			{if $oCategory->getAllowShow()}
				{assign var='aForums' value=$oCategory->getChildren()}
				<section class="forum-block">
					<header class="forum-header">
						<span class="js-forum-cat-toggler fl-r"></span>
						<h3><a href="{$oCategory->getUrlFull()}">{$oCategory->getTitle()}</a></h3>
					</header>
					<div class="forum-content">
						{include file="$sTemplatePathForum/forums_list.tpl"}
					</div>
				</section>
			{/if}
		{/foreach}
	{else}
		<div class="notice-empty">
		{if $oUserCurrent && $oUserCurrent->isAdministrator()}
			{assign var="sRoot" value='root%%'|cat:$aRouter.forum}
			{$aLang.plugin.forum.welcome|ls_lang:$sRoot}
		{else}
			{$aLang.plugin.forum.clear}
		{/if}
		</div>
	{/if}
</div>

{include file="$sTemplatePathForum/statistics.tpl"}

{hook run='forum_copyright'}

{include file='footer.tpl'}