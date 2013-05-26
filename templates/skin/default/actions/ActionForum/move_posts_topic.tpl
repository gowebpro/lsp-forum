{include file='header.tpl' noSidebar=true}
{include file="$sTemplatePathForum/modals/modal.post_anchor.tpl"}

<script type="text/javascript">
	jQuery(document).ready(function($){
		ls.lang.load({lang_load name="plugin.forum.select_topic"});
		ls.forum.initSelect();
	});
</script>

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">{$aLang.plugin.forum.topic_move_posts} <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a></h4>

<form action="" method="POST" enctype="multipart/form-data" id="form_posts_list">
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

	<div class="js-forum-select">
		<label>
			{$aLang.plugin.forum.topic_move_posts_for}
		</label>
		<p>
			<select class="js-select-forum input-width-300" name="forum_id">
				<option value="">{$aLang.plugin.forum.select_forum}</option>
				{if $aForumsList}
					{foreach from=$aForumsList item=aItem}
						<option value="{$aItem.id}"{if $_aRequest.forum_id==$aItem.id} selected{/if}>{$aItem.title}</option>
					{/foreach}
				{/if}
			</select>
		</p>
		<p>
			<select class="js-select-topic input-width-300" name="topic_id"{if !$aTopicList} style="display:none"{/if}>
				<option value="">{$aLang.plugin.forum.select_topic}</option>
				{if $aTopicList}
					{foreach from=$aTopicList item=oTopic}
						<option value="{$oTopic->getId()}"{if $_aRequest.topic_id==$oTopic->getId()} selected{/if}>{$oTopic->getTitle()}</option>
					{/foreach}
				{/if}
			</select>
		</p>
	</div>
	<button type="submit" name="submit_topic_move_posts" class="button button-primary">{$aLang.plugin.forum.topic_move_posts}</button>

	<div class="forums">
		<table class="table table-forum-admin">
			<thead>
				<tr>
					<th class="cell-checkbox"><input type="checkbox" name="" onclick="ls.tools.checkAll('form_posts_checkbox', this, true);" /></th>
					<th>{$aLang.plugin.forum.header_author}</th>
					<th>{$aLang.plugin.forum.post}</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$aPosts item=oPost name=posts}
					{assign var="oUser" value=$oPost->getUser()}
					<tr>
						<td class="cell-checkbox">
							<input type="checkbox" name="posts[{$oPost->getId()}]" class="form_posts_checkbox" {if $oPost->getId() == $oTopic->getFirstPostId()} disabled="disabled" {/if} />
						</td>
						<td>
							{if $oUser}
								<a href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a>
							{else}
								{$aLang.plugin.forum.guest_prefix}{$oPost->getGuestName()}
							{/if}
							(<a href="{$oPost->getUrlFull()}" name="post-{$oPost->getId()}" onclick="return ls.forum.linkToPost({$oPost->getId()})">#{$oPost->getNumber()}</a>)
						</td>
						<td>
							{$oPost->getText()|strip_tags|truncate:100:'...'|escape:'html'}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</form>

{include file='footer.tpl'}