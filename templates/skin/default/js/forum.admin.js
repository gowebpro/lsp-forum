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

	this.addModerator = function(form) {
		ls.ajaxSubmit(aRouter['forum']+'ajax/addmoderator/', form, function(result) {
			if (result.bStateError) {
				ls.msg.error(null,result.sMsg);
			} else {
				if (result.sMsg) ls.msg.notice(null,result.sMsg);
				this._updateModerList(result);
			}
		}.bind(this));
		return false;
	};

	this.delModerator = function(hash) {
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