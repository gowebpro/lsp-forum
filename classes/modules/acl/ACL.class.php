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
	 * @param Entity_Forum $oForum
	 * @param Entity_User $oUser
	 * @return bool
	 */
	 public function CanAddForumTopic($oForum, ModuleUser_EntityUser $oUser) {
		/**
		 * Для администраторов ограничений нет
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		if ($oUser->getRating() >= $oForum->getLimitRatingTopic()) {
			return true;
		}
		if ($oUser->getRating() >= Config::Get('plugin.forum.acl.create.topic.rating')) {
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
	public function CanAddForumTopicTime(ModuleUser_EntityUser $oUser) {
		/**
		 * Для администраторов ограничение по времени не действует
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		/**
		 * Органичение по времени выключено
		 */
		if (Config::Get('plugin.forum.acl.create.topic.time')==0) {
			return true;
		}
		/**
		 * Отключение ограничения по времени по рейтингу
		 */
		if ($oUser->getRating()>=Config::Get('plugin.forum.acl.create.topic.time_rating')) {
			return true;
		}
		/**
		 * Проверяем, если топик опубликованный меньше чем plugin.forum.acl.create.topic.time секунд назад
		 */
		$aTopics = $this->PluginForum_Forum_GetTopicItemsByFilter(array('#where'=>array('user_id = ?d' => array($oUser->getId()),'topic_date_add >= ?' => array(date("Y-m-d H:i:s",time()-Config::Get('plugin.forum.acl.create.topic.time'))))));

		if (count($aTopics)>0) {
			return false;
		}
		return true;
	}

	/**
	 * Проверяет может ли пользователь закрывать\открывать топик
	 *
	 * @param Entity_User $oTopic
	 * @param Entity_User $oUser
	 * @return bool
	 */
	public function IsAllowClosedForumTopic($oTopic,ModuleUser_EntityUser $oUser) {
		/**
		 * Разрешаем если это админ сайта
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		return false;
	}

	/**
	 * Проверяет может ли пользователь прикреплять\откреплять топик
	 *
	 * @param Entity_User $oTopic
	 * @param Entity_User $oUser
	 * @return bool
	 */
	public function IsAllowPinnedForumTopic($oTopic,ModuleUser_EntityUser $oUser) {
		/**
		 * Разрешаем если это админ сайта
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		return false;
	}

	/**
	 * Проверяет может ли пользователь редактировать топик
	 *
	 * @param Entity_User $oTopic
	 * @param Entity_User $oUser
	 * @return bool
	 */
	public function IsAllowEditForumTopic($oTopic,ModuleUser_EntityUser $oUser) {
		/**
		 * Разрешаем если это админ сайта
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		/**
		 * Разрешаем если это автор топика
		 */
		if ($oTopic->getUserId()==$oUser->getId()) {
			return true;
		}
		/**
		 * Если модер форума
		 */
//		$oForumUser = $this->PluginForum_Forum_GetUserItemsByForumIdAndUserId($oTopic->getForumId(),$oUser->getId());
//		if ($oForumUser and ($oForumUser->getIsModerator())) {
//			return true;
//		}
		return false;
	}


	/**
	 * Проверяет может ли пользователь оставлять посты
	 *
	 * @param  Entity_User $oUser
	 * @return bool
	 */
	public function CanAddForumPost(ModuleUser_EntityUser $oUser) {
		return true;
	}

	/**
	 * Проверяет может ли пользователь оставлять посты по времени
	 *
	 * @param Entity_User $oUser
	 * @return bool
	 */
	public function CanAddForumPostTime(ModuleUser_EntityUser $oUser) {
		/**
		 * Для администраторов ограничение по времени не действует
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		/**
		 * Органичение по времени выключено
		 */
		if (Config::Get('plugin.forum.acl.create.comment.time')==0) {
			return true;
		}
		/**
		 * Отключение ограничения по времени по рейтингу
		 */
		if ($oUser->getRating()>=Config::Get('plugin.forum.acl.create.comment.time_rating')) {
			return true;
		}
		/**
		 * Проверяем, если пост опубликованный меньше чем plugni.forum.acl.create.post.time секунд назад
		 */
		$aPosts = $this->PluginForum_Forum_GetPostItemsByFilter(array('#where'=>array('user_id = ?d'=>array($oUser->getId()),'post_date_add >= ?' => array(date("Y-m-d H:i:s",time()-Config::Get('plugin.forum.acl.create.post.time'))))));

		if (count($aPosts)>0) {
			return false;
		}
		return true;
	}

	/**
	 * Проверяет может ли пользователь оставлять посты в закрытых топиках
	 *
	 * @param  Entity_User $oUser
	 * @return bool
	 */
	public function CanAddForumPostClose(ModuleUser_EntityUser $oUser) {
		/**
		 * Для администраторов ограничение не действует
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		return false;
	}

	/**
	 * Проверяет можно или нет пользователю редактировать пост
	 *
	 * @param  object $oPost
	 * @param  object $oUser
	 * @return bool
	 */
	public function IsAllowEditForumPost($oPost, ModuleUser_EntityUser $oUser) {
		/**
		 * Разрешаем если это админ сайта
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		/**
		 * Разрешаем если это автор топика
		 */
		if ($oPost->getUserId()==$oUser->getId()) {
			//15 минутный тайм-аут
			$sDateComment=strtotime($oPost->getDateAdd());
			if ($sDateComment>(time()-Config::Get('plugin.forum.acl.edit.post.time'))) {
				return true;
			}
		}
		/**
		 * Если модер форума
		 */
//		$oForumUser = $this->PluginForum_Forum_GetUserItemsByForumIdAndUserId($oPost->getForumId(),$oUser->getId());
//		if ($oForumUser and ($oForumUser->getIsModerator())) {
//			return true;
//		}
		return false;
	}

	/**
	 * Проверяет можно или нет пользователю удалять пост
	 *
	 * @param object $oPost
	 * @param object $oUser
	 */
	public function IsAllowDeleteForumPost($oPost,$oUser) {
		/**
		 * Разрешаем если это админ сайта
		 */
		if ($oUser->isAdministrator()) {
			return true;
		}
		/**
		 * Разрешаем если это автор комментария и настройками групп разрешено удалять свои комментарии
		 */
		if ($oPost->getUserId()==$oUser->getId()) {
			//15 минутный тайм-аут
			$sDateComment=strtotime($oPost->getDateAdd());
			if ($sDateComment>(time()-Config::Get('plugin.forum.acl.edit.post.time'))) {
				return true;
			}
		}
		/**
		 * Если модер форума
		 */
//		$oForumUser = $this->PluginForum_Forum_GetUserItemsByForumIdAndUserId($oPost->getForumId(),$oUser->getId());
//		if ($oForumUser and ($oForumUser->getIsModerator())) {
//			return true;
//		}
		return false;
	}

}
?>