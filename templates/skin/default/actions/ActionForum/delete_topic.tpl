{include file='header.tpl' noSidebar=true}

<div class="forum">
	<div class="forumNav">
		<h2>{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>
	</div>

	{include file="$sTemplatePathPlugin/switcher_top.tpl"}

	<div class="forumBlock">
		<div class="forumHeader forumHeader-subjectPage">
			<div class="leftBg">
				<h2>{$aLang.forum_topic_delete} <a href="{$oTopic->getUrlFull()}">{$oTopic->getTitle()}</a></h2>
			</div>
			<div class="rightBg"></div>
		</div>
		
		<div class="fastAnswer clear_fix">
			<div class="fastAnswerForm">
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

					<p>
						<strong>{$aLang.forum_topic_delete_warning}</strong>
					</p>

					<p class="buttons">
						<input type="submit" name="submit_topic_delete" value="{$aLang.forum_topic_delete}" />
					</p>
				</form>
			</div>
		</div>
	</div>

</div>
{include file='footer.tpl'}