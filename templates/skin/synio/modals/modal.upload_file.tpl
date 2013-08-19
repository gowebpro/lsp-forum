<div id="modal-attach-upload" class="modal" >
	<header class="modal-header">
		<h3>{$aLang.plugin.forum.confirm}</h3>
		<a href="#" class="close jqmClose"></a>
	</header>

	<div class="modal-content">
		<form id="attach-upload-form" method="POST" enctype="multipart/form-data" onsubmit="return false">
			<label>{$aLang.topic_photoset_choose_image}:</label>
			<input type="file" id="attach-upload-file" name="Filedata" />

			<input type="hidden" name="is_iframe" value="true" />
			<input type="hidden" name="post_id" value="{$_aRequest.post_id}" />
		</form>

		<button type="submit" class="button button-primary" onclick="ls.forum.attach.upload();">{$aLang.plugin.forum.attach_upload_file_choose}</button>
	</div>
</div>
