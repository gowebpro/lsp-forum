{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header"><a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span> {$aLang.plugin.forum.forums}</h2>

{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}
{include file="$sTemplatePathPlugin/actions/ActionForum/admin/window_moderator.tpl"}

<div class="forums">
	<script type="text/javascript">
		jQuery(document).ready(function($){
			ls.forum.admin.initModerToggler();
		});
	</script>

	<header class="forums-header">
		<h3>{$aLang.plugin.forum.acp_forums_control}</h3>
	</header>

	<table class="table">
		<thead>
			<tr>
				<th width="50%">
					<h3>{$aLang.plugin.forum.acp_forums_control}</h3>
				</th>
				<th width="50%">
					<h3>{$aLang.plugin.forum.in_progress}</h3>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<br/>
					<div class="ta-c mb-10">
						<a href="{router page='forum'}admin/forums/new?type=forum" class="button{if $aForums} button-primary{/if}"{if !$aForums} disabled="disabled"{/if}>{$aLang.plugin.forum.create_forum}</a>
						<a href="{router page='forum'}admin/forums/new?type=category" class="button{if !$aForums} button-primary{else} button-orange{/if}">{$aLang.plugin.forum.create_category}</a>
					</div>
					{if $aForums}
					<div class="mb-20">
						<ul id="forums-tree">
						{foreach from=$aForumsTree item=aItem}
							{assign var=oForum value=$aItem.entity}
							<li id="forum-{$oForum->getId()}"{if $aItem.level == 0} class="head"{else} style="margin-left:{$aItem.level*25}px"{/if}>
								<a class="js-tip-help icon-edit" title="{$aLang.plugin.forum.edit}" href="{router page='forum'}admin/forums/edit/{$oForum->getId()}"></a>
								<a class="js-tip-help icon-remove" title="{$aLang.plugin.forum.delete}" href="{router page='forum'}admin/forums/delete/{$oForum->getId()}"></a>
								<a class="js-tip-help icon-arrow-up" title="{$aLang.plugin.forum.sort_up} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/up/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
								<a class="js-tip-help icon-arrow-down" title="{$aLang.plugin.forum.sort_down} ({$oForum->getSort()})" href="{router page='forum'}admin/forums/sort/{$oForum->getId()}/down/?security_ls_key={$LIVESTREET_SECURITY_KEY}"></a>
								<span class="title">{$oForum->getTitle()}</span>
								{if $aItem.level > 0}
									<span class="js-forum-moder-toogler js-tip-help fl-r icon-plus-sign" id="toggler-moder-list-{$oForum->getId()}" title="{$aLang.plugin.forum.moderators_list}"></span>
									<span class="moder-list" id="moder-list-{$oForum->getId()}" style="display:none">
										{include file="$sTemplatePathPlugin/actions/ActionForum/admin/list_moderators.tpl"}
									</span>
								{/if}
							</li>
						{/foreach}
						</ul>
					</div>
					{else}
						<div class="empty">{$aLang.plugin.forum.clear}</div>
					{/if}
				</td>
				<td>

				</td>
			</tr>
		</tbody>
	</table>
</div>

{include file='footer.tpl'}