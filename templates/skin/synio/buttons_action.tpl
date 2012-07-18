<div class="fl-r">
{if $oUserCurrent}
	{if $sMenuSubItemSelect == 'show_topic' && $oTopic}
		{if !$oTopic->getState()}
			{if $oForum->getQuickReply() && $bFastAnswer}
			<button class="button" onclick="return ls.forum.fastReply(this)">{$aLang.plugin.forum.fast_reply}</button>
			{/if}
			<a href="{$oTopic->getUrlFull()}reply"><button class="button">{$aLang.plugin.forum.reply}</button></a>
		{else}
			<button class="button" disabled="disabled">{$aLang.plugin.forum.topic_closed}</button>
		{/if}
	{/if}
	{if $sMenuSubItemSelect == 'show_topic' || $sMenuSubItemSelect == 'show_forum'}
		{if $oForum->getCanPost() == 0}
			<a href="{$oForum->getUrlFull()}add"><button class="button button-primary">{$aLang.plugin.forum.new_topic}</button></a>
		{/if}
	{/if}
{else}
	{if $sMenuSubItemSelect == 'show_topic'}
	<button class="button" disabled="disabled">{$aLang.plugin.forum.reply_not_allow}</button>
	{/if}
	{if $sMenuSubItemSelect == 'show_forum'}
	<button class="button" disabled="disabled">{$aLang.plugin.forum.new_topic_not_allow}</button>
	{/if}
{/if}
</div>