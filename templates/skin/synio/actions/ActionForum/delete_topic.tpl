{include file='header.tpl' noSidebar=true}

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">{$aLang.plugin.forum.topic_delete} <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a></h4>

<div class="fBox">
	<form action="" method="POST" enctype="multipart/form-data">
		<div class="forums-content">
			<div class="system-message-error">{$aLang.plugin.forum.topic_delete_warning}</div>
		</div>
		<div class="fSubmit">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

			<button type="submit" name="submit_topic_delete" class="button button-primary">{$aLang.plugin.forum.topic_delete}</button>
		</div>
	</form>
</div>

{include file='footer.tpl'}