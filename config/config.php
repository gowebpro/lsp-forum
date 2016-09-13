<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet version: 1.0
* @File Name: config.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/


$config = array();

$config['encrypt'] = 'ChiffaYo';


/**
 * Если вы внесли пожертвование http://livestreetcms.com/profile/Chiffa/donate/
 * ставим true
 */
$config['donator']				= false;

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
 * Ограничение на количество символов в полях
 */
$config['topic']['title_min_length'] = 2;
$config['topic']['title_max_length'] = 100;
$config['topic']['descr_max_length'] = 100;

$config['post']['title_min_length'] = 2;
$config['post']['title_max_length'] = 100;
$config['post']['text_max_length'] = 5000;


/**
 * Добавлять в перемещенную тему пост с информацией по перемещению?
 */
$config['move_info_post']		= true;

/**
 * Настройки авто-подписки
 */
$config['subscribe']['topic']['forum_new_topic']	= false;	// авто-подписка автора топика на новые топики к форуме
$config['subscribe']['topic']['topic_new_post']		= true;		// авто-подписка автора топика на новые ответы к своему топику

$config['subscribe']['post']['topic_new_post']		= false;	// авто-подписка автора поста на новые ответы к топику

/**
 * Настройки статистики
 */
$config['stats'] = array(
	'global' => array(
		'count_post' => true,		// показать кол-во сообщений
		'count_topic' => true,		// показать кол-во тем
		'count_user' => true,		// показать кол-во юзеров (на сайте)
		'last_user' => true,		// показывать последнего зарегистрировавшегося?
	),
	/**
	 * Пользователи онлайн
	 */
	'online' => array(
		'enable' => true,
		'count' => 20
	),
	/**
	 * Именинники
	 */
	'bdays' => array(
		'enable' => true,
		'count' => 20
	),
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
$config['acl']['vote']['post']['time'] = 60*60*24*3;		// ограничение времени голосования за пост


/**
 * Режим отображения топика
 & Варианты:
 *		true		; Линейный (1 сообщение шапка)
 *		false		; Обычный
 */
$config['topic_line_mod']		= true;

/**
 * Формат чисел
 * Символ, используемый в качестве разделителя триад в больших числах
 & Варианты:
 *		false		; Форматирование выключено
 *		' '			; Пробел
 *		'.'			; Точка
 *		','			; Запятая
 */
$config['number_format']		= ',';

/**
 * Заменять кучу восклицательных и вопросительных знаков
 */
$config['title_format']			= true;

/**
 * Список размеров иконок для форума
 */
$config['icon_size']			= array(64,48,32,0);

/**
 * Смайлики
 */
$config['smiles_pack']			= 'default';

/**
 * Файлы
 * TODO: Управление форматами через админку
 */
$config['attach']['max_size'] = 10*1024; // максимально допустимый размер фото, Kb
$config['attach']['count_max'] = 10; // максимальное количество файлов
$config['attach']['format'] = 'zip,rar'; // допустимые форматы файлов
$config['attach']['format_swf'] = '*.zip;*.rar;*.7-zip;*.ZIP;*.RAR;*.7-ZIP'; // настройка для flash загрузчика


/**
 * Активация плагина
 */
$config['activate'] = array();

/**
 * Деактивация плагина
 */
$config['deactivate']['delete'] = false; //Удаление таблиц при деактивации


/**
 * Настройка путей
 */
$config['path_plugin']			= '___path.root.server___/plugins/forum';

$config['path_smarty_plug']		= '___plugin.forum.path_plugin___/smarty_plugs';// Папка плагинов для Smarty

$config['path_uploads']			= '___plugin.forum.path_plugin___/uploads';		//Путь для загрузок
$config['path_uploads_forum']	= '___plugin.forum.path_uploads___/forums';		//Путь для загрузок иконок форума
$config['path_uploads_smiles']	= '___plugin.forum.path_uploads___/smiles';		//Путь для загрузок смайлов
$config['path_uploads_files']	= '___plugin.forum.path_uploads___/files';		//Путь для загрузок файлов

$config['components'] = array(
	'session' => 1 //
);

return $config;
?>