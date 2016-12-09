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

    this.init = function () {
        // panel
        $('.js-forum-panel-slide').click(function () {
            var p_curr = $(this);

            var f = p_curr.data('f'),
                c = p_curr.attr('rel');

            var f_wrap = $('#forum' + f);
            var a_panel = $('#forum' + f + '_panel');
            var s_panel = $('#forum' + f + '_panel_info');

            var info_block = $('#forum' + f + '_' + c + '_block');

            var panel_a = a_panel.find('> .active').not(p_curr);
            var panel_s = s_panel.find('> .active').not(info_block);

            panel_a.removeClass('active');
            panel_s.removeClass('active').slideUp('fast');

            if (info_block.hasClass('active')) {
                info_block.slideUp('fast');
                info_block.removeClass('active');
                p_curr.removeClass('active');
                f_wrap.removeClass('open');
            } else {
                info_block.slideDown('fast');
                info_block.addClass('active');
                p_curr.addClass('active');
                f_wrap.addClass('open');
            }
            return false;
        });

        // inputs
        $('#forum_url').keypress(ls.tools.latinecFilter);
        $('#forum_limit_rating_topic').keypress(ls.tools.floatFilter);
        $('.js-input-number').keypress(ls.tools.numberFilter);

        // modals
        $('#moder_form_modal').jqm();
    };

    this._updateModerList = function (data) {
        if (data.sForumId) {
            var fc = $('#forum' + data.sForumId + '_moders_block');
            if (fc) fc.html(data.sText);
        }
    };

    this.showModerForm = function (data, sAction) {
        var sForumId = (data && data.sForumId ? data.sForumId : ''),
            sModerName = (data && data.sModerName ? data.sModerName : ''),
            bOptViewip = (data && data.bOptViewip ? data.bOptViewip : false),
            bOptEditPost = (data && data.bOptEditPost ? data.bOptEditPost : false),
            bOptEditTopic = (data && data.bOptEditTopic ? data.bOptEditTopic : false),
            bOptDeletePost = (data && data.bOptDeletePost ? data.bOptDeletePost : false),
            bOptDeleteTopic = (data && data.bOptDeleteTopic ? data.bOptDeleteTopic : false),
            bOptMovePost = (data && data.bOptMovePost ? data.bOptMovePost : false),
            bOptMoveTopic = (data && data.bOptMoveTopic ? data.bOptMoveTopic : false),
            bOptOpencloseTopic = (data && data.bOptOpencloseTopic ? data.bOptOpencloseTopic : false),
            bOptPinTopic = (data && data.bOptPinTopic ? data.bOptPinTopic : false);
        $('#moder_form_forum').val(sForumId);
        $('#moder_forum_id').val(sForumId);
        $('#moder_name').val(sModerName);
        $('#moder_opt_viewip').attr('checked', bOptViewip);
        $('#moder_opt_editpost').attr('checked', bOptEditPost);
        $('#moder_opt_edittopic').attr('checked', bOptEditTopic);
        $('#moder_opt_deletepost').attr('checked', bOptDeletePost);
        $('#moder_opt_deletetopic').attr('checked', bOptDeleteTopic);
        $('#moder_opt_movepost').attr('checked', bOptMovePost);
        $('#moder_opt_movetopic').attr('checked', bOptMoveTopic);
        $('#moder_opt_openclosetopic').attr('checked', bOptOpencloseTopic);
        $('#moder_opt_pintopic').attr('checked', bOptPinTopic);
        $('#moder_form_action').val(sAction);
        var formOptions = $('#moder_form_options');
        if (sAction == 'update') {
            formOptions.show();
        } else {
            formOptions.hide();
        }
        $('#moder_form_modal').jqmShow();
    };

    this.applyModerForm = function (form) {
        ls.ajaxSubmit(aRouter['forum'] + 'ajax/addmoderator/', form, function (result) {
            if (result.bStateError) {
                ls.msg.error(null, result.sMsg);
            } else {
                if (result.sMsg) ls.msg.notice(null, result.sMsg);
                this._updateModerList(result);
                $('#moder_form_modal').jqmHide();
            }
        }.bind(this));
        return false;
    };

    this.addModerator = function (sForumId) {
        var data = { sForumId: sForumId };
        this.showModerForm(data, 'add');
        return false;
    };

    this.editModerator = function (hash) {
        ls.ajax(aRouter['forum'] + 'ajax/getmoderator/', {hash: hash}, function (result) {
            if (result.bStateError) {
                ls.msg.error(null, result.sMsg);
            } else {
                if (result.sMsg) ls.msg.notice(null, result.sMsg);
                this.showModerForm(result, 'update');
            }
        }.bind(this));
        return false;
    };

    this.delModerator = function (hash) {
        if (!confirm(ls.lang.get('plugin.forum.moderator_del_confirm'))) return false;

        ls.ajax(aRouter['forum'] + 'ajax/delmoderator/', {hash: hash}, function (result) {
            if (result.bStateError) {
                ls.msg.error(null, result.sMsg);
            } else {
                if (result.sMsg) ls.msg.notice(null, result.sMsg);
                this._updateModerList(result);
            }
        }.bind(this));
        return false;
    };

    this.permsCheckCol = function (perm, form, invert) {
        $.each($('#' + form).find('input[type="checkbox"]'), function (k, v) {
            var s = $(v).attr('id');
            var a = s.replace(/^(.+?)_.+?$/, "$1");
            if (a == perm) {
                $(v).attr('checked', (!invert));
            }
        });
    };

    this.permsCheckRow = function (id, form, invert) {
        $.each($('#' + form).find('input[type="checkbox"]'), function (k, v) {
            var s = $(v).attr('id');
            var a = s.replace(/[^0-9]/gi, "");
            if (a == id) {
                $(v).attr('checked', (!invert));
            }
        });
    };

    this.permsCheckBox = function (sid, maskId, form) {
        return true;
    };

    return this;
}).call(ls.forum.admin || {}, jQuery);


jQuery(document).ready(function ($) {

    ls.forum.admin.init();

});


/**
 * Вспомогательные функции
 */
ls.tools = (function ($) {
    /**
     * Проверка целых чисел
     */
    this.numberFilter = function (e) {
        e = e || window.event;
        var code = e.charCode || e.keyCode;
        if (e.charCode == 0) return true;
        if (code < 32) return true;
        var charCode = String.fromCharCode(code);
        var allowed = '0123456789';
        if (allowed.indexOf(charCode) == -1) return false;
    };

    /**
     * Проверка чисел с плавающей точкой
     */
    this.floatFilter = function (e) {
        e = e || window.event;
        var code = e.charCode || e.keyCode;
        var o = $(e.target || e.srcElement);
        if (e.charCode == 0) return true;
        if (code < 32) return true;
        if ((code == 46 && o.val().indexOf('.') >= 0) || (code == 45 && o.val().indexOf('-') >= 0)) return false;
        if ((code == 46 && o.val() == "") || (code == 45 && o.val() != "")) return false;
        var charCode = String.fromCharCode(code);
        var allowed = '0123456789.-';
        if (allowed.indexOf(charCode) == -1) return false;
    };

    /**
     * Проверка латинских символов
     */
    this.latinecFilter = function (e) {
        e = e || window.event;
        var code = e.charCode || e.keyCode;
        return (/[a-zA-Z_]*$/.test(String.fromCharCode(code)));
    };

    return this;
}).call(ls.tools || {}, jQuery);
