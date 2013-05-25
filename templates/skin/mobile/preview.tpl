{assign var="oUser" value=$oPost->getUser()}

{hook run='forum_preview_show_start' post=$oPost}

<article class="forum-post forum-post-one mb-10" id="post-{$oPost->getId()}">
	<div class="forum-post-wrap">
		<div class="forum-post-content">
			<header class="forum-post-header">
				{hook run='forum_post_header_begin' post=$oPost}
				<div class="clearfix">
					<section class="forum-post-extra-left">
						<div class="forum-post-info-author">
							{hook run='forum_post_userinfo_begin' post=$oPost user=$oUser}

							{if $oUser}
								<a href="{$oUser->getUserWebPath()}"><img alt="{$oUser->getLogin()}" src="{$oUser->getProfileAvatarPath(48)}" /></a>
								<p><a rel="author" href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></p>
							{else}
								<img alt="{$oPost->getGuestName()}" src="{cfg name='path.static.skin'}/images/avatar_male_48x48.png" />
								<p>{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}</p>
							{/if}
							<time datetime="{date_format date=$oPost->getDateAdd() format='c'}" title="{date_format date=$oPost->getDateAdd() format='j F Y, H:i'}">
								{date_format date=$oPost->getDateAdd() format="j F Y, H:i"}
							</time>

							{hook run='forum_post_userinfo_end' post=$oPost user=$oUser}
						</div>
					</section>
				</div>
				{hook run='forum_post_header_end' post=$oPost}
			</header>
			<div class="forum-post-body">
				{hook run='forum_post_content_begin' post=$oPost}
				{if $oPost->getTitle()}
					<h2>{$oPost->getTitle()}</h2>
				{/if}
				<div class="text">
					{$oPost->getText()}
				</div>
				{hook run='forum_post_content_end' post=$oPost}
			</div>
		</div>
	</div>
</article>

{hook run='forum_preview_show_end' post=$oPost}

<div class="mb-10">
	<button type="submit" name="submit_preview" onclick="jQuery('#text_preview').html('').hide(); return false;" class="button">{$aLang.topic_create_submit_preview_close}</button>
</div>