{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.plugin.forum.forums}</h2>

<div class="forums">
	{if $aForums}
		{foreach from=$aForums item=oForum}
			{if $oForum->getAllowShow()}
				{assign var='aSubForums' value=$oForum->getChildren()}
				<section class="forums-list">
					<header class="forums-header">
						<i class="js-forum-cat-toggler fl-r icon-minus-sign"></i>
						<h3><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a></h3>
					</header>
					<div class="forums-content">
						{include file="$sTemplatePathForum/forums_list.tpl" aForums=$aSubForums}
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
	<div class="board-stats-links clearfix">
		<div class="fl-r">
			<a class="link-dotted" href="{router page='forum'}?markread=all">{$aLang.plugin.forum.markread_all}</a>
		</div>
	</div>
</div>

{include file="$sTemplatePathForum/statistics.tpl"}

{hook run='forum_copyright'}

{include file='footer.tpl'}