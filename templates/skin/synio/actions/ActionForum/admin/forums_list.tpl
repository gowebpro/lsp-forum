{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header"><a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span> {$aLang.plugin.forum.forums}</h2>

{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}

<div class="forums">
	<header class="forums-header">
		<h3>{$aLang.plugin.forum.acp_main}</h3>
	</header>

	<table class="table">
		<thead>
			<tr>
				<th width="50%">
					<h3>{$aLang.plugin.forum.acp_forums_control}</h3>
				</th>
				<th width="50%">
					<h3>{$aLang.plugin.forum.acp_forums_moders}</h3>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<br/>
					<div class="ta-c mb-30">
						<a href="{router page='forum'}admin/forums/new?type=forum" class="button{if $aForums} button-primary{/if}"{if !$aForums} disabled="disabled"{/if}>{$aLang.plugin.forum.create_forum}</a>
						<a href="{router page='forum'}admin/forums/new?type=category" class="button{if !$aForums} button-primary{else} button-orange{/if}">{$aLang.plugin.forum.create_category}</a>
					</div>
					{if $aForums}
					<ul id="forums-tree">
					{foreach from=$aForumsTree item=aItem}
						{assign var=oForum value=$aItem.entity}
						<li id="forum-{$oForum->getId()}" style="margin-left:{$aItem.level*20}px">
							<a class="icon-edit" title="{$aLang.plugin.forum.edit}" href="{router page='forum'}admin/forums/edit/{$oForum->getId()}"></a>
							<a class="icon-remove" title="{$aLang.plugin.forum.delete}" href="{router page='forum'}admin/forums/delete/{$oForum->getId()}"></a>
							<a class="icon-arrow-up" title="{$aLang.plugin.forum.sort_up} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/up/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
							<a class="icon-arrow-down" title="{$aLang.plugin.forum.sort_down} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/down/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
							{$oForum->getTitle()}
						</li>
					{/foreach}
					</ul>
					{else}
						<div class="empty">{$aLang.plugin.forum.clear}</div>
					{/if}
				</td>
				<td>
					{$aLang.plugin.forum.in_progress}
				</td>
			</tr>
		</tbody>
	</table>
</div>

{include file='footer.tpl'}