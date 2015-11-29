/**
 * Переопределение функций для мобильного шаблона
 * last update: 11.2015
 */


/**
 * Удаление сообщения
 */
ls.forum.deletePost = function($t) {
	if (!confirm(ls.lang.get('plugin.forum.post_delete_confirm'))) {return;}
	var idPost = $t.attr('data-post-id');
	window.location=aRouter.forum+'topic/delete/'+sId;
	return false;
};

/**
 * Модальное окно с прямой ссылкой на сообщение
 */
ls.forum.linkToPost = function(idPost) {
	var $window = $('#link-to-post');
	$window.insertBefore($('#post-'+idPost));
	$window.find('#link-to-post-input').val(aRouter['forum']+"findpost/"+idPost+"/").select();
	$window.slideToggle();
	return false;
};

/**
 * Колбэк заблокированной кнопки (для гостей)
 */
ls.forum.disabledButton = function() {
	if (ls.blocks.switchTab('login','popup-login')) {
		$('#window_login_form').show();
	} else {
		window.location=aRouter.login;
	}
	return false;
};

/**
 * Инициализация всплывающих подсказок
 */
ls.forum.initHints = function() {

};

/**
 * Инициализация модальных окон
 */
ls.forum.initModals = function() {
	$('.slide').each(function() {
		$(this).find('.jqmClose').click($.proxy($(this).slideUp, $(this)));
	});
};

ls.forum.attach.initModals = function() {

};
ls.forum.attach.showMyFiles = function() {
	$('#modal-attach-files').slideDown();
};
ls.forum.attach.hideMyFiles = function() {
	$('#modal-attach-files').slideUp();
};

ls.forum.attach.showForm = function() {
	$('#forum-attach-upload-input').appendTo('#forum-attach-wrapper');
	$('#forum-attach-upload-input').show();
};
ls.forum.attach.closeForm = function() {
	$('#forum-attach-upload-input').appendTo('#forum-attach-upload-form');
	$('#forum-attach-upload-form').hide();
};
ls.forum.attach.upload = function() {
	ls.forum.attach.closeForm();
	ls.forum.attach.addFileEmpty();
	ls.ajaxSubmit(aRouter.forum+'ajax/attach/upload/', $('#forum-attach-upload-form'), function (data) {
		if (data.bStateError) {
			$('#attach_file_empty').remove();
			ls.msg.error(data.sMsgTitle,data.sMsg);
		} else {
			ls.forum.attach.addFile(data);
		}
	});
};

jQuery(document).ready(function($){
	// Хук начала инициализации javascript-составляющих шаблона
//	ls.hook.run('ls_template_init_start',[],window);

	//tmp
	$('#forum-attach-upload').click(function() {
		ls.forum.attach.showForm();
	});

	// Хук конца инициализации javascript-составляющих шаблона
//	ls.hook.run('ls_template_init_end',[],window);
});
