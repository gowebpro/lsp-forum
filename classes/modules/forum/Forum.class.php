<?php

/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Forum.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum extends ModuleORM
{
    /**
     * Состояния тем
     */
    const TOPIC_STATE_OPEN = 0;
    const TOPIC_STATE_CLOSE = 1;
    const TOPIC_STATE_MOVED = 2;
    /**
     * Типы форума
     */
    const FORUM_TYPE_ARCHIVE = 0;
    const FORUM_TYPE_ACTIVE = 1;
    /**
     * Глобальные маски
     */
    const MASK_PERM_GUEST = 1;
    const MASK_PERM_USER = 2;
    const MASK_PERM_ADMIN = 3;
    /**
     * Префикс подфорумов для дерева
     */
    const DEPTH_GUIDE = '|&mdash;';
    /**
     * Маркеры
     */
    const MARKER_FORUM = 'F';
    const MARKER_TOPIC = 'T';
    const MARKER_TOPIC_FORUM = 'TF';
    const MARKER_USER = 'L';
    const MARKER_CNTS = 'C';
    /**
     * Дополнительные данные форумов
     */
    const FORUM_DATA_INDEX = 'Index';
    const FORUM_DATA_FORUM = 'Forum';
    const FORUM_DATA_TOPIC = 'Topic';
    const FORUM_DATA_RSS = 'Rss';
    /**
     * Объект текущего пользователя
     */
    protected $oUserCurrent = null;
    /**
     * Объект маппера форума
     */
    protected $oMapperForum = null;

    /**
     * Инициализация модуля
     */
    public function Init()
    {
        parent::Init();
        /**
         * Инициализируем вспомогательный маппер
         */
        $this->oMapperForum = Engine::GetMapper(__CLASS__);
        /**
         * Получаем текущего пользователя
         */
        $this->oUserCurrent = $this->User_GetUserCurrent();
    }

    /**
     * Функция создает и публикует сообщение в тему
     * @param    array $aData
     * @return    object
     */
    public function createPost($aData = array())
    {
        $sText = isset($aData['text']) ? $aData['text'] : null;
        $sUser = isset($aData['user']) ? $aData['user'] : null;
        $sTopic = isset($aData['topic']) ? $aData['topic'] : null;
        $sTitle = isset($aData['title']) ? $aData['title'] : null;
        $sGuest = isset($aData['guest']) ? $aData['guest'] : 'unknown';

        if ($sText) {
            $oPost = Engine::GetEntity('PluginForum_Forum_Post');
            $oPost->setTitle($sTitle);
            $oPost->setUserIp(func_getIp());
            $oPost->setDateAdd(date('Y-m-d H:i:s'));
            $oPost->setTextHash(md5($sText));
            $oPost->setTextSource($sText);
            $oPost->setText($this->PluginForum_Forum_TextParse($sText));
            if ($sUser) {
                $oPost->setUserId($sUser);
            } else {
                $oPost->setUserId(0);
                $oPost->setGuestName(strip_tags($sGuest));
            }
            if ($sTopic) {
                $oPost->setTopicId($sTopic);
                return $this->PluginForum_Forum_AddPost($oPost);
            } else {
                return $oPost;
            }
        }

        return null;
    }

    /**
     * Перемещает сообщения в другую тему
     *
     * @param    array $aPostsId
     * @param    integer $sTopicId
     * @return    bool
     */
    public function MovePosts($aPostsId, $sTopicId)
    {
        if (!is_array($aPostsId)) {
            $aPostsId = array($aPostsId);
        }
        if ($res = $this->oMapperForum->MovePosts($aPostsId, $sTopicId)) {
            //чистим кеш
            $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('PluginForum_ModuleForum_EntityPost_save'));
            return $res;
        }
        return false;
    }

    /**
     * Перемещает топики в другой форум
     *
     * @param    integer $sForumId
     * @param    integer $sForumIdNew
     * @return    bool
     */
    public function MoveTopics($sForumId, $sForumIdNew)
    {
        if ($res = $this->oMapperForum->MoveTopics($sForumId, $sForumIdNew)) {
            //чистим кеш
            $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('PluginForum_ModuleForum_EntityTopic_save'));
            return $res;
        }
        return false;
    }

    /**
     * Перемещает подфорумы в другой форум
     *
     * @param    integer $sForumId
     * @param    integer $sForumIdNew
     * @return    bool
     */
    public function MoveForums($sForumId, $sForumIdNew)
    {
        if ($res = $this->oMapperForum->MoveForums($sForumId, $sForumIdNew)) {
            //чистим кеш
            $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('PluginForum_ModuleForum_EntityForum_save'));
            return $res;
        }
        return false;
    }

    /**
     * Получает слудующий по сортировке форум
     *
     * @param    integer $iSort
     * @param    integer $sPid
     * @param    string $sWay
     * @return    object
     */
    public function GetNextForumBySort($iSort, $sPid, $sWay = 'up')
    {
        $sForumId = $this->oMapperForum->GetNextForumBySort($iSort, $sPid, $sWay);
        return $this->GetForumById($sForumId);
    }

    /**
     * Получает значение максимальной сортировки
     *
     * @param    integer $sPid
     * @return    integer
     */
    public function GetMaxSortByPid($sPid)
    {
        return $this->oMapperForum->GetMaxSortByPid($sPid);
    }

    /**
     * Получает статистику форума
     *    todo: opt
     *
     * @return    array
     */
    public function GetForumStats()
    {
        $aStats = array();
        /**
         * Кто онлайн?
         */
        if (Config::Get('plugin.forum.stats.online.enable')) {
            $aStats['online'] = array();
            /**
             * Если подключен модуль сессий
             */
            if (Config::Get('plugin.forum.components.session')) {
                $aSessionsUser = array();
                $aSessionsGuest = array();
                $aSessionsAll = $this->PluginForum_Session_GetSessions();
                foreach ($aSessionsAll as $oSession) {
                    if ($oSession->getUser()) {
                        $aSessionsUser[] = $oSession;
                        $aStats['online']['users'][] = $oSession->getUser();
                    } else {
                        $aSessionsGuest[] = $oSession;
                    }
                }
                $iCountUsers = count($aSessionsUser);
                $iCountGuest = count($aSessionsGuest);
            } else {
                /**
                 * Запрашиваем юзеров по последней дате посещения
                 */
                if ($aUsersLast = $this->User_GetUsersByDateLast(Config::Get('plugin.forum.stats.online.count'))) {
                    $aStats['online']['users'] = array();
                    foreach ($aUsersLast as $oUser) {
                        if ($oUser->isOnline()) {
                            $aStats['online']['users'][] = $oUser;
                        }
                    }
                    shuffle($aStats['online']['users']);
                }
                $iCountUsers = count($aStats['online']['users']);
                $iCountGuest = 0;
            }
            $iCountOnline = $iCountUsers + $iCountGuest;
            $aStats['online']['count_visitors'] = $iCountOnline;
            $aStats['online']['count_users'] = $iCountUsers;
            $aStats['online']['count_quest'] = $iCountGuest;
        }
        /**
         * Дни рождения
         */
        if (Config::Get('plugin.forum.stats.bdays.enable')) {
            $sKey = 'forum_user_bd_' . date('Ymd');
            if (false === ($aUsersBd = $this->Cache_Get($sKey))) {
                $aUsersBd = $this->oMapperForum->GetUsersByBirthday(Config::Get('plugin.forum.stats.bdays.count'));
                $aUsersBd = $this->User_GetUsersAdditionalData($aUsersBd, array());
                $this->Cache_Set($aUsersBd, $sKey, array('user_update', 'user_new'), 60 * 60 * 24 * 1);
            }
            $aStats['bdays'] = $aUsersBd;
        }
        /**
         * Получаем количество всех постов
         */
        if (Config::Get('plugin.forum.stats.global.count_post')) {
            $aStats['count_all_posts'] = $this->oMapperForum->GetCountPosts();
        }
        /**
         * Получаем количество всех топиков
         */
        if (Config::Get('plugin.forum.stats.global.count_topic')) {
            $aStats['count_all_topics'] = $this->oMapperForum->GetCountTopics();
        }
        /**
         * Получаем количество всех юзеров
         */
        if (Config::Get('plugin.forum.stats.global.count_user')) {
            $aStats['count_all_users'] = $this->oMapperForum->GetCountUsers();
        }
        /**
         * Получаем последнего зарегистрировавшегося
         */
        if (Config::Get('plugin.forum.stats.global.last_user')) {
            $aLastUsers = $this->User_GetUsersByDateRegister(1);
            $aStats['last_user'] = end($aLastUsers);
        }

        return $aStats;
    }

    /**
     * Получает статистику форумов
     *
     * @return    array
     */
    public function GetAdminStats()
    {
        $aStats = array();
        /**
         * Получаем количество всех постов
         */
        $iCountPosts = $this->oMapperForum->GetCountPosts();
        /**
         * Получаем количество всех топиков
         */
        //	$iCountTopics=$this->oMapperForum->GetCountTopics();

        $aForums = $this->GetForumItemsAll();

        foreach ($aForums as $oForum) {
            $aStats[$oForum->getId()] = array();
            //считаем активность
            $iActivity = (100 / $iCountPosts) * ($oForum->getCountPost());
            $iActivity = rtrim(rtrim(number_format(round($iActivity, 2), 2, '.', ''), '0'), '.');
            $aStats[$oForum->getId()]['activity'] = $iActivity;
            //последний топик
            if ($oLastTopic = $oForum->getTopic()) {
                $aStats[$oForum->getId()]['last_topic'] = $oLastTopic;
            }
        }

        return $aStats;
    }

    /**
     * Считает инфу по количеству постов и топиков в подфорумах
     *
     * @param    object $oForum
     * @param    boolean $bPerm
     * @param    boolean $bMark
     * @return    object
     */
    protected function CalcChildren($oForum, $bPerm = 1, $bMark = 0)
    {
        if ($bMark) {
            $oForum = $this->PluginForum_User_SetMarkForum($oForum);
        }
        $aChildren = $oForum->getChildren();
        if (!empty($aChildren)) {
            foreach ($aChildren as $oChildren) {
                $oChildren = $this->CalcChildren($oChildren, $bPerm, $bMark);
                if (!$oChildren->getRead()) {
                    $oForum->setRead(false);
                }
                if ($oChildren->getLastPostId() > $oForum->getLastPostId()) {
                    $oForum->setLastPostId($oChildren->getLastPostId());
                }
                $oForum->setCountTopic($oForum->getCountTopic() + $oChildren->getCountTopic());
                $oForum->setCountPost($oForum->getCountPost() + $oChildren->getCountPost());
            }
        }
        return $bPerm ? $this->BuildPerms($oForum) : $oForum;
    }

    /**
     * Удаляет посты по массиву объектов
     *
     * @param    array $aPosts
     * @return    boolean
     */
    public function DeletePosts($aPosts)
    {
        if (!is_array($aPosts)) {
            $aPosts = array($aPosts);
        }
        $aTopicsId = array();

        foreach ($aPosts as $oPost) {
            $aTopicsId[] = $oPost->getTopicId();
            $oPost->Delete();
        }
        foreach (array_unique($aTopicsId) as $sTopicId) {
            $this->RecountTopic($sTopicId);
        }
        return true;
    }

    /**
     * Пересчет счетчиков форума
     *
     * @param    object $oForum
     * @return    object
     */
    public function RecountForum($oForum)
    {
        if (!($oForum instanceof Entity)) {
            $oForum = $this->GetForumById($oForum);
        }

        $iCountTopic = $this->oMapperForum->GetCountTopicByForumId($oForum->getId());
        $iCountPost = $this->oMapperForum->GetCountPostByForumId($oForum->getId());
        $iLastPostId = $this->oMapperForum->GetLastPostByForumId($oForum->getId());
        $sLastPostDate = $this->oMapperForum->GetPostDateById($iLastPostId);

        $oForum->setCountTopic((int)$iCountTopic);
        $oForum->setCountPost((int)$iCountPost);
        $oForum->setLastPostId((int)$iLastPostId);
        $oForum->setLastPostDate($sLastPostDate);

        return $this->UpdateForum($oForum);
    }

    /**
     * Пересчет счетчиков топика
     *
     * @param    object $oForum
     * @return    object
     */
    public function RecountTopic($oTopic)
    {
        if (!($oTopic instanceof Entity)) {
            $oTopic = $this->GetTopicById($oTopic);
        }

        $iCountPost = $this->oMapperForum->GetCountPostByTopicId($oTopic->getId());
        $iLastPostId = $this->oMapperForum->GetLastPostByTopicId($oTopic->getId());
        $sLastPostDate = $this->oMapperForum->GetPostDateById($iLastPostId);

        $oTopic->setCountPost((int)$iCountPost);
        $oTopic->setLastPostId((int)$iLastPostId);
        $oTopic->setLastPostDate($sLastPostDate);
        return $this->UpdateTopic($oTopic);
    }

    /**
     * Выполняет необходимые действия после удаления топика
     *
     * @param    object $oTopic
     * @return    boolean
     */
    public function DeleteTopicAfter($oTopic)
    {
        //чистим кеш
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('PluginForum_ModuleForum_EntityPost_save'));

        return true;
    }

    /**
     * Формируем права доступа
     *
     * @param    object $oForum
     * @return    object
     */
    public function BuildPerms($oForum)
    {
        $oUser = $this->User_GetUserCurrent();
        $oParent = $oForum->getParentId() ? $this->BuildPerms($oForum->getParent()) : null;

        $aPermissions = unserialize(stripslashes($oForum->getPermissions()));

        $oForum->setAllowShow(forum_check_perms($aPermissions['show_perms'], $oUser, true));
        $oForum->setAllowRead(forum_check_perms($aPermissions['read_perms'], $oUser, true));
        $oForum->setAllowReply(forum_check_perms($aPermissions['reply_perms'], $oUser));
        $oForum->setAllowStart(forum_check_perms($aPermissions['start_perms'], $oUser));
        /**
         * Авторизован ли текущий пользователь в данном форуме, при условии что форум запоролен
         */
        $oForum->setAutorization($this->isForumAuthorization($oForum));
        /**
         * Если у нас нет прав для просмотра родителя данного форума, запрещаем просмотр
         */
        if ($oParent && !($oParent->getAllowShow())) {
            $oForum->setAllowShow($oParent->getAllowShow());
        }

        return $oForum;
    }

    /**
     * Проверяем, нужно ли юзеру вводить пароль
     *
     * @param    object $oForum
     * @return    boolean
     */
    public function isForumAuthorization($oForum)
    {
        $bAccess = true;
        if ($oForum->getPassword()) {
            $bAccess = false;
            if ($this->User_IsAuthorization()) {
                if (forum_compare_password($oForum)) {
                    $bAccess = true;
                }
            }
        }
        return $bAccess;
    }

    /**
     * Возвращает список форумов, открытых для пользователя в виде дерева
     *
     * @param    boolean $bNoAllowData
     * @return    array
     */
    public function GetOpenForumsTree($bNoAllowData = false)
    {
        $aResult = array();
        /**
         * Получаем дерево форумов
         */
        if ($aForums = $this->LoadTreeOfForum(array('#order' => array('forum_sort' => 'asc')))) {
            /**
             * Получаем доп.данные
             */
            $sRelationShemeCode = $bNoAllowData ? self::FORUM_DATA_RSS : self::FORUM_DATA_INDEX;
            $aForums = $this->GetForumsAdditionalData($aForums, $sRelationShemeCode);
            /**
             * Оставляем в результате только с разрешенными правами
             */
            foreach ($aForums as $oForum) {
                if ($oForum->getAllowShow()) {
                    $aResult[] = $oForum;
                }
            }
        }
        return $aResult;
    }

    /**
     * Возвращает список форумов, открытых для пользователя
     *
     * @param    object $oForum
     * @param    boolean $bIdOnly
     * @return    array
     */
    public function GetOpenForumsUser($oUser = null, $bIdOnly = false)
    {
        $aResult = array();
        if ($aForums = $this->GetForumItemsAll()) {
            foreach ($aForums as $oForum) {
                $aPermissions = unserialize(stripslashes($oForum->getPermissions()));
                if (forum_check_perms($aPermissions['show_perms'], $oUser, true)
                    and forum_check_perms($aPermissions['read_perms'], $oUser, true)
                    and $this->isForumAuthorization($oForum)
                ) {
                    $aResult[$oForum->getId()] = $oForum;
                }
            }
        }
        return $bIdOnly ? array_keys($aResult) : $aResult;
    }


    /**
     * Обновление просмотров топика
     * Данные в БД обновляются раз в 10 минут
     * @param    PluginForum_ModuleForum_EntityTopic $oTopic
     */
    public function UpdateTopicViews(PluginForum_ModuleForum_EntityTopic $oTopic)
    {
        if (false === ($data = $this->Cache_Get("topic_views_{$oTopic->getId()}"))) {
            $oView = $this->PluginForum_Forum_GetTopicViewByTopicId($oTopic->getId());
            if (!$oView) {
                $oView = Engine::GetEntity('PluginForum_Forum_TopicView');
                $oView->setTopicId($oTopic->getId());
            }
            $oView->setTopicViews($oView->getTopicViews() + 1);
            $data = array(
                'obj' => $oView,
                'time' => time()
            );
        } else {
            $data['obj']->setTopicViews($data['obj']->getTopicViews() + 1);
        }
        if (!Config::Get('sys.cache.use') or $data['time'] < time() - 60 * 10) {
            $data['time'] = time();
            $data['obj']->Save();
        }
        $this->Cache_Set($data, "topic_views_{$oTopic->getId()}", array(), 60 * 60 * 24);
    }

    /**
     * Операции с подписками при создании новой темы
     *
     * @param    string $sTargetId
     * @param    array $aParams
     * @param    array $aExcludeMail
     */
    public function SendSubscribeNewTopic($sTargetId, $aParams = array(), $aExcludeMail = array())
    {
        if (!class_exists('ModuleSubscribe')) {
            return false;
        }
        if (!(isset($aParams['oUser']) && isset($aParams['oTopic']))) {
            return false;
        }
        $sMail = $aParams['oUser']->getMail();
        $sTopicId = $aParams['oTopic']->getId();
        /**
         * Добавляем автора топика в подписчики на новые топики к этом форуме
         */
        if (Config::Get('plugin.forum.subscribe.topic.forum_new_topic')) {
            $this->Subscribe_AddSubscribeSimple('forum_new_topic', $sTargetId, $sMail);
        }
        /**
         * Добавляем автора топика в подписчики на новые ответы к этому топику
         */
        if (Config::Get('plugin.forum.subscribe.topic.topic_new_post')) {
            $this->Subscribe_AddSubscribeSimple('topic_new_post', $sTopicId, $sMail);
        }
        /**
         * Отправка уведомления подписчикам форума
         */
        $this->Subscribe_Send('forum_new_topic', $sTargetId, 'notify.topic_new.tpl', $this->Lang_Get('plugin.forum.notify_subject_new_topic'), $aParams, $aExcludeMail, __CLASS__);
    }

    /**
     * Операции с подписками при создании нового поста
     *
     * @param    string $sTargetId
     * @param    array $aParams
     * @param    array $aExcludeMail
     */
    public function SendSubscribeNewPost($sTargetId, $aParams = array(), $aExcludeMail = array())
    {
        if (!class_exists('ModuleSubscribe')) {
            return false;
        }
        if (!isset($aParams['oUser'])) {
            return false;
        }
        $sMail = $aParams['oUser']->getMail();
        /**
         * Добавляем автора поста в подписчики на новые ответы к этому топику
         */
        if (Config::Get('plugin.forum.subscribe.post.topic_new_post')) {
            $this->Subscribe_AddSubscribeSimple('topic_new_post', $sTargetId, $sMail);
        }
        /**
         * Отправка уведомления подписчикам топика
         */
        $this->Subscribe_Send('topic_new_post', $sTargetId, 'notify.post_new.tpl', $this->Lang_Get('plugin.forum.notify_subject_new_post'), $aParams, $aExcludeMail, __CLASS__);
    }


    /**
     * Отправка уведомления на отвеченные посты
     *
     * @param    PluginForum_ModuleForum_EntityPost $oReply
     * @param    array $aExcludeMail
     */
    public function SendNotifyReply(PluginForum_ModuleForum_EntityPost $oReply, $aExcludeMail = array())
    {
        if ($oReply) {
            if (preg_match_all("@(<blockquote reply=(?:\"|')(.*)(?:\"|').*>)@Ui", $oReply->getTextSource(), $aMatch)) {
                $aIds = array_values($aMatch[2]);
                /**
                 * Получаем список постов
                 */
                $aPosts = $this->GetPostItemsByArrayPostId((array)$aIds);
                /**
                 * Отправка
                 */
                $sTemplate = 'notify.reply.tpl';
                $sSendTitle = $this->Lang_Get('plugin.forum.notify_subject_reply');
                $aSendContent = array(
                    'oUser' => $oReply->getUser(),
                    'oTopic' => $oReply->getTopic(),
                    'oPost' => $oReply
                );
                foreach ($aPosts as $oPost) {
                    if ($oUser = $oPost->getUser()) {
                        $sMail = $oUser->getMail();
                        if (!$sMail || in_array($sMail, (array)$aExcludeMail)) continue;
                        $this->Notify_Send($sMail, $sTemplate, $sSendTitle, $aSendContent, __CLASS__);
                    }
                }
            }
        }
    }

    /**
     * Парсер текста
     *
     * @param    string $sText
     * @return    stiing
     */
    public function TextParse($sText = null)
    {
        $this->Text_LoadJevixConfig('forum');
        /**
         * @username
         */
        if (preg_match_all('/@\w+/u', $sText, $aMatch)) {
            foreach ($aMatch as $aPart) {
                foreach ($aPart as $str) {
                    $sText = str_replace($str, '<ls user="' . substr(trim($str), 1) . '" />', $sText);
                }
            }
        }
        return $this->Text_Parser($sText);
    }

    /**
     * Загружает иконку для форума
     *
     * @param array $aFile Массив $_FILES при загрузке аватара
     * @param PluginForum_ModuleForum_EntityForum $oForum
     * @return bool
     */
    public function UploadIcon($aFile, $oForum)
    {
        if (!is_array($aFile) || !isset($aFile['tmp_name'])) {
            return false;
        }

        $sFileTmp = Config::Get('sys.cache.dir') . func_generator();
        if (!move_uploaded_file($aFile['tmp_name'], $sFileTmp)) {
            return false;
        }
        $sPath = Config::Get('plugin.forum.path_uploads_forum');
        $sPath = str_replace(Config::Get('path.root.server'), '', "/{$sPath}/{$oForum->getId()}/");
        $aParams = $this->Image_BuildParams('avatar');

        $oImage = $this->Image_CreateImageObject($sFileTmp);
        /**
         * Если объект изображения не создан,
         * возвращаем ошибку
         */
        if ($sError = $oImage->get_last_error()) {
            // Вывод сообщения об ошибки, произошедшей при создании объекта изображения
            // $this->Message_AddError($sError,$this->Lang_Get('error'));
            @unlink($sFileTmp);
            return false;
        }
        /**
         * Срезаем квадрат
         */
        $oImage = $this->Image_CropSquare($oImage);

        $aSize = Config::Get('plugin.forum.icon_size');
        rsort($aSize, SORT_NUMERIC);
        $sSizeBig = array_shift($aSize);
        if ($oImage && $sFileAvatar = $this->Image_Resize($sFileTmp, $sPath, "forum_icon_{$oForum->getId()}_{$sSizeBig}x{$sSizeBig}", Config::Get('view.img_max_width'), Config::Get('view.img_max_height'), $sSizeBig, $sSizeBig, false, $aParams, $oImage)) {
            foreach ($aSize as $iSize) {
                if ($iSize == 0) {
                    $this->Image_Resize($sFileTmp, $sPath, "forum_icon_{$oForum->getId()}", Config::Get('view.img_max_width'), Config::Get('view.img_max_height'), null, null, false, $aParams, $oImage);
                } else {
                    $this->Image_Resize($sFileTmp, $sPath, "forum_icon_{$oForum->getId()}_{$iSize}x{$iSize}", Config::Get('view.img_max_width'), Config::Get('view.img_max_height'), $iSize, $iSize, false, $aParams, $oImage);
                }
            }
            @unlink($sFileTmp);
            /**
             * Если все нормально, возвращаем расширение загруженного аватара
             */
            return $this->Image_GetWebPath($sFileAvatar);
        }
        @unlink($sFileTmp);
        /**
         * В случае ошибки, возвращаем false
         */
        return false;
    }

    /**
     * Удаляет иконку форума с сервера
     *
     * @param PluginForum_ModuleForum_EntityForum $oForum
     */
    public function DeleteIcon($oForum)
    {
        /**
         * Если иконка есть, удаляем ее и ее рейсайзы
         */
        if ($oForum->getIcon()) {
            $aSize = Config::Get('plugin.forum.icon_size');
            foreach ($aSize as $iSize) {
                $this->Image_RemoveFile($this->Image_GetServerPath($oForum->getIconPath($iSize)));
            }
        }
    }

    /**
     * Возвращает нужную схему загрузки связей для форума
     *
     * @param    string $sCode константа
     * @return    array
     */
    public function GetForumRelationSheme($sCode = null)
    {
        switch ($sCode) {
            // Схема загрузки связей для страницы RSS
            case self::FORUM_DATA_RSS:
                return array('perms');
            // Схема загрузки связей для страницы топика
            case self::FORUM_DATA_TOPIC:
                return array('marker', 'perms', 'moder');
            // Схема загрузки связей для страницы форума
            case self::FORUM_DATA_FORUM:
                return array('calculate', 'marker', 'perms', 'moder', 'post' => array('user' => array(), 'topic' => array()));
            // Схема загрузки связей для главной страницы
            case self::FORUM_DATA_INDEX:
            case null:
            default:
                return array('calculate', 'marker', 'perms', 'moder', 'post' => array('user' => array(), 'topic' => array()));
        }
    }

    /**
     * Получает дополнительные данные(объекты) для форумов
     *
     * @param    array $aForums Список форумов
     * @param    array|null $aAllowData Список дополнительных данных, которые нужно подключать к топикам
     * @return    array
     */
    public function GetForumsAdditionalData($aForums, $sAllowDataCode = null)
    {
        if (empty($aForums)) {
            return $aForums;
        }
        $aAllowData = $this->GetForumRelationSheme($sAllowDataCode);
        func_array_simpleflip($aAllowData);
        $sOne = false;
        if (!is_array($aForums)) {
            $sOne = $aForums->getId();
            $aForums = array($sOne => $aForums);
        }
        $aForumsByParentId = array();
        $aForumsId = array();
        $aPostsId = array();
        /**
         * Получаем дополнительные данные
         */
        if (isset($aAllowData['marker']) && $this->oUserCurrent) {
            // возможно лучше массово получать статус чтения?
        }
        foreach ($aForums as $oForum) {
            if (isset($aAllowData['calculate'])) {
                // Рекурсивная калькуляция материалов + права + принадлежность к модераторам + маркировка
                $oForum = $this->CalcChildren($oForum, isset($aAllowData['perms']) ? 1 : 0, isset($aAllowData['marker']) ? 1 : 0);
            } else {
                // Маркировка
                if (isset($aAllowData['marker']) && $this->oUserCurrent) {
                    $oForum = $this->PluginForum_User_SetMarkForum($oForum);
                }
                // Права доступа + принадлежность к модераторам
                if (isset($aAllowData['perms'])) {
                    $oForum = $this->BuildPerms($oForum);
                }
            }
            // собираем объекты всей ветки
            if ($aDescendants = $oForum->getChildren()) {//getDescendants()
                foreach ($aDescendants as $oDescendant) {
                    $aForumsByParentId[$oDescendant->getParetId()][] = $oDescendant;
                    $aPostsId[] = $oDescendant->getLastPostId();
                    $aForumsId[] = $oDescendant->getId();
                }
            }
            $aPostsId[] = $oForum->getLastPostId();
            $aForumsId[] = $oForum->getId();
        }
        /**
         * Получаем доп.данные
         */
        $aPosts = array();
        $aModerators = array();
        if (isset($aAllowData['post']) && $aPostsId) {
            $aPosts = $this->GetPostItemsByArrayPostId($aPostsId);
            $aPosts = (isset($aAllowData['post']) && is_array($aAllowData['post'])) ? $this->GetPostsAdditionalData($aPosts, $aAllowData['post']) : $this->GetPostsAdditionalData($aPosts);
        }
        if (isset($aAllowData['moder']) && $this->oUserCurrent) {
            $aModerators = $this->GetModeratorItemsAll(array(
                '#where' => array(
                    'user_id = ?d' => array($this->oUserCurrent->getId()),
                    'forum_id IN (?a)' => array($aForumsId)
                ),
                '#index-from' => 'forum_id'
            ));
        }
        /**
         * Добавляем данные к массиву объектов веток
         */
        foreach ($aForumsByParentId as $sParent => $aChildrens) {
            foreach ($aChildrens as $oChildren) {
                if (!isset($aAllowData['calculate'])) {
                    /**
                     * TODO: избавится от дублирования
                     */
                    if (isset($aAllowData['marker']) && $this->oUserCurrent) {
                        $oChildren = $this->PluginForum_User_SetMarkForum($oChildren);
                    }
                    if (isset($aAllowData['perms'])) {
                        $oChildren = $this->BuildPerms($oChildren);
                    }
                }
                if (isset($aPosts[$oChildren->getLastPostId()])) {
                    $oChildren->setPost($aPosts[$oChildren->getLastPostId()]);
                } else {
                    $oChildren->setPost(null);
                }
                if (isset($aModerators[$oChildren->getId()])) {
                    $oChildren->setModerator($aModerators[$oChildren->getId()]);
                } else {
                    $oChildren->setModerator(null);
                }
            }
        }
        /**
         * Добавляем данные к результату - списку форумов
         */
        foreach ($aForums as $oForum) {
            if (isset($aPosts[$oForum->getLastPostId()])) {
                $oForum->setPost($aPosts[$oForum->getLastPostId()]);
            } else {
                $oForum->setPost(null);
            }
            if (isset($aModerators[$oForum->getId()])) {
                $oForum->setModerator($aModerators[$oForum->getId()]);
            } else {
                $oForum->setModerator(null);
            }
            if (isset($aForumsByParentId[$oForum->getId()])) {
                $oForum->setChildren($aForumsByParentId[$oForum->getId()]);
            }
        }

        return $sOne ? $aForums[$sOne] : $aForums;
    }

    /**
     * Получает дополнительные данные(объекты) для топиков
     *
     * @param    array $aTopics Список топиков
     * @param    array|null $aAllowData Список дополнительных данных, которые нужно подключать к топикам
     * @return    array
     */
    public function GetTopicsAdditionalData($aTopics, $aAllowData = null)
    {
        if (empty($aTopics)) {
            return $aTopics;
        }
        if (is_null($aAllowData)) {
            $aAllowData = array('marker', 'forum' => array(), 'post' => array(), 'user' => array());
        }
        if (is_string($aAllowData)) {
            $aAllowData = explode(',', $aAllowData);
        }
        func_array_simpleflip($aAllowData);
        $sOne = false;
        if (!is_array($aTopics)) {
            $sOne = $aTopics->getId();
            $aTopics = array($sOne => $aTopics);
        }
        $aForumsId = array();
        $aPostsId = array();
        $aUsersId = array();
        /**
         * Формируем ID дополнительных данных, которые нужно получить
         */
        foreach ($aTopics as $oTopic) {
            $aForumsId[] = $oTopic->getForumId();
            $aPostsId[] = $oTopic->getLastPostId();
            $aUsersId[] = $oTopic->getUserId();
        }
        /**
         * Получаем дополнительные данные
         */
        $aForums = array();
        $aPosts = array();
        $aUsers = array();
        /**
         * если нужно подцепить маркировку
         */
        if (isset($aAllowData['marker']) && $this->oUserCurrent) {

        }
        /**
         * если нужно подцепить форумы
         */
        if (isset($aAllowData['forum']) && $aForumsId) {
            $aForums = $this->GetForumItemsByArrayForumId($aForumsId);
        }
        /**
         * если нужно подцепить посты
         */
        if (isset($aAllowData['post']) && $aPostsId) {
            $aPosts = $this->GetPostItemsByArrayPostId($aPostsId);
            foreach ($aPosts as $oPost) {
                $aUsersId[] = $oPost->getUserId();
            }
        }
        /**
         * Подцепляем пользователей
         */
        if (isset($aAllowData['user'])) {
            $aUsers = (isset($aAllowData['user']) && is_array($aAllowData['user'])) ? $this->User_GetUsersAdditionalData($aUsersId, $aAllowData['user']) : $this->User_GetUsersAdditionalData($aUsersId);
        }
        /**
         * Добавляем данные списку постов
         */
        foreach ($aPosts as $oPost) {
            if (isset($aTopics[$oPost->getTopicId()])) {
                $oPost->setTopic($aTopics[$oPost->getTopicId()]);
            } else {
                $oPost->setTopic(null);
            }
            if (isset($aUsers[$oPost->getUserId()])) {
                $oPost->setUser($aUsers[$oPost->getUserId()]);
            } else {
                $oPost->setUser(null);
            }
        }
        /**
         * Добавляем данные к результату - списку топиков
         */
        foreach ($aTopics as $oTopic) {
            if (isset($aAllowData['marker']) && $this->oUserCurrent) {
                $oTopic = $this->PluginForum_User_SetMarkTopic($oTopic);
            }
            if (isset($aForums[$oTopic->getForumId()])) {
                $oTopic->setForum($aForums[$oTopic->getForumId()]);
            } else {
                $oTopic->setForum(null);
            }
            if (isset($aPosts[$oTopic->getLastPostId()])) {
                $oTopic->setPost($aPosts[$oTopic->getLastPostId()]);
            } else {
                $oTopic->setPost(null);
            }
            if (isset($aUsers[$oTopic->getUserId()])) {
                $oTopic->setUser($aUsers[$oTopic->getUserId()]);
            } else {
                $oTopic->setUser(null);
            }
        }

        return $sOne ? $aTopics[$sOne] : $aTopics;
    }

    /**
     * Получает дополнительные данные(объекты) для постов
     *
     * @param    array $aPosts Список топиков
     * @param    array|null $aAllowData Список дополнительных данных, которые нужно подключать к топикам
     * @return    array
     */
    public function GetPostsAdditionalData($aPosts, $aAllowData = null)
    {
        if (empty($aPosts)) {
            return $aPosts;
        }
        if (is_null($aAllowData)) {
            $aAllowData = array('vote', 'topic' => array(), 'user' => array(), 'editor' => array(), 'files');
        }
        if (is_string($aAllowData)) {
            $aAllowData = explode(',', $aAllowData);
        }
        func_array_simpleflip($aAllowData);
        $sOne = false;
        if (!is_array($aPosts)) {
            $sOne = $aPosts->getId();
            $aPosts = array($sOne => $aPosts);
        }
        $aPostId = array();
        $aUsersId = array();
        $aForumsId = array();
        $aTopicsId = array();
        /**
         * Формируем ID дополнительных данных, которые нужно получить
         */
        foreach ($aPosts as $oPost) {
            $aPostId[] = $oPost->getId();
            $aTopicsId[] = $oPost->getTopicId();
            $aUsersId[] = $oPost->getUserId();
            $aUsersId[] = $oPost->getEditorId();
        }
        /**
         * Получаем дополнительные данные
         */
        $aVote = array();
        $aForums = array();
        $aTopics = array();
        $aUsers = array();
        $aForumUsers = array();
        if ($aPostId) {
            /**
             * если нужно подцепить голосования
             */
            if (isset($aAllowData['vote']) && $this->oUserCurrent) {
                $aVote = $this->Vote_GetVoteByArray($aPostId, 'forum_post', $this->oUserCurrent->getId());
            }
            /**
             * если нужно подцепить топики
             */
            if (isset($aAllowData['topic']) && $aTopicsId) {
                $aTopics = $this->GetTopicItemsByArrayTopicId($aTopicsId);
                foreach ($aTopics as $oTopic) {
                    $aUsersId[] = $oTopic->getUserId();
                    $aForumsId[] = $oTopic->getForumId();
                }
            }
            /**
             * Подцепляем форумы
             *    TODO: проверять на наличие allowData, а лучше запрашивать топики через свою спец.функцию и пох на 1 лишний запрос за юзерами
             */
            if ($aForumsId) {
                $aForums = $this->GetForumItemsByArrayForumId($aForumsId);
            }
            /**
             * Подцепляем ForumUser
             */
            if (isset($aAllowData['user']) && $aUsersId) {
                $aForumUsers = $this->PluginForum_User_GetUsersByArrayId($aUsersId);
            }
            /**
             * Подцепляем пользователей
             */
            if (isset($aAllowData['user']) || isset($aAllowData['editor'])) {
                // сюда можно захуяривать данные для User'a (то есть 'vote','session','friend','geo_target','note')
                // по умолчанию стоит пустой массив, то есть не запрашивает всю эту ненужную хуйню
                // данные для хозяина поста и редакторов сливаются
                $aUsersAllowData = isset($aAllowData['user']) ? $aAllowData['user'] : array();
                if (isset($aAllowData['editor'])) {
                    $aUsersAllowData = func_array_merge_assoc($aUsersAllowData, $aAllowData['editor']);
                }
                $aUsers = is_array($aUsersAllowData) ? $this->User_GetUsersAdditionalData($aUsersId, $aUsersAllowData) : $this->User_GetUsersAdditionalData($aUsersId);
            }
            /**
             * Добавляем данные к списку топиков
             */
            foreach ($aTopics as $oTopic) {
                if (isset($aForums[$oTopic->getForumId()])) {
                    $oTopic->setForum($aForums[$oTopic->getForumId()]);
                } else {
                    $oTopic->setForum(null);
                }
                if (isset($aUsers[$oTopic->getUserId()])) {
                    $oTopic->setUser($aUsers[$oTopic->getUserId()]);
                } else {
                    $oTopic->setUser(null);
                }
            }
        }
        /**
         * Добавляем данные к результату - списку постов
         */
        foreach ($aPosts as $oPost) {
            if (isset($aVote[$oPost->getId()])) {
                $oPost->setVote($aVote[$oPost->getId()]);
            } else {
                $oPost->setVote(null);
            }
            if (isset($aTopics[$oPost->getTopicId()])) {
                $oPost->setTopic($aTopics[$oPost->getTopicId()]);
            } else {
                $oPost->setTopic(null);
            }
            if (isset($aUsers[$oPost->getUserId()])) {
                $oPost->setUser($aUsers[$oPost->getUserId()]);
            } else {
                $oPost->setUser(null);
            }
            if (isset($aUsers[$oPost->getEditorId()])) {
                $oPost->setEditor($aUsers[$oPost->getEditorId()]);
            } else {
                $oPost->setEditor(null);
            }
            if (isset($aForumUsers[$oPost->getUserId()])) {
                $oPost->setUserForum($aForumUsers[$oPost->getUserId()]);
            } else {
                $oPost->setUserForum(null);
            }
        }

        return $sOne ? $aPosts[$sOne] : $aPosts;
    }

    /**
     * Возвращает количество файлов по временному id
     *
     * @param    string $sTargetId
     * @return    integer
     */
    public function GetCountFilesByTargetTmp($sTargetId)
    {
        return count($this->GetFileItemsByTargetTmp($sTargetId));
    }

    /**
     * Загружает файл на сервер
     *
     * @param    array $aFile
     * @return    string
     */
    public function UploadAttach($aFile)
    {
        if (!is_array($aFile) || !isset($aFile['tmp_name'])) {
            return false;
        }
        /**
         * Генерируем случайное имя
         */
        $sFileName = func_generator(16);
        /**
         * TODO: Проверка типов файла
         */

        $sFullPath = Config::Get('plugin.forum.path_uploads_files') . '/' . date('Y/m/d') . '/';

        if (!is_dir($sFullPath)) {
            mkdir($sFullPath, 0755, true);
        }

        $sFilePath = $sFullPath . $sFileName;
        if (!move_uploaded_file($aFile['tmp_name'], $sFilePath)) {
            return false;
        }

        /**
         * TODO:
         * Вырезать путь 'plugin.forum.path_uploads_files'
         */

        return $this->Image_GetWebPath($sFilePath);
    }

    /**
     * Удаляет файл с сервера
     *
     * @param    PluginForum_ModuleForum_EntityFile $oFile
     * @return    boolean
     */
    public function DeleteAttach(PluginForum_ModuleForum_EntityFile $oFile)
    {
        @unlink($this->Image_GetServerPath($oFile->getPath()));
        return $this->PluginForum_Forum_DeleteFile($oFile);
    }

    /**
     * Получаем список ID всех топиков форума
     * @param $sForumId
     */
    public function GetTopicsIdByForumId($sForumId, $aFilter = array())
    {
        return $this->oMapperForum->GetTopicsIdByForumId($sForumId, $aFilter);
    }
}
