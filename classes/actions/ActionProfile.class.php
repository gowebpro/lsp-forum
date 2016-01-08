<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: ActionProfile.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Обрабатывает профайл юзера, т.е. УРЛ вида /profile/login/
 *
 */
class PluginForum_ActionProfile extends PluginForum_Inherit_ActionProfile {

	protected function RegisterEvent() {
		parent::RegisterEvent();
		$this->AddEventPreg('/^.+$/i','/^forum/i','/^topics/i','/^(page([1-9]\d{0,5}))?$/i','EventForumTopics');
		$this->AddEventPreg('/^.+$/i','/^forum/i','/^posts$/i','/^(page([1-9]\d{0,5}))?$/i','EventForumPosts');
	}

	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */

	/**
	 * Список топиков пользователя с форума
	 */
	protected function EventForumTopics() {
		if (!$this->CheckUserProfile()) {
			return parent::EventNotFound();
		}
		$this->sMenuSubItemSelect='forum_topics';
		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(2,2) ? $this->GetParamEventMatch(2,2) : 1;
		/**
		 * Получаем список топиков
		 */
		$aResult = $this->PluginForum_Forum_GetPostItemsByUserId($this->oUserProfile->getId(), array(
			'#where' => array('post_new_topic = ?' => array(1)),
			'#order' => array('post_date_add' => 'desc'),
			'#page' => array($iPage, Config::Get('module.topic.per_page'))
		));
		$aPosts = $this->PluginForum_Forum_GetPostsAdditionalData($aResult['collection']);
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.topic.per_page'),Config::Get('pagination.pages.count'),$this->oUserProfile->getUserWebPath().'forum/topics');
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aPosts',$aPosts);
		$this->Viewer_AddHtmlTitle($this->Lang_Get('user_menu_publication').' '.$this->oUserProfile->getLogin());
		$this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.forum.user_menu_publication_topics'));
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('forum_topics');
	}
	/**
	 * Вывод постов пользователя с форума
	 */
	protected function EventForumPosts() {
		if (!$this->CheckUserProfile()) {
			return parent::EventNotFound();
		}
		$this->sMenuSubItemSelect='forum_posts';
		/**
		 * Передан ли номер страницы
		 */
		$iPage=$this->GetParamEventMatch(2,2) ? $this->GetParamEventMatch(2,2) : 1;
		/**
		 * Получаем список комментов
		 */
		$aResult = $this->PluginForum_Forum_GetPostItemsByUserId($this->oUserProfile->getId(), array(
			'#where' => array('post_new_topic = ?'=>array(0)),
			'#order' => array('post_date_add' => 'desc'),
			'#page' => array($iPage, Config::Get('module.comment.per_page'))
		));
		$aPosts = $this->PluginForum_Forum_GetPostsAdditionalData($aResult['collection']);
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('module.comment.per_page'),Config::Get('pagination.pages.count'),$this->oUserProfile->getUserWebPath().'forum/posts');
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aPosts',$aPosts);
		$this->Viewer_AddHtmlTitle($this->Lang_Get('user_menu_publication').' '.$this->oUserProfile->getLogin());
		$this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.forum.user_menu_publication_posts'));
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('forum_posts');
	}

	/**
	 * Выполняется при завершении работы экшена
	 */
	public function EventShutdown() {
		if (!$this->oUserProfile) {
			return ;
		}
		parent::EventShutdown();
		/**
		 * Загружаем в шаблон необходимые переменные
		 */
		$iCountForumTopic=$this->PluginForum_Forum_GetCountItemsByFilter(array('#where'=>array('user_id = ?d' => array($this->oUserProfile->getId()), 'post_new_topic = ?'=>array(1))),'Post');
		$iCountForumPost=$this->PluginForum_Forum_GetCountItemsByFilter(array('#where'=>array('user_id = ?d' => array($this->oUserProfile->getId()), 'post_new_topic = ?'=>array(0))),'Post');
		$this->Viewer_Assign('iCountForumTopic',$iCountForumTopic);
		$this->Viewer_Assign('iCountForumPost',$iCountForumPost);
		/**
		 * Общее число публикация и избранного
		 */
		$iCountCreated = (int)$this->Viewer_GetSmartyObject()->getTemplateVars('iCountCreated');
		$this->Viewer_Assign('iCountCreated',$iCountCreated+$iCountForumTopic+$iCountForumPost);
		/**
		 * Загружаем в шаблон JS текстовки
		 */
		$this->Lang_AddLangJs(
			array(
				'panel_spoiler_placeholder'
			)
		);
	}
}
?>