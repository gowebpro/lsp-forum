<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Subscribe.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleSubscribe extends ModuleSubscribe {

	/**
	 * Проверка объекта подписки с типом "forum_new_topic"
	 * Название метода формируется автоматически
	 *
	 * @param int $iTargetId
	 * @param int $iStatus
	 */
	public function CheckTargetForumNewTopic($iTargetId,$iStatus) {
		if ($oForum=$this->PluginForum_Forum_GetForumById($iTargetId)) {
			return true;
		}
		return false;
	}

	/**
	 * Возвращает URL на страницы объекта подписки с типом "forum_new_topic"
	 * Название метода формируется автоматически
	 *
	 * @param $iTargetId
	 * @return bool
	 */
	public function GetUrlTargetForumNewTopic($iTargetId) {
		if ($oForum=$this->PluginForum_Forum_GetForumById($iTargetId)) {
			return $oForum->getUrlFull();
		}
		return false;
	}


	/**
	 * Проверка объекта подписки с типом "topic_new_post"
	 * Название метода формируется автоматически
	 *
	 * @param int $iTargetId
	 * @param int $iStatus
	 */
	public function CheckTargetTopicNewPost($iTargetId,$iStatus) {
		if ($oTopic=$this->PluginForum_Forum_GetTopicById($iTargetId)) {
			return true;
		}
		return false;
	}

	/**
	 * Возвращает URL на страницы объекта подписки с типом "topic_new_post"
	 * Название метода формируется автоматически
	 *
	 * @param $iTargetId
	 * @return bool
	 */
	public function GetUrlTargetTopicNewPost($iTargetId) {
		if ($oTopic=$this->PluginForum_Forum_GetTopicById($iTargetId)) {
			return $oTopic->getUrlFull();
		}
		return false;
	}
}
?>