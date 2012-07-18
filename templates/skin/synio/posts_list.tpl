<div class="forum-topic">
{foreach from=$aPosts item=oPost}
	{assign var="oUser" value=$oPost->getUser()}
	{assign var="oTopic" value=$oPost->getTopic()}
	{assign var="oForum" value=$oTopic->getForum()}

	<header class="forums-header">
		<a href="{$oForum->getUrlFull()}" class="blog-name">{$oForum->getTitle()|escape:'html'}</a> &rarr;
		<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a>
		<a href="{$oTopic->getUrlFull()}">({$oTopic->getCountPost()})</a>
	</header>

	{include file="$sTemplatePathPlugin/post.tpl" noPostSide=true}
{/foreach}
</div>