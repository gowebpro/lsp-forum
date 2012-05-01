{assign var="oUser" value=$oPost->getUser()}
<article class="forum-post" id="post-{$oPost->getId()}">
	<div class="clear_fix">
		<aside class="forum-post-side">
			{hook run='forum_post_userinfo_begin' post=$oPost user=$oUser}
			<div class="avatar"><img alt="{$oUser->getLogin()}" src="{$oUser->getProfileAvatarPath(100)}" /></div>
			<div class="nickname"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></div>
			{hook run='forum_post_userinfo_end' post=$oPost user=$oUser}
		</aside>
		<div class="forum-post-content">
			<header class="forum-post-header">
				{hook run='forum_post_header_begin' post=$oPost}
				<div class="forum-post-details fl-r">
					{if $oUserCurrent && $oUserCurrent->isAdministrator() && $oPost->getUserIp()}
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
				{hook run='forum_post_content_end' post=$oPost}
			</div>
		</div>
	</div>
	<footer class="forum-post-footer">
	</footer>
</article>