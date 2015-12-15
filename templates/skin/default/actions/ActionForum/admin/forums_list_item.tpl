{$aForumStats = $aForumsStat[$oForum->getId()]}
<div class="forum-item-wrapper" id="forum{$oForum->getId()}">
	{* Основной блок *}
	<div class="forum-item-block">

		{* Панель управления *}
		<section class="forum-item-panel" id="forum{$oForum->getId()}_panel">
			{if $bFirst}
				<span class="forum-panel-item disabled">
					<i class="icon-arrow-up"></i>
				</span>
			{else}
				<a class="forum-panel-item js-tiptop-help" title="{$aLang.plugin.forum.sort_up} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/up/?security_ls_key={$LIVESTREET_SECURITY_KEY}">
					<i class="icon-arrow-up"></i>
				</a>
			{/if}
			{if $bLast}
				<span class="forum-panel-item disabled">
					<i class="icon-arrow-down"></i>
				</span>
			{else}
				<a class="forum-panel-item js-tiptop-help" title="{$aLang.plugin.forum.sort_down} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/down/?security_ls_key={$LIVESTREET_SECURITY_KEY}">
					<i class="icon-arrow-down"></i>
				</a>
			{/if}
			{if $bRefreshEnable}
				<a class="forum-panel-item js-tiptop-help" title="{$aLang.plugin.forum.refresh}" href="{router page='forum'}admin/forums/refresh/{$oForum->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}">
					<i class="icon-refresh"></i>
				</a>
			{/if}
			<a class="forum-panel-item js-tiptop-help" title="{$aLang.plugin.forum.delete}" href="{router page='forum'}admin/forums/delete/{$oForum->getId()}">
				<i class="icon-trash"></i>
			</a>
			<a class="forum-panel-item js-tiptop-help" title="{$aLang.plugin.forum.edit}" href="{router page='forum'}admin/forums/edit/{$oForum->getId()}">
				<i class="icon-edit"></i>
			</a>
			<a class="forum-panel-item js-tiptop-help" title="{$aLang.plugin.forum.perms}" href="{router page='forum'}admin/forums/perms/{$oForum->getId()}">
				<i class="icon-eye-open"></i>
			</a>
			{if $bModerList}
			<a class="forum-panel-item js-tiptop-help js-forum-panel-slide" title="{$aLang.plugin.forum.moderators_list}" href="#" rel="moders" data-f="{$oForum->getId()}">
				<i class="icon-user"></i>
			</a>
			{/if}
			{if $bStats}
			<a class="forum-panel-item js-tiptop-help js-forum-panel-slide" title="{$aLang.plugin.forum.stats}" href="#" rel="stats" data-f="{$oForum->getId()}">
				<i class="icon-signal"></i>
			</a>
			{/if}
		</section>

		{* Основная информация *}
		<section class="forum-item-main">
			<img class="forum-item-icon" src="{$oForum->getIconPath(32)}" alt="{$oForum->getTitle()|escape:'html'}" />
			<span class="forum-item-title">{$oForum->getTitle()|escape:'html'}</span>
			{if $oForum->getCanPost()}
				{if $oForum->getParentId()}
					<i class="folder-open" title="Category"></i>
				{else}
					<i class="icon-home" title="Root Category"></i>
				{/if}
			{/if}
			{if $oForum->getType() == $FORUM_TYPE_ARCHIVE}
				<i class="icon-book" title="Archive (Read only)"></i>
			{/if}
			{if $oForum->getPassword()}
				<i class="icon-lock" title="Close (with password)"></i>
			{/if}
			{if $oForum->getRedirectOn()}
				<i class="icon-share-alt" title="Redirect to {$oForum->getRedirectUrl()}"></i>
			{/if}
		</section>
	</div>

	{* Вспомогательный блок\аккордион *}
	<div class="forum-item-info" id="forum{$oForum->getId()}_panel_info">
		{if $bStats}
			{* Статистика форума *}
			<section class="forum-info-item forum-info-stats" id="forum{$oForum->getId()}_stats_block">
				<div class="forum-stat-item">
					<span class="huge">{$oForum->getCountTopic()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</span>
					{$oForum->getCountTopic()|declension:$aLang.plugin.forum.topics_declension:'russian'|lower}
				</div>
				<div class="forum-stat-item">
					<span class="huge">{$oForum->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}</span>
					{$oForum->getCountPost()|declension:$aLang.plugin.forum.posts_declension:'russian'|lower}
				</div>
				{if $aForumStats}
					<div class="forum-stat-item">
						<span class="huge">{$aForumStats.activity|default:'0'}%</span>
						{$aLang.plugin.forum.stats_activity}
					</div>
					<div class="forum-stat-item">
						<ul>
							<li>
								{$aLang.plugin.forum.stats_last_post}:
								<strong>{if $oForum->getLastPostDate()}{date_format date=$oForum->getLastPostDate()}{else}-{/if}</strong>
							</li>
							{if $aForumStats.last_topic}
								{$oLastTopic = $aForumStats.last_topic}
								<li>
									{$aLang.plugin.forum.stats_last_topic}:
									<strong>{$oLastTopic->getDateAdd()}</strong>
								</li>
							{/if}
						</ul>
					</div>
				{/if}
			</section>
		{/if}

		{if $bModerList}
			{* Список модераторов *}
			<section class="forum-info-item forum-info-moders" id="forum{$oForum->getId()}_moders_block">
				{include file="$sTemplatePathForum/actions/ActionForum/admin/list_moderators.tpl"}
			</section>
		{/if}
	</div>
</div>