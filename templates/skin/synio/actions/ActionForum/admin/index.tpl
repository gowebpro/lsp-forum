{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.forum_acp}</h2>

{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}

<div class="forums">
	<header class="forums-header">
		<h3>{$aLang.forum_plugin_about}</h3>
	</header>

	<div class="forums-content">
		<section>{$aLang.forum_plugin_about_text}</section>
	</div>
</div>

{include file='footer.tpl'}