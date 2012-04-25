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
	deleteForum = function(idForum,sTitle) {
		if (!confirm(ls.lang.get('forum_delete_confirm',{'title':sTitle}) + '?')) return false;
 
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

	return this;
}).call(ls.forum.admin || {},jQuery);