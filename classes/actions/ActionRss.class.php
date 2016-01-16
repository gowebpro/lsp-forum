<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: ActionRss.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Экшен бработки RSS
 *
 */
class PluginForum_ActionRss extends PluginForum_Inherit_ActionRss {

	protected function RegisterEvent() {
		parent::RegisterEvent();
		$this->AddEvent('forum','RssForum');
		$this->AddEvent('forum_topic','RssForumTopic');
		$this->AddEvent('forum_stream','RssForumStream');
	}

	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */

	/**
	 * Вывод RSS топиков из форума
	 */
	protected function RssForum() {
		$sForumUrl=$this->GetParam(0);
		/**
		 * Проверяем, существует ли форум
		 */
		if (!($oForum=$this->PluginForum_Forum_GetForumByUrl($sForumUrl))) {
			if(!($oForum=$this->PluginForum_Forum_GetForumById($sForumUrl))) {
				return parent::EventNotFound();
			}
		}
		/**
		 * Проверяем права доступа
		 */
		$oForum=$this->PluginForum_Forum_GetForumsAdditionalData($oForum,PluginForum_ModuleForum::FORUM_DATA_RSS);
		if (!($oForum->getAllowShow() && $oForum->getAllowRead()) || !$this->PluginForum_Forum_isForumAuthorization($oForum)) {
			return parent::EventNotFound();
		}
		$aResult=$this->PluginForum_Forum_GetTopicItemsByForumId($oForum->getId(),array('#order'=>array('topic_pinned'=>'desc','last_post_id'=>'desc','topic_date_add'=>'desc'),'#page'=>array(1,Config::Get('plugin.forum.topic_per_page')*2)));
		$aTopics=$aResult['collection'];
		/**
		 * Формируем данные канала RSS
		 */
		$aChannel['title']=Config::Get('view.name');
		$aChannel['link']=Config::Get('path.root.web');
		$aChannel['description']=Config::Get('path.root.web').' / '.$oForum->getTitle().' / RSS channel';
		$aChannel['language']='ru';
		$aChannel['managingEditor']=Config::Get('general.rss_editor_mail');
		$aChannel['generator']=Config::Get('path.root.web');
		/**
		 * Запрашиваем первые сообщения каждой темы
		 */
		$aFirstPostsId=array();
		$aFirstPosts=array();
		foreach ($aTopics as $oTopic) {
			$aFirstPostsId[$oTopic->getId()]=$oTopic->getFirstPostId();
		}
		if (!empty($aFirstPostsId)) {
			$aFirstPosts=$this->PluginForum_Forum_GetPostItemsByArrayPostId($aFirstPostsId);
			$aFirstPosts=$this->PluginForum_Forum_GetPostsAdditionalData($aFirstPosts);
		}
		/**
		 * Формируем записи RSS
		 */
		$aItems=array();
		foreach ($aTopics as $oTopic){
			if (isset($aFirstPosts[$oTopic->getFirstPostId()])) {
				/**
				 * Relation data
				 */
				$oPost=$aFirstPosts[$oTopic->getFirstPostId()];
				$oUser=$oPost->getUser();
				/**
				 * Build record
				 */
				$aItem=array(
					'title'			=> $oTopic->getTitle(),
					'guid'			=> $oTopic->getUrlFull(),
					'link'			=> $oTopic->getUrlFull(),
					'description'	=> $this->getPostText($oPost),
					'pubDate'		=> $oTopic->getDateAdd(),
					'category'		=> htmlspecialchars($oForum->getTitle())
				);
				if ($oUser) {
					$aItem['author']=$oUser->getLogin();
				} else {
					$aItem['author']=$this->Lang_Get('plugin.forum.guest_prefix') . $oPost->getGuestName();
				}
				$aItems[]=$aItem;
			}
		}
		/**
		 * Формируем ответ
		 */
		$this->InitRss();
		$this->Viewer_Assign('aChannel',$aChannel);
		$this->Viewer_Assign('aItems',$aItems);
		$this->SetTemplateAction('index');
	}

