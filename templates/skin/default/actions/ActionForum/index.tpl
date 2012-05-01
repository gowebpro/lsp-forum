{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.forums}</h2>

<div class="forums">
	{if $aCategories}
		{foreach from=$aCategories item=oCategory}
			{assign var='aForums' value=$oCategory->getChildren()}
			<section class="forums-list">
				<header class="forums-header">
					<span class="js-forum-cat-toogler fl-r icon-minus-sign"></span>
					<h3><a href="{$oCategory->getUrlFull()}">{$oCategory->getTitle()}</a></h3>
				</header>
				<div class="forums-content">
					{include file="$sTemplatePathPlugin/forums_list.tpl"}
				</div>
			</section>
		{/foreach}
	{else}
		<div class="body-message">
		{if $oUserCurrent && $oUserCurrent->isAdministrator()}
			{assign var="sRoot" value='root%%'|cat:$aRouter.forum}
			{$aLang.forums_welcome|ls_lang:$sRoot}
		{else}
			{$aLang.plugin.forum.clear}
		{/if}
		</div>
	{/if}
</div>

{include file="$sTemplatePathPlugin/statistics.tpl"}

{hook run='forum_copyright'}

{include file='footer.tpl'}