<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: ACL.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleACL extends ModuleACL {
	/**
	 * Проверяет может ли пользователь создавать топики
	 *
	 * @param Entity_User $oUser
	 * @return bool
	 */
	 public function CanCreateTopic(ModuleUser_EntityUser $oUser) {
		if ($oUser->getRating()>=Config::Get('acl.create.topic.rating')) {
			return true;
		}
		return false;
	}

	/**
	 * Проверяет может ли пользователь создавать топик по времени
	 *
	 * @param  Entity_User $oUser
	 * @return bool
	 */
	public function CanCreateTopicTime(ModuleUser_EntityUser $oUser) {
		/**
		 * Для администраторов ограничение по времени не действует
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		/**
		 * Органичение по времени выключено
		 */
		if (Config::Get('acl.create.topic.limit_time')==0) {
			return true;
		}
		/**
		 * Отключение ограничения по времени по рейтингу
		 */
		if ($oUser->getRating()>=Config::Get('acl.create.topic.limit_time_rating')) {
			return true;
		}
		/**
		 * Проверяем, если топик опубликованный меньше чем acl.create.topic.limit_time секунд назад
		 */
		$aTopics = array();//$this->PluginForum_Forum_GetTopicItemsByFilter(array('#where'=>array('topic_date_add < ?d' => array(...))));

		if (isset($aTopics['count']) and $aTopics['count']>0) {
			return false;
		}
		return true;
	}

	/**
	 * Проверяет может ли пользователь создавать комментарии в закрытых топиках
	 *
	 * @param  Entity_User $oUser
	 * @return bool
	 */
	public function CanPostCommentClose(ModuleUser_EntityUser $oUser) {
		if ($oUser->isAdministrator()) {
			return true;
		}
		return false;
	}

	/**
	 * Проверяет может ли пользователь создавать комментарии
	 *
	 * @param  Entity_User $oUser
	 * @return bool
	 */
	public function CanPostComment(ModuleUser_EntityUser $oUser) {
		/**
		 * Для администраторов ограничение не действует
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}

		return false;
	}
}
?>