<div class="topic-preview" style="display: none;" id="text_preview"></div>

<div class="forum-fast-reply" style="display:none" id="fast-reply-form">
	{include file='editor.tpl' sImgToLoad='post_text' sSettingsTinymce='ls.settings.getTinymceComment()' sSettingsMarkitup='ls.forum.getMarkitupMini()'}

	<h4 class="page-subheader">{$aLang.plugin.forum.reply_for|ls_lang:'topic%%'} &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;</h4>

	<form action="{$oTopic->getUrlFull()}reply/" method="POST" enctype="multipart/form-data" id="form-fast-reply">
		{hook run='form_forum_fast_reply_begin'}

		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		<input type="hidden" name="replyto" id="replyto" value="0" />
		<input type="hidden" name="action_type" value="add_post" />

		<textarea name="post_text" id="post_text" rows="10" class="mce-editor markitup-editor input-width-full">{$_aRequest.post_text}</textarea>

		{hook run='form_forum_fast_reply_end'}

		<div class="fl-r" id="reply-to-post-wrap" style="display:none">
			{$aLang.plugin.forum.reply_for_post} <span></span>
		</div>

		<button type="submit" name="submit_post_publish" id="submit_post_publish" class="button button-primary">{$aLang.plugin.forum.button_publish}</button>
		<button type="submit" name="submit_preview" onclick="return ls.forum.preview('form-fast-reply','text_preview');" class="button">{$aLang.plugin.forum.button_preview}</button>
		<button type="button" name="submit_cancel" onclick="return ls.forum.cancelPost()" class="button">{$aLang.plugin.forum.button_cancel}</button>
	</form>
</div>