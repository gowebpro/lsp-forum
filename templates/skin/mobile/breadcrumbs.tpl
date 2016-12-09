<a href="{router page='forum'}">{$aLang.plugin.forum.forums}</a>

{foreach $aBreadcrumbs as $oItem}
    <span>&raquo;</span>
    {strip}
        {if $oItem->getLink()}
            <a href="{$oItem->getUrl()}">
        {/if}

        {$oItem->getTitle()|escape:'html'}

        {if $oItem->getLink()}
            </a>
        {/if}
    {/strip}
{/foreach}