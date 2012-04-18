{assign var="oUser" value=$oPost->getUser()}
<div class="post{if $oRead and $oRead->getDate()<=$oPost->getDateAdd()} new{/if}" id="post{$oPost->getId()}">
	<span class="rndCorners tl"></span>
	<span class="rndCorners tr"></span>
	<div class="personal">
		<div class="avatar"><img alt="{$oUser->getLogin()}" src="{$oUser->getProfileAvatarPath(100)}" /></div>
		<div class="nickname"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></div>
		<div class="rating{if $oUser->getRating()>0} positive{elseif $oUser->getRating()<0} negative{/if}">{$oUser->getRating()}</div>
	</div>
	<div class="postSection">
		<div class="postHeader">
			<span class="postInfo">
				{if $oUserCurrent && $oUserCurrent->isAdministrator() && $oPost->getUserIp()}
				IP: {$oPost->getUserIp()} |
				{/if}
				{$aLang.forum_post} <a href="{$oPost->getUrlFull()}" name="post{$oPost->getId()}" onclick="return ls.forum.linkToPost({$oPost->getId()})">#</a>
			</span>
			<span class="postDate">{date_format date=$oPost->getDateAdd()}</span>
		</div>
		<div class="postBody">
			{$oPost->getText()}
		</div>
	</div>
	<span class="rndCorners bl"></span>
	<span class="rndCorners br"></span>
	<div class="clear_fix"></div>
</div>