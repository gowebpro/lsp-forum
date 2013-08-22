{include file='header.tpl' noSidebar=true}

{include file='editor.tpl' sImgToLoad='post_text' sSettingsTinymce='ls.settings.getTinymce()' sSettingsMarkitup='ls.forum.getMarkitup()'}
{include file="$sTemplatePathForum/modals/modal.editor_spoiler.tpl" sToLoad='post_text'}
{include file="$sTemplatePathForum/modals/modal.confirm_box.tpl"}
{include file="$sTemplatePathForum/modals/modal.files.tpl"}

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">
{if $bEditTopic}
	{$aLang.plugin.forum.topic_edit}: &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;
{else}
	{$aLang.plugin.forum.post_edit_for|ls_lang:'topic%%'} &laquo;<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>&raquo;
{/if}
</h4>

<div class="fBox">
	<form action="" method="POST" enctype="multipart/form-data" id="form-post-edit">
		<div class="forums-content fLayout-withright">
			<div class="fContainer fLayout-content-side fl-r">
				{if $oUserCurrent && $bEditTopic && ($oUserCurrent->isAdministrator())}
				<p>
					<label><input type="checkbox" id="topic_pinned" name="topic_pinned" class="input-checkbox" value="1"{if $_aRequest.topic_pinned==1} checked{/if} /> {$aLang.plugin.forum.new_topic_pin}</label>
					<label><input type="checkbox" id="topic_close" name="topic_close" class="input-checkbox" value="1"{if $_aRequest.topic_close==1} checked{/if} /> {$aLang.plugin.forum.new_topic_close}</label>
				</p>
				{/if}
			</div>
			<div class="fContainer fLayout-content">
				<div class="fLayout-pad">
					{if $bEditTopic}
						{hook run='form_forum_edit_topic_begin'}
					{else}
						{hook run='form_forum_edit_post_begin'}
					{/if}

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

					<textarea name="post_text" id="post_text" rows="20" class="mce-editor markitup-editor input-width-full">{$_aRequest.post_text}</textarea>

					{if !$oConfig->GetValue('view.tinymce')}
						{include file='tags_help.tpl' sTagsTargetId="post_text"}
						<br />
						<br />
					{/if}

					{* Прикрепление файлов *}
					{include file="$sTemplatePathForum/forms/form.attach.tpl"}

					<p>
						<label for="post_edit_reason">{$aLang.plugin.forum.post_edit_reason}:</label>
						<input type="text" id="post_edit_reason" name="post_edit_reason" value="{$_aRequest.post_edit_reason}" class="input-text input-width-full" /><br />
						<span class="note">{$aLang.plugin.forum.post_edit_reason_notice}</span>
					</p>

					{if $bEditTopic}
						{hook run='form_forum_edit_topic_end'}
					{else}
						{hook run='form_forum_edit_post_end'}
					{/if}
				</div>
			</div>
		</div>
		<div class="fSubmit">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
			{if $bEditTopic}
				<input type="hidden" name="action_type" value="edit_topic" />
			{else}
				<input type="hidden" name="action_type" value="edit_post" />
			{/if}

			<button type="submit" name="submit_preview" onclick="return ls.forum.preview('form-post-edit','text_preview');" class="button">{$aLang.plugin.forum.button_preview}</button>
			<button type="submit" name="submit_edit_post" id="submit_edit_post" class="button button-orange">{$aLang.plugin.forum.button_publish}</button>
		</div>
	</div>
</form>

<div class="topic-preview" style="display: none;" id="text_preview"></div>

{include file='footer.tpl'}