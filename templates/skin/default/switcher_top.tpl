{if $oUserCurrent}
<div class="clear_fix">
	<ul class="switcher">
		{if $sMenuSubItemSelect == 'show_topic'}
			{if $oTopic->getStatus()!=1 || $oUserCurrent->isAdministrator()}
				{if $oConfig->GetValue('plugin.forum.fast_reply')}
				<li><a href="{$oTopic->getUrlFull()}reply" onclick="return ls.forum.fastReply({$oTopic->getId()},this)">{$aLang.forum_fast_reply}</a></li>
				{/if}
				<li{if $sMenuSubItemSelect=='reply'} class="active"{/if}><a href="{$oTopic->getUrlFull()}reply">{$aLang.forum_reply}</a></li>
			{/if}
		{/if}
		{if $sMenuSubItemSelect == 'show_topic' || $sMenuSubItemSelect == 'show_forum'}
			{if $oForum->getCanPost() == 0}
				<li{if $sMenuSubItemSelect=='add'} class="active"{/if}><a href="{$oForum->getUrlFull()}add">{$aLang.forum_new_topic}</a></li>
			{/if}
		{/if}
	</ul>
</div>
{/if}
