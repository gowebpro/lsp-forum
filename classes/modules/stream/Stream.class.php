<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Stream.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleStream extends PluginForum_Inherit_ModuleStream {

	/**
	 * Получает список топиков
	 *
	 * @param unknown_type $aIds
	 * @return unknown
	 */
	protected function loadRelatedForumTopic($aIds) {
		return $this->PluginForum_Forum_GetTopicItemsByArrayTopicId($aIds);
	}

	/**
	 * Получает список постов
	 *
	 * @param unknown_type $aIds
	 * @return unknown
	 */
	protected function loadRelatedForumPost($aIds) {
		return $this->PluginForum_Forum_GetPostItemsByArrayPostId($aIds);
	}

}
?>