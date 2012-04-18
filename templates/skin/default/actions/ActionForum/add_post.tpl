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

<div class="forum">
	<div class="forumNav">
		<h2>{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>
	</div>

	{include file="$sTemplatePathPlugin/switcher_top.tpl"}

	<div class="forumBlock">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_reply_for|ls_lang:'topic%%'} &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;</h2>
			</div>
			<div class="rightBg"></div>
		</div>

		<div class="fastAnswer clear_fix">
			<div class="topic" style="display:none">
				<div class="content" id="text_preview"></div>
			</div>
			<div class="fastAnswerForm">
				<form action="" method="POST" enctype="multipart/form-data">
					<fieldset>
						<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

						<p>
							<label for="post_title">{$aLang.forum_post_create_title}:</label><br />
							<input type="text" id="post_title" name="post_title" value="{$_aRequest.post_title}" class="input-text input-width-full" /><br />
							<span class="note">{$aLang.forum_post_create_title_notice}</span>
						</p>

						<p>
							<label for="post_text">{$aLang.forum_post_create_text}{if !$oConfig->GetValue('view.tinymce')} ({$aLang.forum_post_create_text_notice}){/if}:</label>
							<textarea name="post_text" id="post_text" rows="20" class="mce-editor">{$_aRequest.post_text}</textarea>
						</p>

						<p class="buttons">
							<input type="submit" name="submit_post_publish" value="{$aLang.topic_create_submit_publish}" class="right" />
							<input type="submit" name="submit_preview" value="{$aLang.topic_create_submit_preview}" onclick="jQuery('#text_preview').parent().show(); ls.tools.textPreview('post_text',false); return false" />&nbsp;
						</p>
					</fieldset>
				</form>
			</div>
		</div>
	</div>

</div>
{include file='footer.tpl'}