<div id="fast-reply-form" class="forum-fast-reply" style="display:none"> 
	<h4 class="page-subheader">{$aLang.forum_reply_for|ls_lang:'topic%%'} &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;</h4>

	<div class="topic-preview" style="display: none;" id="text_preview"></div>

	<form action="{$oTopic->getUrlFull()}reply" method="POST" enctype="multipart/form-data" id="form-fast-reply">
		{hook run='form_forum_fast_reply_begin'}

		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

		<p>
			<label for="post_title">{$aLang.forum_post_create_title}:</label>
			<input type="text" id="post_title" name="post_title" value="{$_aRequest.post_title}" class="input-text input-width-full" /><br />
			<span class="note">{$aLang.forum_post_create_title_notice}</span>
		</p>

		<p>
			<label for="post_text">{$aLang.forum_post_create_text}{if !$oConfig->GetValue('view.tinymce')} ({$aLang.forum_post_create_text_notice}){/if}:</label>
			<textarea name="post_text" id="post_text" rows="10" class="input-text input-width-full">{$_aRequest.post_text}</textarea>
		</p>

		{hook run='form_forum_fast_reply_end'}

		<button name="submit_post_publish" id="submit_post_publish" class="button button-primary fl-r">{$aLang.topic_create_submit_publish}</button>
		<button name="submit_preview" onclick="return ls.forum.preview('post_text');" class="button">{$aLang.topic_create_submit_preview}</button>
	</form>
</div>