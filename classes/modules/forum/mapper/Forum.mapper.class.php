<?php

/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Forum.mapper.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_MapperForum extends Mapper
{
    /**
     * Перемещает сообщения в другую тему
     *
     * @param    integer $sForumId
     * @param    integer $sForumIdNew
     * @return    bool
     */
    public function MovePosts($aPostsId, $sTopicId)
    {
        $sql = 'UPDATE ' . Config::Get('db.table.forum_post') . '
				SET topic_id = ?d
				WHERE post_id IN (?a)';
        if ($this->oDb->query($sql, $sTopicId, $aPostsId)) {
            return true;
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
        $sql = 'UPDATE ' . Config::Get('db.table.forum_topic') . '
				SET forum_id = ?d
				WHERE forum_id = ?d';
        if ($this->oDb->query($sql, $sForumIdNew, $sForumId)) {
            return true;
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
        $sql = 'UPDATE ' . Config::Get('db.table.forum') . '
				SET forum_parent_id = ?d
				WHERE forum_parent_id = ?d';
        if ($this->oDb->query($sql, $sForumIdNew, $sForumId)) {
            return true;
        }
        return false;
    }

    /**
     * Получает слудующий по сортировке форум
     *
     * @param    integer $iSort
     * @param    integer $sPid
     * @param    string $sWay
     * @return    string
     */
    public function GetNextForumBySort($iSort, $sPid, $sWay)
    {
        if ($sWay == 'up') {
            $sWay = '<';
            $sOrder = 'desc';
        } else {
            $sWay = '>';
            $sOrder = 'asc';
        }
        $sPidNULL = '';
        if (is_null($sPid)) {
            $sPidNULL = 'forum_parent_id IS NULL and';
        }
        $sql = 'SELECT forum_id
				FROM ' . Config::Get('db.table.forum') . '
				WHERE { forum_parent_id = ? and } ' . $sPidNULL . ' forum_sort ' . $sWay . ' ?
				ORDER BY forum_sort ' . $sOrder . '
				LIMIT 0,1';
        if ($aRow = $this->oDb->selectRow($sql, is_null($sPid) ? DBSIMPLE_SKIP : $sPid, $iSort)) {
            return $aRow['forum_id'];
        }
        return null;
    }

    /**
     * Получает значение максимальной сртировки
     *
     * @param    integer $sPid
     * @return    integer
     */
    public function GetMaxSortByPid($sPid)
    {
        $sPidNULL = '';
        if (is_null($sPid)) {
            $sPidNULL = 'and forum_parent_id IS NULL';
        }
        $sql = 'SELECT MAX(forum_sort) as max_sort
				FROM ' . Config::Get('db.table.forum') . '
				WHERE 1=1
				{ and forum_parent_id = ? }' .
            $sPidNULL;
        if ($aRow = $this->oDb->selectRow($sql, is_null($sPid) ? DBSIMPLE_SKIP : $sPid)) {
            return $aRow['max_sort'];
        }
        return 0;
    }

    /**
     * Получаем список ID всех топиков форума
     * @param $sForumId
     */
    public function GetTopicsIdByForumId($sForumId) {
        $sql = 'SELECT topic_id
				FROM ' . Config::Get('db.table.forum_topic') . '
				WHERE forum_id = ?';
        $aResult = array();
        if ($aRows = $this->oDb->select($sql, $sForumId)) {
            foreach ($aRows as $aRow) {
                $aResult[] = $aRow['topic_id'];
            }
        }
        return $aResult;
    }

    /**
     * Получает количество тем в форуме по ID
     *
     * @param    integer $sFid
     * @return    integer
     */
    public function GetCountTopicByForumId($sFid)
    {
        $sql = 'SELECT COUNT(*) as count
				FROM ' . Config::Get('db.table.forum_topic') . '
				WHERE forum_id = ?';
        if ($aRow = $this->oDb->selectRow($sql, $sFid)) {
            return $aRow['count'];
        }
        return 0;
    }

    /**
     * Получает количество постов в форуме по ID
     *
     * @param    integer $sFid
     * @return    integer
     */
    public function GetCountPostByForumId($sFid)
    {
        $sql = 'SELECT SUM(topic_count_post) as replies
				FROM ' . Config::Get('db.table.forum_topic') . '
				WHERE forum_id = ?';
        if ($aRow = $this->oDb->selectRow($sql, $sFid)) {
            return $aRow['replies'];
        }
        return 0;
    }

    /**
     * Получает последний пост в форуме по ID
     *
     * @param    integer $sFid
     * @return    string
     */
    public function GetLastPostByForumId($sFid)
    {
        $sql = 'SELECT MAX(last_post_id) as last_post
				FROM ' . Config::Get('db.table.forum_topic') . '
				WHERE forum_id = ?';
        if ($aRow = $this->oDb->selectRow($sql, $sFid)) {
            return $aRow['last_post'];
        }
        return null;
    }

    /**
     * Получает количество постов в топике по ID
     *
     * @param    integer $sTid
     * @return    integer
     */
    public function GetCountPostByTopicId($sTid)
    {
        $sql = 'SELECT COUNT(*) as count
				FROM ' . Config::Get('db.table.forum_post') . '
				WHERE topic_id = ?';
        if ($aRow = $this->oDb->selectRow($sql, $sTid)) {
            return $aRow['count'];
        }
        return 0;
    }

    /**
     * Получает последний пост в топике по ID
     *
     * @param    integer $sTid
     * @return    string
     */
    public function GetLastPostByTopicId($sTid)
    {
        $sql = 'SELECT MAX(post_id) as last_post
				FROM ' . Config::Get('db.table.forum_post') . '
				WHERE topic_id = ?';
        if ($aRow = $this->oDb->selectRow($sql, $sTid)) {
            return $aRow['last_post'];
        }
        return null;
    }

    /**
     * Получает дату поста по ID
     *
     * @param    integer $sPid
     * @return    string
     */
    public function GetPostDateById($sPid)
    {
        $sql = 'SELECT post_date_add
				FROM ' . Config::Get('db.table.forum_post') . '
				WHERE post_id = ?';
        if ($aRow = $this->oDb->selectRow($sql, $sPid)) {
            return $aRow['post_date_add'];
        }
        return null;
    }

    /**
     * Получает количество топиков
     *
     * @return    integer
     */
    public function GetCountTopics()
    {
        $sql = 'SELECT COUNT(*) as count
				FROM ' . Config::Get('db.table.forum_topic');
        if ($aRow = $this->oDb->selectRow($sql)) {
            return (int)$aRow['count'];
        }
        return 0;
    }

    /**
     * Получает количество постов
     *
     * @return    integer
     */
    public function GetCountPosts()
    {
        $sql = 'SELECT COUNT(*) as count
				FROM ' . Config::Get('db.table.forum_post');
        if ($aRow = $this->oDb->selectRow($sql)) {
            return (int)$aRow['count'];
        }
        return 0;
    }

    /**
     * Получает количество пользователей
     *
     * @param    integer $sPid
     * @return    integer
     */
    public function GetCountUsers()
    {
        $sql = 'SELECT COUNT(*) as count
				FROM ' . Config::Get('db.table.user');
        if ($aRow = $this->oDb->selectRow($sql)) {
            return (int)$aRow['count'];
        }
        return 0;
    }

    /**
     * Получает пользователей, дата рождения которых совпадает с текущей
     *
     * @param    integer $iLimit
     * @return    array
     */
    public function GetUsersByBirthday($iLimit)
    {
        $sql = 'SELECT user_id
				FROM ' . Config::Get('db.table.user') . '
				WHERE user_profile_birthday LIKE ?
				LIMIT 0, ?d';
        $aResult = array();
        if ($aRows = $this->oDb->select($sql, '%' . date('m-d') . '%', $iLimit)) {
            foreach ($aRows as $aRow) {
                $aResult[] = $aRow['user_id'];
            }
        }
        return $aResult;
    }
}

?>