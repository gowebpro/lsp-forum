{assign var="oUser" value=$oPost->getUser()}
<article class="forum-post" id="post-{$oPost->getId()}">
	<div class="clear_fix">
		<aside class="forum-post-side">
			<div class="avatar"><img alt="{$oUser->getLogin()}" src="{$oUser->getProfileAvatarPath(100)}" /></div>
			<div class="nickname"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></div>
		</aside>
		<div class="forum-post-content">
			<header class="forum-post-header">
				<div class="forum-post-info fl-r">
					{if $oUserCurrent && $oUserCurrent->isAdministrator() && $oPost->getUserIp()}
						IP: {$oPost->getUserIp()} |
					{/if}
					{$aLang.forum_post} <a href="{$oPost->getUrlFull()}" name="post-{$oPost->getId()}" onclick="return ls.forum.linkToPost({$oPost->getId()})">#{$oPost->getNumber()}</a>
				</div>
				<div class="forum-post-date">
					{date_format date=$oPost->getDateAdd()}
				</div>
			</header>
			<div class="forum-post-body">
				{$oPost->getText()}
			</div>
		</div>
	</div>
	<footer class="forum-post-footer">
	</footer>
</article>