{if $oUserCurrent}
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

{include file="$sTemplatePathForum/modals/modal.files.tpl"}

{/if}