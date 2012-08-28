{if $oUser}The user <a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>{else}Guest{/if} left a new reply to topic <b>«{$oTopic->getTitle()|escape:'html'}»</b>, you can read it by clicking on <a href="{$oPost->getUrlFull()}">this link</a><br>
{if $oConfig->GetValue('sys.mail.include_comment')}
	Message: <i>{$oPost->getText()}</i>
{/if}

{if $sSubscribeKey}
	<br><br>
	<a href="{router page='subscribe'}unsubscribe/{$sSubscribeKey}/">Unsubscribe from new comments to this topic</a>
{/if}

<br><br>
Best regards, site administration <a href="{cfg name='path.root.web'}">{cfg name='view.name'}</a>