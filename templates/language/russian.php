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

	'forum_closed' => 'Закрытый форум',

	'authorization' => 'Авторизация',
	/**
	 * Кнопки
	 */
	'button_edit' => 'Редактировать',
	'button_delete' => 'Удалить',
	'button_reply' => 'Ответить',
	'button_quote' => 'Цитировать',
	'button_publish' => 'Опубликовать',
	'button_preview' => 'Предпросмотр',
	'button_cancel' => 'Отмена',
	'button_insert' => 'Вставить',
	'button_save' => 'Сохранить',

	'in_progress' => 'В разработке',
	'notice' => 'Здесь можно просто пообщаться',
	/**
	 * Заголовки
	 */
	'header_last_post' => 'Последнее сообщение',
	'header_answers' => 'Ответов',
	'header_topics' => 'Тем',
	'header_views' => 'Просмотров',
	'header_author' => 'Автор',

	'clear' => 'Форумов нет',
	'empty' => 'Не найдено ни одной темы',
	'on_page' => 'На страницу',
	'and' => 'и',

	'refresh' => 'Пересчет показателей',
	'refresh_submit_ok' => 'Показатели форума пересчитаны',

	'select_forum' => 'Выбрать форум',
	'select_topic' => 'Выбрать топик',
	/**
	 * Статистика
	 */
	'stats' => 'Статистика форума',
	'stats_visitors' => 'Сейчас на сайте',
	'stats_birthday' => 'Дни рождения',
	'stats_birthday_notice' => '',
	'stats_post_count' => 'Написано сообщений',
	'stats_topic_count' => 'Создано тем',
	'stats_user_count' => 'Зарегистрировано пользователей',
	'stats_user_last' => 'Последний зарегистрировавшийся пользователь',
	'stats_activity' => 'Активность',
	'stats_last_post' => 'Последнее сообщение',
	'stats_last_topic' => 'Поледняя тема',


	'categories' => 'Категории',
	/**
	 * Создание\редактирование\удаление форума
	 */
	'create' => 'Создать форум',
	'create_ok' => 'Форум успешно создан',
	'create_warning' => 'Перед тем, как создать форум создайте хотя бы 1 категорию',
	'create_block_main' => 'Основные настройки',
	'create_block_options' => 'Общие настройки',
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
	'create_parent_error' => 'Неверная категория',
	'create_parent_error_descendants' => 'К сожалению, это невозможно. Вы пытаетесь вложить форум или категорию в свою структуру подфорумов',
	'create_perms' => 'Копировать права доступа из',
	'create_perms_not' => 'Не копировать права доступа',
	'create_perms_notice' => 'Вновь созданному форуму будут присвоены те же права доступа, что и у выбранного из списка. Если ничего не выбрано, созданный форум не будет отображаться на форуме до установки прав доступа',
	'create_type' => 'Состояние форума',
	'create_type_notice' => '',
	'create_type_active' => 'Активный',
	'create_type_archive' => 'Архив только для чтения',
	'create_sub_can_post' => 'Сделать форум категорией?',
	'create_sub_can_post_notice' => 'Если вы выберите <b>«Да»</b>, то форум будет категорией, в нем будут запрещено открытие тем и публикация сообщений, соответственно, все нижеследующие настройки не будут иметь силы.<br><br>Если выберите <b>«Нет»</b>, то форум будет обычным, в нем будут разрешено открытие тем, публикация сообщений (если это разрешено).',
	'create_quick_reply' => 'Включить форму быстрого ответа',
	'create_quick_reply_notice' => 'Включает функцию быстрого ответа для данного форума',
	'create_display_subforum_list' => 'Показывать подфорумы в списке',
	'create_display_subforum_list_notice' => 'Отображает подфорумы этого форума на главной и других страницах как ссылку в списке, если для этих подфорумов включена функция «Показывать форум в списке подфорумов»',
	'create_display_on_index' => 'Показывать форум в списке подфорумов',
	'create_display_on_index_notice' => 'Отображает ссылку на данный форум в списке подфорумов родительского форума, если таковой существует',
	'create_topics_per_page' => 'Тем на страницу',
	'create_topics_per_page_notice' => 'Если отлично от нуля, это значение заменит настройку количества тем на страницу по умолчанию (%%default%%)',
	'create_posts_per_page' => 'Сообщений на страницу темы',
	'create_posts_per_page_notice' => 'Если отлично от нуля, это значение заменит настройку количества сообщений на страницу по умолчанию (%%default%%)',
	'create_posts_hot_topic' => 'Сообщений в популярной теме',
	'create_posts_hot_topic_notice' => 'Если отлично от нуля, тема будет считаться "популярной" при наборе этого количества сообщений',
	'create_password' => 'Требовать пароль при заходе на форум?',
	'create_password_notice' => 'Вы можете заблокировать форум и пускать на него только по паролю<br/>Вы можете оставить поле пустым, чтобы не использовать пароль вообще.',
	'create_rating' => 'Ограничение по рейтингу',
	'create_rating_notice' => 'Рейтинг, который необходим пользователю, чтобы создать тему в этот форум',
	'create_redirect_url' => 'URL адрес для перемещения',
	'create_redirect_url_notice' => '',
	'create_redirect_on' => 'Переключить форум на перемещение?',
	'create_redirect_on_notice' => 'При выборе <b>«Да»</b> нижеследующие блоки настроек не будут иметь силы, так как форум станет лишь ссылкой. Уже существующие темы в форуме будут недоступны!',
	'create_submit' => 'Создать',
	'create_icon' => 'Иконка форума',
	'create_icon_notice' => '',
	'create_icon_error' => 'Не удалось загрузить иконку',
	'create_icon_delete' => 'Удалить',

	'create_forum' => 'Создать форум',
	'create_category' => 'Создать категорию',

	'edit' => 'Редактировать форум',
	'edit_ok' => 'Изменения сохранены',
	'edit_submit' => 'Сохранить изменения',
	'edit_submit_next_perms' => 'Сохранить и настроить права доступа',

	'edit_forum' => 'Редактировать форум',
	'edit_category' => 'Редактировать категорию',

	'delete' => 'Удалить форум',
	'delete_confirm' => 'Удалить форум %%title%%',
	'delete_move_items' => 'Переместить все имеющиеся темы и сообщения в',
	'delete_move_items_note' => '',
	'delete_move_items_error_category' => 'Вы не можете перенести темы и сообщения в категорию',
	'delete_move_items_error_self' => 'Вы не можете переместить темы и сообщения в удаляемый форум!',
	'delete_move_items_error_descendants' => 'К сожалению, это невозможно. Вы пытаетесь переместить темы и сообщения в структуру удаляемого форума',
	'delete_move_childrens' => 'Переместить все имеющиеся подфорумы в',
	'delete_move_childrens_note' => '',
	'delete_move_childrens_error_self' => 'Вы не можете переместить подфорумы в удаляемый форум!',
	'delete_move_childrens_error_descendants' => 'К сожалению, это невозможно. Вы пытаетесь переместить подфорумы в структуру удаляемого форума',
	'delete_move_error' => 'Выбран не существующий форум',
	'delete_success' => 'Форум удален',

	'delete_forum' => 'Удалить форум',
	'delete_category' => 'Удалить категорию',
	/**
	 * Авторизация на форум
	 */
	'password' => 'Пароль форума',
	'password_write' => 'Введите пароль форума',
	'password_security' => 'Этот форум защищен паролем',
	'password_security_notice' => 'Вы должны ввести верный пароль для доступа в этот форум. Проверьте и убедитесь, что ваш браузер поддерживает временные cookies.',
	'password_blank' => 'Вы не ввели пароль',
	'password_wrong' => 'Введенный пароль неверный. Повторите попытку.',
	'password_submit' => 'Войти',

	'forum_read' => 'Не прочитанных тем нет',
	'forum_unread' => 'Есть не прочитанные темы',
	/**
	 * Топики
	 */
	'topic' => 'Тема',
	'topic_read' => 'Тема прочитана',
	'topic_unread' => 'Тема не прочитана',
	'topic_close' => 'Закрыть тему',
	'topic_open' => 'Открыть тему',
	'topic_delete' => 'Удалить тему',
	'topic_delete_warning' => 'При удалении темы, также будут удалены все ее сообщения. Продолжайте только в том случае, если вы действительно хотите удалить эту тему. Больше никаких предупреждений не будет.',
	'topic_pin' => '"Поднять" тему',
	'topic_unpin' => '"Опустить" тему',
	'topic_merge' => 'Соединить тему',
	'topic_split' => 'Разделить тему',
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
	'topic_move_posts' => 'Переместить сообщения',
	'topic_move_posts_for' => 'Вам нужно выбрать тему, в которую вы хотите перенести сообщения',
	'topic_move_posts_error_self' => 'Сообщения итак находятся в выбранной теме',
	'topic_move_posts_error_topic' => 'Вам нужно выбрать новую тему для сообщений',
	'topic_move_post_template' => 'Тема была перемещена из форума %%sOldForum%% в форум %%sNewForum%%',
	'topic_post_count' => 'Сообщений в теме',
	'topic_acl' => 'Вам не хватает рейтинга для создания темы в этом форуме',
	'topic_time_limit' => 'Вам нельзя создавать темы слишком часто',
	/**
	 * Создание\редактирование топика
	 */
	'new_topic' => 'Новая тема',
	'new_topic_for' => 'Создание темы в',
	'new_topic_forum' => 'Форум',
	'new_topic_forum_notice' => '',
	'new_topic_forum_error_unknown' => 'Вы должны выбрать форум',
	'new_topic_forum_error_empty' => 'К сожалению нет разделов для выбора',
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
	/**
	 * Сообщения
	 */
	'post' => 'Сообщение',
	'posts' => 'Сообщения',
	'post_anchor' => 'Ссылка на сообщение',
	'post_anchor_promt' => 'Копирование прямой ссылки этого сообщения, для сохранения в буфере обмена',
	'post_last' => 'Последнее сообщение',
	'post_last_view' => 'Просмотр последнего сообщения',
	'post_create_title' => 'Заголовок сообщения',
	'post_create_title_notice' => 'Необязательно',
	'post_create_title_error' => 'Название сообщения должно быть от 2 до 100 символов',
	'post_create_text' => 'Текст сообщения',
	'post_create_text_notice' => 'Доступны html-теги',
	'post_create_text_error_unique' => 'Вы уже писали сообщение с таким содержанием',
	'post_edit' => 'Редактирование ответа',
	'post_edit_for' => 'Редактирование ответа в %%topic%%',
	'post_edit_reason' => 'Причина редактирования',
	'post_edit_reason_notice' => 'Обязательное поле',
	'post_edit_not_allow' => 'Нет доступа к этому действию',
	'post_editing' => 'Последний раз редактировал пользователь',
	'post_delete_confirm' => 'Удалить это сообщение?',
	'post_delete_not_allow' => 'Нет доступа к этому действию',
	'post_writer' => 'Пишет',
	'post_view' => 'Просмотр сообщения',
	/**
	 * О пользователе
	 */
	'user_info_posts' => 'Сообщения',
	/**
	 * Ответ в тему
	 */
	'reply' => 'Ответ',
	'reply_for' => 'Ответ в %%topic%%',
	'reply_for_post' => 'Ответ на сообщение',
	'reply_not_allow' => 'Вы не можете написать в эту тему',
	'reply_not_allow_close' => 'Тема закрыта',
	'reply_time_limit' => 'Вам нельзя отправлять сообщения слишком часто',
	'fast_reply' => 'Быстрый ответ',

	'redirect_hits' => 'Переходов',

	'subforums' => 'Подфорумы',
	'themes_list' => 'Список тем',

	'not_reading' => 'Новые темы',

	'markread' => 'Отметить этот форум прочитанным',
	'markread_all' => 'Отметить все форумы прочитанными',
	/**
	 * Вложения
	 */
	'attach_upload_title' => 'Загрузка вложений',
	'attach_upload_rules' => 'Доступна загрузка файлов форматов %%FORMAT%%<br>Размер одного файла не должен превышать %%SIZE%% Kб<br>Максимальное число загружаемых файлов: %%COUNT%%',
	'attach_upload_file_choose' => 'Загрузить файл',
	'attach_file_delete' => 'Удалить',
	'attach_file_delete_confirm' => 'Удалить файл?',
	'attach_file_deleted' => 'Файл удален',
	'attach_file_added' => 'Файл загружен',
	'attach_file_hint' => '%%TEXT%%<br>Размер файла: %%SIZE%%<br>Скачан раз: %%COUNT%%',
	'attach_error_too_much_files' => 'Сообщение может содержать не более %%MAX%% файлов',
	'attach_error_bad_filesize' => 'Размер файла должен быть не более %%MAX%% Кб',
	'attach_my_files' => 'Мои файлы',
	'attach_my_files_notice' => 'Вы можете прикрепить к сообщению файл, уже загруженный ранее',
	'attach_file_size' => 'Размер файла',
	'attach_file_download' => 'Скачан',
	'attach_file_posts' => 'Прикреплен к',
	'attach_this' => 'Прикрепить',
	/**
	 * Голосование
	 */
	'vote_up' => 'нравится',
	'vote_down' => 'не нравится',
	'vote_error_already' => 'Вы уже голосовали за это сообщение!',
	'vote_error_self' => 'Вы не можете голосовать за свое сообщение!',
	'vote_error_guest' => 'для голосования необходимо авторизоваться',
	'vote_error_time' => 'Срок голосования за сообщение истёк!',
	'vote_error_acl' => 'У вас не хватает рейтинга и силы для голосования!',
	'vote_no' => 'пока никто не голосовал',
	'vote_ok' => 'Ваш голос учтен',
	'vote_ok_abstain' => 'Вы воздержались для просмотра рейтинга сообщения',
	'vote_count' => 'всего проголосовало',
	/**
	 * Сессии
	 */
	'sessions_event_forum_title' => 'Количество посетителей, просматривающих этот форум',
	'sessions_event_topic_title' => 'Количество посетителей, читающих эту тему',
	/**
	 * Админка
	 */
	'acp' => 'Управление форумом',
	'acp_main' => 'Центр управления',
	'acp_forums_control' => 'Управление форумами',
	'acp_forums_control_notice' => 'Каждый форум может иметь неограниченное количество подфорумов, и Вы можете определять, разрешено в нем создавать темы или нет (в последнем случае форум будет действовать как раздел). Здесь Вы можете добавлять, редактировать, закрывать, открывать каждый из форумов, устанавливать некоторые дополнительные настройки. Если Ваши сообщения и темы рассинхронизированы, Вы можете также синхронизировать форум. Вы должны скопировать или установить нужные права для того, чтобы вновь созданный форум отображался в списке форумов.',
	'acp_forums_moders' => 'Управление модераторами',
	/**
	 * Управление файлами
	 */
	'acp_files' => 'Файлы',
	'acp_files_control' => 'Управление вложениями',
	'acp_files_control_notice' => 'Раздел находится в разработке.<br>Здесь представлены все загруженные файлы<br>В дальнейшем здесь можно будет настраивать компонент и управлять расширениями файлов',
	'acp_files_empty' => 'Вложений не найдено',
	/**
	 * Модераторы
	 */
	'moderators' => 'Модераторы',
	'moderators_list' => 'Список модераторов',
	'moderators_empty' => 'Модераторов нет',
	'moderator_add' => 'Добавить модератора в форум',
	'moderator_add_ok' => 'Модератор успешно добавлен',
	'moderator_add_error_exsist' => 'Пользователь %%login%% уже является модератором этого форума',
	'moderator_del' => 'Убрать этого модератора',
	'moderator_del_confirm' => 'Убрать модератора?',
	'moderator_del_ok' => 'Модератор убран',
	'moderator_del_error_not_found' => 'Пользователь %%login%% не является модератором этого форума',
	'moderator_update_ok' => 'Изменения сохранены',
	'moderator_action_error_forum' => 'Форум выбран неправильно',
	'moderator_action_error_forum_cat' => 'Нельзя установить модератора категории',
	'moderator_action_error_user' => 'Пользователь %%login%% не найден',
	'moderator_action_error_not_found' => 'Модератор %%login%% не найден',
	'moderator_select_forum' => 'Выбрать форум',
	'moderator_select_user' => 'Выбрать пользователя',
	'moderator_select_user_placeholder' => 'Введите логин пользователя',
	'moderator_options' => 'Опции модерирования',
	'moderator_options_viewip' => 'Возможность видеть IP, с которого было написано сообщение',
	'moderator_options_editpost' => 'Возможность редактировать сообщения',
	'moderator_options_edittopic' => 'Возможность редактировать темы',
	'moderator_options_deletepost' => 'Возможность удалять сообщения',
	'moderator_options_deletetopic' => 'Возможность удалять темы',
	'moderator_options_movepost' => 'Возможность перемещать сообщения',
	'moderator_options_movetopic' => 'Возможность перемещать темы',
	'moderator_options_openclosetopic' => 'Возможность открывать/закрывать темы',
	'moderator_options_pintopic' => 'Возможность поднимать/опускать темы',
	/**
	 * Гости
	 */
	'guest_prefix' => 'Гость_',
	'guest_name' => 'Ваше имя',
	'guest_name_notice' => '',
	'guest_name_error' => 'Имя должно быть от %%min%% до %%max%% символов',
	'guest_captcha' => 'Введите цифры и буквы',
	'guest_captcha_error' => 'Неверный код',
	/**
	 * Права доступа
	 */
	'perms' => 'Права доступа',
	'perms_show' => 'Просмотр форума',
	'perms_read' => 'Чтение тем',
	'perms_reply' => 'Ответы в темы',
	'perms_start' => 'Создание тем',
	'perms_submit' => 'Сохранить',
	'perms_submit_next_edit' => 'Сохранить и редактировать форум',
	'perms_submit_ok' => 'Права доступа отредактированы',
	'perms_mask_name' => 'Название маски',
	/**
	 * Сортировка
	 */
	'sort_up' => 'Переместить выше',
	'sort_down' => 'Переместить ниже',
	'sort_submit_ok' => 'Сортировка изменена',
	/**
	 * Пользователи и группы
	 */
	'users' => 'Пользователи',
	'users_acp' => 'Управление пользователями',
	/**
	 * О плагине
	 */
	'plugin_about' => 'О плагине',
	'plugin_about_text' => '<strong>CC BY-NC (Атрибуция — Некоммерческое использование)</strong><br>Эта лицензия позволяет другим изменять, поправлять и брать за основу ваше произведение некоммерческим образом и хотя их новые произведения должны указывать вас в качестве автора и быть некоммерческими и они не должны лицензировать их производные произведения на тех же условиях.<br><a href="http://creativecommons.org/licenses/by-nc/3.0/" target="_blank"><img src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" title="ARS Mod License" width="88" height="31"></a><br><a href="http://creativecommons.org/licenses/by-nc/3.0" target="_blank">Смотреть общее краткое описание лицензии</a><br><a href="http://creativecommons.org/licenses/by-nc/3.0/legalcode" target="_blank">Смотреть юридический текст</a>',
	'plugin_donate' => 'Для пожертвований',

	'welcome' => '<a href="%%root%%admin/forums/new?type=category">Создать первый форум</a>',
	/**
	 * Склонения
	 */
	'moderators_declension' => 'Модератор;Модераторы;Модераторы',
	'topics_declension' => 'Тема;Темы;Тем',
	'posts_declension' => 'Сообщение;Сообщения;Сообщений',
	'redirect_hits_declension' => 'Переход;Перехода;Переходов',
	'views_declension' => 'Просмотр;Просмотра;Просмотров',
	'users_declension' => 'Пользователь;Пользователя;Пользователей',
	'guest_declension' => 'Гость;Гостя;Гостей',
	'attach_download_declension' => 'Раз;Раза;Раз',
	'attach_posts_declension' => 'Посту;Постам;Постам',
	/**
	 * Менюшки
	 */
	'user_menu_publication_topics' => 'Темы на форуме',
	'user_menu_publication_posts' => 'Сообщения на форуме',

	'create_menu_topic' => 'Тему на форуме',
	'write_topic' => 'Тема на форум',
	/**
	 * Активность
	 */
	'event_type_add_topic' => 'Добавление темы на форум',
	'event_type_add_post' => 'Добавление сообщения на форум',

	'event_add_topic' => 'Добавил новую тему на форуме',
	'event_add_post' => 'Добавил новое сообщение на форуме к теме',
	/**
	 * Подписка
	 */
	'subscribe_forum' => 'Подписка на новые темы',
	'subscribe_topic' => 'Подписка на новые сообщения',
	/**
	 * Заголовки уведомлений
	 */
	'notify_subject_new_topic' => 'Новая тема на форуме',
	'notify_subject_new_post' => 'Новый ответ в тему',
	'notify_subject_reply' => 'Ответ на сообщение',
	/**
	 * Блоки
	 */
	'block_stream' => 'Форум',
	'block_stream_empty' => 'Новых сообщений нет',
	'block_forum' => 'Последняя активность на форуме',
	/**
	 * Редактор
	 */
	'panel_spoiler' => 'Спойлер',
	'panel_spoiler_title' => 'Заголовок спойлера',
	'panel_spoiler_placeholder' => 'Скрытый текст',
	'panel_spoiler_insert' => 'Вставить спойлер',
	/**
	 * Confirm
	 */
	'confirm' => 'Подтвердите действие',
	'confirm_yes' => 'Подтверждаю',
	'confirm_no' => 'Отмена',
	/**
	 * Тулбар
	 */
	'toolbar_post_prev' => 'Предыдущий пост',
	'toolbar_post_next' => 'Следующий пост',
);

?>