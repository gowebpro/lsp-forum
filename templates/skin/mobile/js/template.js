/**
 * Переопределение функций для мобильного шаблона
 * last update: 8.13
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
 * Инициализация модальных окон
 */
ls.forum.initModals = function() {
	$('.slide').each(function() {
		$(this).find('.jqmClose').click($.proxy($(this).slideUp, $(this)));
	});
};


jQuery(document).ready(function($){
	// Хук начала инициализации javascript-составляющих шаблона
//	ls.hook.run('ls_template_init_start',[],window);

	// Хук конца инициализации javascript-составляющих шаблона
//	ls.hook.run('ls_template_init_end',[],window);
});
