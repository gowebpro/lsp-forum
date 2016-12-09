<a href="{router page='forum'}">{$aLang.plugin.forum.forums}</a>

{foreach $aBreadcrumbs as $oItem}
    {strip}
        <span>&raquo;</span>
        {if $oItem->getLink()}
            <a href="{$oItem->getUrl()}">
        {/if}

        {$oItem->getTitle()|escape:'html'}

        {if $oItem->getLink()}
            </a>
        {/if}
    {/strip}
{/foreach}