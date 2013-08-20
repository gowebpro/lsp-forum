<script type="text/javascript">
	jQuery(function($){
		if (jQuery.browser.flash) {
			ls.forum.attach.initSwfUpload({
				post_params: { 'post_id': {json var=$_aRequest.post_id} },
				button_placeholder_id: 'js-attach-file-upload-flash',
				file_types: "{$oConfig->get('plugin.forum.attach.format_swf')}"
			});
		}
	});
</script>

<div class="forum-attach-upload">
	<h2>{$aLang.plugin.forum.attach_upload_title}</h2>

	<div class="forum-attach-upload-rules">
		{$aLang.plugin.forum.attach_upload_rules|ls_lang:"SIZE%%`$oConfig->get('plugin.forum.attach.max_size')`":"COUNT%%`$oConfig->get('plugin.forum.attach.count_max')`":"FORMAT%%`$oConfig->get('plugin.forum.attach.format')`"}
	</div>

	<ul id="swfu_files" class="forum-attach-files">
		{if count($aFiles)}
			{foreach from=$aFiles item=oFile}
				<li id="file_{$oFile->getId()}" class="forum-attach-files-item">
					<div class="forum-attach-files-item-header">
						<span class="forum-attach-files-item-title">{$oFile->getName()}</span>
						<span class="forum-attach-files-item-size">{$oFile->getSizeFormat()}</span>
					</div>
					<textarea onblur="ls.forum.attach.setFileDescription({$oFile->getId()}, this.value)">{$oFile->getText()}</textarea><br />
					<a href="javascript:ls.forum.attach.deleteFile({$oFile->getId()})" class="file-delete">{$aLang.plugin.forum.attach_file_delete}</a>
				</li>
			{/foreach}
		{/if}
	</ul>

	<a href="javascript:ls.forum.attach.showForm()" id="js-attach-file-upload-flash">{$aLang.plugin.forum.attach_upload_file_choose}</a>
</div>