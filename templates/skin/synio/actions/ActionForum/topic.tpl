{assign var="noSidebar" value=true}
{include file='header.tpl'}
{include file="$sTemplatePathPlugin/window_post_anchor.tpl"}

{assign var="oSubscribeTopic" value=$oTopic->getSubscribeNewPost()}

<h2 class="page-header">{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>

{if $oConfig->GetValue('plugin.forum.topic_line_mod') && $oHeadPost}
<div class="forum-topic">
	<header class="forums-header">
		{if $oUserCurrent}
		<section class="fl-r">
			<input{if $oSubscribeTopic and $oSubscribeTopic->getStatus()} checked="checked"{/if} type="checkbox" id="topic_subscribe" class="input-checkbox" onchange="ls.subscribe.toggle('topic_new_post','{$oTopic->getId()}','',this.checked);">
			<label for="topic_subscribe">{$aLang.plugin.forum.subscribe_topic}</label>
		</section>
		{/if}
		<h3>{$oTopic->getTitle()}</h3>
	</header>
	{include file="$sTemplatePathPlugin/post.tpl" oPost=$oHeadPost bFirst=true}
</div>
{/if}

{if count($aPosts) > 0}
<div id="topic-controls-top" class="controllers clearfix">
	{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}
	{include file="$sTemplatePathPlugin/buttons_action.tpl"}
</div>

<div class="forum-topic">
	<header class="forums-header">
	{if $oConfig->GetValue('plugin.forum.topic_line_mod')}
		<section class="fl-r">
			{$aLang.plugin.forum.topic_post_count}: {$iPostsCount|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')}
		</section>
		<h3>{$aLang.plugin.forum.topic_answers}</h3>
	{else}
		{if $oUserCurrent}
		<section class="fl-r">
			<input{if $oSubscribeTopic and $oSubscribeTopic->getStatus()} checked="checked"{/if} type="checkbox" id="topic_subscribe" class="input-checkbox" onchange="ls.subscribe.toggle('topic_new_post','{$oTopic->getId()}','',this.checked);">
			<label for="topic_subscribe">{$aLang.plugin.forum.subscribe_topic}</label>
		</section>
		{/if}
		<h3>{$oTopic->getTitle()}</h3>
	{/if}
	</header>
	{foreach from=$aPosts item=oPost name=posts}
		{include file="$sTemplatePathPlugin/post.tpl" oPost=$oPost bFirst=$smarty.foreach.posts.first}
	{/foreach}
</div>
{/if}

{if $oUserCurrent && ($oUserCurrent->isAdministrator() || $oForum->isModerator())}
<footer class="forums-footer-block">
	<form name="modform" action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		<input type="hidden" name="t" value="{$oTopic->getId()}" />
		<input type="hidden" name="f" value="{$oForum->getId()}" />
		<select name="code" class="">
			<option value="-1"> {$aLang.plugin.forum.topic_mod_option}</option>
			{if $oForum->getModMoveTopic()}
				<option value="1">- {$aLang.plugin.forum.topic_move}</option>
			{/if}
			{if $oForum->getModDeleteTopic()}
				<option value="2">- {$aLang.plugin.forum.topic_delete}</option>
			{/if}
			{if $oForum->getModOpencloseTopic()}
				{if $oTopic->getState()}
					<option value="3">- {$aLang.plugin.forum.topic_open}</option>
				{else}
					<option value="3">- {$aLang.plugin.forum.topic_close}</option>
				{/if}
			{/if}
			{if $oForum->getModPinTopic()}
				{if $oTopic->getPinned()}
					<option value="4">- {$aLang.plugin.forum.topic_unpin}</option>
				{else}
					<option value="4">- {$aLang.plugin.forum.topic_pin}</option>
				{/if}
			{/if}
		</select>
		<button type="submit" name="submit_topic_mod" class="button">OK</button>
	</form>
</footer>
{/if}

<div id="topic-controls-bottom" class="controllers clearfix">
	{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}
	{include file="$sTemplatePathPlugin/buttons_action.tpl" bFastAnswer=true}
</div>

{if $oUserCurrent && (!$oTopic->getState() || $oUserCurrent->isAdministrator()) && $oForum->getAllowReply() && $oForum->getQuickReply()}
	{include file="$sTemplatePathPlugin/fast_answer_form.tpl"}
{/if}

<footer class="forums-footer-block clearfix">
	<div class="fl-r">
		{include file="$sTemplatePathPlugin/jumpmenu.tpl"}
	</div>
</footer>

{include file='footer.tpl'}