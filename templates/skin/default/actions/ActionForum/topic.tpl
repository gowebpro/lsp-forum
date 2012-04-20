{assign var="noSidebar" value=true}
{include file='header.tpl'}

{assign var="oForum" value=$oTopic->getForum()}

<h2 class="page-header">{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>

<div class="controllers clear_fix">
	{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging sAlign='left'}
	{include file="$sTemplatePathPlugin/buttons_action.tpl" sAlign='right'}
</div>

<div class="forum-topic">
	<header class="forums-header">
		<h3>{$oTopic->getTitle()}</h3>
	</header>
	{foreach from=$aPosts item=oPost}
		{include file="$sTemplatePathPlugin/post.tpl" oPost=$oPost}
	{/foreach}
	<footer class="forum-topic-footer">
		<form name="modform" action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
			<input type="hidden" name="t" value="{$oTopic->getId()}" />
			<input type="hidden" name="f" value="{$oForum->getId()}" />
			<select name="code">
				<option value="-1">{$aLang.forum_topic_mod_option}</option>
				<option value="1">-{$aLang.forum_topic_move}</option>
				<option value="2">-{$aLang.forum_topic_delete}</option>
				{if $oTopic->getStatus() == '0'}
				<option value="3">-{$aLang.forum_topic_close}</option>
				{else}
				<option value="3">-{$aLang.forum_topic_open}</option>
				{/if}
				{if $oTopic->getPosition() == '0'}
				<option value="4">-{$aLang.forum_topic_pin}</option>
				{else}
				<option value="4">-{$aLang.forum_topic_unpin}</option>
				{/if}
			</select>
			<button type="submit" name="submit_topic_mod" class="button">OK</button>
		</form>
	</footer>
</div>

<div class="controllers clear_fix">
	{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging sAlign='left'}
	{include file="$sTemplatePathPlugin/buttons_action.tpl" sAlign='right'}
</div>

<div id="fastAnswer{$oTopic->getId()}" style="display:none">
	<div class="fastAnswer clear_fix">
		<div class="topic" style="display:none">
			<div class="content" id="text_preview"></div>
		</div>
		<div class="fastAnswerForm">
			<form action="{$oTopic->getUrlFull()}reply" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

				<p>
					<label for="post_title">{$aLang.forum_post_create_title}:</label><br />
					<input type="text" id="post_title" name="post_title" value="{$_aRequest.post_title}" class="input-wide" /><br />
					<span class="note">{$aLang.forum_post_create_title_notice}</span>
				</p>

				<textarea name="post_text" id="post_text" rows="20" class="input-wide markItUpEditor">{$_aRequest.post_text}</textarea><br />

				<p class="buttons">
					<input type="submit" name="submit_post_publish" value="{$aLang.topic_create_submit_publish}" class="right" />
					<input type="submit" name="submit_preview" value="{$aLang.topic_create_submit_preview}" onclick="jQuery('#text_preview').parent().show(); ls.tools.textPreview('post_text',false); return false" />&nbsp;
				</p>
			</form>
		</div>
	</div>
</div>

{include file='footer.tpl'}