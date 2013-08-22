<div id="modal-attach-files" class="slide slide-files">
	<header class="modal-header">
		<h3>{$aLang.plugin.forum.attach_my_files}</h3>
		<span class="note">{$aLang.plugin.forum.attach_my_files_notice}</span>
		<a href="#" class="close jqmClose"></a>
	</header>

	<div class="modal-content">
		{if count($aFilesMy) > 0}
		<div class="modal-scroll">
			<ul class="attach-files">
			{foreach from=$aFilesMy item=oFile}
				{assign var=aPosts value=$oFile->getPosts()}
				<li class="attach-files-item" data-id="{$oFile->getId()}">
					<div class="attach-files-item-main">
						<span class="file-name">{$oFile->getName()}</span>
						<span class="file-text">{$oFile->getText()}</span>
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
</div>
