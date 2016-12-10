{$oUser = $oPost->getUser()}
{$aFiles = $oPost->getFiles()}
{$oVote = $oPost->getVote()}
{$oUserForum = $oPost->getUserForum()}

{if $oVote || ($oUserCurrent && $oPost->getUserId() == $oUserCurrent->getId()) || strtotime($oPost->getDateAdd()) < $smarty.now-$oConfig->GetValue('plugin.forum.acl.vote.post.time')}
	{$bVoteInfoShow = true}
{/if}

<article class="forum-post{if $bFirst} forum-post-first{/if}{if strtotime($oPost->getDateAdd()) > strtotime($oTopic->getReadDate())} new{/if} js-post" id="post-{$oPost->getId()}">
	<div class="forum-post-wrap {if !$noPostSide}clearfix{/if}">
		{if !$noPostSide}
		<aside class="forum-post-side">
			{hook run='forum_post_userinfo_begin' post=$oPost user=$oUser}
			{if $oUser}
				<section class="avatar">
					<div class="status {if $oUser->isOnline()}status-online{else}status-offline{/if}">{if $oUser->isOnline()}{$aLang.user_status_online}{else}{$aLang.user_status_offline}{/if}</div>
					<a href="{$oUser->getUserWebPath()}"><img alt="{$oUser->getLogin()|escape:'html'}" src="{$oUser->getProfileAvatarPath(100)}" /></a>
				</section>
				<section class="login">
					<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()|escape:'html'}</a>
				</section>
				<section class="info">
					{if $oUser->getProfileName()}
						<p class="info-item"><span>{$aLang.settings_profile_name}:</span> {$oUser->getProfileName()|escape:'html'}</p>
					{/if}
					<p class="info-item"><span>{$aLang.user_rating}:</span> {if $oUser->getRating()>0}+{/if}{$oUser->getRating()}</p>
					{if $oUser->getProfileBirthday()}
						<p class="info-item"><span>{$aLang.profile_birthday}</span>: {date_format date=$oUser->getProfileBirthday() format="j.n.Y"}</p>
					{/if}
					<p class="info-item"><span>{$aLang.profile_date_registration}:</span> {date_format date=$oUser->getDateRegister() format="j.n.Y"}</p>
					{if $oUserForum}
						<p class="info-item"><span>{$aLang.plugin.forum.user_info_posts}:</span> {$oUserForum->getPostCount()}</p>
					{else}
						<p class="info-item"><span>{$aLang.plugin.forum.user_info_posts}:</span> 0</p>
					{/if}
				</section>
			{else}
				<section class="avatar"><img alt="{$oPost->getGuestName()|escape:'html'}" src="{cfg name='path.static.skin'}/images/avatar_male_100x100.png" /></section>
				<section class="login">{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()|escape:'html'}</a></section>
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
					{date_format date=$oPost->getDateAdd() day="day H:i" format="j F Y, H:i"}
					{if $oPost->getTitle()}
						<span class="divide">|</span>
						<strong>{$oPost->getTitle()|escape:'html'}</strong>
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
				<div class="js-post-text-source" style="display: none;">
					{$oPost->getTextSource()}
				</div>
				{if $oPost->getEditorId()}
					{$oEditor = $oPost->getEditor()}
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
				{if !$noAttach}
					{if count($aFiles) > 0}
						<div class="attach">
						{foreach from=$aFiles item=oFile name=post_files}
							<a class="attach-item js-attach-file-download js-tip-help" href="#" data-file-id="{$oFile->getId()}" title='{$aLang.plugin.forum.attach_file_hint|ls_lang:"TEXT%%`$oFile->getText()`":"SIZE%%`$oFile->getSizeFormat()`":"COUNT%%`$oFile->getDownload()`"}'>
								<i class="icon-file"></i>
								{$oFile->getName()|escape:'html'}
							</a>{if !$smarty.foreach.post_files.last}, {/if}
						{/foreach}
						</div>
					{/if}
				{/if}
				{hook run='forum_post_content_end' post=$oPost}
			</div>
			{if !$noVote}
			<div class="forum-post-vote cleafix">
				<div id="vote_area_forum_post_{$oPost->getId()}"
					data-type="tooltip-toggle"
					data-param-i-post-id="{$oPost->getId()}"
					data-option-url="{router page='forum'}ajax/vote/info/"
					data-vote-type="forum_post"
					data-vote-id="{$oPost->getId()}"
					class="vote-topic
						{if $oVote || ($oUserCurrent && $oPost->getUserId() == $oUserCurrent->getId())}
							{if $oPost->getRating() > 0}
								vote-count-positive
							{elseif $oPost->getRating() < 0}
								vote-count-negative
							{elseif $oPost->getRating() == 0}
								vote-count-zero
							{/if}
						{/if}

						{if !$oUserCurrent or ($oUserCurrent && $oPost->getUserId() != $oUserCurrent->getId())}
							vote-not-self
						{/if}

						{if $oVote} 
							voted
							{if $oVote->getDirection() > 0}
								voted-up
							{elseif $oVote->getDirection() < 0}
								voted-down
							{elseif $oVote->getDirection() == 0}
								voted-zero
							{/if}
						{else}
							not-voted
						{/if}

						{if (strtotime($oPost->getDateAdd()) < $smarty.now-$oConfig->GetValue('plugin.forum.acl.vote.post.time') && !$oVote) || ($oUserCurrent && $oPost->getUserId() == $oUserCurrent->getId())}
							vote-nobuttons
						{/if}
						{if strtotime($oPost->getDateAdd()) > $smarty.now-$oConfig->GetValue('plugin.forum.acl.vote.post.time')}
							vote-not-expired
						{/if}

						{if $bVoteInfoShow}js-infobox-vote-forum_post{/if}">
					<div class="vote-item vote-down" onclick="return ls.vote.vote({$oPost->getId()},this,-1,'forum_post');"><span><i></i></span></div>
					<div class="vote-item vote-count" title="{$aLang.topic_vote_count}: {$oPost->getCountVote()}">
						<span id="vote_total_forum_post_{$oPost->getId()}">
							{if $bVoteInfoShow}
								{if $oPost->getRating() > 0}+{/if}{$oPost->getRating()}
							{else}
								<i onclick="return ls.vote.vote({$oPost->getId()},this,0,'forum_post');"></i>
							{/if}
						</span>
					</div>
					<div class="vote-item vote-up" onclick="return ls.vote.vote({$oPost->getId()},this,1,'forum_post');"><span><i></i></span></div>
					{if $bVoteInfoShow}
						<div id="vote-info-forum_post-{$oPost->getId()}" style="display: none;">
							<ul class="vote-topic-info">
								<li><i class="icon-synio-vote-info-up"></i> {$oPost->getCountVoteUp()}</li>
								<li><i class="icon-synio-vote-info-down"></i> {$oPost->getCountVoteDown()}</li>
								<li><i class="icon-synio-vote-info-zero"></i> {$oPost->getCountVoteAbstain()}</li>
								<li><i class="icon-asterisk icon-white"></i> {$oPost->getCountVote()}</li>
								{hook run='forum_post_show_vote_stats' post=$oPost}
							</ul>
						</div>
					{/if}
				</div>
			</div>
			{/if}
		</div>
	</div>
	{if $oUserCurrent && !$noFooter}
	<footer class="forum-post-footer clearfix">
		<section class="fl-r">
            {if (!$oTopic->getState() || $oUserCurrent->isAdministrator()) && $oForum->getAllowReply() && $oForum->getQuickReply()}
				<a href="#" class="button js-post-quote" data-name="{if $oUser}{$oUser->getLogin()|escape:'html'}{/if}" data-post-id="{$oPost->getId()}">
					<i class="icon-leaf"></i> {$aLang.plugin.forum.button_quote}
				</a>
				<a href="{$oTopic->getUrlFull()}reply" class="button js-post-reply" data-name="{if $oUser}{$oUser->getLogin()|escape:'html'}{/if}" data-post-id="{$oPost->getId()}">
					<i class="icon-comment"></i> {$aLang.plugin.forum.button_reply}
				</a>
			{/if}
			{if $LS->ACL_IsAllowEditForumPost($oPost,$oUserCurrent)}
				<a href="{router page='forum'}topic/edit/{$oPost->getId()}" class="button button-orange js-post-edit" data-post-id="{$oPost->getId()}">
					<i class="icon-white icon-edit"></i> {$aLang.plugin.forum.button_edit}
				</a>
			{/if}
			{if $LS->ACL_IsAllowDeleteForumPost($oPost,$oUserCurrent)}
				<a href="{router page='forum'}topic/delete/{$oPost->getId()}" class="button button-red js-post-delete" data-post-id="{$oPost->getId()}">
					<i class="icon-white icon-remove"></i> {$aLang.plugin.forum.button_delete}
				</a>
			{/if}
		</section>
	</footer>
	{/if}
</article>