<form id="forum-attach-upload-form" class="modal modal-attach" method="POST" enctype="multipart/form-data" onsubmit="return false;">
	<header class="modal-header">
		<h3>{$aLang.plugin.forum.attach_upload_title}</h3>
		<a href="#" class="close jqmClose"></a>
	</header>

	<div id="forum-attach-upload-input" class="forum-attach-upload-input modal-content">
		<label for="forum-attach-upload-file">{$aLang.plugin.forum.attach_upload_file_choose}:</label>
		<input type="file" id="forum-attach-upload-file" name="Filedata" /><br><br>

		<button type="submit" class="button button-primary" onclick="ls.forum.attach.upload();">{$aLang.plugin.forum.attach_upload_file_choose}</button>
		<button type="submit" class="button" onclick="ls.forum.attach.closeForm();">{$aLang.topic_photoset_upload_close}</button>

		<input type="hidden" name="is_iframe" value="true" />
		<input type="hidden" id="forum-attach-post-id" name="post_id" value="{$_aRequest.post_id}" />
	</div>
</form>