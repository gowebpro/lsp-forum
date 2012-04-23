{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.forums}</h2>

<div class="forums">
	{if $aCategories}
		{foreach from=$aCategories item=oCategory}
			{assign var='aForums' value=$oCategory->getChildren()}
			<section class="forums-list">
				<header class="forums-header">
					<h3><a href="{$oCategory->getUrlFull()}">{$oCategory->getTitle()}</a></h3>
				</header>
				<div class="forums-content">
					{include file="$sTemplatePathPlugin/forums_list.tpl"}
				</div>
			</section>
		{/foreach}
	{else}
		<div class="empty">
		{if $oUserCurrent && $oUserCurrent->isAdministrator()}
			{$aLangs.forums_welcome}
		{else}
			{$aLangs.forums_no}
		{/if}
		</div>
	{/if}
</div>

{include file="$sTemplatePathPlugin/statistics.tpl"}

{hook run='forum_copyright'}

{include file='footer.tpl'}