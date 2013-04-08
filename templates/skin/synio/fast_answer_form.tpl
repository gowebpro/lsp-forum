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
			ls.lang.load({lang_load name="panel_b,panel_i,panel_s,panel_url,panel_url_promt,panel_image,panel_quote,panel_clear_tags,panel_image_promt,panel_user_promt,panel_emotion"});
			// Подключаем редактор
			$('#post_text').markItUp(ls.forum.getMarkitupMini());
		});
	</script>
{/if}
	<h4 class="page-subheader">{$aLang.plugin.forum.reply_for|ls_lang:'topic%%'} &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;</h4>

	<form action="{$oTopic->getUrlFull()}reply/" method="POST" enctype="multipart/form-data" id="form-fast-reply">
		{hook run='form_forum_fast_reply_begin'}

		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		<input type="hidden" name="replyto" id="replyto" value="0" />
		<input type="hidden" name="action_type" value="add_post" />

		<textarea name="post_text" id="post_text" rows="10" class="mce-editor">{$_aRequest.post_text}</textarea>

		{hook run='form_forum_fast_reply_end'}

		<div class="fl-r" id="reply-to-post-wrap" style="display:none">
			{$aLang.plugin.forum.reply_for_post} <span></span>
		</div>

		<button type="submit" name="submit_post_publish" id="submit_post_publish" class="button button-primary">{$aLang.topic_create_submit_publish}</button>
		<button type="submit" name="submit_preview" onclick="return ls.forum.preview('form-fast-reply','text_preview');" class="button">{$aLang.topic_create_submit_preview}</button>
		or
		<button type="button" name="submit_cancel" onclick="return ls.forum.cancelPost()" class="button button-red">cancel</button>
	</form>
</div>