{assign var="noSidebar" value=true}
{include file='header.tpl'}

<div class="forum">
	<div class="forumNav">
		<h2>
			<span><a href="{router page='forum'}admin">{$aLang.forum_acp}</a></span>
			<span><a href="{router page='forum'}admin/forums">{$aLang.forums}</a></span>
			{$aLang.forum_delete}
		</h2>
	</div>

	<div class="forumBlock">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_delete} &laquo;{$oForum->getTitle()}&raquo;</h2>
			</div>
			<div class="rightBg"></div>
		</div>

		<div class="fastAnswer clear_fix">
			<div class="fastAnswerForm">
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

					<table class="forumBody">
						<tr>
							<td width="400">
								<label for="forum_move_id_topics">{$aLang.forum_delete_move_items}:</label><br />
								<span class="note">{$aLang.forum_delete_move_items_note}</span>
							</td>
							<td>
								<select id="forum_move_id_topics" name="forum_move_id_topics">
								{foreach from=$aForumsList item=aItem}
									<option value="{$aItem.id}"{if $_aRequest.forum_move_id_topics==$aItem.id} selected{/if}>{$aItem.title}</option>
								{/foreach}
								</select>
							</td>
						</tr>
						{if $oForum->getChildren()}
						<tr>
							<td width="400">
								<label for="forum_delete_move_childrens">{$aLang.forum_delete_move_childrens}:</label><br />
								<span class="note">{$aLang.forum_delete_move_childrens_note}</span>
							</td>
							<td>
								<select id="forum_delete_move_childrens" name="forum_delete_move_childrens">
								{foreach from=$aForumsList item=aItem}
									<option value="{$aItem.id}"{if $_aRequest.forum_delete_move_childrens==$aItem.id} selected{/if}>{$aItem.title}</option>
								{/foreach}
								</select>
							</td>
						</tr>
						{/if}
						<tr>
							<td colspan="2">
								<div class="buttons">
									<input type="submit" name="submit_forum_delete" value="{$aLang.forum_delete_forum}" />
								</div>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

{include file='footer.tpl'}