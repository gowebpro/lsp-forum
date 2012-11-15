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

	this.replyPost = function(idPost) {
		var fast_form=$('#fast-reply-form');
		if (fast_form.is(":hidden")) {
			fast_form.slideDown();
		}
		$.markItUp({target: $('#post_text'), replaceWith: '\n<ls reply="'+idPost+'" />'} );
		$.scrollTo(fast_form, 1000, {offset: -220});
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
			}
		});
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
				{separator:'---------------' },
				{name: ls.lang.get('panel_clear_tags'), className:'editor-clean', replaceWith: function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },
			]
		}
	};

	return this;
}).call(ls.forum || {},jQuery);

jQuery(document).ready(function($){
	ls.hook.run('forum_template_init_start',[],window);

	$('.js-forum-cat-toogler').click(function() {
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

	$('#link-to-post').jqm();

	ls.blocks.options.type.stream_forum = {
		url: aRouter['forum']+'ajax/getlasttopics/'
	}

	ls.hook.run('forum_template_init_end',[],window);
});