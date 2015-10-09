{include file='header.tpl' noSidebar=true}

<h2 class="page-header">{include file="$sTemplatePathForum/breadcrumbs.tpl"}</h2>

<h4 class="page-subheader">{$aLang.plugin.forum.topic_move} <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()|escape:'html'}</a></h4>

<div class="fBox">
	<form action="" method="POST" enctype="multipart/form-data">
		<div class="forums-content">
			<div class="fContainer fPad">
				<p>
					<label>
						{$aLang.plugin.forum.topic_move_for}
						<select id="topic_move_id" name="topic_move_id">
							{foreach from=$aForumsList item=aItem}
							<option value="{$aItem.id}"{if $_aRequest.topic_move_id==$aItem.id} selected{/if}>{$aItem.title|escape:'html'}</option>
							{/foreach}
						</select>
					</label>
				</p>
			</div>
		</div>
		<div class="fSubmit">
			<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

			<button type="submit" name="submit_topic_move" class="button button-primary">{$aLang.plugin.forum.topic_move}</button>
		</div>
	</form>
</div>

{include file='footer.tpl'}