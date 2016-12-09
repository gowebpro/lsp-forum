<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet version: 1.0
* @File Name: config.system.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Настройка таблиц базы данных
 */
Config::Set('db.table.forum', '___db.table.prefix___forum');
Config::Set('db.table.forum_file', '___db.table.prefix___forum_file');
Config::Set('db.table.forum_file_rel', '___db.table.prefix___forum_file_rel');
Config::Set('db.table.forum_moderator', '___db.table.prefix___forum_moderator');
Config::Set('db.table.forum_moderator_rel', '___db.table.prefix___forum_moderator_rel');
Config::Set('db.table.forum_post', '___db.table.prefix___forum_post');
Config::Set('db.table.forum_topic', '___db.table.prefix___forum_topic');
Config::Set('db.table.forum_topic_view', '___db.table.prefix___forum_topic_view');
Config::Set('db.table.forum_readonly', '___db.table.prefix___forum_readonly');
Config::Set('db.table.forum_user', '___db.table.prefix___forum_user');


/**
 * Настройки роутера
 */
Config::Set('router.page.forum', 'PluginForum_ActionForum');

?>