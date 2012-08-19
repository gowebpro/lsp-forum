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

	'button_edit' => 'Редактировать',
	'button_delete' => 'Удалить',

	'in_progress' => 'В разработке',
	'notice' => 'Здесь можно просто пообщаться',

	'header_last_post' => 'Последнее сообщение',
	'header_answers' => 'Ответов',
	'header_topics' => 'Тем',
	'header_views' => 'Просмотров',
	'header_author' => 'Автор',

	'clear' => 'Форумов нет',
	'empty' => 'Не найдено ни одной темы',
	'on_page' => 'На страницу',
	'and' => 'и',

	'stats' => 'Статистика форума',
	'stats_visitors' => 'Сейчас на сайте',
	'stats_birthday' => 'Дни рождения',
	'stats_birthday_notice' => '',
	'stats_post_count' => 'Написано сообщений',
	'stats_topic_count' => 'Создано тем',
	'stats_user_count' => 'Зарегистрировано пользователей',
	'stats_user_last' => 'Последний зарегистрировавшийся пользователь',

	'categories' => 'Категории',

	'create' => 'Создать форум',
	'create_ok' => 'Форум успешно создан',
	'create_warning' => 'Перед тем, как создать форум создайте хотя бы 1 категорию',
	'create_block_main' => 'Основные настройки',
	'create_block_redirect' => 'Настройки переадресации',
	'create_title' => 'Название форума',
	'create_url' => 'URL форума',
	'create_url_note' => 'Короткий адрес, по которому будет доступен форум (Необязательное поле)',
	'create_url_error' => 'URL форума должен быть от %%min%% до %%max%% символов и только на латинице + цифры и знаки "-", "_"',
	'create_url_error_badword' => 'URL форума должен отличаться от:',
	'create_url_error_used' => 'Форум с таким URL уже существует',
	'create_sort' => 'Сортировка',
	'create_sort_notice' => 'Устанавливает сортировку при отображении',
	'create_description' => 'Описание',
	'create_parent' => 'Выберите родительский форум или категорию',
	'create_type' => 'Состояние форума',
	'create_type_notice' => '',
	'create_type_active' => 'Активный',
	'create_type_archive' => 'Архив только для чтения',
	'create_sub_can_post' => 'Сделать форум категорией?',
	'create_sub_can_post_notice' => 'Если вы выберите <b>«Да»</b>, то форум будет категорией, в нем будут запрещено открытие тем и публикация сообщений, соответственно, все нижеследующие настройки не будут иметь силы.<br><br>Если выберите <b>«Нет»</b>, то форум будет обычным, в нем будут разрешено открытие тем, публикация сообщений (если это разрешено).',
	'create_quick_reply' => 'Включить форму быстрого ответа для этого форума?',
	'create_quick_reply_notice' => '',
	'create_password' => 'Требовать пароль при заходе на форум?',
	'create_password_notice' => 'Вы можете заблокировать форум и пускать на него только по паролю<br/>Вы можете оставить поле пустым, чтобы не использовать пароль вообще.',
	'create_rating' => 'Ограничение по рейтингу',
	'create_rating_notice' => 'Рейтинг, который необходим пользователю, чтобы создать тему в этот форум',
	'create_redirect_url' => 'URL адрес для перемещения',
	'create_redirect_url_notice' => '',
	'create_redirect_on' => 'Переключить форум на перемещение?',
	'create_redirect_on_notice' => 'При выборе <b>«Да»</b> нижеследующие блоки настроек не будут иметь силы, так как форум станет лишь ссылкой. Уже существующие темы в форуме будут недоступны!',
	'create_submit' => 'Создать',

	'create_forum' => 'Создать форум',
	'create_category' => 'Создать категорию',

	'edit' => 'Редактировать форум',
	'edit_ok' => 'Изменения сохранены',
	'edit_submit' => 'Сохранить изменения',

	'edit_forum' => 'Редактировать форум',
	'edit_category' => 'Редактировать категорию',

	'delete' => 'Удалить форум',
	'delete_confirm' => 'Удалить форум %%title%%',
	'delete_move_items' => 'Переместить все имеющиеся темы и сообщения в',
	'delete_move_items_note' => '',
	'delete_move_items_error_category' => 'Вы не можете перенести темы и сообщения в категорию',
	'delete_move_items_error_self' => 'Вы не можете переместить темы и сообщения в удаляемый форум!',
	'delete_move_items_error_descendants' => '',
	'delete_move_childrens' => 'Переместить все имеющиеся подфорумы в',
	'delete_move_childrens_note' => '',
	'delete_move_childrens_error_self' => 'Вы не можете переместить подфорумы в удаляемый форум!',
	'delete_move_childrens_error_descendants' => '',
	'delete_move_error' => '',
	'delete_success' => 'Форум удален',

	'delete_forum' => 'Удалить форум',
	'delete_category' => 'Удалить категорию',

	'password' => 'Пароль форума',
	'password_write' => 'Введите пароль форума',
	'password_security' => 'Этот форум защищен паролем',
	'password_security_notice' => 'Вы должны ввести верный пароль для доступа в этот форум. Проверьте и убедитесь, что ваш браузер поддерживает временные cookies.',
	'password_blank' => 'Вы не ввели пароль',
	'password_wrong' => 'Введенный пароль неверный. Повторите попытку.',
	'password_submit' => 'Войти',


	'topic' => 'Тема',
	'topic_close' => 'Закрыть тему',
	'topic_open' => 'Открыть тему',
	'topic_delete' => 'Удалить тему',
	'topic_delete_warning' => 'При удалении темы, также будут удалены все ее сообщения. Продолжайте только в том случае, если вы действительно хотите удалить эту тему. Больше никаких предупреждений не будет.',
	'topic_pin' => '"Поднять" тему',
	'topic_unpin' => '"Опустить" тему',
	'topic_answers' => 'Ответы в тему',

	'topics' => 'Темы',
	'topics_forum' => 'Темы форума',
	'topics_pinned' => 'Важные темы',
	'topic_pinned' => 'Прикреплена',
	'topic_closed' => 'Тема закрыта',
	'topic_mod_option' => 'Опции модератора',
	'topic_move' => 'Переместить тему',
	'topic_move_for' => 'Переместить тему в форум',
	'topic_move_error_self' => 'Эта тема итак находится в выбранном форуме!',
	'topic_move_error_category' => 'Вы не можете перенести тему в категорию',
	'topic_post_count' => 'Сообщений в теме',
	'topic_acl' => 'Вам нельзя создавать темы',
	'topic_time_limit' => 'Вам нельзя создавать темы слишком часто',

	'new_topic' => 'Новая тема',
	'new_topic_for' => 'Создание темы в',
	'new_topic_title' => 'Название темы',
	'new_topic_title_notice' => '',
	'new_topic_title_error' => 'Название должно быть от %%min%% до %%max%% символов',
	'new_topic_description' => 'Описание',
	'new_topic_description_notice' => 'Опционально',
	'new_topic_description_error' => 'Описание темы не должно превышать 100 символов',
	'new_topic_text_error' => 'Текст должен быть от %%min%% до %%max%% символов',
	'new_topic_not_allow' => 'Вы не можете создать новую тему',

	'new_topic_pin' => 'Закрепить',
	'new_topic_close' => 'Закрыть',

	'topic_edit' => 'Редактирование темы',
	'topic_edit_not_allow' => 'Нет доступа к этому действию',


	'post' => 'Сообщение',
	'posts' => 'Сообщения',
	'post_anchor_promt' => 'Копирование прямой ссылки этого сообщения, для сохранения в буфере обмена',
	'post_last' => 'Последнее сообщение',
	'post_create_title' => 'Заголовок сообщения',
	'post_create_title_notice' => 'Необязательно',
	'post_create_title_error' => 'Название сообщения должно быть от 2 до 100 символов',
	'post_create_text' => 'Текст сообщения',
	'post_create_text_notice' => 'Доступны html-теги',
	'post_create_text_error_unique' => 'Вы уже писали сообщение с таким содержанием',
	'post_by' => 'от',//!!
	'post_edit' => 'Редактирование ответа',
	'post_edit_for' => 'Редактирование ответа в %%topic%%',
	'post_edit_reason' => 'Причина редактирования',
	'post_edit_reason_notice' => 'Обязательное поле',
	'post_edit_not_allow' => 'Нет доступа к этому действию',
	'post_editing' => 'Последний раз редактировал пользователь',
	'post_delete_not_allow' => 'Нет доступа к этому действию',

	'reply' => 'Ответ',
	'reply_for' => 'Ответ в %%topic%%',
	'reply_not_allow' => 'Вы не можете написать в эту тему',
	'reply_not_allow_close' => 'Тема закрыта',
	'reply_time_limit' => 'Вам нельзя отправлять сообщения слишком часто',
	'fast_reply' => 'Быстрый ответ',

	'redirect_hits' => 'Переходов',

	'subforums' => 'Подфорумы',
	'themes_list' => 'Список тем',

	'not_reading' => 'Новые темы',

	'acp' => 'Управление форумом',
	'acp_main' => 'Центр управления',
	'acp_forums_control' => 'Управление форумами',
	'acp_forums_moders' => 'Управление модераторами',

	'moderators' => 'Модераторы',
	'moderators_list' => 'Список модераторов',
	'moderators_empty' => 'Модераторов нет',
	'moderator_add' => 'Добавить модератора в форум',
	'moderator_add_ok' => 'Модератор успешно добавлен',
	'moderator_add_error_exsist' => 'Пользователь %%login%% уже является модератором этого форума',
	'moderator_action_error_forum' => 'Форум выбран непривильно',
	'moderator_action_error_user' => 'Пользователь %%login%% не найден',
	'moderator_del' => 'Убрать этого модератора',
	'moderator_del_ok' => 'Модератор убран',
	'moderator_del_error_exsist' => 'Пользователь %%login%% не является модератором этого форума',

	'sort_up' => 'Переместить выше',
	'sort_down' => 'Переместить ниже',
	'sort_submit_ok' => 'Сортировка изменена',

	'plugin_about' => 'О плагине',
	'plugin_about_text' => '<strong>CC BY-NC (Атрибуция — Некоммерческое использование)</strong><br>Эта лицензия позволяет другим изменять, поправлять и брать за основу ваше произведение некоммерческим образом и хотя их новые произведения должны указывать вас в качестве автора и быть некоммерческими и они не должны лицензировать их производные произведения на тех же условиях.<br><a href="http://creativecommons.org/licenses/by-nc/3.0/" target="_blank"><img src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" title="ARS Mod License" width="88" height="31"></a><br><a href="http://creativecommons.org/licenses/by-nc/3.0" target="_blank">Смотреть общее краткое описание лицензии</a><br><a href="http://creativecommons.org/licenses/by-nc/3.0/legalcode" target="_blank">Смотреть юридический текст</a>',

	'welcome' => '<a href="%%root%%admin/forums/new?type=category">Создать первый форум</a>',

	'topics_declension' => 'Тема;Темы;Тем',
	'posts_declension' => 'Сообщение;Сообщения;Сообщений',
	'redirect_hits_declension' => 'Переход;Перехода;Переходов',
	'views_declension' => 'Просмотр;Просмотра;Просмотров',
	'users_declension' => 'Пользователь;Пользователя;Пользователей',
	'guest_declension' => 'Гость;Гостя;Гостей',

	'user_menu_publication_topics' => 'Темы на форуме',
	'user_menu_publication_posts' => 'Сообщения на форуме',

	'event_type_add_topic' => 'Добавление темы на форум',
	'event_type_add_post' => 'Добавление сообщения на форум',

	'event_add_topic' => 'Добавил новую тему на форуме',
	'event_add_post' => 'Добавил новое сообщение на форуме к теме',

	'subscribe_forum' => 'Подписка на новые темы',
	'subscribe_topic' => 'Подписка на новые сообщения',

	'notify_subject_new_topic' => 'Новая тема на форуме',
	'notify_subject_new_post' => 'Новый ответ в тему',
);

?>