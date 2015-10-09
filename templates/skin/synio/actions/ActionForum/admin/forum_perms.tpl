{assign var="noSidebar" value=true}
{include file='header.tpl'}

<h2 class="page-header">
	<a href="{router page='forum'}admin">{$aLang.plugin.forum.acp}</a> <span>&raquo;</span>
	<a href="{router page='forum'}admin/forums">{$aLang.plugin.forum.forums}</a> <span>&raquo;</span>
	{$aLang.plugin.forum.perms}
</h2>

{include file="$sTemplatePathForum/menu.forum.admin.tpl"}
{assign var="bCategory" value=$oForum->getCanPost()}

<div class="forums">
	<div class="fBox forum-acp">
		<header class="forums-header">
			<h3>{$aLang.plugin.forum.perms} &laquo;{$oForum->getTitle()|escape:'html'}&raquo;</h3>
		</header>

		<div class="forums-content">
			<div class="fContainer">
				<form method="POST" id="forum-perms">
					<table class="table table-perms">
						<tr>
							<th class="ta-c">
								{$aLang.plugin.forum.perms_mask_name}
							</th>
							<th class="perm-red ta-c">
								<div>{$aLang.plugin.forum.perms_show}</div>
								<button type="button" class="button button-primary" onclick="ls.forum.admin.permsCheckCol('show','forum-perms')"><i class="icon-white icon-plus"></i></button>
								<button type="button" class="button button-red" onclick="ls.forum.admin.permsCheckCol('show','forum-perms',1)"><i class="icon-white icon-minus"></i></button>
							</th>
							<th class="perm-green ta-c">
								<div>{$aLang.plugin.forum.perms_read}</div>
								<button type="button" class="button button-primary" onclick="ls.forum.admin.permsCheckCol('read','forum-perms')"><i class="icon-white icon-plus"></i></button>
								<button type="button" class="button button-red" onclick="ls.forum.admin.permsCheckCol('read','forum-perms',1)"><i class="icon-white icon-minus"></i></button>
							</th>
							<th class="perm-yellow ta-c">
								<div>{$aLang.plugin.forum.perms_reply}</div>
								<button type="button" class="button button-primary" onclick="ls.forum.admin.permsCheckCol('reply','forum-perms')"{if $bCategory} disabled="disabled"{/if}><i class="icon-white icon-plus"></i></button>
								<button type="button" class="button button-red" onclick="ls.forum.admin.permsCheckCol('reply','forum-perms',1)"{if $bCategory} disabled="disabled"{/if}><i class="icon-white icon-minus"></i></button>
							</th>
							<th class="perm-blue ta-c">
								<div>{$aLang.plugin.forum.perms_start}</div>
								<button type="button" class="button button-primary" onclick="ls.forum.admin.permsCheckCol('start','forum-perms')"{if $bCategory} disabled="disabled"{/if}><i class="icon-white icon-plus"></i></button>
								<button type="button" class="button button-red" onclick="ls.forum.admin.permsCheckCol('start','forum-perms',1)"{if $bCategory} disabled="disabled"{/if}><i class="icon-white icon-minus"></i></button>
							</th>
						</tr>
						{foreach from=$aPerms item=oPerm}
						<tr>
							<td class="ta-c">
								{$oPerm->getName()}
								<button type="button" class="button" onclick="ls.forum.admin.permsCheckRow({$oPerm->getId()},'forum-perms')"><i class="icon-plus"></i></button>
								<button type="button" class="button" onclick="ls.forum.admin.permsCheckRow({$oPerm->getId()},'forum-perms',1)"><i class="icon-minus"></i></button>
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
								<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('reply',{$oPerm->getId()},'forum-perms')" name="reply[{$oPerm->getId()}]" id="reply_{$oPerm->getId()}" value="1"{if $_aRequest.reply[$oPerm->getId()]} checked{/if}{if $bCategory} disabled="disabled"{/if} />
							</td>
							<td class="perm-blue">
								<div>{$aLang.plugin.forum.perms_start}</div>
								<input type="checkbox" onclick="return ls.forum.admin.permsCheckBox('start',{$oPerm->getId()},'forum-perms')" name="start[{$oPerm->getId()}]" id="start_{$oPerm->getId()}" value="1"{if $_aRequest.start[$oPerm->getId()]} checked{/if}{if $bCategory} disabled="disabled"{/if} />
							</td>
						</tr>
						{/foreach}
						<tr>
							<th colspan="5">
								<div class="ta-c">
									<button type="submit" name="submit_forum_perms" class="button button-primary">{$aLang.plugin.forum.perms_submit}</button>
									<button type="submit" name="submit_forum_perms_next_edit" class="button">{$aLang.plugin.forum.perms_submit_next_edit}</button>
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