{assign var="noSidebar" value=true}
{include file='header.tpl'}

<div class="forum clear_fix">
	{assign var='aSubForums' value=$oForum->getChildren()}

	<div class="forumNav">
		<h2>{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>
	</div>

	<div class="forumBlock">
		{if $aSubForums}
		<div class="forumHeader clear_fix">
			<div class="leftBg">
				<h2><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()} - {$aLang.forum_subforums}</a></h2>
			</div>
			<div class="rightBg">
				<span class="lastMsg">{$aLang.forum_header_last_post|lower}</span>
				<span class="answers">{$aLang.forum_header_answers|lower}</span>
				<span class="views">{$aLang.forum_header_topics|lower}</span>
			</div>
		</div>

		<div class="tableContainer clear_fix">
			{include file="$sTemplatePathPlugin/forums_list.tpl" aForums=$aSubForums}
		</div>
		<div class="shadow"></div>
		{/if}

		{if $oForum->getCanPost() == 0}
		<div class="clear_fix">
		{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}
		{include file="$sTemplatePathPlugin/switcher_top.tpl"}
		</div>

		<div class="forumHeader forumHeader-sectionPage clear_fix">
			<div class="leftBg">
				<h2>{$oForum->getTitle()}</h2>
			</div>
			<div class="rightBg">
				<span class="answers">{$aLang.forum_header_answers|lower}</span>
				<span class="views">{$aLang.forum_header_views|lower}</span>
				<span class="lastMsg">{$aLang.forum_header_last_post|lower}</span>
			</div>
		</div>

		<div class="tableContainer clear_fix">
		{include file="$sTemplatePathPlugin/topics_list.tpl"}
		</div>

		<div class="shadow"></div>

		<div class="clear_fix">
		{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}
		{include file="$sTemplatePathPlugin/switcher_top.tpl"}
		</div>
		{/if}
	</div>

</div>
{include file='footer.tpl'}