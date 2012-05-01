<li{if $sMenuSubItemSelect=='forum_topics'} class="active"{/if}>
	<a href="{$oUserProfile->getUserWebPath()}forum/topics/">{$aLang.user_menu_publication_forum_topics}{if $iCountForumTopic} ({$iCountForumTopic}){/if}</a>
</li>

<li{if $sMenuSubItemSelect=='forum_posts'} class="active"{/if}>
	<a href="{$oUserProfile->getUserWebPath()}forum/posts/">{$aLang.user_menu_publication_forum_posts}{if $iCountForumPost} ({$iCountForumPost}){/if}</a>
</li>