	/**
	 * Вывод RSS собщений конкретного топика
	 */
	protected function RssForumTopic() {
		$sTopicId=$this->GetParam(0);
		/**
		 * Проверяем, существует ли топик
		 */
		if (!($oTopic=$this->PluginForum_Forum_GetTopicById($sTopicId))) {
			return parent::EventNotFound();
		}
		$oTopic=$this->PluginForum_Forum_GetTopicsAdditionalData($oTopic);
		/**
		 * Проверяем, существует ли форум
		 */
		if (!($oForum=$oTopic->getForum())) {
			return parent::EventNotFound();
		}
		/**
		 * Проверяем права доступа
		 */
		$oForum=$this->PluginForum_Forum_GetForumsAdditionalData($oForum,PluginForum_ModuleForum::FORUM_DATA_RSS);
		if (!($oForum->getAllowShow() && $oForum->getAllowRead()) || !$this->PluginForum_Forum_isForumAuthorization($oForum)) {
			return parent::EventNotFound();
		}
		/**
		 * Получаем сообщения
		 */
		$aPosts=$this->PluginForum_Forum_GetPostItemsByTopicId($oTopic->getId(), array('#limit'=>array(100)));
		$aPosts=$this->PluginForum_Forum_GetPostsAdditionalData($aPosts);
		/**
		 * Формируем данные канала RSS
		 */
		$aChannel['title']=Config::Get('view.name');
		$aChannel['link']=Config::Get('path.root.web');
		$aChannel['description']=Config::Get('path.root.web').' / '.$oTopic->getTitle().' / '.$oForum->getTitle().' / RSS channel';
		$aChannel['language']='ru';
		$aChannel['managingEditor']=Config::Get('general.rss_editor_mail');
		$aChannel['generator']=Config::Get('path.root.web');
		/**
		 * Формируем записи RSS
		 */
		$aItems=array();
		foreach ($aPosts as $oPost){
			/**
			 * Relation data
			 */
			$oUser=$oPost->getUser();
			/**
			 * Build record
			 */
			$aItem=array(
				'title'			=> 'Posts: '.$oTopic->getTitle(),
				'guid'			=> $oTopic->getUrlFull().'#post-'.$oPost->getId(),
				'link'			=> $oTopic->getUrlFull().'#post-'.$oPost->getId(),
				'description'	=> $this->getPostText($oPost),
				'pubDate'		=> $oPost->getDateAdd(),
				'category'		=> 'posts'
			);
			if ($oUser) {
				$aItem['author']=$oUser->getLogin();
			} else {
				$aItem['author']=$this->Lang_Get('plugin.forum.guest_prefix') . $oPost->getGuestName();
			}
			$aItems[]=$aItem;
		}
		/**
		 * Формируем ответ
		 */
		$this->InitRss();
		$this->Viewer_Assign('aChannel',$aChannel);
		$this->Viewer_Assign('aItems',$aItems);
		$this->SetTemplateAction('index');
	}

	/**
	 * Вывод RSS последних записей с форума
	 */
	protected function RssForumStream() {
		/**
		 * Получаем список форумов
		 */
		$aForumsId=$this->PluginForum_Forum_GetOpenForumsUser($this->User_GetUserCurrent(),true);
		/**
		 * Получаем последние топики
		 */
		$aTopics=$this->PluginForum_Forum_GetTopicItemsAll(
			array(
				'#where'=>array('forum_id IN (?a)'=>array($aForumsId)),
				'#order'=>array('last_post_id'=>'desc'),
				'#limit'=>array(30)
			)
		);
		$aTopics = $this->PluginForum_Forum_GetTopicsAdditionalData($aTopics);
		/**
		 * Формируем данные канала RSS
		 */
		$aChannel['title']=Config::Get('view.name');
		$aChannel['link']=Config::Get('path.root.web');
		$aChannel['description']=Config::Get('path.root.web').' / RSS channel';
		$aChannel['language']='ru';
		$aChannel['managingEditor']=Config::Get('general.rss_editor_mail');
		$aChannel['generator']=Config::Get('path.root.web');
		/**
		 * Формируем записи RSS
		 */
		$aItems=array();
		foreach ($aTopics as $oTopic){
			/**
			 * Relation data
			 */
			$oPost=$oTopic->getPost();
			$oUser=$oPost->getUser();
			/**
			 * Build record
			 */
			$aItem=array(
				'title'			=> 'Latest topics: '.$oTopic->getTitle(),
				'guid'			=> $oTopic->getUrlFull().'#post-'.$oPost->getId(),
				'link'			=> $oTopic->getUrlFull().'#post-'.$oPost->getId(),
				'description'	=> $this->getPostText($oPost),
				'pubDate'		=> $oPost->getDateAdd(),
				'category'		=> 'topics'
			);
			if ($oUser) {
				$aItem['author']=$oUser->getLogin();
			} else {
				$aItem['author']=$this->Lang_Get('plugin.forum.guest_prefix') . $oPost->getGuestName();
			}
			$aItems[]=$aItem;
		}
		/**
		 * Формируем ответ
		 */
		$this->InitRss();
		$this->Viewer_Assign('aChannel',$aChannel);
		$this->Viewer_Assign('aItems',$aItems);
		$this->SetTemplateAction('index');
	}

	/**
	 * Формирует текст топика для RSS
	 *
	 */
	protected function getPostText($oTopic) {
		$sText=$oTopic->getText();
		$sShortText=mb_substr($oTopic->getText(),0,500,'UTF-8');
		if ($sShortText!=$sText) {
			$sText.="<br><a href=\"{$oTopic->getUrlFull()}#cut\" title=\"{$this->Lang_Get('topic_read_more')}\">{$this->Lang_Get('topic_read_more')}</a>";
		}
		return $sText;
	}
}
?>