{assign var="oUser" value=$oPost->getUser()}

{hook run='forum_preview_show_start' topic=$oTopic}

<article class="forum-post forum-post-one mb-10" id="post-{$oPost->getId()}">
	<div class="clearfix">
		<aside class="forum-post-side">
			{hook run='forum_post_userinfo_begin' post=$oPost user=$oUser}
			{if $oUser}
				<section class="avatar"><img alt="{$oUser->getLogin()}" src="{$oUser->getProfileAvatarPath(100)}" /></section>
				<section class="login"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></section>
			{else}
				<section class="avatar"><img alt="{$oPost->getGuestName()}" src="{cfg name='path.static.skin'}/images/avatar_male_100x100.png" /></section>
				<section class="login">{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}</a></section>
			{/if}
			{hook run='forum_post_userinfo_end' post=$oPost user=$oUser}
		</aside>
		<div class="forum-post-content clearfix">
			<header class="forum-post-header">
				{hook run='forum_post_header_begin' post=$oPost}
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
</article>

{hook run='forum_preview_show_end' topic=$oTopic}

<div class="mb-10">
	<button type="submit" name="submit_preview" onclick="jQuery('#text_preview').html('').hide(); return false;" class="button">{$aLang.topic_create_submit_preview_close}</button>
</div>