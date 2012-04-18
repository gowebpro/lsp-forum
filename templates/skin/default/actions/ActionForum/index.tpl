{include file='header.tpl' noSidebar=true}

<div class="forum clear_fix">

	<div class="forumNav">
		<h2>{$aLang.forums}</h2>
	</div>

	{if $aCategories}
	{foreach from=$aCategories item=oCategory}
		{assign var='aForums' value=$oCategory->getChildren()}
		<div class="forumHeader clear_fix">
			<div class="leftBg">
				<h2><a href="{$oCategory->getUrlFull()}">{$oCategory->getTitle()}</a></h2>
			</div>
			<div class="rightBg">
				<span class="lastMsg">{$aLang.forum_header_last_post|lower}</span>
				<span class="answers">{$aLang.forum_header_answers|lower}</span>
				<span class="views">{$aLang.forum_header_topics|lower}</span>
			</div>
		</div>

		<div class="tableContainer">
			{include file="$sTemplatePathPlugin/forums_list.tpl"}
		</div>
	{/foreach}
	{/if}

	<div class="shadow"></div>

	{if $oUserCurrent}
	<div class="clear_fix">
		<ul class="bottomMenu right">
			<li><a href="{router page='forum'}markread">{$aLang.forum_markread_all}</a></li>
		</ul>
	</div>
	{/if}
	
	{hook run='forum_copyright'}

	<div class="forumStats">
		<h2>{$aLang.forum_stat}</h2>
		<div class="topics">
			<span class="now">{$aLang.forum_stat_all} &mdash; <span class="sv-count">{$aForumStat.count_all_topics}/{$aForumStat.count_all_posts}</span></span>
			<span class="small">{$aLang.forum_stat_post_today} &mdash; {$aForumStat.count_today_posts}</span>
		</div>
	</div>

</div>

{include file='footer.tpl'}