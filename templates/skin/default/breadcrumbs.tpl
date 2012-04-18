<span><a href="{router page='forum'}">{$aLang.forums}</a></span>

{foreach from=$aBreadcrumbs item=aItem name=breadcrumbs}
	{if $smarty.foreach.breadcrumbs.last}
		<a href="{$aItem.url}">{$aItem.title}</a>
	{else}
		<span><a href="{$aItem.url}">{$aItem.title}</a></span>
	{/if}
{/foreach}