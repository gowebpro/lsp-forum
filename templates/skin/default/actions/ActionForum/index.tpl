{include file='header.tpl' noSidebar=true}

<div class="forum clear_fix">

	<div class="forumNav">
		<h2>{$aLang.forums}</h2>
	</div>

	{if $aCategories}
	{foreach from=$aCategories item=oCategory}
		{assign var='aForums' value=$oCategory->getChildren()}
		<div class="forumHeader clear_fix">
			<div class="leftBg">
				<h2><a href="{$oCategory->getUrlFull()}">{$oCategory->getTitle()}</a></h2>
			</div>
			<div class="rightBg">
				<span class="lastMsg">{$aLang.forum_header_last_post|lower}</span>
				<span class="answers">{$aLang.forum_header_answers|lower}</span>
				<span class="views">{$aLang.forum_header_topics|lower}</span>
			</div>
		</div>

		<div class="tableContainer">
			{include file="$sTemplatePathPlugin/forums_list.tpl"}
		</div>
	{/foreach}
	{/if}

	<div class="shadow"></div>

	{hook run='forum_copyright'}

	<div class="forumStats">
		<h2>{$aLang.forum_stats}</h2>
		{if $aForumStats.online}
		<div class="users">
			<div class="header">{$aLang.forum_stats_visitors}: {$aForumStats.online.count_visitors}</div>
			<div class="content">
				{if $aForumStats.online.count_users} {$aForumStats.online.count_users} Пользователей {/if}
				{if $aForumStats.online.count_users && $aForumStats.online.count_quest}{$aLang.forum_and}{/if}
				{if $aForumStats.online.count_quest} {$aForumStats.online.count_quest} Гостей {/if}
				{if $aForumStats.online.users}
					<div class="user-list">
					{foreach from=$aForumStats.online.users item=oUser name=online_user}
						<span>
							<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(24)}" alt="" /></a>
							<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()|escape:'html'}</a>
							{if !$smarty.foreach.online_user.last}, {/if}
						</span>
					{/foreach}
					</div>
				{/if}
			</div>
		</div>
		{/if}
		{if $aForumStats.bdays}
		<div class="bdays">
			<div class="header">{$aLang.forum_stats_birthday}: {$aForumStats.bdays|@count}</div>
			<div class="content">
				<div class="user-list">
				{foreach from=$aForumStats.bdays item=oUser name=bday_user}
					<span>
						<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(24)}" width="20px" alt="" /></a>
						<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()|escape:'html'}</a>
						{if !$smarty.foreach.online_user.last}, {/if}
					</span>
				{/foreach}
				</div>
				{$aLang.forum_stats_birthday_notice}
			</div>
		</div>
		{/if}
		<div class="topics">
			<div class="header">{$aLang.forum_stats}</div>
			<div class="content">
				<div>{$aLang.forum_stats_post_count}: <span class="count">{$aForumStats.count_all_posts}</span></div>
				<div>{$aLang.forum_stats_topic_count}: <span class="count">{$aForumStats.count_all_topics}</span></div>
				<div>{$aLang.forum_stats_user_count}: <span class="count">{$aForumStats.count_all_users}</span></div>
				{if $aForumStats.last_user}
					{assign var=oUser value=$aForumStats.last_user}
					<div>{$aLang.forum_stats_user_last}: <span class="count">{$oUser->getLogin()|escape:'html'}</span></div>
				{/if}
			</div>
		</div>
	</div>

</div>

{include file='footer.tpl'}