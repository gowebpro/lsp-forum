{include file='header.tpl' noSidebar=true}

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">{$aLang.plugin.forum.topic_delete} <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a></h4>

<form action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

	<div class="system-message-error">{$aLang.plugin.forum.topic_delete_warning}</div>

	<button type="submit" name="submit_topic_delete" class="button button-primary">{$aLang.plugin.forum.topic_delete}</button>
</form>

{include file='footer.tpl'}