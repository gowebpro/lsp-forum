{if $oUser}Пользователь <a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>{else}Гость{/if} ответил на ваше сообщение в теме <b>«{$oTopic->getTitle()|escape:'html'}»</b>, прочитать его можно перейдя по <a href="{$oPost->getUrlFull()}">этой ссылке</a><br>

<br><br>
С уважением, администрация сайта <a href="{cfg name='path.root.web'}">{cfg name='view.name'}</a>