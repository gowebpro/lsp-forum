<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: russian.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

return array(
	'forum' => 'Форум',
	'forums' => 'Форумы',
	'forums_no' => 'Форумов нет',
	'forum_and' => 'и',

	'forums_notice' => 'Здесь можно просто пообщаться',

	'forum_header_last_post' => 'Последнее сообщение',
	'forum_header_answers' => 'Ответов',
	'forum_header_topics' => 'Тем',
	'forum_header_views' => 'Просмотров',
	'forum_header_author' => 'Автор',

	'forum_empty' => 'Не найдено ни одной темы',

	'forum_on_page' => 'На страницу',

	'forum_stats' => 'Статистика форума',
	'forum_stats_visitors' => 'Сейчас на сайте',
	'forum_stats_birthday' => 'Дни рождения',
	'forum_stats_birthday_notice' => 'От души поздравляем, братюня',
	'forum_stats_post_count' => 'Написано сообщений',
	'forum_stats_topic_count' => 'Создано тем',
	'forum_stats_user_count' => 'Зарегистрировано пользователей',
	'forum_stats_user_last' => 'Последний зарегистрировавшийся пользователь',

	'forum_categories' => 'Категории',

	'forum_create' => 'Создать форум',
	'forum_create_ok' => 'Форум успешно создан',
	'forum_create_warning' => 'Перед тем, как создать форум создайте хотя бы 1 категорию',
	'forum_create_block_main' => 'Основные настройки',
	'forum_create_block_redirect' => 'Настройки переадресации',
	'forum_create_title' => 'Название форума',
	'forum_create_title_error' => 'Название форума должно быть от %%min%% до %%max%% символов',
	'forum_create_url' => 'URL форума',
	'forum_create_url_note' => 'Короткий адресс, по которому будет доступен форум (Необязательное поле)',
	'forum_create_url_error' => 'URL форума должен быть от %%min%% до %%max%% символов и только на латинице + цифры и знаки "-", "_"',
	'forum_create_url_error_badword' => 'URL форума должен отличаться от:',
	'forum_create_url_error_used' => 'Форум с таким URL уже существует',
	'forum_create_description' => 'Описание',
	'forum_create_parent' => 'Выберите родительский форум или категорию',
	'forum_create_sub_can_post' => 'Сделать форум категорией?',
	'forum_create_sub_can_post_notice' => 'Если вы выберите <b>«Да»</b>, то форум будет категорией, в нем будут запрещено открытие тем и публикация сообщений, соответственно, все нижеследующие настройки не будут иметь силы.<br><br>Если выберите <b>«Нет»</b>, то форум будет обычным, в нем будут разрешено открытие тем, публикация сообщений (если это разрешено).',
	'forum_create_forum_redirect_url' => 'URL адрес для перемещения',
	'forum_create_forum_redirect_url_notice' => '',
	'forum_create_forum_redirect_on' => 'Переключить форум на перемещение?',
	'forum_create_forum_redirect_on_notice' => 'При выборе «Да» нижеследующие блоки настроек не будут иметь силы, так как форум станет лишь ссылкой. Уже существующие темы в форуме будут недоступны!',
	'forum_create_submit' => 'Создать',

	'forum_create_forum' => 'Создать форум',
	'forum_create_category' => 'Создать категорию',

	'forum_edit' => 'Редактировать форум',
	'forum_edit_ok' => 'Изменения сохранены',
	'forum_edit_submit' => 'Сохранить изменения',

	'forum_edit_forum' => 'Редактировать форум',
	'forum_edit_category' => 'Редактировать категорию',

	'forum_delete' => 'Удалить форум',
	'forum_delete_confirm' => 'Удалить форум %%title%%',
	'forum_delete_move_items' => 'Переместить все имеющиеся темы и сообщения в',
	'forum_delete_move_items_note' => '',
	'forum_delete_move_items_error_category' => 'Вы не можете перенести темы и сообщения в категорию',
	'forum_delete_move_items_error_self' => 'Вы не можете переместить темы и сообщения в удаляемый форум!',
	'forum_delete_move_items_error_descendants' => '',
	'forum_delete_move_childrens' => 'Переместить все имеющиеся подфорумы в',
	'forum_delete_move_childrens_note' => '',
	'forum_delete_move_childrens_error_self' => 'Вы не можете переместить подфорумы в удаляемый форум!',
	'forum_delete_move_childrens_error_descendants' => '',
	'forum_delete_move_error' => '',
	'forum_delete_success' => 'Форум удален',

	'forum_delete_forum' => 'Удалить форум',
	'forum_delete_category' => 'Удалить категорию',


	'forum_topic' => 'Тема',
	'forum_topic_close' => 'Закрыть тему',
	'forum_topic_open' => 'Открыть тему',
	'forum_topic_delete' => 'Удалить тему',
	'forum_topic_delete_warning' => 'При удалении темы, также все ее сообщения. Продолжайте только в том случае, если вы действительно хотите удалить эту тему. Больше никаких предупреждений не будет.',
	'forum_topic_pin' => '"Поднять" тему',
	'forum_topic_unpin' => '"Опустить" тему',
	'forum_topic_answers' => 'Ответы в тему',

	'forum_topics' => 'Темы',
	'forum_topics_forum' => 'Темы форума',
	'forum_topics_pinned' => 'Важные темы',
	'forum_topic_pinned' => 'Прикреплена',
	'forum_topic_closed' => 'Тема закрыта',
	'forum_topic_mod_option' => 'Опции модератора',
	'forum_topic_move' => 'Переместить тему',
	'forum_topic_move_for' => 'Переместить тему в форум',
	'forum_topic_move_error_self' => 'Эта тема итак находится в выбранном форуме!',
	'forum_topic_move_error_category' => 'Вы не можете перенести тему в категорию',
	'forum_topic_post_count' => 'Сообщений в теме',
	'forum_topic_time_acl' => 'Вам нельзя создавать топики',
	'forum_topic_time_limit' => 'Вам нельзя создавать топики слишком часто',

	'forum_new_topic' => 'Новая тема',
	'forum_new_topic_for' => 'Создание темы в',
	'forum_new_topic_title' => 'Название темы',
	'forum_new_topic_title_notice' => '',
	'forum_new_topic_title_error' => 'Название должно быть от %%min%% до %%max%% символов',
	'forum_new_topic_description' => 'Описание',
	'forum_new_topic_description_notice' => 'Опционально',
	'forum_new_topic_description_error' => 'Описание темы не должно превышать 100 символов',
	'forum_new_topic_text' => 'Текст',
	'forum_new_topic_text_error' => 'Текст должен быть от %%min%% до %%max%% символов',
	'forum_new_topic_not_allow' => 'Вы не можете создать новую тему',

	'forum_new_topic_pin' => 'Закрепить',
	'forum_new_topic_close' => 'Закрыть',


	'forum_post' => 'Сообщение',
	'forum_posts' => 'Сообщения',
	'forum_post_anchor_promt' => 'Копирование прямой ссылки этого сообщения, для сохранения в буфере обмена',
	'forum_post_last' => 'Последнее сообщение',
	'forum_post_create_title' => 'Заголовок сообщения',
	'forum_post_create_title_notice' => 'Необязательно',
	'forum_post_create_title_error' => 'Название сообщения должно быть от 2 до 100 символов',
	'forum_post_create_text_error' => 'Текст сообщения должен быть от 2 до %%count%% символов',
	'forum_post_create_text_error_unique' => 'Вы уже писали сообщение с таким содержанием',
	'forum_post_by' => 'от',//!!

	'forum_reply' => 'Ответ',
	'forum_reply_for' => 'Ответ в %%topic%%',
	'forum_reply_notallow' => 'Тема закрыта',
	'forum_reply_not_allow' => 'Вы не можете написать в эту тему',
	'forum_post_edit_for' => 'Редактирование ответа в %%topic%%',
	'forum_fast_reply' => 'Быстрый ответ',

	'forum_redirect_hits' => 'Переходов',

	'forum_subforums' => 'Подфорумы',
	'forum_themes_list' => 'Список тем',

	'forum_not_reading' => 'Новые темы',

	'forum_acp' => 'Управление форумом',
	'forum_acp_main' => 'Центр управления',
	'forum_acp_forums_control' => 'Управление форумами',
	'forum_acp_forums_list_msg' => 'Внимание, при удалении категории так-же удаляются все форумы и топики, связанные с этой категорией. В скором времени будут функции переноса.',

	'forum_plugin_about' => 'О плагине',
	'forum_plugin_about_text' => '<strong>CC BY-NC (Атрибуция — Некоммерческое использование)</strong><br>Эта лицензия позволяет другим изменять, поправлять и брать за основу ваше произведение некоммерческим образом и хотя их новые произведения должны указывать вас в качестве автора и быть некоммерческими и они не должны лицензировать их производные произведения на тех же условиях.<br><a href="http://creativecommons.org/licenses/by-nc/3.0/" target="_blank"><img src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" title="ARS Mod License" width="88" height="31"></a><br><a href="http://creativecommons.org/licenses/by-nc/3.0" target="_blank">Смотреть общее краткое описание лицензии</a><br><a href="http://creativecommons.org/licenses/by-nc/3.0/legalcode" target="_blank">Смотреть юридический текст</a>',

);

?>