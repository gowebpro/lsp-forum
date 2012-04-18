{assign var="noSidebar" value=true}
{include file='header.tpl'}
<div id="forum">

	<div class="forumNav">
		<h2>{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>
	</div>

	<div class="forumBlock">
		{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}

		<div class="forumHeader forumHeader-sectionPage clear_fix">
			<div class="leftBg"><h2>{$aLang.forum_not_reading}</h2></div>
			<div class="rightBg">
				<span class="answers">{$aLang.replies}</span>
				<span class="views">{$aLang.views}</span>
				<span class="lastMsg">{$aLang.last_post}</span>
			</div>
		</div>

		<div class="tableContainer clear_fix">
		{include file="$sTemplatePathPlugin/topics_list.tpl"}
		</div>

		<div class="shadow"></div>

		{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}
	</div>

</div>
{include file='footer.tpl'}