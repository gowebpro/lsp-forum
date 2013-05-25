<li{if $sMenuSubItemSelect=='forum_topics'} class="active"{/if}>
	<a href="{$oUserProfile->getUserWebPath()}forum/topics/">{$aLang.plugin.forum.user_menu_publication_topics}{if $iCountForumTopic} ({$iCountForumTopic}){/if}</a>
</li>

<li{if $sMenuSubItemSelect=='forum_posts'} class="active"{/if}>
	<a href="{$oUserProfile->getUserWebPath()}forum/posts/">{$aLang.plugin.forum.user_menu_publication_posts}{if $iCountForumPost} ({$iCountForumPost}){/if}</a>
</li>