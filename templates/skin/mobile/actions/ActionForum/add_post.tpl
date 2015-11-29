{include file='header.tpl' noSidebar=true}

{include file='editor.tpl' sImgToLoad='post_text' sSettingsTinymce='ls.settings.getTinymce()' sSettingsMarkitup='ls.forum.getMarkitup()'}
{include file="$sTemplatePathForum/modals/modal.editor_spoiler.tpl" sToLoad='post_text'}

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">{$aLang.plugin.forum.reply_for|ls_lang:'topic%%'} &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;</h4>

<form action="" method="POST" enctype="multipart/form-data" id="form-post-add">
	{hook run='form_forum_add_post_begin'}

	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

	<p>
		<label for="post_title">{$aLang.plugin.forum.post_create_title}:</label>
		<input type="text" id="post_title" name="post_title" value="{$_aRequest.post_title|escape:'html'}" class="input-text input-width-full" /><br />
		<span class="note">{$aLang.plugin.forum.post_create_title_notice}</span>
	</p>

	<label for="post_text">{$aLang.plugin.forum.post_create_text}{if !$oConfig->GetValue('view.tinymce')} ({$aLang.plugin.forum.post_create_text_notice}){/if}:</label>
	<textarea name="post_text" id="post_text" rows="20" class="mce-editor markitup-editor input-width-full">{$_aRequest.post_text}</textarea>

	{if !$oConfig->GetValue('view.tinymce')}
		{include file='tags_help.tpl' sTagsTargetId="post_text"}
		<br />
		<br />
	{/if}

	{* Расширенная форма для гостей *}
	{include file="$sTemplatePathForum/guest_block.tpl" event="post"}

	{* Прикрепление файлов *}
	{include file="$sTemplatePathForum/forms/form.attach.tpl"}

	{hook run='form_forum_add_post_end'}

	<input type="hidden" name="action_type" value="add_post" />

	<button type="submit" name="submit_preview" onclick="return ls.forum.preview('form-post-add','text_preview');" class="button">{$aLang.plugin.forum.button_preview}</button>
	<button type="submit" name="submit_post_publish" id="submit_post_publish" class="button button-primary">{$aLang.plugin.forum.button_publish}</button>
</form>

<div class="topic-preview" style="display: none;" id="text_preview"></div>

{include file='footer.tpl'}