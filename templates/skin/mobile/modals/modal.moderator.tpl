<div id="moder_form_modal" class="slide slide-moderator" >
	<header class="modal-header">
		<h3>{$aLang.plugin.forum.moderator_add}</h3>
	</header>

	<div class="modal-content">
		<form id="moder-form">
			<p><label for="moder_forum_id">{$aLang.plugin.forum.moderator_select_forum}:</label>
			<select id="moder_forum_id" name="moder_forum_id" class="input-width-full">
				<option value="-1">--</option>
				{foreach from=$aForumsList item=aItem}
				<option value="{$aItem.id}"{if $aItem.level == 0}disabled="disabled"{/if}>{$aItem.title}</option>
				{/foreach}
			</select></p>

			<p><label for="moder_name">{$aLang.plugin.forum.moderator_select_user}:</label>
			<input type="text" id="moder_name" name="moder_name" placeholder="{$aLang.plugin.forum.moderator_select_user_placeholder}" class="input-text input-width-full autocomplete-users" /></p>

			<p><a href="#" class="link-dotted help-link" onclick="jQuery('#moder_form_options').toggle(); return false;">{$aLang.plugin.forum.moderator_options}</a></p>

			<div class="moder-options" id="moder_form_options" style="display:none">
				<label><input type="checkbox" id="moder_opt_viewip" name="moder_opt_viewip" class="input-checkbox" value="1"{if $_aRequest.moder_opt_viewip==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_viewip}</label>
				<label><input type="checkbox" id="moder_opt_editpost" name="moder_opt_editpost" class="input-checkbox" value="1"{if $_aRequest.moder_opt_editpost==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_editpost}</label>
				<label><input type="checkbox" id="moder_opt_edittopic" name="moder_opt_edittopic" class="input-checkbox" value="1"{if $_aRequest.moder_opt_edittopic==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_edittopic}</label>
				<label><input type="checkbox" id="moder_opt_deletepost" name="moder_opt_deletepost" class="input-checkbox" value="1"{if $_aRequest.moder_opt_deletepost==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_deletepost}</label>
				<label><input type="checkbox" id="moder_opt_deletetopic" name="moder_opt_deletetopic" class="input-checkbox" value="1"{if $_aRequest.moder_opt_deletetopic==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_deletetopic}</label>
				<label><input type="checkbox" id="moder_opt_movepost" name="moder_opt_movepost" class="input-checkbox" value="1"{if $_aRequest.moder_opt_movepost==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_movepost}</label>
				<label><input type="checkbox" id="moder_opt_movetopic" name="moder_opt_movetopic" class="input-checkbox" value="1"{if $_aRequest.moder_opt_movetopic==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_movetopic}</label>
				<label><input type="checkbox" id="moder_opt_openclosetopic" name="moder_opt_openclosetopic" class="input-checkbox" value="1"{if $_aRequest.moder_opt_openclosetopic==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_openclosetopic}</label>
				<label><input type="checkbox" id="moder_opt_pintopic" name="moder_opt_pintopic" class="input-checkbox" value="1"{if $_aRequest.moder_opt_pintopic==1} checked{/if} /> {$aLang.plugin.forum.moderator_options_pintopic}</label>
			</div>

			<input type="hidden" name="moder_form_action" id="moder_form_action" />
			type="hidden" name="moder_form_forum" id="moder_form_forum" />

			<button type="button" onclick="return ls.forum.admin.applyModerForm('moder-form')" class="button button-primary">{$aLang.plugin.forum.button_save}</button>
			<button type="button" class="button jqmClose">{$aLang.plugin.forum.button_cancel}</button>
		</form>
	</div>
</div>