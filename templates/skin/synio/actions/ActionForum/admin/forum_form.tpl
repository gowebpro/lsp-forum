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

{include file="$sTemplatePathForum/menu.forum.admin.tpl"}

<div class="forums">
	<div class="fBox forum-acp">
		<header class="forums-header">
		{if $sType == 'edit'}
			<h3>{$aLang.plugin.forum["edit_"|cat:$sNewType]} &laquo;{$_aRequest.forum_title|escape:'html'}&raquo;</h3>
		{else}
			<h3>{$aLang.plugin.forum["create_"|cat:$sNewType]}</h3>
		{/if}
		</header>

		<div class="forums-content">
			<div class="fContainer">
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
					<input type="hidden" name="f_type" value="{$sNewType}" />

					<table class="table table-forum-admin">
						<tr>
							<th colspan="2" class="cell-subtitle">
								{$aLang.plugin.forum.create_block_main}
							</th>
						</tr>

						<tr>
							<td class="cell-label">
								<label for="forum_title"><strong>{$aLang.plugin.forum.create_title}:</strong></label>
							</td>
							<td class="cell-labeled">
								<input type="text" id="forum_title" name="forum_title" value="{$_aRequest.forum_title|escape:'html'}" class="input-text input-width-full" />
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_url"><strong>{$aLang.plugin.forum.create_url}:</strong></label>
							</td>
							<td class="cell-labeled">
								<input type="text" id="forum_url" name="forum_url" value="{$_aRequest.forum_url|escape:'html'}" class="input-text input-width-full" />
								<span class="note">{$aLang.plugin.forum.create_url_note}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_sort"><strong>{$aLang.plugin.forum.create_sort}:</strong></label>
							</td>
							<td class="cell-labeled">
								<input type="text" id="forum_sort" name="forum_sort" value="{$_aRequest.forum_sort|default:'0'|escape:'html'}" class="input-text input-width-100" />
								<span class="note">{$aLang.plugin.forum.create_sort_notice}</span>
							</td>
						</tr>

						{if $sNewType != 'category'}
						<tr>
							<td class="cell-label">
								<label for="forum_description"><strong>{$aLang.plugin.forum.create_description}:</strong></label>
							</td>
							<td class="cell-labeled">
								<textarea id="forum_description" name="forum_description" rows="5" class="input-text input-width-full">{$_aRequest.forum_description|escape:'html'}</textarea>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_parent"><strong>{$aLang.plugin.forum.create_parent}:</strong></label>
							</td>
							<td class="cell-labeled">
								<select id="forum_parent" name="forum_parent">
								{foreach from=$aForumsList item=aItem}
									<option value="{$aItem.id}"{if $_aRequest.forum_parent==$aItem.id} selected{/if}>{$aItem.title|escape:'html'}</option>
								{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_perms"><strong>{$aLang.plugin.forum.create_perms}:</strong></label>
							</td>
							<td class="cell-labeled">
								<select id="forum_perms" name="forum_perms">
									<option value="">{$aLang.plugin.forum.create_perms_not}</option>
								{foreach from=$aForumsList item=aItem}
									<option value="{$aItem.id}"{if $_aRequest.forum_perms==$aItem.id} selected{/if}>{$aItem.title}</option>
								{/foreach}
								</select>
								<br><span class="note">{$aLang.plugin.forum.create_perms_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_password"><strong>{$aLang.plugin.forum.create_password}:</strong></label>
							</td>
							<td class="cell-labeled">
								<input type="text" id="forum_password" name="forum_password" value="{$_aRequest.forum_password|escape:'html'}" class="input-text input-width-200" />
								<span class="note">{$aLang.plugin.forum.create_password_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_limit_rating_topic"><strong>{$aLang.plugin.forum.create_rating}:</strong></label>
							</td>
							<td class="cell-labeled">
								<input type="text" id="forum_limit_rating_topic" name="forum_limit_rating_topic" value="{$_aRequest.forum_limit_rating_topic|default:$oConfig->Get('plugin.forum.acl.create.topic.rating')|escape:'html'}" class="input-text input-width-100" />
								<span class="note">{$aLang.plugin.forum.create_rating_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_icon"><strong>{$aLang.plugin.forum.create_icon}:</strong></label>
							</td>
							<td class="cell-labeled">
								{if $oForumEdit and $oForumEdit->getIcon()}
								<div class="avatar-edit">
									{foreach from=$oConfig->GetValue('plugin.forum.icon_size') item=iSize}
										{if $iSize}<img src="{$oForumEdit->getIconPath({$iSize})}">{/if}
									{/foreach}
									<label><input type="checkbox" id="forum_icon_delete" name="forum_icon_delete" value="on" class="input-checkbox"> {$aLang.plugin.forum.create_icon_delete}</label>
								</div>
								{/if}
								<input type="file" name="forum_icon" id="forum_icon">
								<span class="note">{$aLang.plugin.forum.create_icon_notice}</span>
							</td>
						</tr>

						<tr>
							<th colspan="2" class="cell-subtitle">
								{$aLang.plugin.forum.create_block_options}
							</th>
						</tr>

						<tr>
							<td class="cell-label">
								<label for="forum_type"><strong>{$aLang.plugin.forum.create_type}:</strong></label>
							</td>
							<td class="cell-labeled">
								<select id="forum_type" name="forum_type">
									<option value="1"{if $_aRequest.forum_type=='1'} selected{/if}>{$aLang.plugin.forum.create_type_active}</option>
									<option value="0"{if $_aRequest.forum_type=='0'} selected{/if}>{$aLang.plugin.forum.create_type_archive}</option>
								</select>
								<span class="note">{$aLang.plugin.forum.create_type_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_sub_can_post"><strong>{$aLang.plugin.forum.create_sub_can_post}:</strong></label>
							</td>
							<td class="cell-labeled">
								<span class="yesno_yes">
									<label><input type="radio" class="radio" name="forum_sub_can_post" id="forum_sub_can_post_yes" value="1"{if $_aRequest.forum_sub_can_post=='1'} checked{/if}> Yes</label>
								</span><span class="yesno_no">
									<label><input type="radio" class="radio" name="forum_sub_can_post" id="forum_sub_can_post_no" value="0"{if !$_aRequest.forum_sub_can_post || $_aRequest.forum_sub_can_post=='0'} checked{/if}> No</label>
								</span>
								<span class="note">{$aLang.plugin.forum.create_sub_can_post_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_quick_reply"><strong>{$aLang.plugin.forum.create_quick_reply}:</strong></label>
							</td>
							<td class="cell-labeled">
								<span class="yesno_yes">
									<label><input type="radio" class="radio" name="forum_quick_reply" id="forum_quick_reply_yes" value="1"{if !$_aRequest.forum_quick_reply || $_aRequest.forum_quick_reply=='1'} checked{/if}> Yes</label>
								</span><span class="yesno_no">
									<label><input type="radio" class="radio" name="forum_quick_reply" id="forum_quick_reply_no" value="0"{if $_aRequest.forum_quick_reply=='0'} checked{/if}> No</label>
								</span>
								<span class="note">{$aLang.plugin.forum.create_quick_reply_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_display_subforum_list"><strong>{$aLang.plugin.forum.create_display_subforum_list}:</strong></label>
							</td>
							<td class="cell-labeled">
								<span class="yesno_yes">
									<label><input type="radio" class="radio" name="forum_display_subforum_list" id="forum_display_subforum_list_yes" value="1"{if $_aRequest.forum_display_subforum_list=='1'} checked{/if}> Yes</label>
								</span><span class="yesno_no">
									<label><input type="radio" class="radio" name="forum_display_subforum_list" id="forum_display_subforum_list_no" value="0"{if !$_aRequest.forum_display_subforum_list || $_aRequest.forum_display_subforum_list=='0'} checked{/if}> No</label>
								</span>
								<span class="note">{$aLang.plugin.forum.create_display_subforum_list_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_display_on_index"><strong>{$aLang.plugin.forum.create_display_on_index}:</strong></label>
							</td>
							<td class="cell-labeled">
								<span class="yesno_yes">
									<label><input type="radio" class="radio" name="forum_display_on_index" id="forum_display_on_index_yes" value="1"{if $_aRequest.forum_display_on_index=='1'} checked{/if}> Yes</label>
								</span><span class="yesno_no">
									<label><input type="radio" class="radio" name="forum_display_on_index" id="forum_display_on_index_no" value="0"{if !$_aRequest.forum_display_on_index || $_aRequest.forum_display_on_index=='0'} checked{/if}> No</label>
								</span>
								<span class="note">{$aLang.plugin.forum.create_display_on_index_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_topics_per_page"><strong>{$aLang.plugin.forum.create_topics_per_page}:</strong></label>
							</td>
							<td class="cell-labeled">
								<input type="text" id="forum_topics_per_page" name="forum_topics_per_page" value="{$_aRequest.forum_topics_per_page|default:0|escape:'html'}" class="input-text input-width-100" />
								<span class="note">{$aLang.plugin.forum.create_topics_per_page_notice|ls_lang:"default%%`$oConfig->Get('plugin.forum.topic_per_page')`"}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_posts_per_page"><strong>{$aLang.plugin.forum.create_posts_per_page}:</strong></label>
							</td>
							<td class="cell-labeled">
								<input type="text" id="forum_posts_per_page" name="forum_posts_per_page" value="{$_aRequest.forum_posts_per_page|default:0|escape:'html'}" class="input-text input-width-100" />
								<span class="note">{$aLang.plugin.forum.create_posts_per_page_notice|ls_lang:"default%%`$oConfig->Get('plugin.forum.post_per_page')`"}</span>
							</td>
						</tr>

						<tr>
							<th colspan="2" class="cell-subtitle">
								{$aLang.plugin.forum.create_block_redirect}
							</th>
						</tr>

						<tr>
							<td class="cell-label">
								<label for="forum_redirect_url"><strong>{$aLang.plugin.forum.create_redirect_url}:</strong></label>
							</td>
							<td class="cell-labeled">
								<input type="text" id="forum_redirect_url" name="forum_redirect_url" value="{$_aRequest.forum_redirect_url|escape:'html'}" class="input-text input-width-full" />
								<span class="note">{$aLang.plugin.forum.create_redirect_url_notice}</span>
							</td>
						</tr>
						<tr>
							<td class="cell-label">
								<label for="forum_redirect_on"><strong>{$aLang.plugin.forum.create_redirect_on}:</strong></label>
							</td>
							<td class="cell-labeled">
								<span class="yesno_yes">
									<label><input type="radio" class="radio" name="forum_redirect_on" id="forum_redirect_on_yes" value="1"{if $_aRequest.forum_redirect_on=='1'} checked{/if}> Yes</label>
								</span><span class="yesno_no">
									<label><input type="radio" class="radio" name="forum_redirect_on" id="forum_redirect_on_no" value="0"{if !$_aRequest.forum_redirect_on || $_aRequest.forum_redirect_on=='0'} checked{/if}> No</label>
								</span>
								<span class="note">{$aLang.plugin.forum.create_redirect_on_notice}</span>
							</td>
						</tr>
						{/if}

						<tr>
							<th colspan="2">
								<div class="ta-c">
									{if $sType == 'edit'}
									<button type="submit" name="submit_forum_save" class="button button-orange">{$aLang.plugin.forum.edit_submit}</button>
									<button type="submit" name="submit_forum_save_next_perms" class="button">{$aLang.plugin.forum.edit_submit_next_perms}</button>
									{else}
									<button type="submit" name="submit_forum_add" class="button button-primary">{$aLang.plugin.forum.create_submit}</button>
									{/if}
								</div>
							</th>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

{include file='footer.tpl'}