{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">
	<a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span>
	<a href="{router page='forum'}admin/forums">{$aLang.plugin.forum.forums}</a> <span>&raquo;</span>
	{$aLang.plugin.forum.delete}
</h2>

<div class="forums">
	<header class="forums-header">
		<h3>{$aLang.plugin.forum.delete} &laquo;{$oForum->getTitle()}&raquo;</h3>
	</header>

	<form action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

		<table class="table table-forum-admin">
			<tr>
				<td class="cell-label">
					<label for="forum_move_id_topics">{$aLang.plugin.forum.delete_move_items}:</label>
					<span class="note">{$aLang.plugin.forum.delete_move_items_note}</span>
				</td>
				<td class="cell-labeled">
					<select id="forum_move_id_topics" name="forum_move_id_topics">
					{foreach from=$aForumsList item=aItem}
						<option value="{$aItem.id}"{if $_aRequest.forum_move_id_topics==$aItem.id} selected{/if}>{$aItem.title}</option>
					{/foreach}
					</select>
				</td>
			</tr>

			{if $oForum->getChildren()}
			<tr>
				<td class="cell-label">
					<label for="forum_delete_move_childrens">{$aLang.plugin.forum.delete_move_childrens}:</label>
					<span class="note">{$aLang.plugin.forum.delete_move_childrens_note}</span>
				</td>
				<td class="cell-labeled">
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
					<div class="ta-c">
						<button type="submit" name="submit_forum_delete" class="button">{$aLang.plugin.forum.delete_forum}</button>
					</div>
				</td>
			</tr>
		</table>
	</form>
</div>

{include file='footer.tpl'}