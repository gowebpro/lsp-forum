{include file='header.tpl' noSidebar=true}

<div class="forum">
	<div class="forumNav">
		<h2>{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>
	</div>

	{include file="$sTemplatePathPlugin/switcher_top.tpl"}

	<div class="forumBlock">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_topic_move} {$oForum->getTitle()} > {$oTopic->getTitle()}</h2>
			</div>
			<div class="rightBg"></div>
		</div>
		
		<div class="fastAnswer clear_fix">
			<div class="topic" style="display:none">
				<div class="content" id="text_preview"></div>
			</div>
			<div class="fastAnswerForm">
				<form action="" method="POST" enctype="multipart/form-data">
					<fieldset>
						<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

						<p>
							<label for="topic_move_id">{$aLang.forum_topic_move_for}</label><br>
							<select id="topic_move_id" name="topic_move_id">
							{foreach from=$aForumsList item=aItem}
								<option value="{$aItem.id}"{if $_aRequest.topic_move_id==$aItem.id} selected{/if}>{$aItem.title}</option>
							{/foreach}
							</select>
						</p>

						<p class="buttons">
							<input type="submit" name="submit_topic_move" value="{$aLang.forum_topic_move}" />
						</p>
					</fieldset>
				</form>
			</div>
		</div>
	</div>

</div>
{include file='footer.tpl'}