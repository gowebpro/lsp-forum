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

$config['encrypt'] = 'ChiffaYo';

/**
 * Закрытый режим
 * Закрыть раздел от всех, кроме админа
 */
$config['close_mode']			= false;

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
	'last_user' => true,
);

/**
 * ACL
 */
$config['acl']['create']['topic']['time'] = 240;			// время в секундах между созданием топиков, если 0 то ограничение по времени не будет работать
$config['acl']['create']['topic']['time_rating'] = 5;		// рейтинг, выше которого перестаёт действовать ограничение по времени на создание записей
$config['acl']['create']['post']['rating'] = -10;			// порог рейтинга при котором юзер может оставлять ответы
$config['acl']['create']['post']['time'] = 60;				// время в секундах между созданием ответов, если 0 то ограничение по времени не будет работать
$config['acl']['create']['post']['time_rating'] = 5;		// рейтинг, выше которого перестаёт действовать ограничение по времени на создание записей
$config['acl']['edit']['post']['time'] = 60*60*15;			// время в секундах для возможности редактирования ответа, если 0 то ограничение по времени не будет работать
$config['acl']['vote']['topic']['rating'] = 1;				// порог рейтинга при котором юзер может голосовать за топик
$config['acl']['vote']['topic']['time'] = 60*60*24*7;		// ограничение времени голосования за топик
$config['acl']['vote']['post']['rating'] = 0;				// порог рейтинга при котором юзер может голосовать за пост
$config['acl']['vote']['post']['time'] = 60*60*24*1;		// ограничение времени голосования за пост


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
 * Настройка Jevix
 */
$aJevix = Config::Get('jevix.default');
$aJevix['cfgAllowTagParams'][] = array('blockquote', array('post'=>'#int'));
Config::Set('jevix.forum',$aJevix);

/**
 * Настройка таблиц
 */
Config::Set('db.table.forum', '___db.table.prefix___forum');
Config::Set('db.table.forum_moderator', '___db.table.prefix___forum_moderator');
Config::Set('db.table.forum_moderator_rel', '___db.table.prefix___forum_moderator_rel');
Config::Set('db.table.forum_post', '___db.table.prefix___forum_post');
Config::Set('db.table.forum_topic', '___db.table.prefix___forum_topic');
Config::Set('db.table.forum_topic_view', '___db.table.prefix___forum_topic_view');
Config::Set('db.table.forum_readonly', '___db.table.prefix___forum_readonly');


/**
 * Настройки роутера
 */
Config::Set('router.page.forum', 'PluginForum_ActionForum');

return $config;

?>