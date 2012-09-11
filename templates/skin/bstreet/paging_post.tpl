{if $aPaging and $aPaging.iCountPage>1}
<span class="goToPage">
[
	{$aLang.plugin.forum.on_page}:
	{if $aPaging.iCurrentPage>1}
	<a href="{$aPaging.sBaseUrl}">1 <<</a>
	{/if}
	{foreach from=$aPaging.aPagesLeft item=iPage}
	<a href="{$aPaging.sBaseUrl}/page{$iPage}">{$iPage}</a>
	{/foreach}
	<a href="{$aPaging.sBaseUrl}/page{$aPaging.iCurrentPage}">{$aPaging.iCurrentPage}</a>
	{foreach from=$aPaging.aPagesRight item=iPage}
	<a href="{$aPaging.sBaseUrl}/page{$iPage}">{$iPage}</a>
	{/foreach}
	{if $aPaging.iCountPage>5}
	<a href="{$aPaging.sBaseUrl}/page{$aPaging.iCountPage}">>> {$aPaging.iCountPage}</a>
	{/if}
]
</span>
{/if}