{if $aPaging and $aPaging.iCountPage>1}
<div class="forumNav">
	<div class="numbers">
		{if $aPaging.iCurrentPage>1}
		<a href="{$aPaging.sBaseUrl}">&larr;</a>
		{/if}
		{foreach from=$aPaging.aPagesLeft item=iPage}
		<a href="{$aPaging.sBaseUrl}/page{$iPage}">{$iPage}</a>
		{/foreach}
		{$aPaging.iCurrentPage}
		{foreach from=$aPaging.aPagesRight item=iPage}
		<a href="{$aPaging.sBaseUrl}/page{$iPage}">{$iPage}</a>
		{/foreach}
		{if $aPaging.iCurrentPage<$aPaging.iCountPage}
		<a href="{$aPaging.sBaseUrl}/page{$aPaging.iCountPage}">{$aLang.paging_last}</a>
		{/if}
	</div>
</div>
{/if}