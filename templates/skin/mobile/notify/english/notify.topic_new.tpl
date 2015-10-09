{if $oUser}The user <a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()|escape:'html'}</a>{else}Guest{/if} posted a new topic - <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a><br> in a forum <b>«{$oForum->getTitle()|escape:'html'}»</b>

<br><br>
Best regards, site administration <a href="{cfg name='path.root.web'}">{cfg name='view.name'}</a>