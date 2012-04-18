{assign var="noSidebar" value=true}
{include file='header.tpl'}

<div class="forum">
	<div class="forumNav">
		<h2>{$aLang.forum_acp}</h2>
	</div>

	{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}

	<div class="forumBblock">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_plugin_about}</h2>
			</div>
			<div class="rightBg"></div>
		</div>
		
		<div class="fastAnswer clear_fix">
			<div class="fastAnswerForm">
				{$aLang.forum_plugin_about_text}
			</div>
		</div>
	</div>

</div>
{include file='footer.tpl'}