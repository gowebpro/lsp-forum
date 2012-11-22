<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: ActionForum.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ActionForum extends ActionPlugin {
	/**
	 * Текущий юзер
	 *
	 * @var ModuleUser_EntityUser
	 */
	protected $oUserCurrent=null;
	/**
	 * Главное меню
	 *
	 * @var string
	 */
	protected $sMenuHeadItemSelect='forum';
	/**
	 * Меню
	 *
	 * @var string
	 */
	protected $sMenuItemSelect='forum';
	/**
	 * Подменю
	 *
	 * @var string
	 */
	protected $sMenuSubItemSelect='';
	/**
	 * Хлебные крошки
	 *
	 * @var array
	 */
	protected $aBreadcrumbs=array();
	/**
	 * Заголовки
	 *
	 * @var array
	 */
	protected $aTitles=array('before'=>array(),'after'=>array());


	/**
	 * Инициализация экшена
	 */
	public function Init() {
		/**
		 * Получаем текущего пользователя
		 */
		$this->oUserCurrent=$this->User_GetUserCurrent();
		/**
		 * Закрытый режим
		 */
		if (!(LS::Adm()) && Config::Get('plugin.forum.close_mode')) {
			return parent::EventNotFound();
		}
		/**
		 * Меню
		 */
		$this->Viewer_AddMenu('forum',$this->getTemplatePathPlugin().'menu.forum.tpl');
		/**
		 * Заголовок
		 */
		$this->_addTitle($this->Lang_Get('plugin.forum.forums'));
		/**
		 * Устанавливаем дефолтный эвент
		 */
		$this->SetDefaultEvent('index');
		/**
		 * Устанавливаем дефолтный шаблон
		 */
		$this->SetTemplateAction('index');
	}


	/**
	 * Регистрация эвентов
	 */
	protected function RegisterEvent() {
		/**
		 * Админка
		 */
		$this->AddEvent('admin','EventAdmin');
		/**
		 * Пользовательская часть
		 */
		$this->AddEvent('index','EventIndex');
		$this->AddEvent('jump','EventJump');
		$this->AddEventPreg('/^topic$/i','/^(\d+)$/i','/^(page([1-9]\d{0,5}))?$/i','EventShowTopic');
		$this->AddEventPreg('/^topic$/i','/^(\d+)$/i','/^reply$/i','EventAddPost');
		$this->AddEventPreg('/^topic$/i','/^edit$/i','/^(\d+)$/i','EventEditPost');
		$this->AddEventPreg('/^topic$/i','/^delete$/i','/^(\d+)$/i','EventDeletePost');
		$this->AddEventPreg('/^topic$/i','/^(\d+)$/i','/^lastpost$/i','EventLastPost');
		$this->AddEventPreg('/^findpost$/i','/^(\d+)$/i','EventFindPost');
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^(page([1-9]\d{0,5}))?$/i',array('EventShowForum','forum'));
		$this->AddEventPreg('/^[\w\-\_]+$/i','/^add$/i',array('EventAddTopic','add_topic'));
		$this->AddEventPreg('/^(\d+)$/i','/^(page([1-9]\d{0,5}))?$/i',array('EventShowForum','forum'));
		$this->AddEventPreg('/^(\d+)$/i','/^add$/i',array('EventAddTopic','add_topic'));
		/**
		 * AJAX Обработчики
		 */
		$this->AddEventPreg('/^ajax$/i','/^preview$/','EventAjaxPreview');
		$this->AddEventPreg('/^ajax$/i','/^addmoderator$/','EventAjaxAddModerator');
		$this->AddEventPreg('/^ajax$/i','/^delmoderator$/','EventAjaxDelModerator');
		$this->AddEventPreg('/^ajax$/i','/^getmoderator$/','EventAjaxGetModerator');
		$this->AddEventPreg('/^ajax$/i','/^getlasttopics$/','EventAjaxGetLastTopics');
	}


	/**
	 * Предпросмотр
	 *
	 */
	protected function EventAjaxPreview() {
		$this->Viewer_SetResponseAjax('jsonIframe',false);
		/**
		 * Допустимый тип?
		 */
		$sType=getRequest('action_type');
		$bTopic=in_array($sType,array('add_topic','edit_topic')) ? 1 : 0;
		$oTopic=null;
		$oPost=LS::Ent('PluginForum_Forum_Post');
		/**
		 * Создаем объект топика для валидации данных
		 */
		if ($bTopic) {
			$oTopic=LS::Ent('PluginForum_Forum_Topic');
			$oTopic->setTitle(strip_tags(getRequest('topic_title')));
			$oTopic->setDescription(getRequest('topic_description'));
			$oTopic->setDateAdd(date('Y-m-d H:i:s'));

			$oPost->_setValidateScenario('topic');
			$oPost->setTitle(strip_tags($oTopic->getTitle()));
		} else {
			$oPost->_setValidateScenario('post');
			$oPost->setTitle(strip_tags(getRequest('post_title')));
		}
		$oPost->setDateAdd(date('Y-m-d H:i:s'));
		$oPost->setText($this->PluginForum_Forum_TextParse(getRequest('post_text')));
		$oPost->setTextSource(getRequest('post_text'));
		if (!$this->User_IsAuthorization()) {
			$oPost->setUser(null);
			$oPost->setGuestName(strip_tags(getRequest('guest_name')));
		} else {
			$oPost->setUser($this->oUserCurrent);
		}
		/**
		 * Проверка корректности полей формы
		 */
		if ($bTopic && !$this->checkTopicFields($oTopic)) {
			return false;
		}
		if (!$this->checkPostFields($oPost)) {
			return false;
		}
		/**
		 * Рендерим шаблон для предпросмотра топика
		 */
		$oViewer=$this->Viewer_GetLocalViewer();
		$oViewer->Assign('oPost',$oPost);
		$sTextResult=$oViewer->Fetch($this->getTemplatePathPlugin().'preview.tpl');
		/**
		 * Передаем результат в ajax ответ
		 */
		$this->Viewer_AssignAjax('sText',$sTextResult);
		return true;
	}

	/**
	 * Добавление модератора
	 *
	 */
	protected function EventAjaxAddModerator() {
		/**
		 * Устанавливаем формат Ajax ответа
		 */
		$this->Viewer_SetResponseAjax('json');
		/**
		 * Обновляем или добавляем
		 */
		$sAction = getRequest('moder_form_action');
		/**
		 * Получаем форум по ID
		 */
		if (!($oForum=$this->PluginForum_Forum_GetForumById(getRequest('moder_forum_id')))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_action_error_forum'),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Если выбранный форум является категорией
		 */
		if ($oForum->getCanPost()==1) {
			$this->Message_AddError($this->Lang_Get('plugin.forum.moderator_action_error_forum_cat'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Получаем юзера по имени
		 */
		if (!($oUser=$this->User_GetUserByLogin(getRequest('moder_name')))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_action_error_user', array('login'=>getRequest('moder_name'))),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Проверяем модератора на существование
		 */
		$oModerator=$this->PluginForum_Forum_GetModeratorByUserIdAndForumId($oUser->getId(),$oForum->getId());
		if ($sAction == 'add' && $oModerator) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_add_error_exsist', array('login'=>$oUser->getLogin())),$this->Lang_Get('error'));
			return false;
		} elseif ($sAction == 'update' && !$oModerator) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_update_error_not', array('login'=>$oUser->getLogin())),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Создаем объект модератора
		 */
		if ($sAction == 'add') {
			$oModerator=LS::Ent('PluginForum_Forum_Moderator');
		}
		$oModerator->setForumId($oForum->getId());
		$oModerator->setUserId($oUser->getId());
		$oModerator->setLogin($oUser->getLogin());
		$oModerator->setViewIp( (int)getRequest('moder_opt_viewip',0,'post') === 1 );
		$oModerator->setAllowReadonly(0);
		$oModerator->setAllowEditPost( (int)getRequest('moder_opt_editpost',0,'post') === 1 );
		$oModerator->setAllowEditTopic( (int)getRequest('moder_opt_edittopic',0,'post') === 1 );
		$oModerator->setAllowDeletePost( (int)getRequest('moder_opt_deletepost',0,'post') === 1 );
		$oModerator->setAllowDeleteTopic( (int)getRequest('moder_opt_deletetopic',0,'post') === 1 );
		$oModerator->setAllowMovePost(0);
		$oModerator->setAllowMoveTopic( (int)getRequest('moder_opt_movetopic',0,'post') === 1 );
		$oModerator->setAllowOpencloseTopic( (int)getRequest('moder_opt_openclosetopic',0,'post') === 1 );
		$oModerator->setAllowPinTopic( (int)getRequest('moder_opt_pintopic',0,'post') === 1 );
		$oModerator->setIsActive(1);
		/**
		 * Код
		 */
		require_once Config::Get('path.root.engine').'/lib/external/XXTEA/encrypt.php';
		$sCode=$oForum->getId().'_'.$oUser->getId();
		$sCode=rawurlencode(base64_encode(xxtea_encrypt($sCode,Config::Get('plugin.forum.encrypt'))));
		$oModerator->setHash($sCode);
		/**
		 * Добавляем\сохраняем
		 */
		$oModerator->Save();
		/**
		 * Свзяка модератор - форум
		 */
		if ($sAction == 'add') {
			$oForum->moderators->add($oModerator);
			$oForum->Save();
		}
		/**
		 * Рендерим шаблон для предпросмотра топика
		 */
		$oViewer=$this->Viewer_GetLocalViewer();
		$oViewer->Assign('oForum',$oForum);
		$sTextResult=$oViewer->Fetch($this->getTemplatePathPlugin().'actions/ActionForum/admin/list_moderators.tpl');
		/**
		 * Передаем результат в ajax ответ
		 */
		$this->Viewer_AssignAjax('sForumId',$oForum->getId());
		$this->Viewer_AssignAjax('sText',$sTextResult);
		$this->Message_AddNoticeSingle($this->Lang_Get('plugin.forum.moderator_'.$sAction.'_ok'));
		return true;
	}
	/**
	 * Удаление модератора
	 *
	 */
	protected function EventAjaxDelModerator() {
		/**
		 * Устанавливаем формат Ajax ответа
		 */
		$this->Viewer_SetResponseAjax('json');
		/**
		 * Читаем параметры
		 */
		$sHash = getRequest('hash');
		/**
		 * Декодируем хэш
		 */
		require_once Config::Get('path.root.engine').'/lib/external/XXTEA/encrypt.php';
		$sModeratorId=xxtea_decrypt(base64_decode(rawurldecode($sHash)),Config::Get('plugin.forum.encrypt'));
		if (!$sModeratorId) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return;
		}
		list($sForumId,$sUserId)=explode('_',$sModeratorId);
		/**
		 * Получаем форум по ID
		 */
		if (!($oForum=$this->PluginForum_Forum_GetForumById($sForumId))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_action_error_forum'),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Получаем юзера по ID
		 */
		if (!($oUser=$this->User_GetUserById($sUserId))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_action_error_user', array('login'=>$oUser->getLogin())),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Проверяем модератора на существование
		 */
		if (!($oModerator=$this->PluginForum_Forum_GetModeratorByUserIdAndForumId($oUser->getId(),$oForum->getId()))){
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_del_error_not_found', array('login'=>$oUser->getLogin())),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Удаляем связку модератор - форум
		 */
		$oForum->moderators->delete($oModerator->getId());
		$oForum->Save();
		/**
		 * Удаляем модератора
		 */
		$oModerator->Delete();
		/**
		 * Рендерим шаблон для предпросмотра топика
		 */
		$oViewer=$this->Viewer_GetLocalViewer();
		$oViewer->Assign('oForum',$oForum);
		$sTextResult=$oViewer->Fetch($this->getTemplatePathPlugin().'actions/ActionForum/admin/list_moderators.tpl');
		/**
		 * Передаем результат в ajax ответ
		 */
		$this->Viewer_AssignAjax('sForumId',$oForum->getId());
		$this->Viewer_AssignAjax('sText',$sTextResult);
		$this->Message_AddNoticeSingle($this->Lang_Get('plugin.forum.moderator_del_ok'));
		return true;
	}
	/**
	 * Извлечение модератора
	 *
	 */
	protected function EventAjaxGetModerator() {
		/**
		 * Устанавливаем формат Ajax ответа
		 */
		$this->Viewer_SetResponseAjax('json');
		/**
		 * Читаем параметры
		 */
		$sHash = getRequest('hash');
		/**
		 * Декодируем хэш
		 */
		require_once Config::Get('path.root.engine').'/lib/external/XXTEA/encrypt.php';
		$sModeratorId=xxtea_decrypt(base64_decode(rawurldecode($sHash)),Config::Get('plugin.forum.encrypt'));
		if (!$sModeratorId) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return;
		}
		list($sForumId,$sUserId)=explode('_',$sModeratorId);
		/**
		 * Получаем форум по ID
		 */
		if (!($oForum=$this->PluginForum_Forum_GetForumById($sForumId))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_action_error_forum'),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Получаем юзера по ID
		 */
		if (!($oUser=$this->User_GetUserById($sUserId))) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_action_error_user', array('login'=>$oUser->getLogin())),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Получаем модератора
		 */
		if (!($oModerator=$this->PluginForum_Forum_GetModeratorByUserIdAndForumId($oUser->getId(),$oForum->getId()))){
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.moderator_action_error_not_found', array('login'=>$oUser->getLogin())),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Передаем результат в ajax ответ
		 */
		$this->Viewer_AssignAjax('sForumId',$oForum->getId());
		$this->Viewer_AssignAjax('sModerName',$oUser->getLogin());
		$this->Viewer_AssignAjax('bOptViewip',(bool)$oModerator->getViewIp());
		$this->Viewer_AssignAjax('bOptEditPost',(bool)$oModerator->getAllowEditPost());
		$this->Viewer_AssignAjax('bOptEditTopic',(bool)$oModerator->getAllowEditTopic());
		$this->Viewer_AssignAjax('bOptDeletePost',(bool)$oModerator->getAllowDeletePost());
		$this->Viewer_AssignAjax('bOptDeleteTopic',(bool)$oModerator->getAllowDeleteTopic());
		$this->Viewer_AssignAjax('bOptMoveTopic',(bool)$oModerator->getAllowMoveTopic());
		$this->Viewer_AssignAjax('bOptOpencloseTopic',(bool)$oModerator->getAllowOpencloseTopic());
		$this->Viewer_AssignAjax('bOptPinTopic',(bool)$oModerator->getAllowPinTopic());
		return true;
	}
	/**
	 * Обработка получения последних топиков
	 * Используется в блоке "Прямой эфир"
	 *
	 */
	protected function EventAjaxGetLastTopics() {
		/**
		 * Устанавливаем формат Ajax ответа
		 */
		$this->Viewer_SetResponseAjax('json');
		/**
		 * Получаем список форумов
		 */
		$aForumsId=$this->PluginForum_Forum_GetForumsOpenUser(LS::CurUsr(),true);
		/**
		 * Получаем последние топики
		 */
		$aLastTopics=$this->PluginForum_Forum_GetTopicItemsAll(
			array(
				'#where'=>array('forum_id IN (?a)'=>array($aForumsId)),
				'#order'=>array('last_post_id'=>'desc'),
				'#page'=>array(1,Config::Get('block.stream.row'))
			)
		);
		if (!empty($aLastTopics['collection'])) {
			$oViewer=$this->Viewer_GetLocalViewer();
			$oViewer->Assign('aLastTopics',$aLastTopics['collection']);
			$sTextResult=$oViewer->Fetch($this->getTemplatePathPlugin().'blocks/block.stream_forum.tpl');
			$this->Viewer_AssignAjax('sText',$sTextResult);
			return;
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.block_stream_empty'),$this->Lang_Get('attention'));
			return;
		}
	}


	/**
	 * Авторизация на форуме
	 */
	protected function EventForumLogin($oForum=null) {
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('oForum',$oForum);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('login');
		/**
		 * Если была отправлена форма с данными
		 */
		if (isPost('f_password')) {
			$sPassword=getRequest('f_password','','post');
			if (!func_check($sPassword,'text',1,32)) {
				$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.password_blank'));
				return;
			}
			if ($sPassword != $oForum->getPassword()) {
				$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.password_wrong'));
				return;
			}
			fSetCookie('chiffaforumpass_'.$oForum->getId(), md5($sPassword));
			$sBackUrl = $oForum->getUrlFull();
			if (isset($_SERVER['HTTP_REFERER'])) {
				$sBackUrl = $_SERVER['HTTP_REFERER'];
			}
			Router::Location($sBackUrl);
		}
	}


	/**
	 * Переход по форумам
	 */
	protected function EventJump() {
		$this->Security_ValidateSendForm();
		/**
		 * Получаем форум по ID
		 */
		if (!($oForum=$this->PluginForum_Forum_GetForumById(getRequest('f')))) {
			return parent::EventNotFound();
		}
		Router::Location($oForum->getUrlFull());
	}


	/**
	 * Главная страница форума
	 *
	 */
	public function EventIndex() {
		/**
		 * Получаем список форумов
		 */
		$aCategories=$this->PluginForum_Forum_LoadTreeOfForum(array('#order'=>array('forum_sort'=>'asc')));
		/**
		 * Калькулирует инфу о счетчиках и последнем сообщении из подфорумов
		 */
		if (!empty($aCategories)) {
			foreach ($aCategories as $oForum) {
				$oForum=$this->PluginForum_Forum_CalcChildren($oForum);
			}
		}
		/**
		 * Получаем статистику
		 */
		$aForumStats=$this->PluginForum_Forum_GetForumStats();
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aCategories',$aCategories);
		$this->Viewer_Assign('aForumStats',$aForumStats);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');
	}


	/**
	 * Просмотр форума
	 *
	 */
	public function EventShowForum() {
		$this->sMenuSubItemSelect='show_forum';
		/**
		 * Получаем URL форума из эвента
		 */
		$sUrl=$this->sCurrentEvent;
		/**
		 * Получаем форум по URL
		 */
		if (!($oForum=$this->PluginForum_Forum_GetForumByUrl($sUrl))) {
			/**
			 * Возможно форум запросили по id
			 */
			if (!($oForum=$this->PluginForum_Forum_GetForumById($sUrl))) {
				return parent::EventNotFound();
			}
			if ($oForum->getUrl()){
				Router::Location($oForum->getUrlFull());
			}
		}
		/**
		 * Редирект
		 */
		if ($oForum->getRedirectOn()) {
			$oForum->setRedirectHits((int)$oForum->getRedirectHits()+1);
			$oForum->Save();

			Router::Location($oForum->getRedirectUrl());
		}
		/**
		 * Калькулятор
		 */
		$oForum=$this->PluginForum_Forum_CalcChildren($oForum);
		/**
		 * Права доступа
		 */
		if (!($oForum->getAllowShow() && $oForum->getAllowRead())) {
			return parent::EventNotFound();
		}
		/**
		 * Хлебные крошки
		 */
		$this->_breadcrumbsCreate($oForum);
		/**
		 * Если установлен пароль
		 */
		if (!$this->PluginForum_Forum_isForumAuthorization($oForum)) {
			$this->EventForumLogin($oForum);
			return;
		}
		/**
		 * Получаем текущую страницу
		 */
		$iPage=$this->GetParamEventMatch(0,2) ? $this->GetParamEventMatch(0,2) : 1;
		/**
		 * Получаем топики
		 */
		$aResult=$this->PluginForum_Forum_GetTopicItemsByForumId($oForum->getId(),array('#order'=>array('topic_pinned'=>'desc','last_post_id'=>'desc','topic_date_add'=>'desc'),'#page'=>array($iPage,Config::Get('plugin.forum.topic_per_page'))));
		/**
		 * Делим топики на важные и обычные
		 */
		$aPinned=array();
		$aTopics=array();
		foreach ($aResult['collection'] as $oTopic) {
			if ($oTopic->getPinned()) {
				$aPinned[]=$oTopic;
			} else {
				$aTopics[]=$oTopic;
			}
		}
		/**
		 * Сортировка подфорумов
		 * https://github.com/Xmk/lsplugin-forum/issues/26
		 */
		$aSubForums = array();
		if ($oForum->getChildren()) {
			$aChildrens = array();
			$aChildSort = array();
			foreach ($oForum->getChildren() as $oChildren) {
				$aChildrens[$oChildren->getId()] = $oChildren;
				$aChildSort[$oChildren->getId()] = $oChildren->getSort();
			}
			asort($aChildSort, SORT_NUMERIC);
			foreach ($aChildSort as $sId => $iSort) {
				$aSubForums[] = $aChildrens[$sId];
			}
		}
		/**
		 * JumpMenu
		 */
		$this->AssignJumpMenu();
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,Config::Get('plugin.forum.topic_per_page'),Config::Get('pagination.pages.count'),$oForum->getUrlFull());
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aPinned',$aPinned);
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('aSubForums',$aSubForums);
		$this->Viewer_Assign('oForum',$oForum);
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_show',array('oForum'=>$oForum));
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('forum');
	}


	/**
	 * Просмотр топика
	 *
	 */
	public function EventShowTopic() {
		$bLineMod=Config::Get('plugin.forum.topic_line_mod');
		$this->sMenuSubItemSelect='show_topic';
		/**
		 * Получаем ID топика из URL
		 */
		$sId=$this->GetParamEventMatch(0,1);
		/**
		 * Получаем топик по ID
		 */
		if (!($oTopic=$this->PluginForum_Forum_GetTopicById($sId))) {
			return parent::EventNotFound();
		}
		/**
		 * Получаем форум
		 */
		if (!($oForum=$oTopic->getForum())) {
			return parent::EventNotFound();
		}
		/**
		 * Права доступа
		 */
		$oForum=$this->PluginForum_Forum_BuildPerms($oForum);
		if (!$oForum->getAllowRead()) {
			return parent::EventNotFound();
		}
		/**
		 * Хлебные крошки
		 */
		//$this->_breadcrumbsCreate($oTopic,true);
		$this->_breadcrumbsCreate($oForum,false);
		/**
		 * Если установлен пароль
		 */
		if (!$this->PluginForum_Forum_isForumAuthorization($oForum)) {
			$this->EventForumLogin($oForum);
			return;
		}
		/**
		 * Получаем номер страницы
		 */
		$iPage=$this->GetParamEventMatch(1,2) ? $this->GetParamEventMatch(1,2) : 1;
		/**
		 * Получаем посты
		 */
		$aWhere=array();
		$iPerPage=Config::Get('plugin.forum.post_per_page');
		if ($bLineMod) {
			$oHeadPost=$this->PluginForum_Forum_GetPostById($oTopic->getFirstPostId());
			$oHeadPost->setNumber(1);
			$this->Viewer_Assign('oHeadPost',$oHeadPost);
			$aWhere=array_merge($aWhere,array('post_id > ?d'=>array($oHeadPost->getId())));
			$iPerPage--;
		}
		$aResult=$this->PluginForum_Forum_GetPostItemsByTopicId($oTopic->getId(),array('#where'=>$aWhere,'#page'=>array($iPage,$iPerPage)));
		$aPosts=$aResult['collection'];
		$iPostsCount=$aResult['count'];
		if ($bLineMod) $iPostsCount++;
		/**
		 * Номера постов
		 */
		for ($i=1; $i <= count($aPosts); $i++) {
			$oPost=$aPosts[$i-1];
			$iNumber=ceil(($iPage-1)*$iPerPage+$i);
			if ($bLineMod) $iNumber++;
			$oPost->setNumber($iNumber);
		}
		/**
		 * JumpMenu
		 */
		$this->AssignJumpMenu();
		/**
		 * Формируем постраничность
		 */
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,$iPerPage,Config::Get('pagination.pages.count'),$oTopic->getUrlFull());

		if ($this->User_IsAuthorization()) {
			/**
			 * Отмечаем дату прочтения топика
			 */

			/**
			 * Счетчик просмотров топика
			 */
			$this->PluginForum_Forum_UpdateTopicViews($oTopic);
			/**
			 * Check
			 */
			if ($oTopic->getCountPost() <> $iPostsCount) {
				$oTopic->setCountPost($iPostsCount);
				$oTopic->Save();
			}
		}
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('oForum',$oForum);
		$this->Viewer_Assign('oTopic',$oTopic);
		$this->Viewer_Assign('aPosts',$aPosts);
		$this->Viewer_Assign('iPostsCount',$iPostsCount);
		$this->Viewer_Assign('aPaging',$aPaging);
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_topic_show',array('oTopic'=>$oTopic));
		/**
		 * Задаем шаблон
		 */
		$this->SetTemplateAction('topic');
		/**
		 * Обработка модераторских действий
		 */
		if (isPost('submit_topic_mod')) {
			return $this->submitTopicActions($oTopic);
		}
		/**
		 * Обработка перемещения топика
		 */
		if (isPost('submit_topic_move')) {
			return $this->submitTopicMove($oTopic);
		}
		/**
		 * Обработка удаления топика
		 */
		if (isPost('submit_topic_delete')) {
			return $this->submitTopicDelete($oTopic);
		}
	}

	/**
	 * Обработка модераторских действий
	 */
	protected function submitTopicActions($oTopicF=null) {
		$this->Security_ValidateSendForm();
		/**
		 * Получаем топик по ID
		 */
		if (!($oTopic=$this->PluginForum_Forum_GetTopicById(getRequest('t')))) {
			return parent::EventNotFound();
		}
		/**
		 * Проверка доступа
		 */
		$oForum=$this->PluginForum_Forum_BuildPerms($oTopic->getForum());
		if (!(LS::Adm() || $oForum->isModerator())) {
			return false;
		}
		/**
		 * Список ключей действий по их коду
		 */
		$sKeyByCode=array(
			1=>'MOVE',
			2=>'DELETE',
			3=>'STATE',
			4=>'PIN'
		);
		/**
		 * Действие
		 */
		$iCode=(int)getRequest('code',0);
		if (!isset($sKeyByCode[$iCode])) {
			return parent::EventNotFound();
		}
		$sAction=strtolower($sKeyByCode[$iCode]);
		switch ($iCode) {
			/**
			 * Переместить топик
			 */
			case 1:
				/**
				 * Получаем список форумов
				 */
				$aForums=$this->PluginForum_Forum_LoadTreeOfForum(array('#order'=>array('forum_sort'=>'asc')));
				/**
				 * Дерево форумов
				 */
				$aForumsList=forum_create_list($aForums);
				/**
				 * Загружаем переменные в шаблон
				 */
				$this->Viewer_Assign('aForums',$aForums);
				$this->Viewer_Assign('aForumsList',$aForumsList);
				break;
			/**
			 * Удалить топик
			 */
			case 2:
				break;
			/**
			 * Открыть\закрыть топик
			 */
			case 3:
				/**
				 * Проверка доступа
				 */
				if (!$this->ACL_IsAllowClosedForumTopic($oTopic,$this->oUserCurrent)) {
					return parent::EventNotFound();
				}
				$oTopic->setState($oTopic->getState() ? PluginForum_ModuleForum::TOPIC_STATE_OPEN : PluginForum_ModuleForum::TOPIC_STATE_CLOSE);
				$oTopic->Save();
				return Router::Location($oTopic->getUrlFull());
			/**
			 * Закрепить\открепить топик
			 */
			case 4:
				/**
				 * Проверка доступа
				 */
				if (!$this->ACL_IsAllowPinnedForumTopic($oTopic,$this->oUserCurrent)) {
					return parent::EventNotFound();
				}
				$oTopic->setPinned($oTopic->getPinned() ? 0 : 1);
				$oTopic->Save();
				return Router::Location($oTopic->getUrlFull());
			default:
				return parent::EventNotFound();
		}
		/**
		 * Заголовки
		 */
		$this->Viewer_SetHtmlTitle('');
		$this->_addTitle($this->Lang_Get('plugin.forum.topic_'.$sAction).': '.$oTopic->getTitle());
		/**
		 * Задаем шаблон
		 */
		$this->SetTemplateAction($sAction.'_topic');
	}

	/**
	 * Переместить топик
	 */
	protected function submitTopicMove($oTopic) {
		$this->Security_ValidateSendForm();

		$oForumOld=$this->PluginForum_Forum_BuildPerms($oTopic->getForum());
		/**
		 * Проверка доступа
		 */
		if (!(LS::Adm() || ($oForumOld->isModerator() && $oForumOld->getModMoveTopic()))) {
			return;
		}
		if ($oForumNew=$this->PluginForum_Forum_GetForumById(getRequest('topic_move_id'))) {
			/**
			 * Если выбранный форум является удаляемым форум
			 */
			if ($oForumNew->getId()==$oForumOld->getId()) {
				$this->Message_AddError($this->Lang_Get('plugin.forum.topic_move_error_self'),$this->Lang_Get('error'));
				return;
			}
			/**
			 * Если выбранный форум является категорией
			 */
			if ($oForumNew->getCanPost()==1) {
				$this->Message_AddError($this->Lang_Get('plugin.forum.topic_move_error_category'),$this->Lang_Get('error'));
				return;
			}
			/**
			 * Обновляем свойства топика
			 */
			$oTopic->setForumId($oForumNew->getId());
			$oTopic->Save();
			/**
			 * Обновляем счетчики форумов
			 */
			$this->PluginForum_Forum_RecountForum($oForumOld);
			$this->PluginForum_Forum_RecountForum($oForumNew);
			Router::Location($oTopic->getUrlFull());
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
		}
	}

	/**
	 * Удалить топик
	 */
	protected function submitTopicDelete($oTopic) {
		$this->Security_ValidateSendForm();

		$oForum=$this->PluginForum_Forum_BuildPerms($oTopic->getForum());
		/**
		 * Проверка доступа
		 */
		if (!(LS::Adm() || ($oForum->isModerator() && $oForum->getModDeleteTopic()))) {
			return;
		}
		if ($this->PluginForum_Forum_DeleteTopic($oTopic)) {
			/**
			 * Обновляем свойства форума
			 */
			$this->PluginForum_Forum_RecountForum($oForum);
			Router::Location($oForum->getUrlFull());
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
		}
	}


	/**
	 * Добавление топика
	 *
	 */
	public function EventAddTopic() {
		$this->sMenuSubItemSelect='add';
		/**
		 * Проверяем авторизован ли пользователь
		 */
		if (!$this->User_IsAuthorization()) {
			return parent::EventNotFound();
		}
		$oForum=null;
		/**
		 * Получаем URL форума из эвента
		 */
		$sForumUrl=$this->sCurrentEvent;
		/**
		 * Создаем ли мы тему не из форума
		 */
		if ($sForumUrl != 'topic') {
			/**
			 * Получаем форум по URL
			 */
			if (!($oForum=$this->PluginForum_Forum_GetForumByUrl($sForumUrl))) {
				/**
				 * Возможно форум запросили по id
				 */
				if(!($oForum=$this->PluginForum_Forum_GetForumById($sForumUrl))) {
					return parent::EventNotFound();
				}
			}
			/**
			 * Права доступа
			 */
			$oForum=$this->PluginForum_Forum_BuildPerms($oForum);
			if (!$oForum->getAllowStart()) {
				return parent::EventNotFound();
			}
			/**
			 * Загружаем перемененные в шаблон
			 */
			$this->Viewer_Assign('oForum',$oForum);
			/**
			 * Хлебные крошки
			 */
			$this->_breadcrumbsCreate($oForum);
			/**
			 * Заголовки
			 */
			$this->_addTitle($this->Lang_Get('plugin.forum.new_topic_for').' '.$oForum->getTitle(),'after');
		} else {
			/**
			 * Получаем список форумов
			 */
			$aForums=$this->PluginForum_Forum_LoadTreeOfForum(array('#order'=>array('forum_sort'=>'asc')));
			/**
			 * Дерево форумов
			 */
			$aForumsTree=$this->PluginForum_Forum_buildTree($aForums);
			/**
			 * Загружаем переменные в шаблон
			 */
			$this->Viewer_Assign('aForumsTree',$aForumsTree);
			/**
			 * Заголовки
			 */
			$this->_addTitle($this->Lang_Get('plugin.forum.new_topic'),'after');
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_topic_add_show');
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('add_topic');
		/**
		 * Проверяем отправлена ли форма с данными(хотяб одна кнопка)
		 */
		if (isPost('submit_topic_publish')) {
			if (!$oForum) {
				/**
				 * Определяем в какой форум делаем запись
				 */
				$iForumId=getRequest('forum_id', 0);
				if ($iForumId > 0) {
					$oForum=$this->PluginForum_Forum_GetForumById($iForumId);
				}
			}
			return $this->submitTopicAdd($oForum);
		}
	}

	/**
	 * Обрабатываем форму добавления топика
	 */
	protected function submitTopicAdd($oForum) {
		if (is_null($oForum)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.new_topic_forum_error_unknown'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Проверяем разрешено ли создавать топики
		 */
		if (!$this->ACL_CanAddForumTopic($oForum,$this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.topic_acl'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Проверяем разрешено ли постить комменты по времени
		 */
		if (!$this->ACL_CanAddForumTopicTime($this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.topic_time_limit'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Создаем топик
		 */
		$oTopic=LS::Ent('PluginForum_Forum_Topic');
		/**
		 * Заполняем поля для валидации
		 */
		$oTopic->setForumId($oForum->getId());
		$oTopic->setUserId($this->oUserCurrent->getId());
		$oTopic->setUserIp(func_getIp());
		$oTopic->setTitle(rtrim(getRequest('topic_title'), '(^A-Za-z0-9!?)'));
		$oTopic->setDescription(getRequest('topic_description'));
		$oTopic->setDateAdd(date('Y-m-d H:i:s'));
		$oTopic->setState(PluginForum_ModuleForum::TOPIC_STATE_OPEN);
		if (isPost('topic_close')) {
			if ($this->ACL_IsAllowClosedForumTopic($oTopic,$this->oUserCurrent)) {
				$oTopic->setState(PluginForum_ModuleForum::TOPIC_STATE_CLOSE);
			}
		}
		$oTopic->setPinned(0);
		if (isPost('topic_pinned')) {
			if ($this->ACL_IsAllowPinnedForumTopic($oTopic,$this->oUserCurrent)) {
				$oTopic->setPinned(1);
			}
		}
		/**
		 * Проверка корректности полей формы
		 */
		if (!$this->checkTopicFields($oTopic)) {
			return false;
		}
		/**
		 * Первый пост
		 */
		$oPost=LS::Ent('PluginForum_Forum_Post');
		$oPost->_setValidateScenario('topic');
		/**
		 * Заполняем поля для валидации
		 */
		$oPost->setTitle($oTopic->getTitle());
		$oPost->setUserId($this->oUserCurrent->getId());
		$oPost->setUserIp(func_getIp());
		$oPost->setDateAdd(date('Y-m-d H:i:s'));
		$oPost->setText($this->PluginForum_Forum_TextParse(getRequest('post_text')));
		$oPost->setTextSource(getRequest('post_text'));
		$oPost->setNewTopic(1);
		/**
		 * Проверка корректности полей формы
		 */
		if (!$this->checkPostFields($oPost)) {
			return false;
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_topic_add_before', array('oTopic'=>$oTopic,'oPost'=>$oPost,'oForum'=>$oForum));
		/**
		 * Добавляем топик
		 */
		if ($oTopic->Add()) {
			/**
			 * Получаем топик, чтобы подцепить связанные данные
			 */
			$oTopic=$this->PluginForum_Forum_GetTopicById($oTopic->getId());
			$oPost->setTopicId($oTopic->getId());
			/**
			 * Добавляет первый пост
			 */
			if ($oPost->Add()) {
				$this->Hook_Run('forum_topic_add_after', array('oTopic'=>$oTopic,'oPost'=>$oPost,'oForum'=>$oForum));
				/**
				 * Получаем пост, чтоб подцепить связанные данные
				 */
				$oPost=$this->PluginForum_Forum_GetPostById($oPost->getId());
				/**
				 * Обновляем данные в топике
				 */
				$oTopic->setFirstPostId($oPost->getId());
				$oTopic->setLastPostId($oPost->getId());
				$oTopic->setCountPost((int)$oTopic->getCountPost()+1);
				$oTopic->Save();
				/**
				 * Обновляем данные в форуме
				 */
				$oForum->setLastPostId($oPost->getId());
				$oForum->setCountTopic((int)$oForum->getCountTopic()+1);
				$oForum->setCountPost((int)$oForum->getCountPost()+1);
				$oForum->Save();

				/**
				 * Список емайлов на которые не нужно отправлять уведомление
				 */
				$aExcludeMail=array();
				if ($this->oUserCurrent) {
					/**
					 * Исключаем автора топика из списки рассылки
					 */
					$aExcludeMail[]=$this->oUserCurrent->getMail();
					/**
					 * Добавляем автора топика в подписчики на новые ответы к этому топику
					 */
					$this->Subscribe_AddSubscribeSimple('topic_new_post',$oTopic->getId(),$this->oUserCurrent->getMail());
					/**
					 * Добавляем событие в ленту
					 */
					$this->Stream_write($oTopic->getUserId(), 'add_forum_topic', $oTopic->getId());
				}
				/**
				 * Отправка уведомления подписчикам форума
				 */
				$this->Subscribe_Send('forum_new_topic',$oForum->getId(),'notify.topic_new.tpl',$this->Lang_Get('plugin.forum.notify_subject_new_topic'),array(
					'oForum' => $oForum,
					'oTopic' => $oTopic,
					'oPost' => $oPost,
					'oUser' => $this->oUserCurrent,
				),$aExcludeMail,__CLASS__);

				Router::Location($oTopic->getUrlFull());
			} else {
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
				return Router::Action('error');
			}
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
			return Router::Action('error');
		}
	}


	/**
	 * Добавление поста
	 *
	 */
	public function EventAddPost() {
		$this->sMenuSubItemSelect='reply';
		/**
		 * Получаем ID топика из URL
		 */
		$sTopicId=$this->GetParam(0);
		/**
		 * Получаем топик по ID
		 */
		if (!($oTopic=$this->PluginForum_Forum_GetTopicById($sTopicId))) {
			return parent::EventNotFound();
		}
		/**
		 * Получаем форум
		 */
		if (!($oForum=$oTopic->getForum())) {
			return parent::EventNotFound();
		}
		/**
		 * Проверям права доступа
		 */
		$oForum=$this->PluginForum_Forum_BuildPerms($oForum);
		if (!$oForum->getAllowReply()) {
			return parent::EventNotFound();
		}
		/**
		 * Проверяем не закрыто ли обсуждение
		 */
		if ($oTopic->getState()==1 and !$this->ACL_CanAddForumPostClose($this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.reply_notallow'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_post_add_show');
		/**
		 * Загружаем перемененные в шаблон
		 */
		$this->Viewer_Assign('oForum',$oForum);
		$this->Viewer_Assign('oTopic',$oTopic);
		/**
		 * Хлебные крошки
		 */
		$this->_breadcrumbsCreate($oForum);
		/**
		 * Заголовки
		 */
		$this->_addTitle($this->Lang_Get('plugin.forum.reply_for',array('topic'=>$oTopic->getTitle())),'after');
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('add_post');
		/**
		 * Проверяем отправлена ли форма с данными(хотяб одна кнопка)
		 */
		if (isPost('submit_post_publish')) {
			return $this->submitPostAdd($oForum,$oTopic);
		}
	}

	/**
	 * Обработка формы добавление поста
	 */
	protected function submitPostAdd($oForum=null,$oTopic=null) {
		if (!($oForum && $oTopic)) {
			return false;
		}
		/**
		 * Проверяем разрешено ли постить
		 */
		if (!$this->ACL_CanAddForumPost($this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.reply_not_allow'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Проверяем разрешено ли постить по времени
		 */
		if (!$this->ACL_CanAddForumPostTime($this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.reply_time_limit'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Проверяем не закрыто ли обсуждение
		 */
		if ($oTopic->getState()==1 and !$this->ACL_CanAddForumPostClose($this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.reply_not_allow_close'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Создаём
		 */
		$oPost=LS::Ent('PluginForum_Forum_Post');
		$oPost->_setValidateScenario('post');
		/**
		 * Заполняем поля для валидации
		 */
		$oPost->setTitle(rtrim(getRequest('post_title'), '(^A-Za-z0-9!?)'));
		$oPost->setTopicId($oTopic->getId());
		$oPost->setUserIp(func_getIp());
		$oPost->setText($this->PluginForum_Forum_TextParse(getRequest('post_text')));
		$oPost->setTextSource(getRequest('post_text'));
		$oPost->setTextHash(md5(getRequest('post_text')));
		$oPost->setDateAdd(date('Y-m-d H:i:s'));
		if (!$this->User_IsAuthorization()) {
			$oPost->setUserId(0);
			$oPost->setGuestName(strip_tags(getRequest('guest_name')));
		} else {
			$oPost->setUserId($this->oUserCurrent->getId());
		}
		/**
		 * Проверяем поля формы
		 */
		if (!$this->checkPostFields($oPost)) {
			return false;
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_post_add_before',array('oPost'=>$oPost,'oTopic'=>$oTopic,'oForum'=>$oForum));
		/**
		 * Добавляем
		 */
		if ($oPost->Add()) {
			$this->Hook_Run('forum_post_add_after',array('oPost'=>$oPost,'oTopic'=>$oTopic,'oForum'=>$oForum));
			/**
			 * Обновляем инфу в топике
			 */
			$oTopic->setLastPostId($oPost->getId());
			$oTopic->setCountPost((int)$oTopic->getCountPost()+1);
			$oTopic->Save();
			/**
			 * Обновляем инфу в форуме
			 */
			$oForum->setLastPostId($oPost->getId());
			$oForum->setCountPost((int)$oForum->getCountPost()+1);
			$oForum->Save();

			/**
			 * Список емайлов на которые не нужно отправлять уведомление
			 */
			$aExcludeMail=array();
			if ($this->oUserCurrent) {
				/**
				 * Исключаем автора поста из списка рассылки
				 */
				$aExcludeMail[]=$this->oUserCurrent->getMail();
				/**
				 * Добавляем событие в ленту
				 */
				$this->Stream_write($oPost->getUserId(), 'add_forum_post', $oPost->getId());
			}
			/**
			 * Отправка уведомления подписчикам темы
			 */
			$this->Subscribe_Send('topic_new_post',$oTopic->getId(),'notify.post_new.tpl',$this->Lang_Get('plugin.forum.notify_subject_new_post'),array(
				'oForum' => $oForum,
				'oTopic' => $oTopic,
				'oPost' => $oPost,
				'oUser' => $this->oUserCurrent,
			),$aExcludeMail,__CLASS__);
			/**
			 * Отправка уведомления на отвеченные посты
			 */
			$this->PluginForum_Forum_SendNotifyReply($oPost,$aExcludeMail);

			Router::Location($oPost->getUrlFull());
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
			return Router::Action('error');
		}
	}


	/**
	 * Редактирование поста\топика
	 *
	 */
	public function EventEditPost() {
		/**
		 * Получаем ID поста из URL
		 */
		$sPostId=$this->GetParamEventMatch(1,1);
		/**
		 * Получаем пост по ID
		 */
		if(!($oPost=$this->PluginForum_Forum_GetPostById($sPostId))) {
			return parent::EventNotFound();
		}
		/**
		 * Relations
		 */
		$oTopic=$oPost->getTopic();
		$oForum=$oTopic->getForum();
		/**
		 * Редактируем ли мы топик
		 */
		$bEditTopic=($oTopic->getFirstPostId() == $oPost->getId());
		/**
		 * Проверяем, есть ли права редактировать данный топик\пост
		 */
		if ($bEditTopic) {
			if (!$this->ACL_IsAllowEditForumTopic($oTopic,$this->oUserCurrent)) {
				$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.topic_edit_not_allow'),$this->Lang_Get('error'));
				return Router::Action('error');
			}
		} else {
			if (!$this->ACL_IsAllowEditForumPost($oPost,$this->oUserCurrent)) {
				$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.post_edit_not_allow'),$this->Lang_Get('error'));
				return Router::Action('error');
			}
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_post_edit_show',array('oPost'=>$oPost));
		/**
		 * Загружаем перемененные в шаблон
		 */
		$this->Viewer_Assign('oForum',$oForum);
		$this->Viewer_Assign('oTopic',$oTopic);
		$this->Viewer_Assign('bEditTopic',$bEditTopic);
		/**
		 * Хлебные крошки
		 */
		$this->_breadcrumbsCreate($oForum);
		/**
		 * Заголовки
		 */
		if ($bEditTopic) {
			$this->_addTitle($this->Lang_Get('plugin.forum.topic_edit').' '.$oForum->getTitle(),'after');
		} else {
			$this->_addTitle($this->Lang_Get('plugin.forum.post_edit_for',array('topic'=>$oTopic->getTitle())),'after');
		}
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('edit_post');
		/**
		 * Была ли отправлена форма с данными
		 */
		if (isPost('submit_edit_post')) {
			return $this->submitPostEdit($oPost);
		} else {
			if ($bEditTopic) {
				$_REQUEST['forum_id']=$oTopic->getForumId();
				$_REQUEST['topic_title']=$oTopic->getTitle();
				$_REQUEST['topic_description']=$oTopic->getDescription();
				$_REQUEST['topic_pinned']=$oTopic->getPinned();
				$_REQUEST['topic_close']=$oTopic->getState();
			} else {
				$_REQUEST['post_title']=$oPost->getTitle();
			}
			$_REQUEST['post_text']=$oPost->getTextSource();
		}
	}

	/**
	 * Обработка формы редактирования поста
	 */
	protected function submitPostEdit($oPost) {
		if (!$oPost) {
			return false;
		}
		/**
		 * Relations
		 */
		$oTopic=$oPost->getTopic();
		/**
		 * Редактируем ли мы топик
		 */
		$bEditTopic=($oTopic->getFirstPostId() == $oPost->getId());
		/**
		 * Заполняем поля для валидации
		 */
		if ($bEditTopic) {
			$oTopic->setTitle(rtrim(getRequest('topic_title'), '(^A-Za-z0-9!?)'));
			$oTopic->setDescription(getRequest('topic_description'));
			$oTopic->setState(PluginForum_ModuleForum::TOPIC_STATE_OPEN);
			if (isPost('topic_close')) {
				if ($this->ACL_IsAllowClosedForumTopic($oTopic,$this->oUserCurrent)) {
					$oTopic->setState(PluginForum_ModuleForum::TOPIC_STATE_CLOSE);
				}
			}
			$oTopic->setPinned(0);
			if (isPost('topic_pinned')) {
				if ($this->ACL_IsAllowPinnedForumTopic($oTopic,$this->oUserCurrent)) {
					$oTopic->setPinned(1);
				}
			}
			$oTopic->setDateEdit(date('Y-m-d H:i:s'));

			$oPost->_setValidateScenario('topic');
			$oPost->setTitle($oTopic->getTitle());
		} else {
			$oPost->_setValidateScenario('post');
			$oPost->setTitle(rtrim(getRequest('post_title'), '(^A-Za-z0-9!?)'));
		}
		$oPost->setText($this->PluginForum_Forum_TextParse(getRequest('post_text')));
		$oPost->setTextSource(getRequest('post_text'));
		$oPost->setDateEdit(date('Y-m-d H:i:s'));
		$oPost->setEditorId($this->oUserCurrent->getId());
		$oPost->setEditReason(getRequest('post_edit_reason'));
		/**
		 * Проверка корректности полей формы
		 */
		if ($bEditTopic && !($this->checkTopicFields($oTopic) && $this->checkPostFields($oPost))) {
			return false;
		}
		if (!$bEditTopic && !$this->checkPostFields($oPost)) {
			return false;
		}
		/**
		 * Обновляем
		 */
		if ($bEditTopic) $oTopic->Save();
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_post_edit_before',array('oPost'=>$oPost));
		/**
		 * Сохраняем пост
		 */
		if ($oPost->Save()) {
			$this->Hook_Run('forum_post_edit_after',array('oPost'=>$oPost));
			Router::Location($oPost->getUrlFull());
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
			return Router::Action('error');
		}
	}


	/**
	 * Удаление поста
	 * TODO: Перевесить на ajax с возможностью быстрого восстановления
	 */
	public function EventDeletePost() {
		/**
		 * Получаем ID поста из URL
		 */
		$sPostId=$this->GetParamEventMatch(1,1);
		/**
		 * Получаем пост по ID
		 */
		if (!($oPost=$this->PluginForum_Forum_GetPostById($sPostId))) {
			return parent::EventNotFound();
		}
		/**
		 * Relations
		 */
		$oTopic=$oPost->getTopic();
		/**
		 * Возможно, мы собрались удалить первый пост?
		 */
		if ($oTopic->getFirstPostId() == $oPost->getId()) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.post_delete_not_allow'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
		/**
		 * Проверяем, есть ли права на редактирование
		 */
		if (!$this->ACL_IsAllowDeleteForumPost($oPost,$this->oUserCurrent)) {
			$this->Message_AddErrorSingle($this->Lang_Get('plugin.forum.post_delete_not_allow'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_post_delete_before',array('oPost'=>$oPost));
		/**
		 * Удаляем пост
		 */
		if ($this->PluginForum_Forum_DeletePosts($oPost)) {
			$this->Hook_Run('forum_post_delete_after',array('oPost'=>$oPost));
			/**
			 * Обновляем счетчик форума
			 */
			$this->PluginForum_Forum_RecountForum($oTopic->getForumId());
			Router::Location($oTopic->getUrlFull() . 'lastpost');
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return Router::Action('error');
		}
	}


	/**
	 * Последний пост в топике
	 *
	 */
	public function EventLastPost() {
		/**
		 * Получаем ID топика из URL
		 */
		$sId=$this->GetParamEventMatch(0,1);
		/**
		 * Получаем топик по ID
		 */
		if(!($oTopic=$this->PluginForum_Forum_GetTopicById($sId))) {
			return parent::EventNotFound();
		}
		/**
		 * Получаем последний пост
		 */
		if(!($oLastPost=$oTopic->getPost())) {
			return parent::EventNotFound();
		}
		/**
		 * Определяем на какой странице находится пост
		 */
		$sPage='';
		$iPostsCount=(int)$oTopic->getCountPost();
		$iPerPage=Config::Get('plugin.forum.post_per_page');
		if (Config::Get('plugin.forum.topic_line_mod')) {
			$iPostsCount--;
			$iPerPage--;
		}
		if ($iCountPage=ceil($iPostsCount/$iPerPage)) {
			if ($iCountPage > 1) {
				$sPage="page{$iCountPage}";
			}
		}
		/**
		 * Редирект
		 */
		Router::Location(Router::GetPath('forum')."topic/{$oTopic->getId()}/{$sPage}#post-{$oLastPost->getId()}");
	}

	/**
	 * Поиск поста
	 */
	public function EventFindPost() {
		/**
		 * Получаем ID топика из URL
		 */
		$sPostId=$this->GetParamEventMatch(0,1);
		/**
		 * Получаем пост по ID
		 */
		if(!($oPost=$this->PluginForum_Forum_GetPostById($sPostId))) {
			return parent::EventNotFound();
		}
		/**
		 * Получаем топик по ID
		 */
		if(!($oTopic=$oPost->getTopic())) {
			return parent::EventNotFound();
		}
		$aLeftPosts=$this->PluginForum_Forum_GetPostItemsByTopicId($oTopic->getId(),array('#where'=>array('post_id < ?'=>array($oPost->getId())),'#page'=>array(1,1)));
		/**
		 * Определяем на какой странице находится пост
		 */
		$sPage='';
		$iPostsCount=(int)$aLeftPosts['count']+1;
		$iPerPage=Config::Get('plugin.forum.post_per_page');
		if (Config::Get('plugin.forum.topic_line_mod')) {
			$iPostsCount--;
			$iPerPage--;
		}
		if ($iCountPage=ceil($iPostsCount/$iPerPage)) {
			if ($iCountPage > 1) {
				$sPage="page{$iCountPage}";
			}
		}
		/**
		 * Редирект
		 */
		Router::Location(Router::GetPath('forum')."topic/{$oTopic->getId()}/{$sPage}#post-{$oPost->getId()}");
	}


	/**
	 * Jump menu
	 */
	protected function AssignJumpMenu() {
		/**
		 * Получаем список id форумов, открытых для юзера
		 */
	//	$aForumsId=$this->PluginForum_Forum_GetForumsOpenUser(LS::CurUsr(),true);
		/**
		 * Получаем список форумов
		 */
		$aForums=$this->PluginForum_Forum_LoadTreeOfForum(
			array(
			//	'#where'=>array('forum_id IN (?a)'=>array($aForumsId)),
				'#order'=>array('forum_sort'=>'asc')
			)
		);
		/**
		 * Дерево форумов
		 */
		$aJumpList=forum_create_list($aForums);
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aJumpForums',$aForums);
		$this->Viewer_Assign('aJumpList',$aJumpList);
	}


	/**
	 * Обработка отправки формы добавления нового форума
	 */
	protected function submitAddForum() {
		$sNewType=(isPost('forum_type')) ? getRequest('forum_type') : 'forum';
		/**
		 * Заполняем свойства
		 */
		$oForum=LS::ENT('PluginForum_Forum');
		$oForum->setTitle(getRequest('forum_title'));
		$oForum->setUrl(preg_replace("/\s+/",'_',trim(getRequest('forum_url',''))));
		if ($sNewType=='category') {
			$oForum->setCanPost(1);
		} else {
			$oForum->setDescription(getRequest('forum_description'));
			$oForum->setParentId((int)getRequest('forum_parent'));
			$oForum->setType((int)getRequest('forum_type'));
			$oForum->setCanPost((int)getRequest('forum_sub_can_post') ? 1 : 0 );
			$oForum->setQuickReply((string)getRequest('forum_quick_reply') ? 1 : 0 );
			$oForum->setPassword(getRequest('forum_password',null));
			if (getRequest('forum_sort')) {
				$oForum->setSort((int)getRequest('forum_sort'));
			} else {
				$oForum->setSort((int)$this->PluginForum_Forum_GetMaxSortByPid($oForum->getParentId())+1);
			}
			$oForum->setRedirectUrl(getRequest('forum_redirect_url',null));
			if (isPost('forum_redirect_url')) {
				$oForum->setRedirectOn(getRequest('forum_redirect_on') ? 1 : 0 );
			}
			$oForum->setLimitRatingTopic((float)getRequest('forum_limit_rating_topic'));
		}
		/**
		 * Проверяем корректность полей
		 */
		if (!$this->checkForumFields($oForum)) {
			return ;
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_add_before',array('oForum'=>$oForum));
		/**
		 * Добавляем форум
		 */
		if ($oForum->Save()) {
			$this->Hook_Run('forum_add_after',array('oForum'=>$oForum));
			$this->Message_AddNotice($this->Lang_Get('plugin.forum.create_ok'),null,1);
		} else {
			$this->Message_AddError($this->Lang_Get('system_error'),null,1);
		}

		Router::Location(Router::GetPath('forum').'admin/forums/');
	}

	/**
	 * Обработка отправки формы при редактировании форума
	 *
	 * @param unknown_type $oForum
	 */
	protected function submitEditForum($oForum=null) {
		if ($oForum->getId()==getRequest('forum_parent')) {
			$this->Message_AddError($this->Lang_Get('system_error'));
			return;
		}
		$sNewType=(isPost('forum_type')) ? getRequest('forum_type') : 'forum';
		/**
		 * Обновляем свойства форума
		 */
		$oForum->setTitle(getRequest('forum_title'));
		$oForum->setUrl(preg_replace("/\s+/",'_',trim(getRequest('forum_url',''))));
		if ($sNewType=='category') {
			$oForum->setCanPost(1);
		} else {
			$oForum->setDescription(getRequest('forum_description'));
			$oForum->setParentId((int)getRequest('forum_parent'));
			$oForum->setType((int)getRequest('forum_type'));
			$oForum->setCanPost( (int)getRequest('forum_sub_can_post',0,'post') === 1 );
			$oForum->setQuickReply( (int)getRequest('forum_quick_reply',0,'post') === 1 );
			$oForum->setPassword(getRequest('forum_password',null));
			$oForum->setSort((int)getRequest('forum_sort'));
			$oForum->setRedirectUrl(getRequest('forum_redirect_url',null));
			if (isPost('forum_redirect_url')) {
				$oForum->setRedirectOn( (int)getRequest('forum_redirect_on',0,'post') === 1 );
			}
			$oForum->setLimitRatingTopic((float)getRequest('forum_limit_rating_topic'));
		}
		/**
		 * Проверяем корректность полей
		 */
		if (!$this->checkForumFields($oForum)) {
			return;
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_edit_before',array('oForum'=>$oForum));
		/**
		 * Сохраняем форум
		 */
		if ($oForum->Save()) {
			$this->Hook_Run('forum_edit_after',array('oForum'=>$oForum));
			$this->Message_AddNotice($this->Lang_Get('plugin.forum.edit_ok'),null,1);
		} else {
			$this->Message_AddError($this->Lang_Get('system_error'),null,1);
		}

		Router::Location(Router::GetPath('forum').'admin/forums/');
	}


	/**
	 * Главная страница админцентра
	 */
	protected function _adminMain() {
		$this->sMenuSubItemSelect='main';
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('admin/index');
	}

	/**
	 * Управление форумами
	 */
	protected function _adminForums() {
		/**
		 * Получаем список форумов
		 */
		$aForums=$this->PluginForum_Forum_LoadTreeOfForum(array('#order'=>array('forum_sort'=>'asc')));
		$aForumsList=array();
		$aForumsTree=array();
		if ($aForums) {
			/**
			 * Дерево форумов
			 */
			$aForumsList=forum_create_list($aForums);
			$aForumsTree=$this->PluginForum_Forum_buildTree($aForums);
		}
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aForums',$aForums);
		$this->Viewer_Assign('aForumsList',$aForumsList);
		$this->Viewer_Assign('aForumsTree',$aForumsTree);
		/**
		 * Загружаем в шаблон JS текстовки
		 */
		 $this->Lang_AddLangJs(array('plugin.forum.delete_confirm'));
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('admin/forums_list');
	}

	/**
	 * Создание\редактирование форума
	 */
	protected function _adminForumForm($sType='edit') {
		/**
		 * Получаем список форумов
		 */
		$aForums=$this->PluginForum_Forum_LoadTreeOfForum(array('#order'=>array('forum_sort'=>'asc')));
		/**
		 * Дерево форумов
		 */
		$aForumsList=forum_create_list($aForums);
		/*
		 * Определяем тип создаваемого\редактируемого объекта (форум\категория)
		 */
		$sNewType=getRequest('type',null) ? getRequest('type') : 'forum';
		/**
		 * Обрабатываем редактирование форума
		 */
		if ($sType=='edit') {
			if ($oForumEdit=$this->PluginForum_Forum_GetForumById($this->GetParam(2))) {
				if (isPost('submit_forum_save')) {
					$this->submitEditForum($oForumEdit);
				} else {
					$_REQUEST['forum_title']=$oForumEdit->getTitle();
					$_REQUEST['forum_url']=$oForumEdit->getUrl();
					$_REQUEST['forum_description']=$oForumEdit->getDescription();
					$_REQUEST['forum_type']=$oForumEdit->getType();
					$_REQUEST['forum_parent']=$oForumEdit->getParentId();
					$_REQUEST['forum_sub_can_post']=$oForumEdit->getCanPost();
					$_REQUEST['forum_redirect_url']=$oForumEdit->getRedirectUrl();
					$_REQUEST['forum_redirect_on']=$oForumEdit->getRedirectOn();
					$_REQUEST['forum_sort']=$oForumEdit->getSort();
					$_REQUEST['forum_quick_reply']=$oForumEdit->getQuickReply();
					$_REQUEST['forum_password']=$oForumEdit->getPassword();
					$_REQUEST['forum_limit_rating_topic']=$oForumEdit->getLimitRatingTopic();

					$sNewType=($oForumEdit->getParentId()==0) ? 'category' : 'forum';
				}
			} else {
				return parent::EventNotFound();
			}
		} else {
			/**
			 * Обрабатываем создание форума
			 */
			if (isPost('submit_forum_add')) {
				$this->submitAddForum();
			}
		}
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_form',array('sShowType'=>$sType,'sType'=>$sNewType));
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aForums',$aForums);
		$this->Viewer_Assign('aForumsList',$aForumsList);
		$this->Viewer_Assign('sNewType',$sNewType);
		$this->Viewer_Assign('sType',$sType);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('admin/forum_form');
	}

	/**
	 * Удаление форума
	 */
	protected function _adminForumDelete() {
		$sForumId=$this->GetParam(2);
		if (!$oForumDelete=$this->PluginForum_Forum_GetForumById($sForumId)) {
			return parent::EventNotFound();
		}
		/**
		 * Получаем список форумов
		 */
		$aForums=$this->PluginForum_Forum_LoadTreeOfForum(array('#order'=>array('forum_sort'=>'asc')));
		/**
		 * Дерево форумов
		 */
		$aForumsList=forum_create_list($aForums);
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('oForum',$oForumDelete);
		$this->Viewer_Assign('aForums',$aForums);
		$this->Viewer_Assign('aForumsList',$aForumsList);
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_delete_show');
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('admin/forum_delete');
		/**
		 * Обрабатываем создание форума
		 */
		if (isPost('submit_forum_delete')) {
			/**
			 * Получаем топики форума
			 */
			$aTopics=$this->PluginForum_Forum_GetTopicItemsByForumId($sForumId);
			/**
			 * Получаем подфорумы
			 */
			$aSubForums=$oForumDelete->getChildren();
			/**
			 * Получаем всех потомков форума
			 */
			$aDescendantsIds=array();
			$aDescendants=$this->PluginForum_Forum_GetDescendantsOfForum($oForumDelete);
			foreach ($aDescendants as $oDescendant) {
				$aDescendantsIds[]=$oDescendant->getId();
			}
			/**
			 * Если указан идентификатор форума для перемещения, то делаем попытку переместить топики.
			 *
			 * (-1) - выбран пункт меню "удалить топики".
			 */
			if ($sForumIdNew=getRequest('forum_move_id_topics') and ($sForumIdNew!=-1) and is_array($aTopics) and count($aTopics)) {
				if (!$oForumNew=$this->PluginForum_Forum_GetForumById($sForumIdNew)){
					$this->Message_AddError($this->Lang_Get('plugin.forum.delete_move_error'),$this->Lang_Get('error'));
					return;
				}
				/**
				 * Если выбранный форум является удаляемым форум
				 */
				if ($sForumIdNew==$sForumId) {
					$this->Message_AddError($this->Lang_Get('plugin.forum.delete_move_items_error_self'),$this->Lang_Get('error'));
					return;
				}
				/**
				 * Если выбранный форум является одним из подфорумов удаляемого форум
				 */
				if (in_array($sForumIdNew,$aDescendantsIds)) {
					$this->Message_AddError($this->Lang_Get('plugin.forum.delete_move_items_error_descendants'),$this->Lang_Get('error'));
					return;
				}
				/**
				 * Если выбранный форум является категорией, возвращаем ошибку
				 */
				if ($oForumNew->getCanPost()) {
					$this->Message_AddError($this->Lang_Get('plugin.forum.delete_move_items_error_category'),$this->Lang_Get('error'));
					return;
				}
			}
			/**
			 * Если указан идентификатор форума для перемещения, то делаем попытку переместить подфорумы.
			 */
			if ($sForumIdNew=getRequest('forum_delete_move_childrens') and is_array($aSubForums) and count($aSubForums)) {
				if(!$oForumNew=$this->PluginForum_Forum_GetForumById($sForumIdNew)){
					$this->Message_AddError($this->Lang_Get('plugin.forum.delete_move_error'),$this->Lang_Get('error'));
					return;
				}
				/**
				 * Если выбранный форум является удаляемым форум
				 */
				if ($sForumIdNew==$sForumId) {
					$this->Message_AddError($this->Lang_Get('plugin.forum.delete_move_childrens_error_self'),$this->Lang_Get('error'));
					return;
				}
				/**
				 * Если выбранный форум является одним из подфорумов удаляемого форум
				 */
				if (in_array($sForumIdNew,$aDescendantsIds)) {
					$this->Message_AddError($this->Lang_Get('plugin.forum.delete_move_childrens_error_descendants'),$this->Lang_Get('error'));
					return;
				}
			}
			/**
			 * Перемещаем топики
			 */
			if ($sForumIdNew=getRequest('forum_move_id_topics') and ($sForumIdNew!=-1) and is_array($aTopics) and count($aTopics)) {
				$this->PluginForum_Forum_MoveTopics($sForumId,$sForumIdNew);
			}
			/**
			 * Перемещаем подфорумы
			 */
			if ($sForumIdNew=getRequest('forum_delete_move_childrens') and is_array($aSubForums) and count($aSubForums)) {
				$this->PluginForum_Forum_MoveForums($sForumId,$sForumIdNew);
			}
			/**
			 * Вызов хуков
			 */
			$this->Hook_Run('forum_delete_before',array('oForum'=>$oForumDelete));
			/**
			 * Удаляем форум и перенаправляем админа к списку форумов
			 */
			if($this->PluginForum_Forum_DeleteForum($oForumDelete)) {
				$this->Hook_Run('forum_delete_after',array('oForum'=>$oForumDelete));
				$this->Message_AddNoticeSingle($this->Lang_Get('plugin.forum.delete_success'),$this->Lang_Get('attention'),true);
				Router::Location(Router::GetPath('forum').'admin/forums/');
			} else {
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
				//Router::Location(Router::GetPath('forum').'admin/forums/');
			}
		}
	}

	/**
	 * Изменение сортировки форума
	 */
	protected function _adminForumSort() {
		$sForumId=$this->GetParam(2);
		if (!$oForum=$this->PluginForum_Forum_GetForumById($sForumId)) {
			return parent::EventNotFound();
		}

		$this->Security_ValidateSendForm();

		$sWay=$this->GetParam(3)=='down' ? 'down' : 'up';
		$iSortOld=$oForum->getSort();
		if ($oForumPrev=$this->PluginForum_Forum_GetNextForumBySort($iSortOld,$oForum->getParentId(),$sWay)) {
			$iSortNew=$oForumPrev->getSort();
			$oForumPrev->setSort($iSortOld);
			$oForumPrev->Save();
		} else {
			if ($sWay=='down') {
				$iSortNew=$iSortOld+1;
			} else {
				$iSortNew=$iSortOld-1;
			}
		}
		/**
		 * Меняем значения сортировки местами
		 */
		$oForum->setSort($iSortNew);
		$oForum->Save();

		$this->Message_AddNotice($this->Lang_Get('plugin.forum.sort_submit_ok'));
		Router::Location(Router::GetPath('forum').'admin/forums/');
	}

	/**
	 * Изменение прав доступа
	 */
	protected function _adminForumPerms() {
		$sForumId=$this->GetParam(2);
		if (!$oForum=$this->PluginForum_Forum_GetForumById($sForumId)) {
			return parent::EventNotFound();
		}
		$aPerms=$this->PluginForum_Forum_GetPermItemsAll();
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aPerms',$aPerms);
		$this->Viewer_Assign('oForum',$oForum);
		/**
		 * Вызов хуков
		 */
		$this->Hook_Run('forum_perms_show',array('oForum'=>$oForum));
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('admin/forum_perms');
		/**
		 * Была ли отправлена форма с данными
		 */
		if (isPost('submit_forum_perms')) {
			$aPermissions=array(
				'show_perms'=>getRequest('show',array(),'post'),
				'read_perms'=>getRequest('read',array(),'post'),
				'reply_perms'=>getRequest('reply',array(),'post'),
				'start_perms'=>getRequest('start',array(),'post')
			);
			$oForum->setPermissions(addslashes(serialize($aPermissions)));
			/**
			 * Сохраняем форум
			 */
			if ($oForum->Save()) {
				$this->Message_AddNotice($this->Lang_Get('plugin.forum.perms_submit_ok'),null,1);
				Router::Location(Router::GetPath('forum').'admin/forums/');
			} else {
				$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
				return;
			}
		} else {
			$aPermissions=unserialize(stripslashes($oForum->getPermissions()));
			$_REQUEST['show']=isset($aPermissions['show_perms']) ? $aPermissions['show_perms'] : array();
			$_REQUEST['read']=isset($aPermissions['read_perms']) ? $aPermissions['read_perms'] : array();
			$_REQUEST['reply']=isset($aPermissions['reply_perms']) ? $aPermissions['reply_perms'] : array();
			$_REQUEST['start']=isset($aPermissions['start_perms']) ? $aPermissions['start_perms'] : array();
		}
	}


	/**
	 * Права доступа
	 */
	protected function _adminPerms() {
		$this->sMenuSubItemSelect='perms';
		/**
		 * Получаем список масок
		 */
		$aPerms=$this->PluginForum_Forum_GetPermItemsAll();
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aPerms',$aPerms);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('admin/perms');
	}

	/**
	 * Админка
	 */
	public function EventAdmin() {
		if (!LS::Adm()) {
			return parent::EventNotFound();
		}

		$this->sMenuItemSelect='admin';
		$this->_addTitle($this->Lang_Get('plugin.forum.acp'));

		/**
		 * Подключаем JS
		 */
		$this->Viewer_AppendScript($this->getTemplatePathPlugin().'js/forum.admin.js');

		$sCategory=$this->GetParam(0);
		$sAction=$this->GetParam(1);

		/**
		 * Раздел админки
		 */
		switch ($sCategory) {
			/**
			 * Управление форумами
			 */
			case 'forums':
				/**
				 * Раздел
				 */
				switch ($sAction) {
					/**
					 * Новый форум
					 */
					case 'new':
						$this->_adminForumForm('new');
						break;
					/**
					 * Редактирование форума
					 */
					case 'edit':
						$this->_adminForumForm('edit');
						break;
					/**
					 * Удаление форума
					 */
					case 'delete':
						$this->_adminForumDelete();
						break;
					/**
					 * Изменение сортировки
					 */
					case 'sort':
						$this->_adminForumSort();
						break;
					/**
					 * Права доступа
					 */
					case 'perms':
						$this->_adminForumPerms();
						break;
					/**
					 * Список форумов
					 */
					case null:
						$this->_adminForums();
						break;
					default:
						return parent::EventNotFound();
				}
				$this->sMenuSubItemSelect='forums';
				break;
			/**
			 * Права доступа
			 */
			case 'perms':
				$this->_adminPerms();
				break;
			/**
			 * Главная
			 */
			case null:
				$this->_adminMain();
				break;
			default:
				return parent::EventNotFound();
		}
	}


	/**
	 * Проверка полей формы создания форума
	 */
	private function checkForumFields($oForum) {
		$this->Security_ValidateSendForm();

		$bOk=true;
		/**
		 * Валидация данных
		 */
		if (!$oForum->_Validate()) {
			$this->Message_AddError($oForum->_getValidateError(),$this->Lang_Get('error'));
			$bOk=false;
		}
		/**
		 * Выполнение хуков
		 */
		$this->Hook_Run('forum_check_forum_fields',array('bOk'=>&$bOk));

		return $bOk;
	}

	/**
	 * Проверка полей формы создания топика
	 */
	private function checkTopicFields($oTopic) {
		$this->Security_ValidateSendForm();

		$bOk=true;
		/**
		 * Валидация данных
		 */
		if (!$oTopic->_Validate()) {
			$this->Message_AddError($oTopic->_getValidateError(),$this->Lang_Get('error'));
			$bOk=false;
		}
		/**
		 * Выполнение хуков
		 */
		$this->Hook_Run('forum_check_topic_fields', array('bOk'=>&$bOk));

		return $bOk;
	}

	/**
	 * Проверка полей формы создания поста
	 */
	private function checkPostFields($oPost) {
		$this->Security_ValidateSendForm();

		$bOk=true;

		/**
		 * Валидация данных
		 */
		if (!$oPost->_Validate()) {
			$this->Message_AddError($oPost->_getValidateError(),$this->Lang_Get('error'));
			$bOk=false;
		}
		if (!$this->User_IsAuthorization()) {
			if (!$this->Validate_Validate('captcha',getRequest('guest_captcha'))) {
				$this->Message_AddError($this->Validate_GetErrorLast(),$this->Lang_Get('error'));
				$bOk=false;
			}
		}
		/**
		 * Выполнение хуков
		 */
		$this->Hook_Run('forum_check_post_fields', array('bOk'=>&$bOk));

		return $bOk;
	}


	/**
	 * Хлебные крошки
	 */
	private function _breadcrumbsCreate() {
		$aArgs=func_get_args();
		if (is_object($aArgs[0])) {
			if (!isset($aArgs[1]) || $aArgs[1]) {
				$this->aBreadcrumbs=array();
			}
			$oItem=$aArgs[0];
			$this->aBreadcrumbs[]=array(
				'title'=>$oItem->getTitle(),
				'url'=>$oItem->getUrlFull(),
				'obj'=>$oItem
			);
			if ($oItem->getParentId() && $oParent=$oItem->getParent()) {
				$this->_breadcrumbsCreate($oParent,false);
			}
		} else {
			if (!isset($aArgs[2]) || $aArgs[2]) {
				$this->aBreadcrumbs=array();
			}
			$this->aBreadcrumbs[]=array(
				'title'=>(string)$aArgs[0],
				'url'=>(string)$aArgs[1]
			);
		}
	}


	/**
	 * Заголовки
	 */
	 private function _addTitle($sTitle=null,$sAction='before') {
		if (!(in_array($sAction,array('before','after')))) {
			$sAction='before';
		}
		if ($sTitle)
		$this->aTitles[$sAction][]=$sTitle;
	}


	/**
	 * Завершение работы экшена
	 */
	public function EventShutdown() {
		/**
		 * Titles. Before breadcrumbs
		 */
		foreach ($this->aTitles['before'] as $sTitle) {
			$this->Viewer_AddHtmlTitle($sTitle);
		}
		/**
		 * Breadcrumbs
		 */
		if (!empty($this->aBreadcrumbs)) {
			$this->aBreadcrumbs=array_reverse($this->aBreadcrumbs);
			foreach ($this->aBreadcrumbs as $aItem) {
				$this->Viewer_AddHtmlTitle($aItem['title']);
			}
		}
		/**
		 * Titles. After breadcrumbs
		 */
		foreach ($this->aTitles['after'] as $sTitle) {
			$this->Viewer_AddHtmlTitle($sTitle);
		}
		/**
		 * Загружаем в шаблон необходимые переменные
		 */
        $this->Viewer_Assign('menu','forum');
		$this->Viewer_Assign('aBreadcrumbs',$this->aBreadcrumbs);
		$this->Viewer_Assign('sMenuHeadItemSelect',$this->sMenuHeadItemSelect);
		$this->Viewer_Assign('sMenuItemSelect',$this->sMenuItemSelect);
		$this->Viewer_Assign('sMenuSubItemSelect',$this->sMenuSubItemSelect);
		$this->Viewer_Assign('sTemplatePathPlugin',rtrim($this->getTemplatePathPlugin(),'/'));
		/**
		 * Загружаем в шаблон JS текстовки
		 */
		$this->Lang_AddLangJs(
			array(
				'plugin.forum.post_anchor_promt',
				'plugin.forum.moderator_del_confirm'
			)
		);
	}
}

?>