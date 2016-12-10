{assign var="oUser" value=$oPost->getUser()}
{assign var="aFiles" value=$oPost->getFiles()}

<article class="forum-post{if $bFirst} forum-post-first{/if}{if strtotime($oPost->getDateAdd()) > strtotime($oTopic->getReadDate())} new{/if} {if $aFiles} post-attach{/if} js-post" id="post-{$oPost->getId()}">
	<div class="forum-post-wrap">
		<div class="forum-post-content">
			<div class="forum-post-body">
				{hook run='forum_post_content_begin' post=$oPost}
				<div class="text">
					{if $oPost->getTitle()}
						<h2>{$oPost->getTitle()|escape:'html'}</h2>
					{/if}
					{$oPost->getText()}
				</div>
				{if $oPost->getEditorId()}
					{assign var="oEditor" value=$oPost->getEditor()}
					<div class="edit">
						{$aLang.plugin.forum.post_editing}
						<a href="{$oEditor->getUserWebPath()}">{$oEditor->getLogin()|escape:'html'}</a>
						{if $oPost->getDateEdit()}
							<span class="divide">-</span>
							{date_format date=$oPost->getDateEdit()}
						{/if}
						{if $oPost->getEditReason()}
							<span class="reason">{$oPost->getEditReason()|escape:'html'}</span>
						{/if}
					</div>
				{/if}
				{if count($aFiles) > 0}
					<div class="attach">
					{foreach from=$aFiles item=oFile name=post_files}
						<a class="attach-item js-attach-file-download js-tip-help" href="#" data-file-id="{$oFile->getId()}" title='{$aLang.plugin.forum.attach_file_hint|ls_lang:"TEXT%%`$oFile->getText()`":"SIZE%%`$oFile->getSizeFormat()`":"COUNT%%`$oFile->getDownload()`"}'>
							{* <i class="icon-file"></i> *}
							{$oFile->getName()|escape:'html'}
						</a>
						{if !$smarty.foreach.post_files.last}, {/if}
					{/foreach}
					</div>
				{/if}
				{hook run='forum_post_content_end' post=$oPost}
			</div>
			<header class="forum-post-header">
				{hook run='forum_post_header_begin' post=$oPost}
				<section class="forum-post-extra-right">
					<ul class="forum-post-extra-info">
						{if $oUserCurrent && ($oUserCurrent->isAdministrator() || ($oForum && $oForum->getModViewIP())) && $oPost->getUserIp()}
							<li>IP: {$oPost->getUserIp()}</li>
						{/if}
						<li>{$aLang.plugin.forum.post} <a href="{$oPost->getUrlFull()}" name="post-{$oPost->getId()}" onclick="return ls.forum.linkToPost({$oPost->getId()})">#{$oPost->getNumber()}</a></li>
						{hook run='forum_post_header_info_item' post=$oPost}
					</ul>
					<a class="forum-post-extra-trigger slide-trigger" onclick="ls.tools.slide($('#post-extra-target-{$oPost->getId()}'), $(this));">
						<i class="icon-topic-menu"></i>
					</a>
				</section>
				<section class="forum-post-extra-left">
					<div class="forum-post-info-author">
						{hook run='forum_post_userinfo_begin' post=$oPost user=$oUser}

						{if $oUser}
							<a href="{$oUser->getUserWebPath()}"><img alt="{$oUser->getLogin()|escape:'html'}" src="{$oUser->getProfileAvatarPath(48)}" /></a>
							<p><a rel="author" href="{$oUser->getUserWebPath()}">{$oUser->getLogin()|escape:'html'}</a></p>
						{else}
							<img alt="{$oPost->getGuestName()}" src="{cfg name='path.static.skin'}/images/avatar_male_48x48.png" />
							<p>{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()|escape:'html'}</p>
						{/if}
						<time datetime="{date_format date=$oPost->getDateAdd() format='c'}" title="{date_format date=$oPost->getDateAdd() format='j F Y, H:i'}">
							{date_format date=$oPost->getDateAdd() day="day H:i" format="j F Y, H:i"}
						</time>

						{hook run='forum_post_userinfo_end' post=$oPost user=$oUser}
					</div>
				</section>
				{hook run='forum_post_header_end' post=$oPost}
			</header>
		</div>
	</div>
	{if $oUserCurrent && !$noFooter}
	<footer class="forum-post-footer clearfix">
		<ul class="slide slide-post-info-extra" id="post-extra-target-{$oPost->getId()}">
			{if $oUserCurrent && $oUser}
				<li>
					<a href="{router page='talk'}add/?talk_users={$oUser->getLogin()|escape:'html'}">{$aLang.send_message_to_author}</a>
				</li>
			{/if}
			{if (!$oTopic->getState() || $oUserCurrent->isAdministrator()) && $oForum->getAllowReply() && $oForum->getQuickReply()}
				<li>
					<a href="#" class="js-post-quote" data-name="{if $oUser}{$oUser->getLogin()|escape:'html'}{/if}" data-post-id="{$oPost->getId()}">{$aLang.plugin.forum.button_quote}</a>
				</li>
				<li>
					<a href="{$oTopic->getUrlFull()}reply" class="js-post-reply" data-name="{if $oUser}{$oUser->getLogin()|escape:'html'}{/if}" data-post-id="{$oPost->getId()}">{$aLang.plugin.forum.button_reply}</a>
				</li>
            {/if}
			{if $LS->ACL_IsAllowEditForumPost($oPost,$oUserCurrent)}
				<li>
					<a href="{router page='forum'}topic/edit/{$oPost->getId()}" class="js-post-edit" data-post-id="{$oPost->getId()}">{$aLang.plugin.forum.button_edit}</a>
				</li>
			{/if}
			{if $LS->ACL_IsAllowDeleteForumPost($oPost,$oUserCurrent)}
				<li>
					<a href="{router page='forum'}topic/delete/{$oPost->getId()}" class="js-post-delete" data-post-id="{$oPost->getId()}">{$aLang.plugin.forum.button_delete}</a>
				</li>
			{/if}
		</ul>
	</footer>
	{/if}
</article>