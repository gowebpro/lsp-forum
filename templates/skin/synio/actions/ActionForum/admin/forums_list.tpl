{assign var="noSidebar" value=true}
{assign var="noShowSystemMessage" value=true}
{include file='header.tpl'}

<h2 class="page-header"><a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span> {$aLang.plugin.forum.forums}</h2>

{include file="$sTemplatePathForum/menu.forum.admin.tpl"}
{include file="$sTemplatePathForum/modals/modal.moderator.tpl"}

<div class="forums">
	<script type="text/javascript">
		jQuery(document).ready(function($){
			ls.forum.admin.initModerToggler();
		});
	</script>

	<div class="fBox forum-acp">
		<header class="forums-header">
			<h3>{$aLang.plugin.forum.acp_forums_control}</h3>
		</header>

		<div class="forums-content">
			<div class="fContainer">
				{assign var="noShowSystemMessage" value=false}
				{include file='system_message.tpl'}

				<div class="forum-acp-notice">
					{$aLang.plugin.forum.acp_forums_control_notice}
				</div>

				<div class="forums-tree-controls">
					<div class="ta-c">
						<a href="{router page='forum'}admin/forums/new?type=forum"><button class="button{if $aForums} button-primary{/if}"{if !$aForums} disabled="disabled"{/if}>{$aLang.plugin.forum.create_forum}</button></a>
						<a href="{router page='forum'}admin/forums/new?type=category"><button class="button{if !$aForums} button-primary{else} button-orange{/if}">{$aLang.plugin.forum.create_category}</button></a>
					</div>
				</div>

				{if $aForums}
					<div class="forums-tree-wrapper">
					{assign var="iNesting" value="-1"}
					{foreach from=$aForumsTree item=aItem name=forums_tree}
						{assign var=oForum value=$aItem.entity}
						{assign var=iForumLevel value=$aItem.level}

						{if $iNesting < $iForumLevel}
						<ul class="forums-tree" id="forums-tree-{$oForum->getId()}">
						{elseif $iNesting > $iForumLevel}
							{section name=closelist1 loop=$iNesting-$iForumLevel+1}</li></ul>{/section}
							<ul class="forums-tree" id="forums-tree-{$oForum->getId()}">
						{elseif not $smarty.foreach.forums_tree.first}
							</li>
						{/if}

						<li id="forum-{$oForum->getId()}" class="forum-item level{$iForumLevel}">
						{include file="$sTemplatePathForum/actions/ActionForum/admin/forums_list_item.tpl"
							bFirst=$oForum->getFirst()
							bLast=$oForum->getLast()
							bRefreshEnable=$iForumLevel>0
							bModerList=$iForumLevel>0
						}
						{assign var="iNesting" value=$iForumLevel}
						{if $smarty.foreach.forums_tree.last}
							{section name=closelist2 loop=$iNesting+1}</li></ul>{/section}
						{/if}
					{/foreach}
					</div>
				{else}
					<div class="empty">{$aLang.plugin.forum.clear}</div>
				{/if}
			</div>
		</div>
	</div>
</div>

{include file='footer.tpl'}