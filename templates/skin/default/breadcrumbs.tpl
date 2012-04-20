<a href="{router page='forum'}">{$aLang.forums}</a>

{foreach from=$aBreadcrumbs item=aItem name=breadcrumbs}
	&rarr; <a href="{$aItem.url}">{$aItem.title}</a>
	{if !$smarty.foreach.breadcrumbs.last}{/if}
{/foreach}