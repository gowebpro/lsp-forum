{if !$oUserCurrent}

	<p>
		<label for="guest_name">{$aLang.plugin.forum.guest_name}:</label>
		<input type="text" id="guest_name" name="guest_name" value="{$_aRequest.guest_name}" class="input-text input-width-400" /><br />
		<span class="note">{$aLang.plugin.forum.guest_name_notice}</span>
	</p>

	{hookb run="forum_guest_captcha"}
	<p>
		<label for="guest_captcha">{$aLang.plugin.forum.guest_captcha}</label>
		<img src="{cfg name='path.root.engine_lib'}/external/kcaptcha/index.php?{$_sPhpSessionName}={$_sPhpSessionId}" 
			onclick="this.src='{cfg name='path.root.engine_lib'}/external/kcaptcha/index.php?{$_sPhpSessionName}={$_sPhpSessionId}&n='+Math.random();"
			class="captcha-image" />
		<input type="text" name="guest_captcha" id="guest_captcha" value="" maxlength="3" class="input-text input-width-100" />
	</p>
	{/hookb}

{/if}