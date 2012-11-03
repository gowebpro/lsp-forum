<ul class="item-list">
	{foreach from=$aLastTopics item=oTopic name="topic_list"}
		{assign var="oForum" value=$oTopic->getForum()}
		{assign var="oPost" value=$oTopic->getPost()}
		{assign var="oUser" value=$oPost->getUser()}

		<li class="js-title-comment" title="{$oPost->getText()|trim|truncate:150:'...'|escape:'html'}">
			{if $oUser}
				<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(48)}" alt="avatar" class="avatar" /></a>
				<a href="{$oUser->getUserWebPath()}" class="author">{$oUser->getLogin()}</a> &rarr;
			{else}
				<img src="{cfg name='path.static.skin'}/images/avatar_male_48x48.png" alt="avatar" class="avatar" />
				{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()} &rarr;
			{/if}
			<a href="{$oForum->getUrlFull()}" class="blog-name">{$oForum->getTitle()|escape:'html'}</a> &rarr;
			<a href="{$oPost->getUrlFull()}" class="stream-topic">{$oTopic->getTitle()|escape:'html'}</a>

			<p>
				<time datetime="{date_format date=$oPost->getDateAdd() format='c'}">{date_format date=$oPost->getDateAdd() hours_back="12" minutes_back="60" now="60" day="day H:i" format="j F Y, H:i"}</time> |
				{$oTopic->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')} {$oTopic->getCountPost()|declension:$aLang.plugin.forum.posts_declension:'russian'|lower}
			</p>
		</li>
	{/foreach}
</ul>