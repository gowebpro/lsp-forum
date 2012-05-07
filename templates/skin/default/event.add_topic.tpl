{assign var=oTopic value=$oStreamEvent->getTarget()}
{* assign var=oForum value=$oTopic->getForum() *}

{$aLang.plugin.forum.event_add_topic|lower} <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a>