{if count($aForums) > 0}
	<table class="forumBody">
		{foreach from=$aForums item=oForum}
			{assign var="oTopic" value=$oForum->getTopic()}
			{assign var="oPost" value=$oForum->getPost()}
			{assign var="oUser" value=$oForum->getUser()}
			{assign var='aSubForums' value=$oForum->getChildren()}
			<tr>
				<td class="iconCol">
					<a class="bbl{if $oTopic && $oTopic->getDateRead()<=$oPost->getDateAdd()} new{/if}" href="{$oForum->getUrlFull()}"></a>
				</td>
				<td class="mainCol">
					<h3><a href="{$oForum->getUrlFull()}">{$oForum->getTitle()}</a></h3>
					<p class="details">{$oForum->getDescription()|escape:'html'|nl2br}</p>
					{if $aSubForums}
					<p class="details">
						<strong>{$aLang.forum_subforums}:</strong>
						{foreach from=$aSubForums item=oSubForum name=subforums}
						<a href="{$oSubForum->getUrlFull()}">{$oSubForum->getTitle()}</a>{if !$smarty.foreach.subforums.last}, {/if}
						{/foreach}
					</p>
					{/if}
				</td>
				<td class="lastMsg">
				{if $oForum->getRedirectOn()}
					{$aLang.forum_redirect_hits}: {$oForum->getRedirectHits()}
				{else}
					{if $oTopic && $oPost}
					<a class="subj" href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>
					<a class="linkToMsg" href="{router page='forum'}topic/{$oTopic->getId()}/lastpost/"></a><br />
					<a class="author" href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
					<span class="date">@ {date_format date=$oPost->getDateAdd()}</span>
					{/if}
				{/if}
				</td>
				<td class="answers">{if $oForum->getRedirectOn()}--{else}{$oForum->getCountPost()}{/if}</td>
				<td class="views">{if $oForum->getRedirectOn()}--{else}{$oForum->getCountTopic()}{/if}</td>
			</tr>
		{/foreach}
	</table>
{else}
	<div align="center">{$aLang.forums_no}</div>
{/if}