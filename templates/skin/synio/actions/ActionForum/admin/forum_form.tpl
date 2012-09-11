{assign var="noSidebar" value=true}
{include file='header.tpl'}

{if $sNewType != 'category' && !$aForums}
	{assign var="sNewType" value='category'}
{/if}

<h2 class="page-header">
	<a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span>
	<a href="{router page='forum'}admin/forums">{$aLang.plugin.forum.forums}</a> <span>&raquo;</span>
	{if $sType == 'edit'}
		{$aLang.plugin.forum["edit_"|cat:$sNewType]}
	{else}
		{$aLang.plugin.forum["create_"|cat:$sNewType]}
	{/if}
</h2>

{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}

<div class="forums">
	<header class="forums-header">
	{if $sType == 'edit'}
		<h3>{$aLang.plugin.forum["edit_"|cat:$sNewType]} &laquo;{$_aRequest.forum_title}&raquo;</h3>
	{else}
		<h3>{$aLang.plugin.forum["create_"|cat:$sNewType]}</h3>
	{/if}
	</header>

	<form action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
		<input type="hidden" name="forum_type" value="{$sNewType}" />

		<table class="table table-forum-admin">
			<tr>
				<th colspan="2" class="cell-subtitle ta-c">
					{$aLang.plugin.forum.create_block_main}
				</th>
			</tr>

			<tr>
				<td class="cell-label">
					<label for="forum_title">{$aLang.plugin.forum.create_title}:</label>
					<span class="note"> </span>
				</td>
				<td class="cell-labeled">
					<input type="text" id="forum_title" name="forum_title" value="{$_aRequest.forum_title}" class="input-text input-width-full" />
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_url">{$aLang.plugin.forum.create_url}:</label>
					<span class="note">{$aLang.plugin.forum.create_url_note}</span>
				</td>
				<td class="cell-labeled">
					<input type="text" id="forum_url" name="forum_url" value="{$_aRequest.forum_url}" class="input-text input-width-full" />
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_sort">{$aLang.plugin.forum.create_sort}:</label>
					<span class="note">{$aLang.plugin.forum.create_sort_notice}</span>
				</td>
				<td class="cell-labeled">
					<input type="text" id="forum_sort" name="forum_sort" value="{$_aRequest.forum_sort|default:'0'}" class="input-text input-width-full" />
				</td>
			</tr>

			{if $sNewType != 'category'}
			<tr>
				<td class="cell-label">
					<label for="forum_description">{$aLang.plugin.forum.create_description}:</label>
					<span class="note"></span>
				</td>
				<td class="cell-labeled">
					<textarea id="forum_description" name="forum_description" rows="5" class="input-text input-width-full">{$_aRequest.forum_description}</textarea>
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_parent">{$aLang.plugin.forum.create_parent}:</label>
					<span class="note"></span>
				</td>
				<td class="cell-labeled">
					<select id="forum_parent" name="forum_parent">
					{foreach from=$aForumsList item=aItem}
						<option value="{$aItem.id}"{if $_aRequest.forum_parent==$aItem.id} selected{/if}>{$aItem.title}</option>
					{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_type">{$aLang.plugin.forum.create_type}:</label>
					<span class="note">{$aLang.plugin.forum.create_type_notice}</span>
				</td>
				<td class="cell-labeled">
					<select id="forum_type" name="forum_type">
						<option value="1"{if $_aRequest.forum_type=='1'} selected{/if}>{$aLang.plugin.forum.create_type_active}</option>
						<option value="0"{if $_aRequest.forum_type=='0'} selected{/if}>{$aLang.plugin.forum.create_type_archive}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_sub_can_post">{$aLang.plugin.forum.create_sub_can_post}:</label>
					<span class="note">{$aLang.plugin.forum.create_sub_can_post_notice}</span>
				</td>
				<td class="cell-labeled">
					<label><input type="radio" class="radio" name="forum_sub_can_post" id="forum_sub_can_post_yes" value="1"{if $_aRequest.forum_sub_can_post=='1'} checked{/if}> Yes</label>
					<label><input type="radio" class="radio" name="forum_sub_can_post" id="forum_sub_can_post_no" value="0"{if !$_aRequest.forum_sub_can_post || $_aRequest.forum_sub_can_post=='0'} checked{/if}> No</label>
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_quick_reply">{$aLang.plugin.forum.create_quick_reply}:</label>
					<span class="note">{$aLang.plugin.forum.create_quick_reply_notice}</span>
				</td>
				<td class="cell-labeled">
					<label><input type="radio" class="radio" name="forum_quick_reply" id="forum_quick_reply_yes" value="1"{if !$_aRequest.forum_quick_reply || $_aRequest.forum_quick_reply=='1'} checked{/if}> Yes</label>
					<label><input type="radio" class="radio" name="forum_quick_reply" id="forum_quick_reply_no" value="0"{if $_aRequest.forum_quick_reply=='0'} checked{/if}> No</label>
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_password">{$aLang.plugin.forum.create_password}:</label>
					<span class="note">{$aLang.plugin.forum.create_password_notice}</span>
				</td>
				<td class="cell-labeled">
					<input type="text" id="forum_password" name="forum_password" value="{$_aRequest.forum_password}" class="input-text input-width-200" />
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_limit_rating_topic">{$aLang.plugin.forum.create_rating}:</label>
					<span class="note">{$aLang.plugin.forum.create_rating_notice}</span>
				</td>
				<td class="cell-labeled">
					<input type="text" id="forum_limit_rating_topic" name="forum_limit_rating_topic" value="{$_aRequest.forum_limit_rating_topic|default:$oConfig->Get('plugin.forum.acl.create.topic.rating')}" class="input-text input-width-100" />
				</td>
			</tr>

			<tr>
				<th colspan="2" class="cell-subtitle ta-c">
					{$aLang.plugin.forum.create_block_redirect}
				</th>
			</tr>

			<tr>
				<td class="cell-label">
					<label for="forum_redirect_url">{$aLang.plugin.forum.create_redirect_url}:</label>
					<span class="note">{$aLang.plugin.forum.create_redirect_url_notice}</span>
				</td>
				<td class="cell-labeled">
					<input type="text" id="forum_redirect_url" name="forum_redirect_url" value="{$_aRequest.forum_redirect_url}" class="input-text input-width-full" />
				</td>
			</tr>
			<tr>
				<td class="cell-label">
					<label for="forum_redirect_on">{$aLang.plugin.forum.create_redirect_on}:</label>
					<span class="note">{$aLang.plugin.forum.create_redirect_on_notice}</span>
				</td>
				<td class="cell-labeled">
					<label><input type="radio" class="radio" name="forum_redirect_on" id="forum_redirect_on_yes" value="1"{if $_aRequest.forum_redirect_on=='1'} checked{/if}> Yes</label>
					<label><input type="radio" class="radio" name="forum_redirect_on" id="forum_redirect_on_no" value="0"{if !$_aRequest.forum_redirect_on || $_aRequest.forum_redirect_on=='0'} checked{/if}> No</label>
				</td>
			</tr>
			{/if}

			<tr>
				<th colspan="2">
					<div class="ta-c">
						{if $sType == 'edit'}
						<button type="submit" name="submit_forum_save" class="button">{$aLang.plugin.forum.edit_submit}</button>
						{else}
						<button type="submit" name="submit_forum_add" class="button button-primary">{$aLang.plugin.forum.create_submit}</button>
						{/if}
					</div>
				</th>
			</tr>
		</table>
	</form>
</div>

{include file='footer.tpl'}