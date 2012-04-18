{assign var="noSidebar" value=true}
{include file='header.tpl'}

<div class="forum">
	<div class="forumNav">
		<h2>
			<span><a href="{router page='forum'}admin">{$aLang.forum_acp}</a></span>
			<span><a href="{router page='forum'}admin/forums">{$aLang.forums}</a></span>
			{if $sType == 'edit'}
				{$aLang["forum_edit_"|cat:$sNewType]}
			{else}
				{$aLang["forum_create_"|cat:$sNewType]}
			{/if}
		</h2>
	</div>

	<div class="forumBblock">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_create}</h2>
			</div>
			<div class="rightBg"></div>
		</div>

		<div class="fastAnswer clear_fix">
			<div class="fastAnswerForm">
			{if $sNewType != 'category' && !$aForums}
				{$aLang.forum_create_warning}
			{else}
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
					<input type="hidden" name="forum_type" value="{$sNewType}" />

					<table class="forumBody">
						<tr>
							<td colspan="2" align="center">
								<h3>{$aLang.forum_create_block_main}</h3>
							</td>
						</tr>
						<tr>
							<td width="400">
								<label for="forum_title">{$aLang.forum_create_title}:</label>
								<br /><span class="note"> </span>
							</td>
							<td>
								<input type="text" id="forum_title" name="forum_title" value="{$_aRequest.forum_title}" class="input-wide" />
							</td>
						</tr>
						<tr>
							<td width="400">
								<label for="forum_url">{$aLang.forum_create_url}:</label><br />
								<span class="note">{$aLang.forum_create_url_note}</span>
							</td>
							<td>
								<input type="text" id="forum_url" name="forum_url" value="{$_aRequest.forum_url}" class="input-wide" />
							</td>
						</tr>
						<tr>
							<td width="400">
								<label for="forum_sort">{$aLang.forum_create_sort}:</label><br />
								<span class="note">{$aLang.forum_create_sort_notice}</span>
							</td>
							<td class="row1">
								<input type="text" id="forum_sort" name="forum_sort" value="{$_aRequest.forum_sort}" class="input-wide" />
							</td>
						</tr>
						{if $sNewType != 'category'}
						<tr>
							<td width="400">
								<label for="forum_description">{$aLang.forum_create_description}:</label><br />
								<span class="note"></span>
							</td>
							<td>
								<textarea id="forum_description" name="forum_description" class="input-wide">{$_aRequest.forum_description}</textarea>
							</td>
						</tr>
						<tr>
							<td width="400">
								<label for="forum_parent">{$aLang.forum_create_parent}:</label><br />
								<span class="note"></span>
							</td>
							<td>
								<select id="forum_parent" name="forum_parent">
								{foreach from=$aForumsList item=aItem}
									<option value="{$aItem.id}"{if $_aRequest.forum_parent==$aItem.id} selected{/if}>{$aItem.title}</option>
								{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td width="400">
								<label for="forum_sub_can_post">{$aLang.forum_create_sub_can_post}:</label><br />
								<span class="note">{$aLang.forum_create_sub_can_post_notice}</span>
							</td>
							<td>
								<label><input type="radio" class="radio" name="forum_sub_can_post" id="forum_sub_can_post_yes" value="1"{if $_aRequest.forum_sub_can_post=='1'} checked{/if}> Yes</label>
								<label><input type="radio" class="radio" name="forum_sub_can_post" id="forum_sub_can_post_no" value="0"{if !$_aRequest.forum_sub_can_post || $_aRequest.forum_sub_can_post=='0'} checked{/if}> No</label>
							</td>
						</tr>

						<tr>
							<td colspan="2" align="center">
								<h3>{$aLang.forum_create_block_redirect}</h3>
							</td>
						</tr>
						<tr>
							<td width="400">
								<label for="forum_redirect_url">{$aLang.forum_create_forum_redirect_url}:</label><br />
								<span class="note">{$aLang.forum_create_forum_redirect_url_notice}</span>
							</td>
							<td>
								<input type="text" id="forum_redirect_url" name="forum_redirect_url" value="{$_aRequest.forum_redirect_url}" class="input-wide" />
							</td>
						</tr>
						<tr>
							<td width="400">
								<label for="forum_redirect_on">{$aLang.forum_create_forum_redirect_on}:</label><br />
								<span class="note">{$aLang.forum_create_forum_redirect_on_notice}</span>
							</td>
							<td>
								<label><input type="radio" class="radio" name="forum_redirect_on" id="forum_redirect_on_yes" value="1"{if $_aRequest.forum_redirect_on=='1'} checked{/if}> Yes</label>
								<label><input type="radio" class="radio" name="forum_redirect_on" id="forum_redirect_on_no" value="0"{if !$_aRequest.forum_redirect_on || $_aRequest.forum_redirect_on=='0'} checked{/if}> No</label>
							</td>
						</tr>
						{/if}
						<tr>
							<td colspan="2">
								<div class="buttons">
									{if $sType == 'edit'}
									<input type="submit" name="submit_forum_save" value="{$aLang.forum_edit_submit}" />
									{else}
									<input type="submit" name="submit_forum_add" value="{$aLang.forum_create_submit}" />
									{/if}
								</div>
							</td>
						</tr>
					</table>
				</form>
				{/if}
			</div>
		</div>
	</div>
</div>

{include file='footer.tpl'}