{assign var="noSidebar" value=true}
{include file='header.tpl'}

{assign var='aSubForums' value=$oForum->getChildren()}
{assign var='oSubscribeForum' value=$oForum->getSubscribeNewTopic()}

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

{if $aSubForums}
	<div class="forums">
		<section class="forum-block">
			<header class="forum-header">
				<h3><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()|escape:'html'}</a></h3>
			</header>
			<div class="forum-content">
				{include file="$sTemplatePathForum/forums_list.tpl" aForums=$aSubForums}
			</div>
		</section>
	</div>
{/if}

{if $oForum->getCanPost() == 0}
	<div id="forum-controls-top" class="controllers clearfix">
		{include file="$sTemplatePathForum/paging.tpl" aPaging=$aPaging}
		{include file="$sTemplatePathForum/buttons_action.tpl"}
	</div>

	<div class="forums">
		<section class="forum-block">
			<header class="forum-header">
				{if $oUserCurrent}
				<section class="fl-r">
					<input{if $oSubscribeForum and $oSubscribeForum->getStatus()} checked="checked"{/if} type="checkbox" id="forum_subscribe" class="input-checkbox" onchange="ls.subscribe.toggle('forum_new_topic','{$oForum->getId()}','',this.checked);">
					<label for="forum_subscribe">{$aLang.plugin.forum.subscribe_forum}</label>
				</section>
				{/if}
				<section class="fl-r">
					<a href="{router page='rss'}forum/{if $oForum->getUrl()}{$oForum->getUrl()}{else}{$oForum->getId()}{/if}/" class="rss">RSS</a>
				</section>
				<h3>{$oForum->getTitle()|escape:'html'}</h3>
			</header>
			<div class="forum-content">
				{include file="$sTemplatePathForum/topics.tpl"}
			</div>
		</section>
	</div>

	<div id="forum-controls-bottom" class="controllers clearfix">
		{include file="$sTemplatePathForum/paging.tpl" aPaging=$aPaging}
		{include file="$sTemplatePathForum/buttons_action.tpl"}
	</div>
{/if}

<footer class="forum-footer clearfix">
	<div class="fl-r">
		{include file="$sTemplatePathForum/jumpmenu.tpl"}
	</div>
</footer>

{include file='footer.tpl'}