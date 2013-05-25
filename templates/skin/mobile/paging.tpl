{if $aPaging and $aPaging.iCountPage>1}
<div class="pagination">
	{if $aPaging.iPrevPage}
		<a href="{$aPaging.sBaseUrl}/page{$aPaging.iPrevPage}/{$aPaging.sGetParams}" class="pagination-arrow pagination-arrow-prev js-paging-prev-page" title="{$aLang.paging_previos}"><span></span></a>
	{else}
		<div class="pagination-arrow pagination-arrow-prev inactive" title="{$aLang.paging_previos}"><span></span></div>
	{/if}

	{assign var="iPerPage" value={cfg name='module.topic.per_page'}}
	<div class="pagination-current"><span>{$aPaging.iCurrentPage}</span> {$aLang.paging_out_of} {$aPaging.iCountPage}</div>

	{if $aPaging.iNextPage}
		<a href="{$aPaging.sBaseUrl}/page{$aPaging.iNextPage}/{$aPaging.sGetParams}" class="pagination-arrow pagination-arrow-next js-paging-next-page" title="{$aLang.paging_next}"><span></span></a>
	{else}
		<div class="pagination-arrow pagination-arrow-next inactive" title="{$aLang.paging_next}"><span></span></div>
	{/if}
</div>
{/if}