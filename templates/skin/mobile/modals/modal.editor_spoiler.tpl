<div id="insert-spoiler" class="modal modal-editor" >

	<header class="modal-header">
		<h3>{$aLang.plugin.forum.panel_spoiler_insert}</h3>
		<a href="#" class="close jqmClose"></a>
	</header>

	<div class="modal-content">
		<form method="POST" action="" enctype="multipart/form-data" id="form_insert_spoiler" onsubmit="return false;">
			<p>
				<input type="text" id="spoiler-title" class="input-text input-width-full" placeholder="{$aLang.plugin.forum.panel_spoiler_title}" />
			</p>

			<textarea id="spoiler-text" rows="10" class="mce-editor markitup-editor input-width-full"></textarea>

			<button type="submit" class="button button-primary" onclick="ls.forum.insertSpoiler('form_insert_spoiler','{$sToLoad}');">{$aLang.plugin.forum.button_insert}</button>
			{$aLang.or}
			<button type="submit" class="button jqmClose">{$aLang.plugin.forum.button_cancel}</button>
		</form>
	</div>
</div>
