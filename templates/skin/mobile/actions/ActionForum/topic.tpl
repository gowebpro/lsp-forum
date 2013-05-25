{assign var="noSidebar" value=true}
{include file='header.tpl'}
{include file="$sTemplatePathForum/modals/modal.post_anchor.tpl"}
{include file="$sTemplatePathForum/modals/modal.confirm_box.tpl"}

{assign var="oSubscribeTopic" value=$oTopic->getSubscribeNewPost()}
{assign var='oMarker' value=$oForum->getMarker()}

<script type="text/javascript">
	jQuery(function($){
		ls.lang.load({lang_load name="plugin.forum.post_delete_confirm"});
	});
</script>

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

{if $oConfig->GetValue('plugin.forum.topic_line_mod') && $oHeadPost}
<div class="forum-topic">
	<header class="forum-header">
		{if $oUserCurrent}
		<section class="fl-r">
			<input{if $oSubscribeTopic and $oSubscribeTopic->getStatus()} checked="checked"{/if} type="checkbox" id="topic_subscribe" class="input-checkbox" onchange="ls.subscribe.toggle('topic_new_post','{$oTopic->getId()}','',this.checked);">
			<label for="topic_subscribe">{$aLang.plugin.forum.subscribe_topic}</label>
		</section>
		{/if}
		<h3>{$oTopic->getTitle()}</h3>
	</header>
	{include file="$sTemplatePathForum/post.tpl" oPost=$oHeadPost bFirst=true}
</div>
{/if}

{if count($aPosts) > 0}

{add_block group='toolbar' name="$sTemplatePathForum/toolbar_post.tpl" iCountPost=count($aPosts)}

<div id="topic-controls-top" class="controllers clearfix">
	{include file="$sTemplatePathForum/paging.tpl" aPaging=$aPaging}
</div>

<div class="forum-topic">
	<header class="forum-header">
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
		{include file="$sTemplatePathForum/post.tpl" oPost=$oPost bFirst=$smarty.foreach.posts.first}
	{/foreach}
</div>
{/if}

{if $oUserCurrent && ($oUserCurrent->isAdministrator() || $oForum->isModerator())}
<footer class="forum-footer">
	<form name="modform" action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		<input type="hidden" name="t" value="{$oTopic->getId()}" />
		<input type="hidden" name="f" value="{$oForum->getId()}" />
		<select name="code" class="">
			<option value="-1"> {$aLang.plugin.forum.topic_mod_option}</option>
			<option value="-1" disabled="disabled"> ----------- </option>
			{if $oForum->getModMoveTopic()}
				<option value="1">- {$aLang.plugin.forum.topic_move}</option>
			{/if}
			{if $oForum->getModDeleteTopic()}
				<option value="3">- {$aLang.plugin.forum.topic_delete}</option>
			{/if}
			{if $oForum->getModOpencloseTopic()}
				{if $oTopic->getState()}
					<option value="4">- {$aLang.plugin.forum.topic_open}</option>
				{else}
					<option value="4">- {$aLang.plugin.forum.topic_close}</option>
				{/if}
			{/if}
			{if $oForum->getModPinTopic()}
				{if $oTopic->getPinned()}
					<option value="5">- {$aLang.plugin.forum.topic_unpin}</option>
				{else}
					<option value="5">- {$aLang.plugin.forum.topic_pin}</option>
				{/if}
			{/if}
		</select>
		<button type="submit" name="submit_topic_mod" class="button">OK</button>
	</form>
</footer>
{/if}

<div id="topic-controls-bottom" class="controllers clearfix">
	{include file="$sTemplatePathForum/paging.tpl" aPaging=$aPaging}
	{include file="$sTemplatePathForum/buttons_action.tpl" bFastAnswer=true}
</div>

{if $oUserCurrent && (!$oTopic->getState() || $oUserCurrent->isAdministrator()) && $oForum->getAllowReply() && $oForum->getQuickReply()}
	{include file="$sTemplatePathForum/fast_answer_form.tpl"}
{/if}

<footer class="forum-footer clearfix">
	<div class="fl-r">
		{include file="$sTemplatePathForum/jumpmenu.tpl"}
	</div>
</footer>

{include file='footer.tpl'}