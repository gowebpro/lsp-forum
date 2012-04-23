<div class="{if $sAlign=='left'}fl-l{elseif $sAlign=='right'}fl-r{/if}">
{if $oUserCurrent}
	{if $sMenuSubItemSelect == 'show_topic' && $oTopic}
		{if !$oTopic->getState()}
			{if $oForum->getQuickReply() && $bFastAnswer}
			<button class="button" onclick="return Forum.fastReply({$oTopic->getId()},this)">{$aLang.forum_fast_reply}</button>
			{/if}
			<a href="{$oTopic->getUrlFull()}reply"><button class="button">{$aLang.forum_reply}</button></a>
		{else}
			<button class="button button-disabled">{$aLang.forum_topic_closed}</button>
		{/if}
	{/if}
	{if $sMenuSubItemSelect == 'show_topic' || $sMenuSubItemSelect == 'show_forum'}
		{if $oForum->getCanPost() == 0}
			<a href="{$oForum->getUrlFull()}add"><button class="button button-primary">{$aLang.forum_new_topic}</button></a>
		{/if}
	{/if}
{else}
	{if $sMenuSubItemSelect == 'show_topic'}
	<button class="button button-disabled">{$aLang.forum_reply_not_allow}</button>
	{/if}
	{if $sMenuSubItemSelect == 'show_forum'}
	<button class="button button-disabled">{$aLang.forum_new_topic_not_allow}</button>
	{/if}
{/if}
</div>