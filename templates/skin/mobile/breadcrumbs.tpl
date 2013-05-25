<a href="{router page='forum'}">{$aLang.plugin.forum.forums}</a>

{foreach from=$aBreadcrumbs item=aItem name=breadcrumbs}
	<span>&raquo;</span> <a href="{$aItem.url}">{$aItem.title}</a>
	{if !$smarty.foreach.breadcrumbs.last}{/if}
{/foreach}