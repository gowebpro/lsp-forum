{if $oForum}
	{include file='header.tpl' noSidebar=true}
	<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>
	<h4 class="page-subheader">{$aLang.plugin.forum.new_topic_for}: &laquo;<a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a>&raquo;</h4>
{else}
	{include file='header.tpl' noSidebar=true menu_content='create'}
{/if}

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

<div class="fBox">
	<form action="" method="POST" enctype="multipart/form-data" id="form-topic-add">
		<div class="forums-content fLayout-withright">
			<div class="fContainer fLayout-content-side fl-r">
				{if $oUserCurrent && $oUserCurrent->isAdministrator()}
				<ul class="fLayout-pad">
					<li>
						<label><input type="checkbox" id="topic_pinned" name="topic_pinned" class="input-checkbox" value="1"{if $_aRequest.topic_pinned==1} checked{/if} /> {$aLang.plugin.forum.new_topic_pin}</label>
					</li>
					<li>
						<label><input type="checkbox" id="topic_close" name="topic_close" class="input-checkbox" value="1"{if $_aRequest.topic_close==1} checked{/if} /> {$aLang.plugin.forum.new_topic_close}</label>
					</li>
				</ul>
				{/if}
			</div>
			<div class="fContainer fLayout-content">
				<div class="fLayout-pad">
					{hook run='form_forum_add_topic_begin'}

					{if !$oForum}
					<p>
						<label for="forum_id">{$aLang.plugin.forum.new_topic_forum}</label>
						<select name="forum_id" id="forum_id" class="input-width-full">
							{assign var=bOpenOG value=false}
							{foreach from=$aForumsTree key=sId item=aItem}
								{assign var=oForum value=$aItem.entity}
								{if $aItem.level == 0}
									{if $bOpenOG}
										</optgroup>
										{assign var=bOpenOG value=false}
									{/if}
									<optgroup label="{$oForum->getTitle()|escape:'html'}">
									{assign var=bOpenOG value=true}
								{else}
									<option value="{$sId}" style="margin-left: {$aItem.level*20}px"{if $_aRequest.forum_id==$sId} selected{/if}>{$oForum->getTitle()|escape:'html'}</option>
								{/if}
							{/foreach}
						</select>
						<small class="note">{$aLang.plugin.forum.new_topic_forum_notice}</small>
					</p>
					{/if}

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

					<textarea name="post_text" id="post_text" rows="20" class="mce-editor">{$_aRequest.post_text}</textarea>

					{if !$oConfig->GetValue('view.tinymce')}
						{include file='tags_help.tpl' sTagsTargetId="post_text"}
						<br />
						<br />
					{/if}

					{include file="$sTemplatePathForum/guest_block.tpl" event="topic"}

					{hook run='form_forum_add_topic_end'}
				</div>
			</div>
		</div>
		<div class="fSubmit">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
			<input type="hidden" name="action_type" value="add_topic" />

			<button type="submit" name="submit_preview" onclick="return ls.forum.preview('form-topic-add','text_preview');" class="button">{$aLang.topic_create_submit_preview}</button>
			<button type="submit" name="submit_topic_publish" id="submit_topic_publish" class="button button-primary">{$aLang.topic_create_submit_publish}</button>
		</div>
	</form>
</div>
<div class="topic-preview" style="display: none;" id="text_preview"></div>

{include file='footer.tpl'}