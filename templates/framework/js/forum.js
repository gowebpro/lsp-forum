/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: forum.js
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

var ls=ls || {}

ls.forum = (function ($) {
	this.fastReply = function(el) {
		var form=$('#fast-reply-form');
		if (form.is(":visible")) {
			form.slideUp();
			$(el).removeClass('button-primary');
		} else {
			form.slideDown();
			$(el).addClass('button-primary');
		}
		return false;
	};

	this.cancelPost = function() {
		ls.forum.configReplyForm(0,0);
		$('#post_text').val('');
	};

	this.configReplyForm = function(idPost,bScroll) {
		bScroll=bScroll || true;
		if ($('#fast-reply-form')) {
			var $form=$('#fast-reply-form');
			if ($form.is(":hidden")) {
				$form.slideDown();
			}
			var replyto=$form.find('#replyto');
			replyto.val(idPost);
			var rtpw=$('#reply-to-post-wrap');
			if (replyto.val() > 0) {
				var postLink=aRouter['forum']+"findpost/"+idPost+"/";
				rtpw.show().find('span').html('<a class="link-dashed" href="'+postLink+'" target="_blank">#'+idPost+'</a>');
			} else {
				rtpw.hide().find('span').html('');
			}
			if (bScroll) $.scrollTo($form, 1000, {offset: -220});
		}
		return $form;
	};

	this.configConfirmBox = function(text, params, callback) {
		var $window = $('#confirm-box');
		var $text = $window.find('.confirm-box-text'),
			$btn = $window.find('.js-confirm-yes');
		$text.text(text||'');
		$window.removeData('params');
		$window.data('params', params);
		if ($.type(callback) == 'function')
			$btn.click($.proxy(callback, $window));
		else
			$btn.unbind('click');
		return $window;
	};

	this.replyPost = function($t) {
		var idPost = $t.attr('data-post-id');
		var userName = $t.attr('data-name');
		ls.forum.configReplyForm(idPost);
		if (userName) $.markItUp({target: $('#post_text'), replaceWith: '@'+userName+', '} );
		return false;
	};

	this.quotePost = function($t) {
		var idPost = $t.attr('data-post-id');
		ls.forum.configReplyForm(idPost);
		var $post = $t.parents('#post-'+idPost);
		var $text = $post.find('.forum-post-body .text').html();
		$.markItUp({target: $('#post_text'), replaceWith:'<blockquote reply="'+idPost+'">'+$.trim($text)+'</blockquote>' });
		return false;
	};

	this.deletePost = function($t) {
		var idPost = $t.attr('data-post-id');
		var $window = ls.forum.configConfirmBox(ls.lang.get('plugin.forum.post_delete_confirm'), { 'id':idPost }, function(e) {
			var sId = $(this).data('params').id;
			window.location=aRouter.forum+'topic/delete/'+sId;
		});
		$window.jqmShow();
		return false;
	};

	this.linkToPost = function(idPost) {
		var $window = $('#link-to-post');
		$window.find('#link-to-post-input').val(aRouter['forum']+"findpost/"+idPost+"/").select();
		$window.jqmShow();
		return false;
	};

	this.jumpMenu = function(list) {
		list = $(list);
		if (list.val() > 0) {
			list.parent('form').submit();
			return;
		}
		return false;
	};

	this.disabledButton = function() {
		if (ls.blocks.switchTab('login','popup-login')) {
			$('#window_login_form').jqmShow();
		} else {
			window.location=aRouter.login;
		}
		return false;
	};

	this.preview = function(form, preview) {
		form=$('#'+form);
		preview=$('#'+preview);
		var url = aRouter['forum']+'ajax/preview/';
		ls.hook.marker('previewBefore');
		ls.ajaxSubmit(url, form, function(result) {
			if (result.bStateError) {
				ls.msg.error(null, result.sMsg);
			} else {
				preview.show().html(result.sText);
				ls.hook.run('ls_forum_preview_after',[form, preview, result]);
				ls.forum.initSpoilers();
			}
		});
		return false;
	};

	this.initToggler = function() {
		$('.js-forum-cat-toggler').click(function() {
			var header=$(this).parent('header');
			var content=$(header).next('.forums-content');
			var note=$(content).next('.forums-note');
			if (content.is(":visible")) {
				$(this).addClass('icon-plus-sign').removeClass('icon-minus-sign');
				$(header).addClass('collapsed');
				$(content).slideUp();
				if (note) $(note).slideDown();
			} else {
				$(this).removeClass('icon-plus-sign').addClass('icon-minus-sign');
				$(header).removeClass('collapsed');
				$(content).slideDown();
				if (note) $(note).slideUp();
			}
			return false;
		});
	};

	this.initButtons = function() {
		var $self = this;
		$('.js-post-reply').click(function() {
			var $t = $(this);
			return $self.replyPost($t);
		});
		$('.js-post-quote').click(function() {
			var $t = $(this);
			return $self.quotePost($t);
		});
		$('.js-post-delete').click(function() {
			var $t = $(this);
			return $self.deletePost($t);
		});
	};

	this.initSpoilers = function() {
		$('.spoiler-body').each(function() {
			var $body = $(this);
			var title = $body.attr('data-name') || ls.lang.get('panel_spoiler_placeholder');
			var $head = $('<div class="spoiler-head folded">'+ title +'</div>');
			$head.insertBefore($body).click(function() {
				if ($body.is(":visible")) {
					$(this).addClass('folded').removeClass('unfolded');
					$body.slideUp('fast');
				} else {
					$(this).removeClass('folded').addClass('unfolded');
					$body.slideDown('fast');
				}
			});
			var $fold = $('<div class="spoiler-fold"></div>').click(function(){
				$.scrollTo($head, { duration: 200, axis: 'y', offset: -200 });
				$head.click().animate({opacity: 0.3}, 500).animate({opacity: 1}, 700);
			});
			$body.append($fold);
		});
	};

	this.initModals = function() {
		$('#link-to-post').jqm();
		$('#confirm-box').jqm();
		$('#insert-spoiler').jqm();
	};

	this.initSelect = function() {
		$.each($('.js-forum-select'),function(k,v){
			$(v).find('.js-select-forum').bind('change',function(e){
				this.loadTopics($(e.target));
			}.bind(this));
		}.bind(this));
	};

	this.loadTopics = function($forum) {
		$topic=$forum.parents('.js-forum-select').find('.js-select-topic');
		$topic.empty();
		$topic.append('<option value="">'+ls.lang.get('plugin.forum.select_topic')+'</option>');

		if (!$forum.val()) {
			$topic.hide();
			return;
		}

		ls.ajax(aRouter['forum']+'ajax/gettopics/', { forum_id:$forum.val() }, function(result) {
			if (result.bStateError) {
				ls.msg.error(null, result.sMsg);
			} else {
				$.each(result.aTopics,function(k,v){
					$topic.append('<option value="'+v.id+'">'+v.title+'</option>');
				});
				$topic.show();
			}
		});
	};

	this.showSpoilerForm = function() {
		var $modal = $('#insert-spoiler');
		$modal.find('#spoiler-title').val('');
		$modal.find('#spoiler-text').val('');
		$modal.jqmShow();
	};

	this.insertSpoiler = function(form, target) {
		form = $('#'+form);
		$title = form.find('#spoiler-title').val();
		$text = form.find('#spoiler-text').val();
		$.markItUp({target: $('#'+target), replaceWith:'<spoiler name="'+$title+'">'+$.trim($text)+'</spoiler>' });
		$('#insert-spoiler').jqmHide();
		return false;
	};

	this.getMarkitupMini = function() {
		return {
			onShiftEnter:	{keepDefault:false, replaceWith:'<br />\n'},
			onCtrlEnter:	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>'},
			onTab:			{keepDefault:false, replaceWith:'    '},
			markupSet: [
				{name: ls.lang.get('panel_b'), className:'editor-bold', key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
				{name: ls.lang.get('panel_i'), className:'editor-italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)'  },
				{name: ls.lang.get('panel_s'), className:'editor-stroke', key:'S', openWith:'<s>', closeWith:'</s>' },
				{name: ls.lang.get('panel_quote'), className:'editor-quote', key:'Q', replaceWith: function(m) { if (m.selectionOuter) return '<blockquote>'+m.selectionOuter+'</blockquote>'; else if (m.selection) return '<blockquote>'+m.selection+'</blockquote>'; else return '<blockquote></blockquote>' } },
				{separator:'---------------' },
				{name: ls.lang.get('panel_image'), className:'editor-picture', key:'P', beforeInsert: function(h) { jQuery('#window_upload_img').jqmShow(); } },
				{name: ls.lang.get('panel_url'), className:'editor-link', key:'L', openWith:'<a href="[!['+ls.lang.get('panel_url_promt')+':!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
				{name: ls.lang.get('panel_user'), className:'editor-user', replaceWith:'<ls user="[!['+ls.lang.get('panel_user_promt')+']!]" />' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_clear_tags'), className:'editor-clean', replaceWith: function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },
			]
		}
	};

	this.getMarkitup = function() {
		return {
			onShiftEnter:	{keepDefault:false, replaceWith:'<br />\n'},
			onCtrlEnter:	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>'},
			onTab:			{keepDefault:false, replaceWith:'    '},
			markupSet: [
				{name:'H4', className:'editor-h4', openWith:'<h4>', closeWith:'</h4>' },
				{name:'H5', className:'editor-h5', openWith:'<h5>', closeWith:'</h5>' },
				{name:'H6', className:'editor-h6', openWith:'<h6>', closeWith:'</h6>' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_b'), className:'editor-bold', key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
				{name: ls.lang.get('panel_i'), className:'editor-italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)'  },
				{name: ls.lang.get('panel_s'), className:'editor-stroke', key:'S', openWith:'<s>', closeWith:'</s>' },
				{name: ls.lang.get('panel_u'), className:'editor-underline', key:'U', openWith:'<u>', closeWith:'</u>' },
				{name: ls.lang.get('panel_quote'), className:'editor-quote', key:'Q', replaceWith: function(m) { if (m.selectionOuter) return '<blockquote>'+m.selectionOuter+'</blockquote>'; else if (m.selection) return '<blockquote>'+m.selection+'</blockquote>'; else return '<blockquote></blockquote>' } },
				{name: ls.lang.get('panel_code'), className:'editor-code', openWith:'<code>', closeWith:'</code>' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_list'), className:'editor-ul', openWith:'    <li>', closeWith:'</li>', multiline: true, openBlockWith:'<ul>\n', closeBlockWith:'\n</ul>' },
				{name: ls.lang.get('panel_list'), className:'editor-ol', openWith:'    <li>', closeWith:'</li>', multiline: true, openBlockWith:'<ol>\n', closeBlockWith:'\n</ol>' },
				{name: ls.lang.get('panel_list_li'), className:'editor-li', openWith:'<li>', closeWith:'</li>' },
				{separator:'---------------' },
				{name: ls.lang.get('panel_image'), className:'editor-picture', key:'P', beforeInsert: function(h) { jQuery('#window_upload_img').jqmShow(); } },
				{name: ls.lang.get('panel_video'), className:'editor-video', replaceWith:'<video>[!['+ls.lang.get('panel_video_promt')+':!:http://]!]</video>' },
				{name: ls.lang.get('panel_url'), className:'editor-link', key:'L', openWith:'<a href="[!['+ls.lang.get('panel_url_promt')+':!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
				{name: ls.lang.get('panel_user'), className:'editor-user', replaceWith:'<ls user="[!['+ls.lang.get('panel_user_promt')+']!]" />' },
				{name: ls.lang.get('panel_spoiler'), className:'editor-spoiler', beforeInsert: function(h) { ls.forum.showSpoilerForm(); } },
				{separator:'---------------' },
				{name: ls.lang.get('panel_clear_tags'), className:'editor-clean', replaceWith: function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },
			]
		}
	};

	return this;
}).call(ls.forum || {},jQuery);

/**
 * Функционал тул-бара
 */
ls.toolbar.forum = (function ($) {

	this.iCurrentPost=-1;

	this.init = function() {
		var vars = [], hash;
		var hashes = window.location.hash.replace('#','').split('&');
		for(var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('-');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}

		if (vars.go!==undefined) {
			if (vars.go=='last') {
				this.iCurrentPost=$('.js-post').length-2;
			} else {
				this.iCurrentPost=parseInt(vars.go)-1;
			}
			this.goNextPost();
		}
		if (vars.post!==undefined) {
			this.iCurrentPost=$('#post-'+vars.post).prevAll().length;
			this.goNextPost();
		}
	};

	this.reset = function() {
		this.iCurrentPost=-1;
	};

	this.goNextPost = function() {
		this.iCurrentPost++;
		var post=$('.js-post:eq('+this.iCurrentPost+')');
		if (post.length) {
			$.scrollTo(post, 500);
		} else {
			this.iCurrentPost=$('.js-post').length-1;
			// переход на следующую страницу
			var page=$('.js-paging-next-page');
			if (page.length && page.attr('href')) {
				window.location=page.attr('href')+'#go-0';
			}
		}
		return false;
	};

	this.goPrevPost = function() {
		this.iCurrentPost--;
		if (this.iCurrentPost<0) {
			this.iCurrentPost=0;
			// на предыдущую страницу
			var page=$('.js-paging-prev-page');
			if (page.length && page.attr('href')) {
				window.location=page.attr('href')+'#go-last';
			}
		} else {
			var post=$('.js-post:eq('+this.iCurrentPost+')');
			if (post.length) {
				$.scrollTo(post, 500);
			}
		}
		return false;
	};

	return this;
}).call(ls.toolbar.forum || {},jQuery);


/**
 * Инициализация
 */
jQuery(document).ready(function($){
	ls.hook.run('forum_template_init_start',[],window);

	ls.forum.initToggler();
	ls.forum.initButtons();
	ls.forum.initSpoilers();
	ls.forum.initModals();

	// Тул-бар
	ls.toolbar.forum.init();

	ls.blocks.options.type.stream_forum = {
		url: aRouter['forum']+'ajax/getlasttopics/'
	}

	ls.hook.run('forum_template_init_end',[],window);
});