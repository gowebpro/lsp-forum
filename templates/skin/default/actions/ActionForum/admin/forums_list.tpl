{assign var="noSidebar" value=true}
{include file='header.tpl'}

<div class="forum">
	<div class="forumNav">
		<h2>
			<span><a href="{router page='forum'}admin">{$aLang.forum_acp}</a></span>
			{$aLang.forums}
		</h2>
	</div>

	<div class="forumBblock">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_acp_main}</h2>
			</div>
			<div class="rightBg"></div>
		</div>

		<div class="fastAnswer clear_fix">
			<div class="fastAnswerForm">
				<div style="width:45%;float:right">
					<h2>Menu</h2><br />
					<ul>
						<li><a href="{router page='forum'}admin/forums/new?type=forum">{$aLang.forum_create_forum}</a></li>
						<li><a href="{router page='forum'}admin/forums/new?type=category">{$aLang.forum_create_category}</a></li>
					</ul>
				</div>
				<div style="width:45%;float:left">
					<h2>{$aLang.forum_acp_forums_control}</h2>
					<strong>{$aLang.forum_acp_forums_list_msg}</strong><br /><br />
					{if $aForums}
					<ul id="forums-tree">
					{foreach from=$aForumsTree item=aItem}
						{assign var=oForum value=$aItem.entity}
						<li id="forum-{$oForum->getId()}" style="margin-left:{$aItem.level*20}px">
							<a href="{router page='forum'}admin/forums/edit/{$oForum->getId()}" title="{$aLang.forum_edit}">[E]</a>
							<a href="{router page='forum'}admin/forums/delete/{$oForum->getId()}" title="{$aLang.forum_delete}">[X]</a>
							<!--a href="#" onclick="return ls.forum.admin.deleteForum({$oForum->getId()},'{$oForum->getTitle()}')" title="{$aLang.forum_delete}">[X]</a-->
							{$oForum->getTitle()}
						</li>
					{/foreach}
					</ul>
					{else}
						{$aLang.forums_no}
					{/if}
				</div>
			</div>
		</div>
	</div>

</div>

{include file='footer.tpl'}