<?php

/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Topic.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityTopic extends EntityORM
{
    protected $__aRelationsData = array();
    protected $__aCustomData = array();

    protected $aRelations = array(
        //	'user'=>array(self::RELATION_TYPE_BELONGS_TO,'ModuleUser_EntityUser','user_id'),
        //	'forum'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityForum','forum_id'),
        //	'post'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityPost','last_post_id'),
        //	'polls'=>array(self::RELATION_TYPE_HAS_MANY,'PluginForum_ModuleForum_EntityPoll','post_id')
    );


    /**
     * Инициализация
     * Определяем правила валидации
     */
    public function Init()
    {
        parent::Init();
        $this->aValidateRules[] = array('topic_title', 'string', 'min' => Config::Get('plugin.forum.topic.title_min_length'), 'max' => Config::Get('plugin.forum.topic.title_max_length'), 'allowEmpty' => false, 'label' => $this->Lang_Get('plugin.forum.new_topic_title'));
        $this->aValidateRules[] = array('topic_description', 'string', 'max' => Config::Get('plugin.forum.topic.descr_max_length'), 'allowEmpty' => true, 'label' => $this->Lang_Get('plugin.forum.new_topic_description'));
    }


    /**
     * Метод автоматически выполняется перед сохранением объекта сущности (статьи)
     * Если топик новый, устанавливается дата создания, иначе редактирования
     */
    protected function beforeSave()
    {
        if ($this->_isNew()) {
            $this->setDateAdd(date('Y-m-d H:i:s'));
        } else {
            $this->setDateEdit(date('Y-m-d H:i:s'));
        }
        return true;
    }

    /**
     * Выполняется перед удалением
     */
    protected function beforeDelete()
    {
        if ($bResult = parent::beforeDelete()) {
            /**
             * Запускаем удаление постов топика
             */
            if ($aPosts = $this->PluginForum_Forum_GetPostItemsByTopicId($this->getId())) {
                foreach ($aPosts as $oPost) {
                    $oPost->Delete();
                }
            }
        }
        return $bResult;
    }


    /**
     * Пагинация
     */
    public function getPaging()
    {
        $iCountItems = $this->getCountPost();
        $oForum = $this->getForum();
        $iPerPage = ($oForum && $oForum->getOptionsValue('posts_per_page')) ? $oForum->getOptionsValue('posts_per_page') : Config::Get('plugin.forum.post_per_page');
        if (Config::Get('plugin.forum.topic_line_mod')) {
            $iCountItems--;
            $iPerPage--;
        }
        $aPaging = $this->Viewer_MakePaging($iCountItems, 1, $iPerPage, Config::Get('pagination.pages.count'), $this->getUrlFull());
        return $aPaging;
    }

    /**
     * Возвращает полный URL до топика
     */
    public function getUrlFull()
    {
        return Router::GetPath('forum') . 'topic/' . $this->getId() . '/';
    }

    /**
     * Возвращает состояние подписки на топик
     */
    public function getSubscribeNewPost()
    {
        if (!($oUserCurrent = $this->User_GetUserCurrent())) {
            return null;
        }
        return $this->Subscribe_GetSubscribeByTargetAndMail('topic_new_post', $this->getId(), $oUserCurrent->getMail());
    }

    /**
     * Метка: популярная тема
     */
    public function getHot()
    {
        if ($oForum = $this->getForum()) {
            if ($iCountHot = $oForum->getOptionsValue('posts_hot_topic')) {
                return ($this->getCountPost() >= $iCountHot);
            }
        }
        return false;
    }


    /**
     * Relation data
     */
    protected function _getDataRelation($sKey)
    {
        if (isset($this->__aRelationsData[$sKey])) {
            return $this->__aRelationsData[$sKey];
        }
        return null;
    }

    // relation Forum, Post, User
    public function getForum()
    {
        return $this->_getDataRelation('Forum');
    }

    public function getPost()
    {
        return $this->_getDataRelation('Post');
    }

    public function getUser()
    {
        return $this->_getDataRelation('User');
    }

    public function setForum($data)
    {
        $this->__aRelationsData['Forum'] = $data;
    }

    public function setPost($data)
    {
        $this->__aRelationsData['Post'] = $data;
    }

    public function setUser($data)
    {
        $this->__aRelationsData['User'] = $data;
    }


    /**
     * Custom data
     */
    protected function _getDataCustom($sKey)
    {
        if (isset($this->__aCustomData[$sKey])) {
            return $this->__aCustomData[$sKey];
        }
        return null;
    }

    // Custom Маркер, Дата маркировки
    public function getRead()
    {
        return $this->_getDataCustom('marker');
    }

    public function getReadDate()
    {
        return $this->_getDataCustom('marker_date');
    }

    public function setRead($data)
    {
        $this->__aCustomData['marker'] = $data;
    }

    public function setReadDate($data)
    {
        $this->__aCustomData['marker_date'] = $data;
    }
}

?>