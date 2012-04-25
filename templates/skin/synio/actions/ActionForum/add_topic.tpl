{include file='header.tpl' noSidebar=true}

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
			$('#post_text').markItUp(ls.forum.getMarkitupSettings());
		});
	</script>
{/if}

<h2 class="page-header">{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">{$aLang.forum_new_topic_for}: &laquo;<a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a>&raquo;</h4>

<div class="topic-preview" style="display: none;" id="text_preview"></div>

<form action="" method="POST" enctype="multipart/form-data" id="form-topic-add">
	{hook run='form_forum_add_topic_begin'}

	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

	<p>
		<label for="topic_title">{$aLang.forum_new_topic_title}:</label>
		<input type="text" id="topic_title" name="topic_title" value="{$_aRequest.topic_title}" class="input-text input-width-full" /><br />
		<span class="note">{$aLang.forum_new_topic_title_notice}</span>
	</p>

	<p>
		<label for="topic_description">{$aLang.forum_new_topic_description}:</label>
		<input type="text" id="topic_description" name="topic_description" value="{$_aRequest.topic_description}" class="input-text input-width-full" /><br />
		<span class="note">{$aLang.forum_new_topic_description_notice}</span>
	</p>

	<p>
		<label for="post_text">{$aLang.forum_post_create_text}{if !$oConfig->GetValue('view.tinymce')} ({$aLang.forum_post_create_text_notice}){/if}:</label>
		<textarea name="post_text" id="post_text" rows="20" class="mce-editor">{$_aRequest.post_text}</textarea>
	</p>

	{if $oUserCurrent && $oUserCurrent->isAdministrator()}
	<p>
		<label><input type="checkbox" id="topic_pinned" name="topic_pinned" class="input-checkbox" value="1" {if $_aRequest.topic_pinned==1}checked{/if} />{$aLang.forum_new_topic_pin}</label>
		<label><input type="checkbox" id="topic_close" name="topic_close" class="input-checkbox" value="1" {if $_aRequest.topic_close==1}checked{/if} />{$aLang.forum_new_topic_close}</label>
	</p>
	{/if}

	{hook run='form_forum_add_topic_end'}

	<button name="submit_topic_publish" id="submit_topic_publish" class="button button-primary fl-r">{$aLang.topic_create_submit_publish}</button>
	<button name="submit_preview" onclick="return ls.forum.preview('post_text');" class="button">{$aLang.topic_create_submit_preview}</button>
</form>

{include file='footer.tpl'}