{if $oUserCurrent}
<script type="text/javascript">
	jQuery(function($){
		if (jQuery.browser.flash) {
			ls.forum.attach.initSwfUpload({
				post_params: { 'post_id': {json var=$_aRequest.post_id} },
				button_placeholder_id: 'js-attach-upload-file-flash',
				file_types: "{$oConfig->get('plugin.forum.attach.format_swf')}"
			});
		}
	});
</script>

<div class="forum-attach-upload">
	<header>
		<h2>{$aLang.plugin.forum.attach_upload_title}</h2>

		<p>
			<a class="link-dotted" id="js-attach-my-files" href="#">{$aLang.plugin.forum.attach_my_files}</a>
		</p>

		<div class="forum-attach-upload-rules">
			{$aLang.plugin.forum.attach_upload_rules|ls_lang:"SIZE%%`$oConfig->get('plugin.forum.attach.max_size')`":"COUNT%%`$oConfig->get('plugin.forum.attach.count_max')`":"FORMAT%%`$oConfig->get('plugin.forum.attach.format')`"}
		</div>
	</header>

	<ul id="swfu_files" class="forum-attach-files">
		{if count($aFiles)}
			{foreach from=$aFiles item=oFile}
				<li id="file_{$oFile->getId()}" class="forum-attach-files-item">
					<div class="forum-attach-files-item-header">
						<span class="forum-attach-files-item-title">{$oFile->getName()|escape:'html'}</span>
						<span class="forum-attach-files-item-size">{$oFile->getSizeFormat()}</span>
					</div>
					<textarea onblur="ls.forum.attach.setFileDescription({$oFile->getId()}, this.value)">{$oFile->getText()|escape:'html'}</textarea><br />
					<a href="javascript:ls.forum.attach.deleteFile({$oFile->getId()})" class="file-delete">{$aLang.plugin.forum.attach_file_delete}</a>
				</li>
			{/foreach}
		{/if}
	</ul>

	<a href="#" id="forum-attach-upload" class="link-dotted">{$aLang.plugin.forum.attach_upload_file_choose}</a>
</div>

<div id="forum-attach-wrapper"></div>

<form id="forum-attach-upload-form" method="POST" enctype="multipart/form-data" onsubmit="return false;">
	<div id="forum-attach-upload-input" class="forum-attach-upload-input slide slide-bg-grey mb-20">
		<label for="forum-attach-upload-file">{$aLang.plugin.forum.attach_upload_file_choose}:</label>
		<input type="file" id="forum-attach-upload-file" name="Filedata" /><br><br>

		<button type="submit" class="button button-primary" onclick="ls.forum.attach.upload();">{$aLang.plugin.forum.attach_upload_file_choose}</button>
		<button type="submit" class="button" onclick="ls.forum.attach.closeForm();return false;">{$aLang.topic_photoset_upload_close}</button>

		<input type="hidden" name="is_iframe" value="true" />
		<input type="hidden" name="post_id" value="{$_aRequest.post_id}" />
	</div>
</form>

{include file="$sTemplatePathForum/modals/modal.files.tpl"}

{/if}