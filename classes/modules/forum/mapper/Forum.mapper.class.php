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
}

?>