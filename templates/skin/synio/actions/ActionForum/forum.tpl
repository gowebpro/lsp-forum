{assign var="noSidebar" value=true}
{include file='header.tpl'}

{* assign var='aSubForums' value=$oForum->getChildren() *}
{assign var='oSubscribeForum' value=$oForum->getSubscribeNewTopic()}

<h2 class="page-header">{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>

{if $aSubForums}
	<div class="forums">
		<section class="forums-list">
			<header class="forums-header">
				<h3><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a></h3>
			</header>
			<div class="forums-content">
				{include file="$sTemplatePathPlugin/forums_list.tpl" aForums=$aSubForums}
			</div>
		</section>
	</div>
{/if}

{if $oForum->getCanPost() == 0}
	<div id="forum-controls-top" class="controllers clearfix">
		{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}
		{include file="$sTemplatePathPlugin/buttons_action.tpl"}
	</div>

	<div class="forums">
		<section class="forums-list">
			<header class="forums-header">
				{if $oUserCurrent}
				<section class="fl-r">
					<input{if $oSubscribeForum and $oSubscribeForum->getStatus()} checked="checked"{/if} type="checkbox" id="forum_subscribe" class="input-checkbox" onchange="ls.subscribe.toggle('forum_new_topic','{$oForum->getId()}','',this.checked);">
					<label for="forum_subscribe">{$aLang.plugin.forum.subscribe_forum}</label>
				</section>
				{/if}
				<h3>{$oForum->getTitle()}</h3>
			</header>
			<div class="forums-content">
				{include file="$sTemplatePathPlugin/topics.tpl"}
			</div>
		</section>
	</div>

	<div id="forum-controls-bottom" class="controllers clearfix">
		{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}
		{include file="$sTemplatePathPlugin/buttons_action.tpl"}
	</div>
{/if}

<footer class="forums-footer-block">
	<table class="forum-legend">
		<tr>
			<td class="col1"></td>
			<td class="col2"></td>
			<td class="col3">
				{include file="$sTemplatePathPlugin/jumpmenu.tpl"}
			</td>
		</tr>
	</table>
</footer>

{include file='footer.tpl'}