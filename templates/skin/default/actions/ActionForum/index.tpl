{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">{$aLang.forums}</h2>

<div class="forums">
	{if $aCategories}
		{foreach from=$aCategories item=oCategory}
			{assign var='aForums' value=$oCategory->getChildren()}
			<section class="forums-list">
				<header class="forums-header">
					<h3><a href="{$oCategory->getUrlFull()}">{$oCategory->getTitle()}</a></h3>
				</header>
				<div class="forums-content">
					{include file="$sTemplatePathPlugin/forums_list.tpl"}
				</div>
			</section>
		{/foreach}
	{/if}
</div>

<div class="forum-stats">
	<header class="forums-header">
		<h3>{$aLang.forum_stats}</h3>
	</header>
	<div class="forums-content">
		<table class="table">
			{if $aForumStats.online}
			<tr>
				<td class="cell-subtitle" colspan="2">
					{$aLang.forum_stats_visitors}: {$aForumStats.online.count_visitors}
				</td>
			</tr>
			<tr>
				<td class="cell-icon"><div class="forum-stats-icon-users"></div></td>
				<td class="cell-content">
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
				</td>
			</tr>
			{/if}

			{if $aForumStats.bdays}
			<tr>
				<td class="cell-subtitle" colspan="2">
					{$aLang.forum_stats_birthday}: {$aForumStats.bdays|@count}
				</td>
			</tr>
			<tr>
				<td class="cell-icon"><div class="forum-stats-icon-users"></div></td>
				<td class="cell-content">
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
				</td>
			</tr>
			{/if}

			<tr>
				<td class="cell-subtitle" colspan="2">
					{$aLang.forum_stats}
				</td>
			</tr>
			<tr>
				<td class="cell-icon"><div class="forum-stats-icon-stats"></div></td>
				<td class="cell-content">
					<div>{$aLang.forum_stats_post_count}: <span class="count">{$aForumStats.count_all_posts}</span></div>
					<div>{$aLang.forum_stats_topic_count}: <span class="count">{$aForumStats.count_all_topics}</span></div>
					<div>{$aLang.forum_stats_user_count}: <span class="count">{$aForumStats.count_all_users}</span></div>
					{if $aForumStats.last_user}
						{assign var=oUser value=$aForumStats.last_user}
						<div>{$aLang.forum_stats_user_last}: <span class="count">{$oUser->getLogin()|escape:'html'}</span></div>
					{/if}
				</td>
			</tr>
		</table>
	</div>
</div>

{hook run='forum_copyright'}

{include file='footer.tpl'}