<div class="comments comment-list">
{foreach from=$aPosts item=oPost}
	{assign var="oUser" value=$oPost->getUser()}
	{assign var="oTopic" value=$oPost->getTopic()}
	{assign var="oForum" value=$oTopic->getForum()}

	<div class="comment-path">
		<a href="{$oForum->getUrlFull()}" class="blog-name">{$oForum->getTitle()|escape:'html'}</a> &rarr;
		<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a>
		<a href="{$oTopic->getUrlFull()}">({$oTopic->getCountPost()})</a>
	</div>

	{include file="$sTemplatePathPlugin/post.tpl"}
{/foreach}
</div>