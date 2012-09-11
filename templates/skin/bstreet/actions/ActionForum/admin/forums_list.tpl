{assign var="noSidebar" value=true}
{include file='header.tpl'}
{include file="$sTemplatePathPlugin/actions/ActionForum/admin/window_moderator.tpl"}

<div id="filter-top">
	<div class="filter-bg"></div>

	<h2 class="page-header" style="background:none"><a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span> {$aLang.plugin.forum.forums}</h2>
</div>
<br /><br />
<div class="wrapper-content">
	<div class="mb-30">
		{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}
	</div>
</div>
<div class="forums">
	<script type="text/javascript">
		jQuery(document).ready(function($){
			ls.forum.admin.initModerToggler();
		});
	</script>

	<table class="table table-forum-admin">
		<thead>
			<tr>
				<th class="cell-half">
					<h3>{$aLang.plugin.forum.acp_forums_control}</h3>
				</th>
				<th class="cell-half">
					<h3>{$aLang.plugin.forum.in_progress}</h3>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<br/>
					<div class="ta-c mb-10">
						<div class="{if $aForums}green{else}gray{/if}">
							<span class="l44"></span><span class="r44"></span>
							<a href="{router page='forum'}admin/forums/new?type=forum">
								<button{if !$aForums} disabled="disabled"{/if}>{$aLang.plugin.forum.create_forum}</button>
							</a>
						</div>
						<div class="{if !$aForums}green{else}button-orange{/if}">
							<span class="l44"></span><span class="r44"></span>
							<a href="{router page='forum'}admin/forums/new?type=category">
								<button>{$aLang.plugin.forum.create_category}</button>
							</a>
						</div>
					</div>
					{if $aForums}
					<div class="mb-20">
						<ul id="forums-tree">
						{foreach from=$aForumsTree item=aItem}
							{assign var=oForum value=$aItem.entity}
							<li id="forum-{$oForum->getId()}"{if $aItem.level == 0} class="head"{else} style="margin-left:{$aItem.level*25}px"{/if}>
								{if $aItem.level > 0}
								<a class="js-tip-help icon-eye-open" title="{$aLang.plugin.forum.perms}" href="{router page='forum'}admin/forums/perms/{$oForum->getId()}"></a>
								{/if}
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