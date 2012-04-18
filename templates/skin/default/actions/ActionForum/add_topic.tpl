{include file='header.tpl' noSidebar=true}

{if $oConfig->GetValue('view.tinymce')}
	<script type="text/javascript" src="{cfg name='path.root.engine_lib'}/external/tinymce-jq/tiny_mce.js"></script>

	<script type="text/javascript">
	{literal}
	tinyMCE.init({
		mode:"textareas",
		theme:"advanced",
		theme_advanced_toolbar_location:"top",
		theme_advanced_toolbar_align:"left",
		theme_advanced_buttons1:"lshselect,bold,italic,underline,strikethrough,|,bullist,numlist,|,undo,redo,|,lslink,unlink,lsvideo,lsimage,code",
		theme_advanced_buttons2:"",
		theme_advanced_buttons3:"",
		theme_advanced_statusbar_location:"bottom",
		theme_advanced_resizing:true,
		theme_advanced_resize_horizontal:0,
		theme_advanced_resizing_use_cookie:0,
		theme_advanced_path:false,
		object_resizing:true,
		force_br_newlines:true,
		forced_root_block:'', // Needed for 3.x
		force_p_newlines:false,    
		plugins:"lseditor,safari,inlinepopups,media",
		convert_urls:false,
		extended_valid_elements:"embed[src|type|allowscriptaccess|allowfullscreen|width|height]",
		media_strict:false,
		language:TINYMCE_LANG,
		inline_styles:false,
		formats:{
			underline:{inline:'u',exact:true},
			strikethrough:{inline:'s',exact:true}
		}
	});
	{/literal}
	</script>
{else}
	{include file='window_load_img.tpl' sToLoad='topic_text'}
	<script type="text/javascript">
	jQuery(document).ready(function($){
		ls.lang.load({lang_load name="panel_b,panel_i,panel_u,panel_s,panel_url,panel_url_promt,panel_code,panel_video,panel_image,panel_quote,panel_list,panel_list_ul,panel_list_ol,panel_title,panel_clear_tags,panel_video_promt,panel_list_li,panel_image_promt,panel_user,panel_user_promt"});
		// Подключаем редактор
		$('#topic_text').markItUp(ls.forum.getMarkitupSettings());
	});
	</script>
{/if}

<div class="forum">
	<div class="forumNav">
		<h2>{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>
	</div>

	{include file="$sTemplatePathPlugin/switcher_top.tpl"}

	<div class="forum-block">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_new_topic_for} &laquo;<a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a>&raquo;</h2>
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
							<label for="topic_title">{$aLang.forum_new_topic_title}:</label><br />
							<input type="text" id="topic_title" name="topic_title" value="{$_aRequest.topic_title}" class="input-wide" /><br />
							<span class="note">{$aLang.forum_new_topic_title_notice}</span>
						</p>

						<p>
							<label for="topic_description">{$aLang.forum_new_topic_description}:</label><br />
							<input type="text" id="topic_description" name="topic_description" value="{$_aRequest.topic_description}" class="input-wide" /><br />
							<span class="note">{$aLang.forum_new_topic_description_notice}</span>
						</p>

						<textarea name="topic_text" id="topic_text" rows="20" class="input-wide">{$_aRequest.topic_text}</textarea><br />

						{if $oUserCurrent && $oUserCurrent->isAdministrator()}
						<p>
							<label><input type="checkbox" name="topic_pinned" id="topic_pinned" /> {$aLang.forum_new_topic_pin}</label><br />
							<label><input type="checkbox" name="topic_close" id="topic_close" /> {$aLang.forum_new_topic_close}</label>
						</p>
						{/if}

						<p class="buttons">
							<input type="submit" name="submit_topic_publish" value="{$aLang.topic_create_submit_publish}" class="right" />
							<input type="submit" name="submit_preview" value="{$aLang.topic_create_submit_preview}" onclick="jQuery('#text_preview').parent().show(); ls.tools.textPreview('topic_text',false); return false" />&nbsp;
						</p>
					</fieldset>
				</form>
			</div>
		</div>
	</div>

</div>
{include file='footer.tpl'}