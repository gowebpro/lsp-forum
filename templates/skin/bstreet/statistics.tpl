<div class="forum-stats">
	<header class="forums-header">
		<h3>{$aLang.plugin.forum.stats}</h3>
	</header>
	<div class="forums-content">
		<table class="table table-forum-stats">
			{if $aForumStats.online}
			<tr>
				<th colspan="2">
					{$aLang.plugin.forum.stats_visitors}: {$aForumStats.online.count_visitors}
				</th>
			</tr>
			<tr>
				<td class="cell-icon"><div class="forum-stats-icon-users"></div></td>
				<td class="cell-content">
					{if $aForumStats.online.count_users}
						{$aForumStats.online.count_users} {$aForumStats.online.count_users|declension:$aLang.plugin.forum.users_declension:'russian'|lower}
					{/if}
					{if $aForumStats.online.count_users && $aForumStats.online.count_quest}
						{$aLang.plugin.forum.and}
					{/if}
					{if $aForumStats.online.count_quest}
						{$aForumStats.online.count_quest} {$aForumStats.online.count_quest|declension:$aLang.plugin.forum.guest_declension:'russian'|lower}
					{/if}
					{if $aForumStats.online.users}
						<div class="userlist">
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
				<th colspan="2">
					{$aLang.plugin.forum.stats_birthday}: {$aForumStats.bdays|@count}
				</th>
			</tr>
			<tr>
				<td class="cell-icon"><div class="forum-stats-icon-users"></div></td>
				<td class="cell-content">
					<div class="userlist">
					{foreach from=$aForumStats.bdays item=oUser name=bday_user}
						<span>
							<a href="{$oUser->getUserWebPath()}"><img src="{$oUser->getProfileAvatarPath(24)}" alt="" /></a>
							<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()|escape:'html'}</a>
							{if !$smarty.foreach.bday_user.last}, {/if}
						</span>
					{/foreach}
					</div>
					{$aLang.plugin.forum.stats_birthday_notice}
				</td>
			</tr>
			{/if}

			<tr>
				<th colspan="2">
					{$aLang.plugin.forum.stats}
				</th>
			</tr>
			<tr>
				<td class="cell-icon"><div class="forum-stats-icon-stats"></div></td>
				<td class="cell-content">
					<div>{$aLang.plugin.forum.stats_post_count}: <span class="count">{$aForumStats.count_all_posts}</span></div>
					<div>{$aLang.plugin.forum.stats_topic_count}: <span class="count">{$aForumStats.count_all_topics}</span></div>
					<div>{$aLang.plugin.forum.stats_user_count}: <span class="count">{$aForumStats.count_all_users}</span></div>
					{if $aForumStats.last_user}
						{assign var=oUser value=$aForumStats.last_user}
						<div>{$aLang.plugin.forum.stats_user_last}: <a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()|escape:'html'}</a></div>
					{/if}
				</td>
			</tr>
		</table>
	</div>
</div>