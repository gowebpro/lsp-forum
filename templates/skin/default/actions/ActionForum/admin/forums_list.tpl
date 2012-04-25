{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header"><a href="{router page='forum'}admin">{$aLang.forum_acp}</a> <span>&raquo;</span> {$aLang.forums}</h2>

{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}

<div class="forums">
	<header class="forums-header">
		<h3>{$aLang.forum_acp_main}</h3>
	</header>

	<table class="table">
		<thead>
			<tr>
				<th width="50%">
					<h3>{$aLang.forum_acp_forums_control}</h3>
				</th>
				<th width="50%">
					<h3>{$aLang.forum_acp_forums_moders}</h3>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<br/>
					<div class="ta-c mb-30">
						<a href="{router page='forum'}admin/forums/new?type=forum"><button class="button{if $aForums} button-primary{/if}"{if !$aForums} disabled="disabled"{/if}>{$aLang.forum_create_forum}</button></a>
						<a href="{router page='forum'}admin/forums/new?type=category"><button class="button{if !$aForums} button-primary{/if}">{$aLang.forum_create_category}</button></a>
					</div>
					{if $aForums}
					<ul id="forums-tree">
					{foreach from=$aForumsTree item=aItem}
						{assign var=oForum value=$aItem.entity}
						<li id="forum-{$oForum->getId()}" style="margin-left:{$aItem.level*20}px">
							<a class="icon-edit" title="{$aLang.forum_edit}" href="{router page='forum'}admin/forums/edit/{$oForum->getId()}"></a>
							<a class="icon-remove" title="{$aLang.forum_delete}" href="{router page='forum'}admin/forums/delete/{$oForum->getId()}"></a>
							<a class="icon-arrow-up" title="{$aLang.forum_sort_up} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/up/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
							<a class="icon-arrow-down" title="{$aLang.forum_sort_down} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/down/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
							{$oForum->getTitle()}
						</li>
					{/foreach}
					</ul>
					{else}
						<div class="empty">{$aLang.forums_no}</div>
					{/if}
				</td>
				<td>
					{$aLang.forum_in_progress}
				</td>
			</tr>
		</tbody>
	</table>
</div>

{include file='footer.tpl'}