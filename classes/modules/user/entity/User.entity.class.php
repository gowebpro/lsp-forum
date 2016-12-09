<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet version: 1.X
* @File Name: User.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleUser_EntityUser extends EntityORM
{
    protected $__aCustomData = array();

    protected $aRelations = array(
        'user' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'user_id')
    );

    public function getMarkForum()
    {
        $aData = @unserialize($this->_getDataOne('mark_forum'));
        if (!$aData) {
            $aData = array();
        }
        return $aData;
    }

    public function getMarkTopic()
    {
        $aData = @unserialize($this->_getDataOne('mark_topic'));
        if (!$aData) {
            $aData = array();
        }
        return $aData;
    }

    public function getMarkTopicRel()
    {
        $aData = @unserialize($this->_getDataOne('mark_topic_rel'));
        if (!$aData) {
            $aData = array();
        }
        return $aData;
    }

    public function setMarkForum($aData)
    {
        $this->_aData['mark_forum'] = @serialize($aData);
    }

    public function setMarkTopic($aData)
    {
        $this->_aData['mark_topic'] = @serialize($aData);
    }

    public function setMarkTopicRel($aData)
    {
        $this->_aData['mark_topic_rel'] = @serialize($aData);
    }
}