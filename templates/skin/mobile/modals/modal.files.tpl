<div id="modal-attach-files" class="slide slide-bg-grey slide-files mb-20">
	<header class="modal-header">
		<h3>{$aLang.plugin.forum.attach_my_files}</h3>
		<small class="note">{$aLang.plugin.forum.attach_my_files_notice}</small>
	</header>

	<div class="modal-content">
		{if count($aFilesMy) > 0}
		<div class="modal-scroll">
			<ul class="attach-files">
			{foreach from=$aFilesMy item=oFile}
				{assign var=aPosts value=$oFile->getPosts()}
				<li class="attach-files-item" data-id="{$oFile->getId()}">
					<div class="attach-files-item-main">
						<span class="file-name">{$oFile->getName()|escape:'html'}</span>
						<span class="file-text">{$oFile->getText()|escape:'html'}</span>
					</div>
					<div class="attach-files-item-note">
						<span class="file-hover">{$aLang.plugin.forum.attach_this}</span>
					</div>
					<div class="attach-files-item-detail">
						<span class="file-size">{$aLang.plugin.forum.attach_file_size}: <strong>{$oFile->getSizeFormat()}</strong></span>
						<span class="file-counter">{$aLang.plugin.forum.attach_file_download} <strong>{$oFile->getDownload()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oFile->getDownload()|declension:$aLang.plugin.forum.attach_download_declension:'russian'|lower}</span>
						<span class="file-counter">{$aLang.plugin.forum.attach_file_posts} <strong>{$aPosts|@count|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$aPosts|@count|declension:$aLang.plugin.forum.attach_posts_declension:'russian'|lower}</span>
					</div>
				</li>
			{/foreach}
			</ul>
		</div>
		{/if}
	</div>

	<footer class="modal-footer">
		<button type="submit" class="button jqmClose">{$aLang.topic_photoset_upload_close}</button>
	</footer>
</div>
