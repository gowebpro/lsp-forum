{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.plugin.forum.forums}</h2>

<div class="forums">
	{if count($aForums) > 0}
		{foreach from=$aForums item=oForum}
			{if $oForum->getAllowShow()}
				{assign var="aSubForums" value=$oForum->getChildren()}
				<section class="forum-block toggle-section" id="category-{$oForum->getId()}">
					<header class="forum-header">
						<i class="js-forum-cat-toggler"></i>
						<h3><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a></h3>
					</header>
					<div class="forum-content">
						{include file="$sTemplatePathForum/forums_list.tpl" aForums=$aSubForums}
					</div>
					<div class="forums-note clearfix" style="display:none">
						<div class="fl-r">
							<strong>{$oForum->getCountTopic()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oForum->getCountTopic()|declension:$aLang.plugin.forum.topics_declension:'russian'|lower}
							<span>|</span>
							<strong>{$oForum->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oForum->getCountPost()|declension:$aLang.plugin.forum.posts_declension:'russian'|lower}
						</div>
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
	<div class="board-stats-links clearfix">
		<div class="fl-r">
			<a class="link-dotted" href="{router page='forum'}?markread=all">{$aLang.plugin.forum.markread_all}</a>
		</div>
	</div>
</div>

{include file="$sTemplatePathForum/statistics.tpl"}

{hook run='forum_copyright'}

{include file='footer.tpl'}