<ul class="latest-list">
	{foreach from=$aLastTopics item=oTopic name="topic_list"}
		{assign var="oForum" value=$oTopic->getForum()}
		{assign var="oPost" value=$oTopic->getPost()}
		{assign var="oUser" value=$oPost->getUser()}

		<li class="js-title-comment" title="{$oPost->getText()|strip_tags|trim|truncate:150:'...'|escape:'html'}">
			<p>
				{if $oUser}
					<a href="{$oUser->getUserWebPath()}" class="author">{$oUser->getLogin()}</a>
				{else}
					{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}
				{/if}
				<time datetime="{date_format date=$oPost->getDateAdd() format='c'}" title="{date_format date=$oPost->getDateAdd() format='j F Y, H:i'}">
					{date_format date=$oPost->getDateAdd() hours_back="12" minutes_back="60" now="60" day="day H:i" format="j F Y, H:i"}
				</time>
			</p>
			<a href="{$oForum->getUrlFull()}" class="stream-blog">{$oForum->getTitle()|escape:'html'}</a> &rarr;
			<a href="{$oPost->getUrlFull()}" class="stream-topic">{$oTopic->getTitle()|escape:'html'}</a>
			<span class="block-item-comments"><i class="icon-synio-comments-small"></i>{$oTopic->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</span>
		</li>
	{/foreach}
</ul>

<footer>
	<a href="{router page='rss'}forum_stream/">RSS</a>
</footer>