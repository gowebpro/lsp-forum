<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet CMS
* @Version: 1.0
* @Author: Chiffa http://goweb.pro
* @File Name: PluginForum.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginForum extends Plugin
{
    protected $aInherits = array(
        'action' => array(
            'ActionProfile',
            'ActionRss'
        ),
        'module' => array(
            'ModuleACL',
            'ModuleRating',
            'ModuleStream',
            'ModuleSubscribe',
            'ModuleText'
        )
    );

    /**
     * Активация плагина
     */
    public function Activate()
    {
        if ($this->updateNeed()) {
            $this->updateInstall();
        } else {
            $this->simpleInstall();
        }
        if ($this->isTableExists('prefix_vote')) {
            $this->addEnumType('prefix_vote', 'target_type', 'forum_post');
        }
        return true;
    }

    /**
     * Деактивация плагина
     */
    public function Deactivate()
    {
        if (Config::Get('plugin.forum.deactivate.delete')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/deinstall.sql');
        }
        return true;
    }

    /**
     * Инициализация плагина
     */
    public function Init()
    {
        /**
         * Подключаем CSS
         */
        $this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__) . 'css/forum.css');
        /**
         * Подключаем JS
         */
        $this->Viewer_AppendScript(Plugin::GetWebPath(__CLASS__) . 'templates/framework/js/forum.js');
        /**
         * Подключаем JS
         * - для мобильной версии шаблона
         */
        if (class_exists('MobileDetect') && MobileDetect::IsMobileTemplate(false)) {
            $this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__) . 'js/template.js');
        }
        /**
         * Добавляем в подписку новые типы
         *  - при наличи модуля Subscribe
         */
        if (class_exists('ModuleSubscribe')) {
            $this->Subscribe_AddTargetType('forum_new_topic', array());
            $this->Subscribe_AddTargetType('topic_new_post', array());
        }
        /**
         * Добавляем в ленту новые типы событий
         *  - при наличии модуля Stream
         */
        if (class_exists('ModuleStream')) {
            $this->Stream_AddEventType('add_forum_topic', array(
                'related' => 'forumTopic',
                'unique' => true
            ));
            $this->Stream_AddEventType('add_forum_post', array(
                'related' => 'forumPost',
                'unique' => true
            ));
        }
        /**
         * Добавляем в ленту текстовки новых типов событий
         */
        $this->Lang_AddMessages(array(
            'stream_event_type_add_forum_topic' => $this->Lang_Get('plugin.forum.event_type_add_topic'),
            'stream_event_type_add_forum_post' => $this->Lang_Get('plugin.forum.event_type_add_post'),
            'panel_spoiler' => $this->Lang_Get('plugin.forum.panel_spoiler'),
            'panel_spoiler_placeholder' => $this->Lang_Get('plugin.forum.panel_spoiler_placeholder'),
        ));
        /**
         * Подключаем кнопку
         */
        //$this->Viewer_AddBlock('toolbar', 'toolbar_jumpmenu.tpl', array('plugin' => __CLASS__), -111);
        /**
         * Загружаем в шаблон необходимые переменные
         */
        $this->Viewer_Assign('aLang', $this->Lang_GetLangMsg());
        $this->Viewer_Assign('sTemplatePathForum', rtrim(Plugin::GetTemplatePath(__CLASS__), '/'));
        /**
         * Подключаем нашу директорию плагинов для Smarty
         */
        $oSmarty = $this->Viewer_GetSmartyObject();
        $oSmarty->addPluginsDir(Config::Get('plugin.forum.path_smarty_plug'));

        return true;
    }


    /**
     * Функция определяет наличии установленных таблиц плагина
     */
    private function updateNeed()
    {
        if ($this->isTableExists('prefix_forum')) {
            return true;
        }
        return false;
    }

    /**
     * Чистая установка
     */
    private function simpleInstall()
    {
        $this->ExportSQL(dirname(__FILE__).'/sql/install.sql');
    }

    /**
     * Установка обновлений
     */
    private function updateInstall()
    {
        /**
         * Fixes
         */
        $this->ExportSQL(dirname(__FILE__) . '/sql/primary_fix.sql');
        /**
         * Update
         */
        if ($this->isFieldExists('prefix_forum', 'forum_status')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20120418.sql');
        }
        if (!$this->isFieldExists('prefix_forum', 'forum_quick_reply')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20120423.sql');
        }
        if (!$this->isFieldExists('prefix_forum_topic', 'topic_user_ip')) {
            $this->ExportSQL(dirname(__FILE__).'/sql/update20120426.sql');
        }
        if (!$this->isFieldExists('prefix_forum_post', 'post_new_topic')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20120501.sql');
        }
        if (!$this->isFieldExists('prefix_forum', 'forum_limit_rating_topic')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20120502.sql');
        }
        if (!$this->isTableExists('prefix_forum_moderator')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20120819.sql');
        }
        if (!$this->isTableExists('prefix_forum_readonly')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20120826.sql');
        }
        if (!$this->isFieldExists('prefix_forum', 'forum_permissions')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20120828.sql');
        }
        if ($this->isFieldExists('prefix_forum', 'forum_moder')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20120920.sql');
        }
        if (!$this->isFieldExists('prefix_forum', 'forum_icon')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20121210.sql');
        }
        if (!$this->isFieldExists('prefix_forum_post', 'post_parent_id')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20130406.sql');
        }
        if (!$this->isTableExists('prefix_forum_user')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20130519.sql');
        }
        if (!$this->isTableExists('prefix_forum_marker')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20130609.sql');
        }
        if (!$this->isFieldExists('prefix_forum', 'forum_options')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20130624.sql');
        }
        if (!$this->isTableExists('prefix_forum_file')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20130820.sql');
        }
        if (!$this->isFieldExists('prefix_forum_post', 'post_rating')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20130925.sql');
        }
        if (!$this->isFieldExists('prefix_forum_user', 'user_last_sync')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql/update20140615.sql');
        }
    }

}
