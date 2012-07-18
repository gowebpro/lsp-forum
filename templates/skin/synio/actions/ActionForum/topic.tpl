{assign var="noSidebar" value=true}
{include file='header.tpl'}

{assign var="oForum" value=$oTopic->getForum()}
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
	{include file="$sTemplatePathPlugin/post.tpl" oPost=$oHeadPost}
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
			{$aLang.plugin.forum.topic_post_count}: {$iPostsCount}
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
	{foreach from=$aPosts item=oPost}
		{include file="$sTemplatePathPlugin/post.tpl" oPost=$oPost}
	{/foreach}
</div>
{/if}

<footer class="forum-topic-footer">
	{if $oUserCurrent && $oUserCurrent->isAdministrator()}
	<form name="modform" action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		<input type="hidden" name="t" value="{$oTopic->getId()}" />
		<input type="hidden" name="f" value="{$oForum->getId()}" />
		<select name="code" class="">
			<option value="-1"> {$aLang.plugin.forum.topic_mod_option}</option>
			<option value="1">- {$aLang.plugin.forum.topic_move}</option>
			<option value="2">- {$aLang.plugin.forum.topic_delete}</option>
			{if $oTopic->getState()}
			<option value="3">- {$aLang.plugin.forum.topic_open}</option>
			{else}
			<option value="3">- {$aLang.plugin.forum.topic_close}</option>
			{/if}
			{if $oTopic->getPinned()}
			<option value="4">- {$aLang.plugin.forum.topic_unpin}</option>
			{else}
			<option value="4">- {$aLang.plugin.forum.topic_pin}</option>
			{/if}
		</select>
		<button type="submit" name="submit_topic_mod" class="button">OK</button>
		{/if}
	</form>
</footer>

<div id="topic-controls-bottom" class="controllers clearfix">
	{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging}
	{include file="$sTemplatePathPlugin/buttons_action.tpl" bFastAnswer=true}
</div>

{if $oUserCurrent && (!$oTopic->getState() || $oUserCurrent->isAdministrator()) && $oForum->getQuickReply()}
	{include file="$sTemplatePathPlugin/fast_answer_form.tpl"}
{/if}

{include file='footer.tpl'}