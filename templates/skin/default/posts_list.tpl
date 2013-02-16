<div class="forum-topic">
{foreach from=$aPosts item=oPost name=posts}
	{assign var="oUser" value=$oPost->getUser()}
	{assign var="oTopic" value=$oPost->getTopic()}
	{assign var="oForum" value=$oTopic->getForum()}

	<div class="mb-30">
		<header class="forums-header">
			<a href="{$oForum->getUrlFull()}" class="blog-name">{$oForum->getTitle()|escape:'html'}</a> &rarr;
			<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a>
			<a href="{$oTopic->getUrlFull()}">({$oTopic->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')})</a>
		</header>

		{include file="$sTemplatePathForum/post.tpl" noPostSide=true noFooter=true bFirst=$smarty.foreach.posts.first}
	</div>
{/foreach}
</div>