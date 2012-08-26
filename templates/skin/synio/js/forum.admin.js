/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: forum.admin.js
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

var ls = ls || {};
ls.forum = ls.forum || {};

ls.forum.admin = (function ($) {
	this.deleteForum = function(idForum,sTitle) {
		if (!confirm(ls.lang.get('plugin.forum.delete_confirm',{'title':sTitle}) + '?')) return false;

		var tree=$('#forums-tree');
		if (!tree) return;

		ls.ajax(aRouter['forum']+'ajax/deleteforum/',{'idForum':idForum},function(data){
			if (data.bStateError) {
				ls.msg.error(data.sMsgTitle,data.sMsg);
			} else {
				$('#forum-'+idForum).remove();
				ls.msg.notice(data.sMsgTitle,data.sMsg);
			}
		});

		return false;
	};

	this.initModerToggler = function() {
		$('.js-forum-moder-toogler').click(function() {
			var forumId = parseInt($(this).attr('id').replace('toggler-moder-list-',''));
			var list=$('#moder-list-'+forumId);
			if (list.css('display')=='block') {
				$(this).addClass('icon-plus-sign').removeClass('icon-minus-sign');
				$(list).slideUp();
			} else {
				$(this).removeClass('icon-plus-sign').addClass('icon-minus-sign');
				$(list).slideDown();
			}
			return false;
		});
		$('#moder_form_modal').jqm();
	};

	this.showModerForm = function(data,sAction) {
		var sForumId = (data&&data.sForumId ? data.sForumId : ''),
			sModerName = (data&&data.sModerName ? data.sModerName : ''),
			bOptViewip = (data&&data.bOptViewip ? data.bOptViewip : false),
			bOptEditPost = (data&&data.bOptEditPost ? data.bOptEditPost : false),
			bOptEditTopic = (data&&data.bOptEditTopic ? data.bOptEditTopic : false),
			bOptDeletePost = (data&&data.bOptDeletePost ? data.bOptDeletePost : false),
			bOptDeleteTopic = (data&&data.bOptDeleteTopic ? data.bOptDeleteTopic : false),
			bOptMoveTopic = (data&&data.bOptMoveTopic ? data.bOptMoveTopic : false),
			bOptOpencloseTopic = (data&&data.bOptOpencloseTopic ? data.bOptOpencloseTopic : false),
			bOptPinTopic = (data&&data.bOptPinTopic ? data.bOptPinTopic : false);
		$('#moder_forum_id').val(sForumId);
		$('#moder_name').val(sModerName);
		$('#moder_form_options').hide();
		$('#moder_opt_viewip').attr('checked', bOptViewip);
		$('#moder_opt_editpost').attr('checked', bOptEditPost);
		$('#moder_opt_edittopic').attr('checked', bOptEditTopic);
		$('#moder_opt_deletepost').attr('checked', bOptDeletePost);
		$('#moder_opt_deletetopic').attr('checked', bOptDeleteTopic);
		$('#moder_opt_movetopic').attr('checked', bOptMoveTopic);
		$('#moder_opt_openclosetopic').attr('checked', bOptOpencloseTopic);
		$('#moder_opt_pintopic').attr('checked', bOptPinTopic);
		$('#moder_form_action').val(sAction);
		$('#moder_form_modal').jqmShow();
	};

	this.applyModerForm = function(form) {
		ls.ajaxSubmit(aRouter['forum']+'ajax/addmoderator/', form, function(result) {
			if (result.bStateError) {
				ls.msg.error(null,result.sMsg);
			} else {
				if (result.sMsg) ls.msg.notice(null,result.sMsg);
				this._updateModerList(result);
				$('#moder_form_modal').jqmHide();
			}
		}.bind(this));
		return false;
	};

	this._updateModerList = function(data) {
		if (data.sForumId) {
			var f = $('#forum-' + data.sForumId);
			if (f) {
				var m = f.find('.moder-list');
				if (m) {
					m.html(data.sText);
				}
			}
		}
	};

	this.addModerator = function(sForumId) {
		var data = { sForumId:sForumId }
		this.showModerForm(data,'add');
		return false;
	};

	this.editModerator = function(hash) {
		ls.ajax(aRouter['forum']+'ajax/getmoderator/', { hash:hash }, function(result) {
			if (result.bStateError) {
				ls.msg.error(null,result.sMsg);
			} else {
				if (result.sMsg) ls.msg.notice(null,result.sMsg);
				this.showModerForm(result,'update');
			}
		}.bind(this));
		return false;
	};

	this.delModerator = function(hash) {
		if (!confirm(ls.lang.get('plugin.forum.moderator_del_confirm'))) return false;

		ls.ajax(aRouter['forum']+'ajax/delmoderator/', { hash:hash }, function(result) {
			if (result.bStateError) {
				ls.msg.error(null,result.sMsg);
			} else {
				if (result.sMsg) ls.msg.notice(null,result.sMsg);
				this._updateModerList(result);
			}
		}.bind(this));
		return false;
	};

	return this;
}).call(ls.forum.admin || {},jQuery);