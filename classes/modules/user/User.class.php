<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: User.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleUser extends ModuleORM
{
    /**
     * @var PluginForum_ModuleUser_EntityUser
     */
    protected $oUserCurrent = null;

    public function Init()
    {
        parent::Init();
        if ($oUserCurrent = $this->User_GetUserCurrent()) {
            $this->oUserCurrent = $this->GetUserById($oUserCurrent->getId());
        }
    }

    /**
     * Возвращает объект текущего пользователя форума
     * @return PluginForum_ModuleUser_EntityUser
     */
    public function GetUserCurrent()
    {
        return $this->oUserCurrent;
    }

    /**
     * Возвращает массив пользователей форума по массиву ID пользователей
     * @param $aIds
     * @return mixed
     */
    public function GetUsersByArrayId($aIds)
    {
        return $this->GetUserItemsByArrayUserId($aIds);
    }

    /**
     * Отмечаем прочтенным всё
     * @return bool
     */
    public function MarkAll()
    {
        if ($this->oUserCurrent) {
            $this->oUserCurrent->setMarkAll(time());
            $this->oUserCurrent->setMarkForum(array());
            $this->oUserCurrent->setMarkTopic(array());
            $this->oUserCurrent->setMarkTopicRel(array());
            $this->oUserCurrent->Save();
        }
        return true;
    }

    /**
     * Отмечаем форум как прочитанный
     * @param PluginForum_ModuleForum_EntityForum $oForum
     */
    public function MarkForum(PluginForum_ModuleForum_EntityForum $oForum)
    {
        if ($this->oUserCurrent) {
            $sMarkAll = $this->oUserCurrent->getMarkAll();
            $aMarkForum = $this->oUserCurrent->getMarkForum();
            $aMarkTopic = $this->oUserCurrent->getMarkTopic();
            $aMarkTopicRel = $this->oUserCurrent->getMarkTopicRel();

            $sForumId = $oForum->getId();

            $aMarkForum[$sForumId] = time();

            if (isset($aMarkTopicRel[$sForumId])) {
                $aForumTopicsId = $aMarkTopicRel[$sForumId];

                foreach ($aForumTopicsId as $sForumTopicId) {
                    if (isset($aMarkTopic[$sForumTopicId])) {
                        unset($aMarkTopic[$sForumTopicId]);
                    }
                }
                unset($aMarkTopicRel[$sForumId]);
            }

            $this->oUserCurrent->setMarkForum($aMarkForum);
            $this->oUserCurrent->setMarkTopic($aMarkTopic);
            $this->oUserCurrent->setMarkTopicRel($aMarkTopicRel);
            $this->oUserCurrent->Save();
        }
        return true;
    }

    /**
     * Отмечаем топик как прочитанный
     * @param PluginForum_ModuleForum_EntityTopic $oTopic
     * @param PluginForum_ModuleForum_EntityPost $oLastPost
     */
    public function MarkTopic(PluginForum_ModuleForum_EntityTopic $oTopic, $oLastPost = null)
    {
        if ($this->oUserCurrent) {
            $sMarkAll = $this->oUserCurrent->getMarkAll();
            $aMarkForum = $this->oUserCurrent->getMarkForum();
            $aMarkTopic = $this->oUserCurrent->getMarkTopic();
            $aMarkTopicRel = $this->oUserCurrent->getMarkTopicRel();

            $sForumId = $oTopic->getForumId();
            $sTopicId = $oTopic->getId();

            $sTopicLastPostDate = strtotime($oTopic->getLastPostDate());
            $sLastPostDate = (!$oLastPost) ? $sTopicLastPostDate : strtotime($oLastPost->getDateAdd());
            /**
             * Имеется более свежая отметка о прочтении всего
             */
            if (strtotime($sMarkAll) >= $sLastPostDate) {
                return false;
            }
            /**
             * Имеется более свежая отметка о прочтении форума
             */
            if (isset($aMarkForum[$sForumId])) {
                if ($aMarkForum[$sForumId] >= $sLastPostDate) {
                    return false;
                }
            }
            /**
             * Отметка о прочтении топика имеется и она более свежая
             */
            if (isset($aMarkTopic[$sTopicId])) {
                if ($aMarkTopic[$sTopicId] >= $sLastPostDate) {
                    return false;
                }
            }

            $aMarkTopic[$sTopicId] = $sLastPostDate;
            if ($sLastPostDate >= $sTopicLastPostDate) {
                $aMarkTopicRel[$sForumId][$sTopicId] = true;
            }

            /**
             * Проверка прочтенности всех тем форума
             * Если нужно, отмечаем форум как прочитанный
             */
            $bForumMarkNeed = true;
            if ($aForumTopicsId = $this->PluginForum_Forum_GetTopicsIdByForumId($sForumId)) {
                foreach ($aForumTopicsId as $sForumTopicId) {
                    if (!isset($aMarkTopicRel[$sForumId][$sForumTopicId])) {
                        $bForumMarkNeed = false;
                        break;
                    }
                }
            }
            if (!$bForumMarkNeed) {
                $this->oUserCurrent->setMarkTopic($aMarkTopic);
                $this->oUserCurrent->setMarkTopicRel($aMarkTopicRel);
                $this->oUserCurrent->Save();
            } else {
                $this->MarkForum($this->PluginForum_Forum_GetForumById($sForumId));
            }
        }
        return true;
    }

}