{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.plugin.forum.forums}</h2>

<div class="forums">
	{if $aCategories}
		{foreach from=$aCategories item=oCategory}
			{if $oCategory->getAllowShow()}
				{assign var='aForums' value=$oCategory->getChildren()}
				<section class="fBox forums-list category-block" id="category-{$oCategory->getId()}">
					<header class="forums-header">
						<i class="js-forum-cat-toggler fl-r icon-minus-sign"></i>
						<h3><a href="{$oCategory->getUrlFull()}">{$oCategory->getTitle()}</a></h3>
					</header>
					<div class="forums-content">
						{include file="$sTemplatePathForum/forums_list.tpl"}
					</div>
					<div class="forums-note clearfix" style="display:none">
						<div class="fl-r">
							<strong>{$oCategory->getCountTopic()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oCategory->getCountTopic()|declension:$aLang.plugin.forum.topics_declension:'russian'|lower}
							<span>|</span>
							<strong>{$oCategory->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oCategory->getCountPost()|declension:$aLang.plugin.forum.posts_declension:'russian'|lower}
						</div>
					</div>
				</section>
			{/if}
		{/foreach}
	{else}
		<div class="body-message">
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