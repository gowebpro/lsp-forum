<div class="fl-r">
{if $oUserCurrent}
	{if $sMenuSubItemSelect == 'show_topic' && $oTopic}
		{if !$oTopic->getState()}
			{if $oForum->getQuickReply() && $bFastAnswer}
			<a href="" onclick="return ls.forum.fastReply(this)" class="button">{$aLang.plugin.forum.fast_reply}</a>
			{/if}
			<a href="{$oTopic->getUrlFull()}reply" class="button">{$aLang.plugin.forum.reply}</a>
		{else}
			<a href="" class="button" disabled="disabled">{$aLang.plugin.forum.topic_closed}</a>
		{/if}
	{/if}
	{if $sMenuSubItemSelect == 'show_topic' || $sMenuSubItemSelect == 'show_forum'}
		{if $oForum->getCanPost() == 0}
			<a href="{$oForum->getUrlFull()}add" class="button button-primary">{$aLang.plugin.forum.new_topic}</a>
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