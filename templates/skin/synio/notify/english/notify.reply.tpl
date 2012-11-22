{if $oUser}The user <a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>{else}Guest{/if} replied to your message in topic <b>«{$oTopic->getTitle()|escape:'html'}»</b>, you can read the reply by clicking on the <a href="{$oPost->getUrlFull()}">link</a><br>

<br><br>
Best regards, site administration <a href="{cfg name='path.root.web'}">{cfg name='view.name'}</a>