{include file='header.tpl' noSidebar=true}

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">{$aLang.plugin.forum.topic_move} <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a></h4>

<form action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

	<p>
		<label for="topic_move_id">{$aLang.plugin.forum.topic_move_for}</label>
		<select id="topic_move_id" name="topic_move_id">
			{foreach from=$aForumsList item=aItem}
			<option value="{$aItem.id}"{if $_aRequest.topic_move_id==$aItem.id} selected{/if}>{$aItem.title}</option>
			{/foreach}
		</select>
	</p>

	<button type="submit" name="submit_topic_move" class="button button-primary">{$aLang.plugin.forum.topic_move}</button>
</form>

{include file='footer.tpl'}