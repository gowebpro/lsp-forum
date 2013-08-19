<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Forum.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum extends ModuleORM {
	/**
	 * Состояния тем
	 */
	const TOPIC_STATE_OPEN		= 0;
	const TOPIC_STATE_CLOSE		= 1;
	const TOPIC_STATE_MOVED		= 2;
	/**
	 * Типы форума
	 */
	const FORUM_TYPE_ARCHIVE	= 0;
	const FORUM_TYPE_ACTIVE		= 1;
	/**
	 * Глобальные маски
	 */
	const MASK_PERM_GUEST		= 1;
	const MASK_PERM_USER		= 2;
	const MASK_PERM_ADMIN		= 3;
	/**
	 * Префикс подфорумов для дерева
	 */
	const DEPTH_GUIDE			= '--';
	/**
	 * Маркеры
	 */
	const MARKER_FORUM			= 'F';
	const MARKER_TOPIC			= 'T';
	const MARKER_TOPIC_FORUM	= 'TF';
	const MARKER_USER			= 'L';
	/**
	 * Дополнительные данные форумов
	 */
	const FORUM_DATA_INDEX		= 'marker,calculate,perms';
	const FORUM_DATA_FORUM		= 'marker,calculate,perms,moder';
	const FORUM_DATA_TOPIC		= 'marker,perms,moder';
	const FORUM_DATA_RSS		= 'perms';
	/**
	 * Объект текущего пользователя
	 */
	protected $oUserCurrent=null;
	/**
	 * Объект маппера форума
	 */
	protected $oMapperForum=null;

	/**
	 * Инициализация модуля
	 */
	public function Init() {
		parent::Init();
		/**
		 * Получаем текущего пользователя
		 */
		$this->oUserCurrent=$this->User_GetUserCurrent();
		/**
		 * Получаем объект маппера
		 */
		$this->oMapperForum=Engine::GetMapper(__CLASS__);
	}

	/**
	 * Перемещает сообщения в другую тему
	 *
	 * @param	array	$aPostsId
	 * @param	integer	$sTopicId
	 * @return	bool
	 */
	public function MovePosts($aPostsId,$sTopicId) {
		if (!is_array($aPostsId)) {
			$aPostsId=array($aPostsId);
		}
		if ($res=$this->oMapperForum->MovePosts($aPostsId,$sTopicId)) {
			//чистим кеш
			$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('PluginForum_ModuleForum_EntityPost_save'));
			return $res;
		}
		return false;
	}

	/**
	 * Перемещает топики в другой форум
	 *
	 * @param	integer	$sForumId
	 * @param	integer	$sForumIdNew
	 * @return	bool
	 */
	public function MoveTopics($sForumId,$sForumIdNew) {
		if ($res=$this->oMapperForum->MoveTopics($sForumId,$sForumIdNew)) {
			//чистим кеш
			$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('PluginForum_ModuleForum_EntityTopic_save'));
			return $res;
		}
		return false;
	}

	/**
	 * Перемещает подфорумы в другой форум
	 *
	 * @param	integer	$sForumId
	 * @param	integer	$sForumIdNew
	 * @return	bool
	 */
	public function MoveForums($sForumId,$sForumIdNew) {
		if ($res=$this->oMapperForum->MoveForums($sForumId,$sForumIdNew)) {
			//чистим кеш
			$this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('PluginForum_ModuleForum_EntityForum_save'));
			return $res;
		}
		return false;
	}

	/**
	 * Получает слудующий по сортировке форум
	 *
	 * @param	integer	$iSort
	 * @param	integer	$sPid
	 * @param	string	$sWay
	 * @return	object
	 */
	public function GetNextForumBySort($iSort,$sPid,$sWay='up') {
		$sForumId=$this->oMapperForum->GetNextForumBySort($iSort,$sPid,$sWay);
		return $this->GetForumById($sForumId);
	}

	/**
	 * Получает значение максимальной сортировки
	 *
	 * @param	integer	$sPid
	 * @return	integer
	 */
	public function GetMaxSortByPid($sPid) {
		return $this->oMapperForum->GetMaxSortByPid($sPid);
	}

	/**
	 * Получает статистику форума
	 *
	* @return	array
	 */
	public function GetForumStats() {
		$aStats=array();
		/**
		 * Посетители
		 */
		if (class_exists('PluginAcewidgetmanager_ModuleVisitors') && Config::Get('plugin.forum.stats.online')) {
			$aStats['online']=array();
			$nCountVisitors=$this->PluginAcewidgetmanager_Visitors_GetVisitorsCount(300);
			$nCountGuest=$nCountVisitors;
			$nCountUsers=0;
			if ($aUsersLast=$this->User_GetUsersByDateLast(Config::Get('plugin.forum.stats.users_count'))) {
				$aStats['online']['users']=array();
				foreach ($aUsersLast as $oUser) {
					if ($oUser->isOnline()) {
						$aStats['online']['users'][]=$oUser;
						$nCountUsers++;
						$nCountGuest--;
					}
				}
				shuffle($aStats['online']['users']);
			}
			if ($nCountUsers > $nCountVisitors) $nCountVisitors=$nCountUsers;
			$aStats['online']['count_visitors']=$nCountVisitors;
			$aStats['online']['count_users']=$nCountUsers;
			$aStats['online']['count_quest']=$nCountGuest;
		}
		/**
		 * Дни рождения
		 * TODO:
		 * Написать запрос, возвращающих пользователей, дата рождения которых
		 * совпадает с текущей...
		 */
		if (Config::Get('plugin.forum.stats.bdays')) {
			if ($aUsers=$this->User_GetUsersByFilter(array('activate'=>1),array(),1,999)) {
				$aStats['bdays']=array();

				foreach ($aUsers['collection'] as $oUser) {
					if ($sProfileBirthday=$oUser->getProfileBirthday()) {
						if (date('m-d')==date('m-d',strtotime($sProfileBirthday))) {
							$aStats['bdays'][]=$oUser;
						}
					}
				}
			}
		}
		/**
		 * Получаем количество всех постов
		 */
		$aStats['count_all_posts']=$this->oMapperForum->GetCountPosts();
		/**
		 * Получаем количество всех топиков
		 */
		$aStats['count_all_topics']=$this->oMapperForum->GetCountTopics();
		/**
		 * Получаем количество всех юзеров
		 */
		$aStats['count_all_users']=$this->oMapperForum->GetCountUsers();
		/**
		 * Получаем последнего зарегистрировавшегося
		 */
		if (Config::Get('plugin.forum.stats.last_user')) {
			$aLastUsers=$this->User_GetUsersByDateRegister(1);
			$aStats['last_user']=end($aLastUsers);
		}

		return $aStats;
	}

	/**
	 * Считает инфу по количеству постов и топиков в подфорумах
	 *
	 * @param	object	$oForum
	 * @return	object
	 */
	public function CalcChildren($oForum,$bPerm=1,$bNoModer=1,$bMark=0) {
		if ($bMark) {
			$aMark=$this->GetMarking();
			$sUserMark=(isset($aMark[self::MARKER_USER])) ? $aMark[self::MARKER_USER] : null;
			$sMarkDate=(isset($aMark[self::MARKER_FORUM][$oForum->getId()])) ? $aMark[self::MARKER_FORUM][$oForum->getId()] : $sUserMark;
			if ($sMarkDate && strtotime($sMarkDate) >= strtotime($oForum->getLastPostDate())) {
				$oForum->setRead(true);
			}
		}
		$aChildren=$oForum->getChildren();
		if (!empty($aChildren)) {
			foreach ($aChildren as $oChildren) {
				$oChildren=$this->CalcChildren($oChildren,$bPerm,$bNoModer,$bMark);
				if (!$oChildren->getRead()) {
					$oForum->setRead(false);
				}
				if ($oChildren->getLastPostId() > $oForum->getLastPostId()) {
					$oForum->setLastPostId($oChildren->getLastPostId());
				}
				$oForum->setCountTopic($oForum->getCountTopic() + $oChildren->getCountTopic());
				$oForum->setCountPost($oForum->getCountPost() + $oChildren->getCountPost());
			}
		}
		return $bPerm ? $this->BuildPerms($oForum,$bNoModer) : $oForum;
	}

	/**
	 * Удаляет посты по массиву объектов
	 *
	 * @param	array	$aPosts
	 * @return	boolean
	 */
	public function DeletePosts($aPosts) {
		if (!is_array($aPosts)) {
			$aPosts = array($aPosts);
		}
		$aTopics=array();

		foreach ($aPosts as $oPost) {
			$aTopics[$oPost->getTopicId()] = 1;
			$oPost->Delete();
		}
		foreach (array_keys($aTopics) as $sTopicId) {
			$this->RecountTopic($sTopicId);
		}
		return true;
	}

	/**
	 * Пересчет счетчиков форума
	 *
	 * @param	object	$oForum
	 * @return	object
	 */
	public function RecountForum($oForum) {
		if (!($oForum instanceof Entity)) {
			$oForum = $this->GetForumById($oForum);
		}

		$iCountTopic=$this->oMapperForum->GetCountTopicByForumId($oForum->getId());
		$iCountPost=$this->oMapperForum->GetCountPostByForumId($oForum->getId());
		$iLastPostId=$this->oMapperForum->GetLastPostByForumId($oForum->getId());
		$sLastPostDate=$this->oMapperForum->GetPostDateById($iLastPostId);

		$oForum->setCountTopic((int)$iCountTopic);
		$oForum->setCountPost((int)$iCountPost);
		$oForum->setLastPostId((int)$iLastPostId);
		$oForum->setLastPostDate($sLastPostDate);

		return $oForum->Save();
	}

	/**
	 * Пересчет счетчиков топика
	 *
	 * @param	object	$oForum
	 * @return	object
	 */
	public function RecountTopic($oTopic) {
		if (!($oTopic instanceof Entity)) {
			$oTopic = $this->GetTopicById($oTopic);
		}

		$iCountPost=$this->oMapperForum->GetCountPostByTopicId($oTopic->getId());
		$iLastPostId=$this->oMapperForum->GetLastPostByTopicId($oTopic->getId());
		$sLastPostDate=$this->oMapperForum->GetPostDateById($iLastPostId);

		$oTopic->setCountPost((int)$iCountPost);
		$oTopic->setLastPostId((int)$iLastPostId);
		$oTopic->setLastPostDate($sLastPostDate);
		return $oTopic->Save();
	}

	/**
	 * Формируем права доступа
	 *
	 * @param	object	$oForum
	 * @return	object
	 */
	public function BuildPerms($oForum,$bNoModers=false) {
		$oUser = $this->User_GetUserCurrent();
		$oParent = $oForum->getParentId() ? $this->BuildPerms($oForum->getParent(),true) : null;
		/**
		 * Права модератора
		 */
		if (!$bNoModers) {
			$sId = $oUser ? $oUser->getId() : 0;
			$oModerator = $this->PluginForum_Forum_GetModeratorByUserIdAndForumId($sId,$oForum->getId());

			$oForum->setIsModerator(LS::Adm() || $oModerator);
			$oForum->setModViewIP(LS::Adm() || ($oModerator && $oModerator->getViewIp()));
			$oForum->setModDeletePost(LS::Adm() || ($oModerator && $oModerator->getAllowDeletePost()));
			$oForum->setModDeleteTopic(LS::Adm() || ($oModerator && $oModerator->getAllowDeleteTopic()));
			$oForum->setModMovePost(LS::Adm() || ($oModerator && $oModerator->getAllowMovePost()));
			$oForum->setModMoveTopic(LS::Adm() || ($oModerator && $oModerator->getAllowMoveTopic()));
			$oForum->setModOpencloseTopic(LS::Adm() || ($oModerator && $oModerator->getAllowOpencloseTopic()));
			$oForum->setModPinTopic(LS::Adm() || ($oModerator && $oModerator->getAllowPinTopic()));
		}
		$aPermissions=unserialize(stripslashes($oForum->getPermissions()));

		$oForum->setAllowShow(forum_check_perms($aPermissions['show_perms'],$oUser,true));
		$oForum->setAllowRead(forum_check_perms($aPermissions['read_perms'],$oUser,true));
		$oForum->setAllowReply(forum_check_perms($aPermissions['reply_perms'],$oUser));
		$oForum->setAllowStart(forum_check_perms($aPermissions['start_perms'],$oUser));
		/**
		 * Авторизован ли текущий пользователь в данном форуме, при условии что форум запоролен
		 */
		$oForum->setAutorization($this->isForumAuthorization($oForum));
		/**
		 * Если у нас нет прав для просмотра родителя данного форума, запрещаем просмотр
		 */
		if ($oParent && !($oParent->getAllowShow())) {
			$oForum->setAllowShow($oParent->getAllowShow());
		}

		return $oForum;
	}

	/**
	 * Проверяем, нужно ли юзеру вводить пароль
	 *
	 * @param	object	$oForum
	 * @return	boolean
	 */
	public function isForumAuthorization($oForum) {
		$bAccess=true;
		if ($oForum->getPassword()) {
			$bAccess=false;
			if ($this->User_IsAuthorization()) {
				if (forum_compare_password($oForum)) {
					$bAccess=true;
				}
			}
		}
		return $bAccess;
	}

	/**
	 * Возвращает список форумов, открытых для пользователя в виде дерева
	 * TODO: Проверять права доступа и исключать ненужные форумы из списка
	 *
	 * @param	object	$oForum
	 * @param	boolean	$bIdOnly
	 * @return	array
	 */
	public function GetOpenForumsTree() {
		$oUserCurrent=$this->User_GetUserCurrent();
		/**
		 * Строит дерево
		 */
		$aForums=$this->LoadTreeOfForum(
			array(
				'#order'=>array('forum_sort'=>'asc')
			)
		);
		/**
		 * Подцепляем дополнительные данные
		 */
		if (!empty($aForums)) {
			$aForums=$this->GetForumsAdditionalData($aForums,self::FORUM_DATA_INDEX);
		}
		return $aForums;
	}

	/**
	 * Возвращает список форумов, открытых для пользователя
	 *
	 * @param	object	$oForum
	 * @param	boolean	$bIdOnly
	 * @return	array
	 */
	public function GetOpenForumsUser($oUser=null,$bIdOnly=false) {
		$aForums=$this->GetForumItemsAll();
		/**
		 * Фильтруем список форумов
		 */
		$aRes=array();
		if (!empty($aForums)) {
			foreach ($aForums as $oForum) {
				$aPermissions=unserialize(stripslashes($oForum->getPermissions()));
				if (forum_check_perms($aPermissions['show_perms'],$oUser,true)
				and forum_check_perms($aPermissions['read_perms'],$oUser,true)
				and $this->isForumAuthorization($oForum)) {
					$aRes[$oForum->getId()]=$oForum;
				}
			}
		}
		return $bIdOnly ? array_keys($aRes) : $aRes;
	}

	/**
	 * Обновление просмотров топика
	 * Данные в БД обновляются раз в 10 минут
	 * @param	PluginForum_ModuleForum_EntityTopic	$oTopic
	 */
	public function UpdateTopicViews(PluginForum_ModuleForum_EntityTopic $oTopic) {
		if (false === ($data = $this->Cache_Get("topic_views_{$oTopic->getId()}"))) {
			$oView=$this->PluginForum_Forum_GetTopicViewByTopicId($oTopic->getId());
			if (!$oView) {
				$oView=Engine::GetEntity('PluginForum_Forum_TopicView');
				$oView->setTopicId($oTopic->getId());
			}
			$oView->setTopicViews($oView->getTopicViews()+1);
			$data=array(
				'obj' => $oView,
				'time' => time()
			);
		} else {
			$data['obj']->setTopicViews($data['obj']->getTopicViews()+1);
		}
		if (!Config::Get('sys.cache.use') or $data['time']<time()-60*10) {
			$data['time'] = time();
			$data['obj']->Save();
		}
		$this->Cache_Set($data, "topic_views_{$oTopic->getId()}", array(), 60*60*24);
	}

	/**
	 * Отправка уведомления на отвеченные посты
	 *
	 * @param	PluginForum_ModuleForum_EntityPost	$oReply
	 * @param	array	$aExcludeMail
	 */
	public function SendNotifyReply(PluginForum_ModuleForum_EntityPost $oReply,$aExcludeMail=array()) {
		if ($oReply) {
			if (preg_match_all("@(<blockquote reply=(?:\"|')(.*)(?:\"|').*>)@Ui",$oReply->getTextSource(),$aMatch)) {
				$aIds = array_values($aMatch[2]);
				/**
				 * Получаем список постов
				 */
				$aPosts = $this->GetPostItemsByArrayPostId((array)$aIds);
				/**
				 * Отправка
				 */
				$sTemplate = 'notify.reply.tpl';
				$sSendTitle = $this->Lang_Get('plugin.forum.notify_subject_reply');
				$aSendContent = array(
					'oUser' => $oReply->getUser(),
					'oTopic' => $oReply->getTopic(),
					'oPost' => $oReply
				);
				foreach ($aPosts as $oPost) {
					if ($oUser = $oPost->getUser()) {
						$sMail = $oUser->getMail();
						if (!$sMail || in_array($sMail, (array)$aExcludeMail)) continue;
						$this->Notify_Send($sMail, $sTemplate, $sSendTitle, $aSendContent, __CLASS__);
					}
				}
			}
		}
	}

	/**
	 * Парсер текста
	 *
	 * @param	string	$sText
	 * @return	stiing
	 */
	public function TextParse($sText=null) {
		$this->Text_LoadJevixConfig('forum');
		/**
		 * @username
		 */
		if (preg_match_all('/@\w+/u',$sText,$aMatch)) {
			foreach ($aMatch as $aPart){
				foreach ($aPart as $str){
					$sText=str_replace($str, '<ls user="'.substr(trim($str), 1).'" />', $sText);
				}
			}
		}
		return $this->Text_Parser($sText);
	}

	/**
	 * Загружает иконку для форума
	 *
	 * @param array $aFile	Массив $_FILES при загрузке аватара
	 * @param PluginForum_ModuleForum_EntityForum $oForum
	 * @return bool
	 */
	public function UploadIcon($aFile, $oForum) {
		if(!is_array($aFile) || !isset($aFile['tmp_name'])) {
			return false;
		}

		$sFileTmp = Config::Get('sys.cache.dir').func_generator();
		if (!move_uploaded_file($aFile['tmp_name'], $sFileTmp)) {
			return false;
		}
		$sPath = Config::Get('plugin.forum.path_uploads_forum');
		$sPath = str_replace(Config::Get('path.root.server'), '', "/{$sPath}/{$oForum->getId()}/");
		$aParams = $this->Image_BuildParams('avatar');

		$oImage = $this->Image_CreateImageObject($sFileTmp);
		/**
		 * Если объект изображения не создан,
		 * возвращаем ошибку
		 */
		if($sError=$oImage->get_last_error()) {
			// Вывод сообщения об ошибки, произошедшей при создании объекта изображения
			// $this->Message_AddError($sError,$this->Lang_Get('error'));
			@unlink($sFileTmp);
			return false;
		}
		/**
		 * Срезаем квадрат
		 */
		$oImage = $this->Image_CropSquare($oImage);

		$aSize = Config::Get('plugin.forum.icon_size');
		rsort($aSize, SORT_NUMERIC);
		$sSizeBig = array_shift($aSize);
		if ($oImage && $sFileAvatar = $this->Image_Resize($sFileTmp, $sPath, "forum_icon_{$oForum->getId()}_{$sSizeBig}x{$sSizeBig}", Config::Get('view.img_max_width'), Config::Get('view.img_max_height'), $sSizeBig, $sSizeBig, false, $aParams, $oImage)) {
			foreach ($aSize as $iSize) {
				if ($iSize == 0) {
					$this->Image_Resize($sFileTmp, $sPath, "forum_icon_{$oForum->getId()}", Config::Get('view.img_max_width'), Config::Get('view.img_max_height'), null, null, false, $aParams, $oImage);
				} else {
					$this->Image_Resize($sFileTmp, $sPath, "forum_icon_{$oForum->getId()}_{$iSize}x{$iSize}", Config::Get('view.img_max_width'), Config::Get('view.img_max_height'), $iSize, $iSize, false, $aParams, $oImage);
				}
			}
			@unlink($sFileTmp);
			/**
			 * Если все нормально, возвращаем расширение загруженного аватара
			 */
			return $this->Image_GetWebPath($sFileAvatar);
		}
		@unlink($sFileTmp);
		/**
		 * В случае ошибки, возвращаем false
		 */
		return false;
	}
	/**
	 * Удаляет иконку форума с сервера
	 *
	 * @param PluginForum_ModuleForum_EntityForum $oForum
	 */
	public function DeleteIcon($oForum) {
		/**
		 * Если иконка есть, удаляем ее и ее рейсайзы
		 */
		if ($oForum->getIcon()) {
			$aSize = Config::Get('plugin.forum.icon_size');
			foreach ($aSize as $iSize) {
				$this->Image_RemoveFile($this->Image_GetServerPath($oForum->getIconPath($iSize)));
			}
		}
	}

	/**
	 * Получает дополнительные данные(объекты) для форумов
	 *
	 * @param	array $aForums	Список форумов
	 * @param	array|null $aAllowData Список дополнительных данных, которые нужно подключать к топикам
	 * @return	array
	 */
	public function GetForumsAdditionalData($aForums,$aAllowData=null) {
		if (is_null($aAllowData)) {
			$aAllowData=array('marker','calculate','perms','moder');
		}
		if (is_string($aAllowData)) {
			$aAllowData=explode(',', $aAllowData);
		}
		func_array_simpleflip($aAllowData);
		$sOne=false;
		if (!is_array($aForums)) {
			$sOne=$aForums->getId();
			$aForums=array($aForums->getId() => $aForums);
		}
		/**
		 * Получаем дополнительные данные
		 */
		$aMark=$this->GetMarking();
		if (isset($aAllowData['marker']) && $this->oUserCurrent) {
			$aForumMark=isset($aMark[self::MARKER_FORUM]) ? $aMark[self::MARKER_FORUM] : array();
			$sUserMark=isset($aMark[self::MARKER_USER]) ? $aMark[self::MARKER_USER] : null;
		}
		/**
		 * Добавляем данные к результату - списку форумов
		 */
		foreach ($aForums as $oForum) {
			/**
			 * Calculate
			 */
			if (isset($aAllowData['calculate'])) {
				$oForum=$this->CalcChildren($oForum, isset($aAllowData['perms']) ? 1 : 0, isset($aAllowData['moder']) ? 0 : 1, isset($aAllowData['marker']) ? 1 : 0);
			} else {
				/**
				 * Marker
				 */
				if (isset($aAllowData['marker']) && $this->oUserCurrent) {
					$sMarkDate=(isset($aForumMark[$oForum->getId()]) && strtotime($aForumMark[$oForum->getId()]) > strtotime($sUserMark)) ? $aForumMark[$oForum->getId()] : $sUserMark;
					if ($sMarkDate && strtotime($sMarkDate) >= strtotime($oForum->getLastPostDate())) {
						$oForum->setRead(true);
					} else {
						$oForum->setRead(false);
					}
				}
				/**
				 * Perms
				 */
				if (isset($aAllowData['perms'])) {
					$oForum=$this->BuildPerms($oForum,isset($aAllowData['moder']) ? 0 : 1);
				}
			}
		}

		return $sOne ? $aForums[$sOne] : $aForums;
	}

	/**
	 * Получает дополнительные данные(объекты) для топиков
	 *
	 * @param	array $aTopics	Список топиков
	 * @param	array|null $aAllowData Список дополнительных данных, которые нужно подключать к топикам
	 * @return	array
	 */
	public function GetTopicsAdditionalData($aTopics,$aAllowData=null) {
		if (is_null($aAllowData)) {
			$aAllowData=array('marker');
		}
		if (is_string($aAllowData)) {
			$aAllowData=explode(',', $aAllowData);
		}
		func_array_simpleflip($aAllowData);
		$sOne=false;
		if (!is_array($aTopics)) {
			$sOne=$aTopics->getId();
			$aTopics=array($aTopics->getId() => $aTopics);
		}
		/**
		 * Получаем дополнительные данные
		 */
		$aMark=$this->GetMarking();
		if (isset($aAllowData['marker']) && $this->oUserCurrent) {
			$aForumMark=isset($aMark[self::MARKER_FORUM]) ? $aMark[self::MARKER_FORUM] : array();
			$aTopicMark=isset($aMark[self::MARKER_TOPIC]) ? $aMark[self::MARKER_TOPIC] : array();
			$sUserMark=isset($aMark[self::MARKER_USER]) ? $aMark[self::MARKER_USER] : null;
		}
		/**
		 * Добавляем данные к результату - списку топиков
		 */
		foreach ($aTopics as $oTopic) {
			/**
			 * Marker
			 */
			if (isset($aAllowData['marker']) && $this->oUserCurrent) {
				$sMarkDate=(isset($aForumMark[$oTopic->getForumId()]) && strtotime($aForumMark[$oTopic->getForumId()]) > strtotime($sUserMark)) ? $aForumMark[$oTopic->getForumId()] : $sUserMark;
				$sMarkDate=(isset($aTopicMark[$oTopic->getId()]) && strtotime($aTopicMark[$oTopic->getId()]) > strtotime($sMarkDate)) ? $aTopicMark[$oTopic->getId()] : $sMarkDate;
				if ($sMarkDate && strtotime($sMarkDate) >= strtotime($oTopic->getLastPostDate())) {
					$oTopic->setRead(true);
				} else {
					$oTopic->setRead(false);
				}
				if (isset($aTopicMark[$oTopic->getId()]) && (is_null($sUserMark) || strtotime($aTopicMark[$oTopic->getId()]) > strtotime($sUserMark))) {
					$sUserMark=$aTopicMark[$oTopic->getId()];
				}
				$oTopic->setReadDate($sUserMark);
			}
		}

		return $sOne ? $aTopics[$sOne] : $aTopics;
	}

	/**
	 * Получает массив трека из сессии
	 *
	 * @return	array
	 */
	public function GetMarking() {
		if ($oUser=$this->User_GetUserCurrent()) {
			$aMark=$this->Session_Get("mark{$oUser->getId()}");
			$aMark=unserialize(stripslashes($aMark));
			return $aMark;
		}
		return array();
	}

	/**
	 * Записывает массив трека в сессию
	 *
	 * @param	array	$aMark
	 * @return	boolean
	 */
	public function SetMarking($aMark) {
		if ($oUser=$this->User_GetUserCurrent()) {
			$this->Session_Set("mark{$oUser->getId()}",addslashes(serialize($aMark)));
			return true;
		}
		return false;
	}

	/**
	 * Проверяет форум на предмет непрочитанных тем
	 *
	 * @param	PluginForum_ModuleForum_EntityForum	$oForum
	 * @return	boolean
	 */
	public function CheckForumMarking(PluginForum_ModuleForum_EntityForum $oForum) {
		$sForumId=$oForum->getId();
		/**
		 * Таблица маркировки
		 */
		$aMark=$this->GetMarking();
		$sUserMark=isset($aMark[self::MARKER_USER]) ? $aMark[self::MARKER_USER] : null;
		$sMarkDate=isset($aMark[self::MARKER_FORUM][$sForumId]) ? $aMark[self::MARKER_FORUM][$sForumId] : $sUserMark;
		/**
		 * Если есть информация
		 */
		if (isset($aMark[self::MARKER_TOPIC_FORUM][$sForumId])) {
			/**
			 * Получаем топики
			 */
			$aTopics=array();
			if ($sMarkDate) {
				$aTopics=$this->GetTopicItemsByForumIdAndLastPostDateGt($sForumId,$sMarkDate);
			} else {
				$aTopics=$this->GetTopicItemsByForumId($sForumId);
			}
			/**
			 * Чекаем
			 */
			if (!empty($aTopics)) {
				$aCheckForum=$aMark[self::MARKER_TOPIC_FORUM][$sForumId];
				$bUnread=false;
				foreach ($aTopics as $oTopic) {
					if (!isset($aCheckForum[$oTopic->getId()])) {
						$bUnread=true;
						break;
					}
				}
				if (!$bUnread) {
					return $this->MarkForum($oForum);
				}
			}
		}
		return false;
	}

	/**
	 * Маркируем все форумы как прочитанные
	 *
	 * @return	boolean
	 */
	public function MarkAll() {
		if ($this->User_IsAuthorization()) {
			$aMark=$this->GetMarking();
			if (isset($aMark[self::MARKER_TOPIC_FORUM])) unset($aMark[self::MARKER_TOPIC_FORUM]);
			if (isset($aMark[self::MARKER_TOPIC])) unset($aMark[self::MARKER_TOPIC]);
			if (isset($aMark[self::MARKER_FORUM])) unset($aMark[self::MARKER_FORUM]);
			$aMark[self::MARKER_USER]=date('Y-m-d H:i:s');
			return $this->SetMarking($aMark);
		}
		return false;
	}

	/**
	 * Маркируем форум как прочитанный
	 *
	 * @param	PluginForum_ModuleForum_EntityForum $oForum
	 * @return	boolean
	 */
	public function MarkForum(PluginForum_ModuleForum_EntityForum $oForum) {
		if ($oUser=$this->User_GetUserCurrent()) {
			$sUserId=$oUser->getId();
			$sForumId=$oForum->getId();
			$aMark=$this->GetMarking();
			$aTopicIds=(isset($aMark[self::MARKER_TOPIC_FORUM][$sForumId])) ? $aMark[self::MARKER_TOPIC_FORUM][$sForumId] : array();
			if (isset($aMark[self::MARKER_TOPIC_FORUM][$sForumId])) unset($aMark[self::MARKER_TOPIC_FORUM][$sForumId]);
			foreach ($aTopicIds as $sTopicId) unset($aMark[self::MARKER_TOPIC][$sTopicId]);
			if (isset($aMark[self::MARKER_TOPIC_FORUM]) && empty($aMark[self::MARKER_TOPIC_FORUM])) unset($aMark[self::MARKER_TOPIC_FORUM]);
			$aMark[self::MARKER_FORUM][$sForumId]=$oForum->getLastPostDate();
			return $this->SetMarking($aMark);
		}
		return false;
	}

	/**
	 * Маркируем тему как прочитанную
	 *
	 * @param	PluginForum_ModuleForum_EntityTopic $oTopic
	 * @return	boolean
	 */
	public function MarkTopic(PluginForum_ModuleForum_EntityTopic $oTopic,$oLastPost=null) {
		if ($oUser=$this->User_GetUserCurrent()) {
			$sUserId=$oUser->getId();
			$sTopicId=$oTopic->getId();
			$sForumId=$oTopic->getForumId();
			$aMark=$this->GetMarking();
			if (!isset($aMark[self::MARKER_TOPIC][$sTopicId])) {
				$aMark[self::MARKER_TOPIC_FORUM][$sForumId][$sTopicId]=true;
			}
			$aMark[self::MARKER_TOPIC][$sTopicId]=$oLastPost ? $oLastPost->getDateAdd() : $oTopic->getLastPostDate();
			return $this->SetMarking($aMark);
		}
		return false;
	}

	/**
	 * Сохраняем маркер пользователя в БД
	 *
	 * @return	boolean
	 */
	public function SaveMarkers() {
		if ($oUser=$this->User_GetUserCurrent()) {
			$sUserId=$oUser->getId();
			$aMark=$this->GetMarking();
			/**
			 * Чистим БД
			 */
			$aForumMark=$this->GetMarkerItemsByUserId($oUser->getId());
			$aTopicMark=$this->GetMarkerTopicItemsByUserId($oUser->getId());
			foreach ($aForumMark as $oMarker) $oMarker->Delete();
			foreach ($aTopicMark as $oMarker) $oMarker->Delete();
			/**
			 * Сохраняем трекер форумов
			 */
			if (isset($aMark[self::MARKER_FORUM])) {
				foreach ((array)$aMark[self::MARKER_FORUM] as $sForumId=>$sMarkDate) {
					$oMarker=Engine::GetEntity('PluginForum_Forum_Marker');
					$oMarker->setUserId($sUserId);
					$oMarker->setForumId($sForumId);
					$oMarker->setMarkDate((string)$sMarkDate);
					$oMarker->Add();
				}
			}
			/**
			 * Сохраняем трекер топиков
			 */
			if (isset($aMark[self::MARKER_TOPIC_FORUM])) {
				foreach ((array)$aMark[self::MARKER_TOPIC_FORUM] as $sForumId=>$aTopics) {
					foreach ((array)$aTopics as $sTopicId=>$bState) {
						$sMarkDate=isset($aMark[self::MARKER_TOPIC][$sTopicId]) ? $aMark[self::MARKER_TOPIC][$sTopicId] : null;
						if ($sMarkDate) {
							$oMarker=Engine::GetEntity('PluginForum_Forum_MarkerTopic');
							$oMarker->setUserId($sUserId);
							$oMarker->setForumId($sForumId);
							$oMarker->setTopicId($sTopicId);
							$oMarker->setMarkDate((string)$sMarkDate);
							$oMarker->Add();
						}
					}
				}
			}
			/**
			 * Сохраняем трекер пользователя
			 */
			if (isset($aMark[self::MARKER_USER])) {
				if (!$oUserForum=$this->GetUserById($sUserId)) {
					$oUserForum=Engine::GetEntity('PluginForum_Forum_User');
					$oUserForum->setUserId($sUserId);
				}
				$oUserForum->setLastMark((string)$aMark[self::MARKER_USER]);
				$oUserForum->Save();
			}
			$this->Session_Drop("mark{$sUserId}");
			return true;
		}
		return false;
	}

	/**
	 * Загружает маркер пользователя из БД
	 *
	 * @return	boolean
	 */
	public function LoadMarkers() {
		if ($oUser=$this->User_GetUserCurrent()) {
			$aMarkData=array();
			$aForumMark=$this->GetMarkerItemsByUserId($oUser->getId());
			$aTopicMark=$this->GetMarkerTopicItemsByUserId($oUser->getId());
			$oUserForum=$this->GetUserById($oUser->getId());
			foreach ($aForumMark as $oMarker) {
				$aMarkData[self::MARKER_FORUM][$oMarker->getForumId()]=$oMarker->getMarkDate();
			}
			foreach ($aTopicMark as $oMarker) {
				$aMarkData[self::MARKER_TOPIC_FORUM][$oMarker->getForumId()][$oMarker->getTopicId()]=true;
				$aMarkData[self::MARKER_TOPIC][$oMarker->getTopicId()]=$oMarker->getMarkDate();
			}
			if ($oUserForum) {
				$aMarkData[self::MARKER_USER]=$oUserForum->getLastMark();
			}
			return $this->SetMarking($aMarkData);
		}
		return false;
	}

	/**
	 * Возвращает количество файлов по временному id
	 *
	 * @param	string	$sTargetId
	 * @return	integer
	 */
	public function GetCountFilesByTargetTmp($sTargetId) {
		return count($this->GetFileItemsByTargetTmp($sTargetId));
	}
	/**
	 * Возвращает количество файлов по id поста
	 *
	 * @param	integer	$iPostId
	 * @return	integer
	 */
	public function GetCountFilesByPostId($iPostId) {
		return count($this->GetFileItemsByPostId($iPostId));
	}
	/**
	 * Загружает файл на сервер
	 *
	 * @param	array	$aFile
	 * @return	string
	 */
	public function UploadAttach($aFile) {
		if(!is_array($aFile) || !isset($aFile['tmp_name'])) {
			return false;
		}

		$sFileName = func_generator(10);
		$sTmpName = $aFile['tmp_name'];

		/**
		 * TODO: Проверка типов файла
		 */

		$sFullPath = Config::Get('plugin.forum.path_uploads_files').'/'.date('Y/m/d').'/';

		if (!is_dir($sFullPath)) {
			mkdir($sFullPath, 0755, true);
		}

		$sFilePath = $sFullPath.$sFileName;
		if (!move_uploaded_file($sTmpName,$sFilePath)) {
			return false;
		}

		/**
		 * TODO:
		 * Вырезать путь 'plugin.forum.path_uploads_files'
		 */

		return $this->Image_GetWebPath($sFilePath);
	}
	/**
	 * Удаляет файл с сервера
	 *
	 * @param	PluginForum_ModuleForum_EntityFile	$oFile
	 * @return	boolean
	 */
	public function DeleteAttach(PluginForum_ModuleForum_EntityFile $oFile) {
		@unlink($this->Image_GetServerPath($oFile->getPath()));
		return	$this->PluginForum_Forum_DeleteFile($oFile);
	}

}
?>