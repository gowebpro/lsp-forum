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
		$aTopics = $this->PluginForum_Forum_GetTopicItemsByArrayTopicId($aIds);
		return $this->PluginForum_Forum_GetTopicsAdditionalData($aTopics);
	}

	/**
	 * Получает список постов
	 *
	 * @param unknown_type $aIds
	 * @return unknown
	 */
	protected function loadRelatedForumPost($aIds) {
		$aPosts = $this->PluginForum_Forum_GetPostItemsByArrayPostId($aIds);
		return $this->PluginForum_Forum_GetPostsAdditionalData($aPosts);
	}

}
?>