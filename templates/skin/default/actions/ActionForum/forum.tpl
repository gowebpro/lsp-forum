{assign var="noSidebar" value=true}
{include file='header.tpl'}

{assign var='aSubForums' value=$oForum->getChildren()}

<h2 class="page-header">{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>

{if $aSubForums}
	<div class="forums">
		<section class="forums-list">
			<header class="forums-header">
				<h3><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a></h3>
			</header>
			<div class="forums-content">
				{include file="$sTemplatePathPlugin/forums_list.tpl" aForums=$aSubForums}
			</div>
		</section>
	</div>
{/if}

{if $oForum->getCanPost() == 0}
	<div class="controllers clear_fix">
		{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging sAlign='left'}
		{include file="$sTemplatePathPlugin/buttons_action.tpl" sAlign='right'}
	</div>

	<div class="forums">
		<section class="forums-list">
			<header class="forums-header">
				<h3>{$oForum->getTitle()}</h3>
			</header>
			<div class="forums-content">
				{include file="$sTemplatePathPlugin/topics.tpl"}
			</div>
		</section>
	</div>

	<div class="controllers clear_fix">
		{include file="$sTemplatePathPlugin/paging.tpl" aPaging=$aPaging sAlign='left'}
		{include file="$sTemplatePathPlugin/buttons_action.tpl" sAlign='right'}
	</div>
{/if}

{include file='footer.tpl'}