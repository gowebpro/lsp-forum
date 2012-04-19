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

class PluginForum_ModuleForum_MapperForum extends Mapper {
	/**
	 * Перемещает топики в другой форум
	 *
	 * @param	integer	$sForumId
	 * @param	integer	$sForumIdNew
	 * @return bool
	 */
	public function MoveTopics($sForumId,$sForumIdNew) {
		$sql = "UPDATE ".Config::Get('db.table.prefix')."forum_topic
				SET forum_id = ?d
				WHERE forum_id = ?d";
		if ($this->oDb->query($sql,$sForumIdNew,$sForumId)) {
			return true;
		}
		return false;
	}

	/**
	 * Перемещает подфорумы в другой форум
	 *
	 * @param	integer	$sForumId
	 * @param	integer	$sForumIdNew
	 * @return bool
	 */
	public function MoveForums($sForumId,$sForumIdNew) {
		$sql = "UPDATE ".Config::Get('db.table.prefix')."forum
				SET forum_parent_id = ?d
				WHERE forum_parent_id = ?d";
		if ($this->oDb->query($sql,$sForumIdNew,$sForumId)) {
			return true;
		}
		return false;
	}

	public function GetCountTopicByForumId($sFid) {
		$sql = "SELECT COUNT(*) as count
				FROM ".Config::Get('db.table.prefix')."forum_topic
				WHERE forum_id = ?
				";
		if ($aRow=$this->oDb->selectRow($sql,$sFid)) {
			return $aRow['count'];
		}
		return 0;
	}
	public function GetCountPostByForumId($sFid) {
		$sql = "SELECT SUM(topic_count_post) as replies
				FROM ".Config::Get('db.table.prefix')."forum_topic
				WHERE forum_id = ?
				";
		if ($aRow=$this->oDb->selectRow($sql,$sFid)) {
			return $aRow['replies'];
		}
		return 0;
	}
	public function GetLastPostByForumId($sFid) {
		$sql = "SELECT MAX(last_post_id) as last_post
				FROM ".Config::Get('db.table.prefix')."forum_topic
				WHERE forum_id = ?
				";
		if ($aRow=$this->oDb->selectRow($sql,$sFid)) {
			return $aRow['last_post'];
		}
		return null;
	}

	public function GetCountPostByTopicId($sTid) {
		$sql = "SELECT COUNT(*) as count
				FROM ".Config::Get('db.table.prefix')."forum_post
				WHERE topic_id = ?
				";
		if ($aRow=$this->oDb->selectRow($sql,$sTid)) {
			return $aRow['replies'];
		}
		return 0;
	}
	public function GetLastPostByTopicId($sTid) {
		$sql = "SELECT MAX(post_id) as last_post
				FROM ".Config::Get('db.table.prefix')."forum_post
				WHERE topic_id = ?
				";
		if ($aRow=$this->oDb->selectRow($sql,$sTid)) {
			return $aRow['last_post'];
		}
		return null;
	}

	public function GetCountTopics() {
		$sql = "SELECT COUNT(*) as count
				FROM ".Config::Get('db.table.prefix')."forum_topic";
		if ($aRow=$this->oDb->selectRow($sql)) {
			return (int)$aRow['count'];
		}
		return 0;
	}
	public function GetCountPosts() {
		$sql = "SELECT COUNT(*) as count
				FROM ".Config::Get('db.table.prefix')."forum_post";
		if ($aRow=$this->oDb->selectRow($sql)) {
			return (int)$aRow['count'];
		}
		return 0;
	}
	public function GetCountUsers() {
		$sql = "SELECT COUNT(*) as count
				FROM ".Config::Get('db.table.user');
		if ($aRow=$this->oDb->selectRow($sql)) {
			return (int)$aRow['count'];
		}
		return 0;
	}
}

?>