{assign var=oPost value=$oStreamEvent->getTarget()}
{assign var=oTopic value=$oPost->getTopic()}

{$aLang.plugin.forum.event_add_post|lower} <a href="{$oPost->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a>
<div class="stream-comment-preview">{$oPost->getText()|strip_tags|truncate:200}</div>