{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header"><a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span> {$aLang.plugin.forum.acp_files}</h2>

{include file="$sTemplatePathForum/menu.forum.admin.tpl"}

<div class="forums">
	<header class="forums-header">
		<h3>{$aLang.plugin.forum.acp_files_control}</h3>
	</header>

	<div class="forums-content">
		<div class="forum-acp-notice">
			{$aLang.plugin.forum.acp_files_control_notice}
		</div>

		{if $aFiles}
		<div class="files-wrapper">
			<ul class="files-list">
			{foreach from=$aFiles item=oFile}
				{assign var=aPosts value=$oFile->getPosts()}
				{assign var=oUser value=$oFile->getUser()}
				<li class="files-list-item" id="file-{$oFile->getId()}">
					<section class="files-item-wrapper">
						<div class="files-item-user">
						{if $oUser}
							<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
						{/if}
						</div>
						<div class="files-item-main">
							<span class="file-name">{$oFile->getName()}</span>
							<span class="file-text">{$oFile->getText()}</span>
						</div>
						<div class="files-item-detail">
							<span class="file-size">{$aLang.plugin.forum.attach_file_size}: <strong>{$oFile->getSizeFormat()}</strong></span>
							<span class="file-counter">{$aLang.plugin.forum.attach_file_download} <strong>{$oFile->getDownload()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$oFile->getDownload()|declension:$aLang.plugin.forum.attach_download_declension:'russian'|lower}</span>
							<span class="file-counter">{$aLang.plugin.forum.attach_file_posts} <strong>{$aPosts|@count|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</strong> {$aPosts|@count|declension:$aLang.plugin.forum.attach_posts_declension:'russian'|lower}</span>
						</div>
						<div class="files-item-action">
							delete
						</div>
					</li>
				{/foreach}
				</ul>
			</div>
		{else}
			<div class="empty">{$aLang.plugin.forum.acp_files_empty}</div>
		{/if}
	</div>
</div>

{include file='footer.tpl'}