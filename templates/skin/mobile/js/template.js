
ls.forum.deletePost = function($t) {
	var idPost = $t.attr('data-post-id');
	var $window = ls.forum.configConfirmBox(ls.lang.get('plugin.forum.post_delete_confirm'), { 'id':idPost }, function(e) {
		var sId = $(this).data('params').id;
		window.location=aRouter.forum+'topic/delete/'+sId;
	});
	$window.insertBefore($('#post-'+idPost));
	$window.slideDown();
	return false;
};

ls.forum.linkToPost = function(idPost) {
	var $window = $('#link-to-post');
	$window.insertBefore($('#post-'+idPost));
	$window.find('#link-to-post-input').val(aRouter['forum']+"findpost/"+idPost+"/").select();
	$window.slideToggle();
	return false;
};

ls.forum.disabledButton = function() {
	if (ls.blocks.switchTab('login','popup-login')) {
		$('#window_login_form').show();
	} else {
		window.location=aRouter.login;
	}
	return false;
};

ls.forum.initModals = function() {
	$('.slide').each(function() {
		$(this).find('.jqmClose').click($.proxy($(this).slideUp, $(this)));
	});
};

ls.forum.initToggler = function() {
	$('.js-forum-cat-toggler').click(function() {
		var content=$(this).next('.forum-content');
		var note=$(content).next('.forum-note');
		if (content.is(":visible")) {
			$(this).addClass('collapsed');
			$(content).slideUp();
			if (note) $(note).slideDown();
		} else {
			$(this).removeClass('collapsed');
			$(content).slideDown();
			if (note) $(note).slideUp();
		}
		return false;
	});
};

jQuery(document).ready(function($){
	// Хук начала инициализации javascript-составляющих шаблона
//	ls.hook.run('ls_template_init_start',[],window);

	// Хук конца инициализации javascript-составляющих шаблона
//	ls.hook.run('ls_template_init_end',[],window);
});
