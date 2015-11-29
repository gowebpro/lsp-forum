{if count($aPosts) > 0}
	{add_block group='toolbar' name='toolbar_post.tpl' iCountPost=count($aPosts) plugin='forum'}

	{foreach from=$aPosts item=oPost name=posts}
	<div class="forum-topic forum-user-publish">
		{assign var="oUser" value=$oPost->getUser()}
		{assign var="oTopic" value=$oPost->getTopic()}
		{assign var="oForum" value=$oTopic->getForum()}

		<div class="forum-post">
			<header class="forum-header">
				<a href="{$oForum->getUrlFull()}" class="blog-name">{$oForum->getTitle()|escape:'html'}</a> &rarr;
				<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a>
				<a href="{$oTopic->getUrlFull()}">({$oTopic->getCountPost()|number_format:0:'.':$oConfig->Get('plugin.forum.number_format')})</a>
			</header>

			{include file="$sTemplatePathForum/post.tpl" noPostSide=true noFooter=false bFirst=$smarty.foreach.posts.first}
		</div>
	{/foreach}
	</div>
{/if}