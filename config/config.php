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
$config['topic_per_page']		= 10;
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
 * Настройки статистики
 */
$config['stats'] = array(
	/* Показывать пользователей онлайн (при наличии модуля Visitors) */
	'online' => true,
	/* Максимально отображаемое количество пользователей в списке */
	'users_count' => 20,
	/* Показывать блок с именниниками */
	'bdays' => true,
	/* Показывать последнего зарегистрировавшегося? */
	'last_user' => false,
);

/**
 * Режим отображения топика
 & Варианты:
 *		true		; Линейный (1 сообщение шапка)
 *		false		; Обычный
 */
$config['topic_line_mod']		= true;

/**
 * Активация плагина
 */
$config['activate'] = array();

/**
 * Деактивация плагина
 */
$config['deactivate'] = array(
	/* Удаление таблиц при деактивации */
	'delete' => false
);


/**
 * Настройки роутера
 */
Config::Set('router.page.forum', 'PluginForum_ActionForum');

return $config;

?>