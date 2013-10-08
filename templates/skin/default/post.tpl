{assign var="oUser" value=$oPost->getUser()}
{assign var="aFiles" value=$oPost->getFiles()}
{assign var="oVote" value=$oPost->getVote()}

{if $oVote || ($oUserCurrent && $oPost->getUserId() == $oUserCurrent->getId()) || strtotime($oPost->getDateAdd()) < $smarty.now-$oConfig->GetValue('plugin.forum.acl.vote.post.time')}
	{assign var="bVoteInfoShow" value=true}
{/if}

<article class="forum-post{if $bFirst} forum-post-first{/if}{if strtotime($oPost->getDateAdd()) > strtotime($oTopic->getReadDate())} new{/if} js-post" id="post-{$oPost->getId()}">
	<div class="forum-post-wrap {if !$noPostSide}clearfix{/if}">
		{if !$noPostSide}
		<aside class="forum-post-side">
			{hook run='forum_post_userinfo_begin' post=$oPost user=$oUser}
			{if $oUser}
				<section class="avatar">
					<div class="status {if $oUser->isOnline()}status-online{else}status-offline{/if}">{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}</div>
					<a href="{$oUser->getUserWebPath()}"><img alt="{$oUser->getLogin()}" src="{$oUser->getProfileAvatarPath(100)}" /></a>
				</section>
				<section class="login">
					<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
				</section>
				<section class="info">
					{if $oUser->getProfileName()}
						<p class="info-item"><span>{$aLang.settings_profile_name}:</span> {$oUser->getProfileName()|escape:'html'}</p>
					{/if}
					{if $oUser->getProfileBirthday()}
						<p class="info-item"><span>{$aLang.profile_birthday}</span>: {date_format date=$oUser->getProfileBirthday() format="j.n.Y"}</p>
					{/if}
					<p class="info-item"><span>{$aLang.profile_date_registration}:</span> {date_format date=$oUser->getDateRegister() format="j.n.Y"}</p>
				</section>
			{else}
				<section class="avatar"><img alt="{$oPost->getGuestName()}" src="{cfg name='path.static.skin'}/images/avatar_male_100x100.png" /></section>
				<section class="login">{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}</a></section>
			{/if}
			{hook run='forum_post_userinfo_end' post=$oPost user=$oUser}
		</aside>
		{/if}
		<div class="forum-post-content{if $noPostSide} no-side{/if}">
			<header class="forum-post-header">
				{hook run='forum_post_header_begin' post=$oPost}
				<div class="forum-post-details fl-r">
					{if $oUserCurrent && ($oUserCurrent->isAdministrator() || ($oForum && $oForum->getModViewIP())) && $oPost->getUserIp()}
						IP: {$oPost->getUserIp()}
						<span class="divide">|</span>
					{/if}
					{$aLang.plugin.forum.post} <a href="{$oPost->getUrlFull()}" name="post-{$oPost->getId()}" onclick="return ls.forum.linkToPost({$oPost->getId()})">#{$oPost->getNumber()}</a>
				</div>
				<div class="forum-post-details">
					{date_format date=$oPost->getDateAdd()}
					{if $oPost->getTitle()}
						<span class="divide">|</span>
						<strong>{$oPost->getTitle()}</strong>
					{/if}
					{hook run='forum_post_header_info_item' post=$oPost}
				</div>
				{hook run='forum_post_header_end' post=$oPost}
			</header>
			<div class="forum-post-body">
				{hook run='forum_post_content_begin' post=$oPost}
				<div class="text">
					{$oPost->getText()}
				</div>
				{if $oPost->getEditorId()}
					{assign var="oEditor" value=$oPost->getEditor()}
					<div class="edit">
						{$aLang.plugin.forum.post_editing}
						<a href="{$oEditor->getUserWebPath()}">{$oEditor->getLogin()}</a>
						{if $oPost->getDateEdit()}
							<span class="divide">-</span>
							{date_format date=$oPost->getDateEdit()}
						{/if}
						{if $oPost->getEditReason()}
							<span class="reason">{$oPost->getEditReason()}</span>
						{/if}
					</div>
				{/if}
				{if count($aFiles) > 0}
					<div class="attach">
					{foreach from=$aFiles item=oFile name=post_files}
						<a class="attach-item js-attach-file-download js-tip-help" href="#" data-file-id="{$oFile->getId()}" title='{$aLang.plugin.forum.attach_file_hint|ls_lang:"TEXT%%`$oFile->getText()`":"SIZE%%`$oFile->getSizeFormat()`":"COUNT%%`$oFile->getDownload()`"}'>
							<i class="icon-file"></i>
							{$oFile->getName()}
						</a>{if !$smarty.foreach.post_files.last}, {/if}
					{/foreach}
					</div>
				{/if}
				{hook run='forum_post_content_end' post=$oPost}
			</div>
			<div class="forum-post-vote clearfix">
				<div id="vote_area_forum_post_{$oPost->getId()}"
					data-type="tooltip-toggle"
					data-param-i-post-id="{$oPost->getId()}"
					data-option-url="{router page='forum'}ajax/vote/info/"
					data-vote-type="forum_post"
					data-vote-id="{$oPost->getId()}"
					class="vote
						{if $oVote || ($oUserCurrent && $oPost->getUserId() == $oUserCurrent->getId()) || strtotime($oPost->getDateAdd()) < $smarty.now-$oConfig->GetValue('plugin.travel.acl.vote.post.time')}
							{if $oPost->getRating() > 0}
								vote-count-positive
							{elseif $oPost->getRating() < 0}
								vote-count-negative
							{/if}
						{/if}

						{if $oVote}
							voted
							{if $oVote->getDirection() > 0}
								voted-up
							{elseif $oVote->getDirection() < 0}
								voted-down
							{/if}
						{/if}

						{if $bVoteInfoShow}js-infobox-vote-forum_post{/if}">
					<div class="vote-up" onclick="return ls.vote.vote({$oPost->getId()},this,1,'forum_post');"></div>
					<div class="vote-count" id="vote_total_forum_post_{$oPost->getId()}">
						{if $bVoteInfoShow}
							{if $oPost->getRating() > 0}+{/if}{$oPost->getRating()}
						{else}
							<a href="#" onclick="return ls.vote.vote({$oPost->getId()},this,0,'forum_post');">?</a>
						{/if}
					</div>
					<div class="vote-down" onclick="return ls.vote.vote({$oPost->getId()},this,-1,'forum_post');"></div>
					{if $bVoteInfoShow}
						<div id="vote-info-forum_post-{$oPost->getId()}" style="display: none;">
							<ul class="vote-topic-info">
								<li><i class="icon-plus icon-white"></i> {$oPost->getCountVoteUp()}</li>
								<li><i class="icon-minus icon-white"></i> {$oPost->getCountVoteDown()}</li>
								<li><i class="icon-eye-open icon-white"></i> {$oPost->getCountVoteAbstain()}</li>
								<li><i class="icon-asterisk icon-white"></i> {$oPost->getCountVote()}</li>
								{hook run='forum_post_show_vote_stats' post=$oPost}
							</ul>
						</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	{if $oUserCurrent && !$noFooter}
	<footer class="forum-post-footer clearfix">
		<section class="fl-r">
			<a href="#" class="button js-post-quote" data-name="{if $oUser}{$oUser->getLogin()}{/if}" data-post-id="{$oPost->getId()}">
				<span class="icon-white icon-leaf"></span> {$aLang.plugin.forum.button_quote}
			</a>
			<a href="{$oTopic->getUrlFull()}reply" class="button js-post-reply" data-name="{if $oUser}{$oUser->getLogin()}{/if}" data-post-id="{$oPost->getId()}">
				<span class="icon-white icon-comment"></span> {$aLang.plugin.forum.button_reply}
			</a>
			{if $LS->ACL_IsAllowEditForumPost($oPost,$oUserCurrent)}
				<a href="{router page='forum'}topic/edit/{$oPost->getId()}" class="button button-orange js-post-edit" data-post-id="{$oPost->getId()}">
					<span class="icon-white icon-edit"></span> {$aLang.plugin.forum.button_edit}
				</a>
			{/if}
			{if $LS->ACL_IsAllowDeleteForumPost($oPost,$oUserCurrent)}
				<a href="{router page='forum'}topic/delete/{$oPost->getId()}" class="button button-red js-post-delete" data-post-id="{$oPost->getId()}">
					<span class="icon-white icon-remove"></span> {$aLang.plugin.forum.button_delete}
				</a>
			{/if}
		</section>
	</footer>
	{/if}
</article>