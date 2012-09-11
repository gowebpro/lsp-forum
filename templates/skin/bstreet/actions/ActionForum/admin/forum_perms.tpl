{assign var="noSidebar" value=true}
{include file='header.tpl'}

<div id="filter-top">
	<div class="filter-bg"></div>

	<h2 class="page-header">
		<a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span>
		<a href="{router page='forum'}admin/forums">{$aLang.plugin.forum.forums}</a> <span>&raquo;</span>
		{$aLang.plugin.forum.perms}
	</h2>
</div>
<br /><br />
<div class="wrapper-content">
	<div class="mb-30">
		{include file="$sTemplatePathPlugin/menu.forum.admin.tpl"}
	</div>
</div>
<div class="forums">
	<form method="POST" id="forum-perms">
		<table class="table table-perms">
			<tr>
				<th class="ta-c">
					{$aLang.plugin.forum.perms_mask_name}
				</th>
				<th class="perm-red ta-c">
					<div>{$aLang.plugin.forum.perms_show}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckAll(this,'show','forum-perms')" name="show_all" id="show_all" value="1" />
				</th>
				<th class="perm-green ta-c">
					<div>{$aLang.plugin.forum.perms_read}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckAll(this,'read','forum-perms')" name="read_all" id="read_all" value="1" />
				</th>
				<th class="perm-yellow ta-c">
					<div>{$aLang.plugin.forum.perms_reply}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckAll(this,'reply','forum-perms')" name="reply_all" id="reply_all" value="1" />
				</th>
				<th class="perm-blue ta-c">
					<div>{$aLang.plugin.forum.perms_start}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckAll(this,'start','forum-perms')" name="start_all" id="start_all" value="1" />
				</th>
			</tr>
			{foreach from=$aPerms item=oPerm}
			<tr>
				<td class="ta-c">
					{$oPerm->getName()}
				</td>
				<td class="perm-red">
					<div>{$aLang.plugin.forum.perms_show}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('show',{$oPerm->getId()},'forum-perms')" name="show[{$oPerm->getId()}]" id="show_{$oPerm->getId()}" value="1"{if $_aRequest.show[$oPerm->getId()]} checked{/if} />
				</td>
				<td class="perm-green">
					<div>{$aLang.plugin.forum.perms_read}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('read',{$oPerm->getId()},'forum-perms')" name="read[{$oPerm->getId()}]" id="read_{$oPerm->getId()}" value="1"{if $_aRequest.read[$oPerm->getId()]} checked{/if} />
				</td>
				<td class="perm-yellow">
					<div>{$aLang.plugin.forum.perms_reply}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('reply',{$oPerm->getId()},'forum-perms')" name="reply[{$oPerm->getId()}]" id="reply_{$oPerm->getId()}" value="1"{if $_aRequest.reply[$oPerm->getId()]} checked{/if} />
				</td>
				<td class="perm-blue">
					<div>{$aLang.plugin.forum.perms_start}</div>
					<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('start',{$oPerm->getId()},'forum-perms')" name="start[{$oPerm->getId()}]" id="start_{$oPerm->getId()}" value="1"{if $_aRequest.start[$oPerm->getId()]} checked{/if} />
				</td>
			</tr>
			{/foreach}
			<tr>
				<th colspan="5">
					<div class="ta-c">
						<div class="green">
							<span class="l44"></span><span class="r44"></span>
							<button type="submit" name="submit_forum_perms">{$aLang.plugin.forum.perms_submit}</button>
						</div>
					</div>
				</th>
			</tr>
		</table>
	</form>
</div>

{include file='footer.tpl'}