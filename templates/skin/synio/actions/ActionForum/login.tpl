{include file='header.tpl' noSidebar=true}

<h2 class="page-header">{include file="$sTemplatePathPlugin/breadcrumbs.tpl"}</h2>

<form action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 

	<h4 class="page-subheader">{$aLang.plugin.forum.password_write}</h4>
	<p>
		{$aLang.plugin.forum.password_security}<br/>
		{$aLang.plugin.forum.password_security_notice}
	</p>

	<p>
		<label for="f_password">{$aLang.plugin.forum.password}:</label>
		<input type="text" id="f_password" name="f_password" value="{$_aRequest.f_password}" class="input-text input-width-400" />
	</p>

	<button type="submit" name="submit_password" id="submit_password" class="button button-primary">{$aLang.plugin.forum.password_submit}</button>
</form>

{include file='footer.tpl'}