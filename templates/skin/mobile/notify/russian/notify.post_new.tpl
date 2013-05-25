{if $oUser}Пользователь <a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>{else}Гость{/if} оставил новый ответ в теме <b>«{$oTopic->getTitle()|escape:'html'}»</b>, прочитать его можно перейдя по <a href="{$oPost->getUrlFull()}">этой ссылке</a><br>
{if $oConfig->GetValue('sys.mail.include_comment')}
	Текст сообщения: <i>{$oPost->getText()}</i>
{/if}

{if $sSubscribeKey}
	<br><br>
	<a href="{router page='subscribe'}unsubscribe/{$sSubscribeKey}/">Отписаться от новых ответов к этой теме</a>
{/if}

<br><br>
С уважением, администрация сайта <a href="{cfg name='path.root.web'}">{cfg name='view.name'}</a>