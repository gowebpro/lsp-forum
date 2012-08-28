<div class="fl-r">
	{if $sMenuSubItemSelect == 'show_topic' && $oTopic}
		{if $oForum->getAllowReply()}
			{if !$oTopic->getState()}
				{if $oForum->getQuickReply() && $bFastAnswer && $oUserCurrent}
				<a href="" onclick="return ls.forum.fastReply(this)" class="button">{$aLang.plugin.forum.fast_reply}</a>
				{/if}
				<a href="{$oTopic->getUrlFull()}reply" class="button">{$aLang.plugin.forum.reply}</a>
			{else}
				<a href="" class="button" disabled="disabled">{$aLang.plugin.forum.topic_closed}</a>
			{/if}
		{else}
			<button class="button" disabled="disabled">{$aLang.plugin.forum.reply_not_allow}</button>
		{/if}
	{/if}
	{if $sMenuSubItemSelect == 'show_topic' || $sMenuSubItemSelect == 'show_forum'}
		{if !$oForum->getCanPost()}
			{if $oForum->getAllowStart()}
				<a href="{$oForum->getUrlFull()}add" class="button button-primary">{$aLang.plugin.forum.new_topic}</a>
			{else}
				<button class="button" disabled="disabled">{$aLang.plugin.forum.new_topic_not_allow}</button>
			{/if}
		{/if}
	{/if}
</div>