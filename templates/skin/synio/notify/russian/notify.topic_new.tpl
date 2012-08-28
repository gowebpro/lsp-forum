{if $oUser}Пользователь <a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>{else}Гость{/if} открыл в форуме <b>«{$oForum->getTitle()|escape:'html'}»</b> новую тему -  <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a><br>

<br><br>
С уважением, администрация сайта <a href="{cfg name='path.root.web'}">{cfg name='view.name'}</a>