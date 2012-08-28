{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">
	<a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span>
	<a href="{router page='forum'}admin/forums">{$aLang.plugin.forum.forums}</a> <span>&raquo;</span>
	{$aLang.plugin.forum.perms}
</h2>

{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}

<div class="forums">
	<header class="forums-header">
		<h3>{$aLang.plugin.forum.perms} &laquo;{$oForum->getTitle()}&raquo;</h3>
	</header>

	<form method="POST" id="forum-perms">
		<table class="table">
			<tr>
				<th class="row1 center">
				</th>
				<th class="row1 center" style="background-color:#ECD5D8">
					<div>{$aLang.plugin.forum.perms_show}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckAll('SHOW','forum-perms')" name="show_all" id="show_all" value="1" />
				</th>
				<th class="row1 center" style="background-color:#DBE2DE">
					<div>{$aLang.plugin.forum.perms_read}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckAll('READ','forum-perms')" name="read_all" id="read_all" value="1" />
				</th>
				<th class="row1 center" style="background-color:#DBE6EA">
						<div>{$aLang.plugin.forum.perms_reply}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckAll('REPLY','forum-perms')" name="reply_all" id="reply_all" value="1" />
				</th>
				<th class="row1 center" style="background-color:#DBE6EA">
					<div>{$aLang.plugin.forum.perms_start}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckAll('START','forum-perms')" name="start_all" id="start_all" value="1" />
				</th>
			</tr>
			{foreach from=$aPerms item=oPerm}
			<tr>
				<td class="row2 center">
					{$oPerm->getName()}
				</td>
				<td class="row2 center" style="background-color:#ECD5D8">
					<div>{$aLang.plugin.forum.perms_show}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('SHOW',{$oPerm->getId()},'forum-perms')" name="show[{$oPerm->getId()}]" id="show_{$oPerm->getId()}" value="1"{if $_aRequest.show[$oPerm->getId()]} checked{/if} />
				</td>
				<td class="row2 center" style="background-color:#DBE2DE">
					<div>{$aLang.plugin.forum.perms_read}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('READ',{$oPerm->getId()},'forum-perms')" name="read[{$oPerm->getId()}]" id="read_{$oPerm->getId()}" value="1"{if $_aRequest.read[$oPerm->getId()]} checked{/if} />
				</td>
				<td class="row2 center" style="background-color:#DBE6EA">
					<div>{$aLang.plugin.forum.perms_reply}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('REPLY',{$oPerm->getId()},'forum-perms')" name="reply[{$oPerm->getId()}]" id="reply_{$oPerm->getId()}" value="1"{if $_aRequest.reply[$oPerm->getId()]} checked{/if} />
				</td>
				<td class="row2 center" style="background-color:#DBE6EA">
					<div>{$aLang.plugin.forum.perms_start}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('START',{$oPerm->getId()},'forum-perms')" name="start[{$oPerm->getId()}]" id="start_{$oPerm->getId()}" value="1"{if $_aRequest.start[$oPerm->getId()]} checked{/if} />
				</td>
			</tr>
			{/foreach}
			<tr>
				<th colspan="5">
					<div class="ta-c">
						<button type="submit" name="submit_forum_perms" class="button button-primary">{$aLang.plugin.forum.perms_submit}</button>
					</div>
				</th>
			</tr>
		</table>
	</form>
</div>

{include file='footer.tpl'}