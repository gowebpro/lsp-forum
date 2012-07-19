{include file='header.tpl'}

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
			ls.lang.load({lang_load name="panel_b,panel_i,panel_u,panel_s,panel_url,panel_url_promt,panel_code,panel_video,panel_image,panel_cut,panel_quote,panel_list,panel_list_ul,panel_list_ol,panel_title,panel_clear_tags,panel_video_promt,panel_list_li,panel_image_promt,panel_user,panel_user_promt"});
			// Подключаем редактор
			$('#post_text').markItUp(ls.forum.getMarkitup());
		});
	</script>
{/if}

<h2 class="page-header">{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">
{if $bEditTopic}
	{$aLang.plugin.forum.topic_edit}: &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;
{else}
	{$aLang.plugin.forum.post_edit_for|ls_lang:'topic%%'} &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;
{/if}
</h4>

<form action="" method="POST" enctype="multipart/form-data" id="form-post-edit">
	{if $bEditTopic}
		{hook run='form_forum_edit_topic_begin'}
	{else}
		{hook run='form_forum_edit_post_begin'}
	{/if}

	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

	{if $bEditTopic}
	<p>
		<label for="topic_title">{$aLang.plugin.forum.new_topic_title}:</label>
		<input type="text" id="topic_title" name="topic_title" value="{$_aRequest.topic_title}" class="input-text input-width-full" /><br />
		<span class="note">{$aLang.plugin.forum.new_topic_title_notice}</span>
	</p>

	<p>
		<label for="topic_description">{$aLang.plugin.forum.new_topic_description}:</label>
		<input type="text" id="topic_description" name="topic_description" value="{$_aRequest.topic_description}" class="input-text input-width-full" /><br />
		<span class="note">{$aLang.plugin.forum.new_topic_description_notice}</span>
	</p>
	{else}
	<p>
		<label for="post_title">{$aLang.plugin.forum.post_create_title}:</label>
		<input type="text" id="post_title" name="post_title" value="{$_aRequest.post_title}" class="input-text input-width-full" /><br />
		<span class="note">{$aLang.plugin.forum.post_create_title_notice}</span>
	</p>
	{/if}

	<label for="post_text">{$aLang.plugin.forum.post_create_text}{if !$oConfig->GetValue('view.tinymce')} ({$aLang.plugin.forum.post_create_text_notice}){/if}:</label>
	<textarea name="post_text" id="post_text" rows="20" class="mce-editor">{$_aRequest.post_text}</textarea>

	{if !$oConfig->GetValue('view.tinymce')}
		{include file='tags_help.tpl' sTagsTargetId="post_text"}
		<br />
		<br />
	{/if}

	{if $oUserCurrent && $bEditTopic && ($oUserCurrent->isAdministrator())}
	<p>
		<label><input type="checkbox" id="topic_pinned" name="topic_pinned" class="input-checkbox" value="1"{if $_aRequest.topic_pinned==1} checked{/if} /> {$aLang.plugin.forum.new_topic_pin}</label>
		<label><input type="checkbox" id="topic_close" name="topic_close" class="input-checkbox" value="1"{if $_aRequest.topic_close==1} checked{/if} /> {$aLang.plugin.forum.new_topic_close}</label>
	</p>
	{/if}

	<p>
		<label for="post_edit_reason">{$aLang.plugin.forum.post_edit_reason}:</label>
		<input type="text" id="post_edit_reason" name="post_edit_reason" value="{$_aRequest.post_edit_reason}" class="input-text input-width-full" /><br />
		<span class="note">{$aLang.plugin.forum.post_edit_reason_notice}</span>
	</p>

	{if $bEditTopic}
		{hook run='form_forum_edit_topic_end'}
		<input type="hidden" name="action_type" value="edit_topic" />
	{else}
		{hook run='form_forum_edit_post_end'}
		<input type="hidden" name="action_type" value="edit_post" />
	{/if}

	<button type="submit" name="submit_preview" onclick="return ls.forum.preview('form-post-edit','text_preview');" class="button">{$aLang.topic_create_submit_preview}</button>
	<button type="submit" name="submit_edit_post" id="submit_edit_post" class="button button-orange">{$aLang.topic_create_submit_publish}</button>
</form>

<div class="topic-preview" style="display: none;" id="text_preview"></div>

{include file='footer.tpl'}