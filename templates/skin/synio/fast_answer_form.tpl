<div class="topic-preview" style="display: none;" id="text_preview"></div>

<div class="forum-fast-reply" style="display:none" id="fast-reply-form">
{if $oConfig->GetValue('view.tinymce')}
	<script src="{cfg name='path.root.engine_lib'}/external/tinymce-jq/tiny_mce.js"></script>
	<script>
		jQuery(function($){
			tinyMCE.init(ls.settings.getTinymce());
		});
	</script>
{else}
	{include file='window_load_img.tpl' sToLoad='post_text'}
	<script>
		jQuery(function($){
			ls.lang.load({lang_load name="panel_b,panel_i,panel_s,panel_url,panel_url_promt,panel_image,panel_quote,panel_clear_tags,panel_image_promt,panel_user_promt"});
			// Подключаем редактор
			$('#post_text').markItUp(ls.forum.getMarkitupMini());
		});
	</script>
{/if}
	<h4 class="page-subheader">{$aLang.plugin.forum.reply_for|ls_lang:'topic%%'} &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;</h4>

	<form action="{$oTopic->getUrlFull()}reply" method="POST" enctype="multipart/form-data" id="form-fast-reply">
		{hook run='form_forum_fast_reply_begin'}

		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

		<p>
			<label for="post_title">{$aLang.plugin.forum.post_create_title}:</label>
			<input type="text" id="post_title" name="post_title" value="{$_aRequest.post_title}" class="input-text input-width-full" /><br />
			<span class="note">{$aLang.plugin.forum.post_create_title_notice}</span>
		</p>

		<p>
			<label for="post_text">{$aLang.plugin.forum.post_create_text}{if !$oConfig->GetValue('view.tinymce')} ({$aLang.plugin.forum.post_create_text_notice}){/if}:</label>
			<textarea name="post_text" id="post_text" rows="10" class="mce-editor">{$_aRequest.post_text}</textarea>
		</p>

		{hook run='form_forum_fast_reply_end'}

		<input type="hidden" name="action_type" value="add_post" />

		<button type="submit" name="submit_preview" onclick="return ls.forum.preview('form-fast-reply','text_preview');" class="button">{$aLang.topic_create_submit_preview}</button>
		<button type="submit" name="submit_post_publish" id="submit_post_publish" class="button button-primary">{$aLang.topic_create_submit_publish}</button>
	</form>
</div>