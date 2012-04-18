{assign var="noSidebar" value=true}
{include file='header.tpl'}

<div class="forum">
	<div class="forumNav">
		<h2>
			<span><a href="{router page='forum'}admin">{$aLang.forum_acp}</a></span>
			{$aLang.forums}
		</h2>
	</div>

	{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}

	<div class="forumBblock">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_acp_main}</h2>
			</div>
			<div class="rightBg"></div>
		</div>

		<table class="table">
			<tr>
				<th width="50%">
					<h3>{$aLang.forum_acp_forums_control}</h3>
				</th>
				<th width="50%">
					<h3>Actions</h3>
				</th>
			</tr>
			<tr>
				<td>
					<!--strong>{$aLang.forum_acp_forums_list_msg}</strong-->

					<br/>
					{if $aForums}
					<ul id="forums-tree">
					{foreach from=$aForumsTree item=aItem}
						{assign var=oForum value=$aItem.entity}
						<li id="forum-{$oForum->getId()}" style="margin-left:{$aItem.level*20}px">
							<a class="icon-edit" title="{$aLang.forum_edit}" href="{router page='forum'}admin/forums/edit/{$oForum->getId()}"></a>
							<a class="icon-remove" title="{$aLang.forum_delete}" href="{router page='forum'}admin/forums/delete/{$oForum->getId()}"></a>
							{$oForum->getTitle()}
						</li>
					{/foreach}
					</ul>
					{else}
						<div align="center">{$aLang.forums_no}</div>
					{/if}
				</td>
				<td>
					<ul>
						<li><a href="{router page='forum'}admin/forums/new?type=forum">{$aLang.forum_create_forum}</a></li>
						<li><a href="{router page='forum'}admin/forums/new?type=category">{$aLang.forum_create_category}</a></li>
					</ul>
				</td>
			</tr>
		</table>
	</div>

</div>

{include file='footer.tpl'}