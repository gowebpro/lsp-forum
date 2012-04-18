{foreach from=$aTopics item=oTopic}
	{assign var="oUser" value=$oTopic->getUser()}
	{assign var="oPost" value=$oTopic->getPost()}
	{assign var="oPoster" value=$oPost->getUser()}
	<tr>
		<td class="iconCol">
			<a class="bbl{if $oTopic->getDateRead()<$oPost->getDateAdd()} new{/if}{if $oTopic->getPosition()==1} info{/if}{if $oTopic->getStatus()==1} close{/if}" href="{router page='forum'}topic/{$oTopic->getId()}"></a>
		</td>
		<td class="mainCol">
			<h3 class="clear_fix">
				<a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a>
				{include file="$sTemplatePathPlugin/paging_post.tpl" aPaging=$oTopic->getPaging()}
			</h3>
			<span class="author"><a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></span>
		</td>
		<td class="answers">{$oTopic->getCountPost()}</td>
		<td class="views">{$oTopic->getViews()}</td>
		<td class="lastMsg">
			{if $oPoster}
			<span class="date">{date_format date=$oPost->getDateAdd() format='d.m.Y, H:i'}</span>
			<span class="author">{$aLang.forum_post_by} <a href="{$oPoster->getUserWebPath()}">{$oPoster->getLogin()}</a></span>
			<a class="linkToMsg" href="{router page='forum'}topic/{$oTopic->getId()}/lastpost/"></a>
			{/if}
		</td>
	</tr>
{/foreach}