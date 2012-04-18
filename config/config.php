<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: config.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

$config=array();

/**
 * Количество топиков на страницу
 */
$config['topic_per_page']		= 20;
/**
 * Количество постов на страницу
 */
$config['post_per_page']		= 10;

/**
 * Максимальный размер поста в символах
 */
$config['post_max_length']		= 5000;

/**
 * Быстрый ответ в топиках (Вкл\Выкл)
 */
$config['fast_reply']			= true;


/**
 * Активация плагина
 *
 */
$config['activate'] = array();

/**
 * Деактивация плагина
 *
 */
$config['deactivate'] = array();

/**
 * Удаление таблиц при деактивации
 */
$config['deactivate']['delete'] = false;


/**
 * Настройки роутера
 */
Config::Set('router.page.forum', 'PluginForum_ActionForum');

return $config;

?>