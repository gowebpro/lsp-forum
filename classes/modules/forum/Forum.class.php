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
	const TOPIC_STATE_OPEN		= 0;
	const TOPIC_STATE_CLOSE		= 1;
	const TOPIC_STATE_MOVED		= 2;
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
	 * Объект маппера форума
	 */
	protected $oMapperForum=null;

	/**
	 * Инициализация модуля
	 */
	public function Init() {
		parent::Init();
		/**
		 * Получаем объект маппера
		 */
		$this->oMapperForum=Engine::GetMapper(__CLASS__);
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
		if (class_exists('PluginAceBlockManager_ModuleVisitors') && Config::Get('plugin.forum.stats.online')) {
			$aStats['online']=array();
			$nCountVisitors=$this->PluginAceBlockManager_Visitors_GetVisitorsCount(300);
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
	 * @param	object	$oRoot
	 * @return	object
	 */
	public function CalcChildren($oRoot) {
		$aChildren=$oRoot->getChildren();

		if (!empty($aChildren)) {
			foreach ($aChildren as $oForum) {
				$oForum=$this->CalcChildren($oForum);

				if ($oForum->getLastPostId() > $oRoot->getLastPostId()) {
					$oRoot->setLastPostId($oForum->getLastPostId());
				}

				$oRoot->setCountTopic($oRoot->getCountTopic() + $oForum->getCountTopic());
				$oRoot->setCountPost($oRoot->getCountPost() + $oForum->getCountPost());
			}
		}

		return $this->BuildPerms($oRoot,true);
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

		$oForum->setCountTopic((int)$iCountTopic);
		$oForum->setCountPost((int)$iCountPost);
		$oForum->setLastPostId((int)$iLastPostId);
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

		$oTopic->setCountPost((int)$iCountPost);
		$oTopic->setLastPostId((int)$iLastPostId);
		return $oTopic->Save();
	}

	/**
	 * Формируем права доступа
	 *
	 * @param	object	$oForum
	 * @return	object
	 */
	public function BuildPerms($oForum,$bNoModers=false) {
		$oUser = LS::CurUsr();
		$oParent = $oForum->getParentId() ? $this->BuildPerms($oForum->getParent(),true) : null;

		if (!$bNoModers) {
			$sId = $oUser ? $oUser->getId() : 0;
			$oModerator = $this->PluginForum_Forum_GetModeratorByUserIdAndForumId($sId,$oForum->getId());

			$oForum->setIsModerator(LS::Adm() || $oModerator);
			$oForum->setModViewIP(LS::Adm() || ($oModerator && $oModerator->getViewIp()));
			$oForum->setModDeletePost(LS::Adm() || ($oModerator && $oModerator->getAllowDeletePost()));
			$oForum->setModDeleteTopic(LS::Adm() || ($oModerator && $oModerator->getAllowDeleteTopic()));
			$oForum->setModMoveTopic(LS::Adm() || ($oModerator && $oModerator->getAllowMoveTopic()));
			$oForum->setModOpencloseTopic(LS::Adm() || ($oModerator && $oModerator->getAllowOpencloseTopic()));
			$oForum->setModPinTopic(LS::Adm() || ($oModerator && $oModerator->getAllowPinTopic()));
		}
		$aPermissions=unserialize(stripslashes($oForum->getPermissions()));

		$oForum->setAllowShow(check_perms($aPermissions['show_perms'],$oUser,true));
		$oForum->setAllowRead(check_perms($aPermissions['read_perms'],$oUser,true));
		$oForum->setAllowReply(check_perms($aPermissions['reply_perms'],$oUser));
		$oForum->setAllowStart(check_perms($aPermissions['start_perms'],$oUser));

		$oForum->setAutorization($this->isForumAuthorization($oForum));

		if ($oParent && !($oParent->getAllowShow())) {
			$oForum->setAllowShow($oParent->getAllowShow());
		}

		// markers
		$oForum->setMarker($this->GetMarker($oForum));

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
			if (LS::CurUsr()) {
				if (forum_compare_password($oForum)) {
					$bAccess=true;
				}
			}
		}
		return $bAccess;
	}

	/**
	 * Возвращает список форумов, открытых для пользователя
	 *
	 * @param	object	$oForum
	 * @param	boolean	$bIdOnly
	 * @return	array
	 */
	public function GetForumsOpenUser($oUser=null,$bIdOnly=false) {
		$aForums=$this->GetForumItemsAll();
		/**
		 * Фильтруем список форумов
		 */
		$aRes=array();
		if (!empty($aForums)) {
			foreach ($aForums as $oForum) {
				$aPermissions=unserialize(stripslashes($oForum->getPermissions()));
				if (check_perms($aPermissions['show_perms'],$oUser,true)
				and check_perms($aPermissions['read_perms'],$oUser,true)
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
	 */
	public function UpdateTopicViews($oTopic) {
		if (false === ($data = $this->Cache_Get("topic_views_{$oTopic->getId()}"))) {
			$oView = $this->PluginForum_Forum_GetTopicViewByTopicId($oTopic->getId());
			if (!$oView) {
				$oView = LS::ENT('PluginForum_Forum_TopicView');
				$oView->setTopicId($oTopic->getId());
			}
			$oView->setTopicViews($oView->getTopicViews()+1);
			$data = array(
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

	public function SendNotifyReply($oReply,$aExcludeMail=array()) {
		if ($oReply) {
			if (preg_match_all("@(<ls reply=(?:\"|')(.*)(?:\"|').*>)@Ui",$oReply->getTextSource(),$aMatch)) {
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
		return $this->Text_Parser($sText);
	}

	/**
	 * Загружает иконку для форума
	 *
	 * @param array $aFile	Массив $_FILES при загрузке аватара
	 * @param PluginForum_ModuleForum_EntityForum $oForum	Форум
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
	 * @param PluginForum_ModuleForum_EntityForum $oForum	Блог
	 */
	public function DeleteIcon($oForum) {
		/**
		 * Если иконка есть, удаляем ее и ее рейсайзы
		 */
		if($oForum->getIcon()) {
			$aSize = Config::Get('plugin.forum.icon_size');
			foreach ($aSize as $iSize) {
				$this->Image_RemoveFile($this->Image_GetServerPath($oForum->getIconPath($iSize)));
			}
		}
	}

	public function MarkTopic($oTopic) {
		$oUser = $this->User_GetUserCurrent();
		$oForum = $oTopic->getForum();
		if ($oUser && $oForum) {
			$sUserId = $oUser->getId();
			$sForumId = $oForum->getId();
			// build mark data
			$aMarkData = $this->Session_Get("mark{$sUserId}");
			$aMarkData = unserialize(stripslashes($aMarkData));
			if (!isset($aMarkData[$sForumId])) {
				$aMarkData[$sForumId]['user_id'] = $sUserId;
				$aMarkData[$sForumId]['forum_id'] = $sForumId;
				$aMarkData[$sForumId]['marker_read_array'] = array();
				$aMarkData[$sForumId]['marker_unread_item'] = $oForum->getCountPost();
				$aMarkData[$sForumId]['marker_count_item'] = $oForum->getCountPost();
			}
			// при добавлении нового поста/топика
			if ($aMarkData[$sForumId]['marker_count_item'] < $oForum->getCountPost()) {
				$iCountDiff = $oForum->getCountPost() - (int)$aMarkData[$sForumId]['marker_count_item'];
				$aMarkData[$sForumId]['marker_unread_item'] = (int)$aMarkData[$sForumId]['marker_unread_item'] + $iCountDiff;
				$aMarkData[$sForumId]['marker_count_item'] = $oForum->getCountPost();
			}
			// build topic data
			$aMarkTopic = array();
			$aMarkTopic['i'] = $oTopic->getCountPost();
			// re-write
			if (isset($aMarkData[$sForumId]['marker_read_array'][$oTopic->getId()])) {
				$aMarkTopicOld = $aMarkData[$sForumId]['marker_read_array'][$oTopic->getId()];
				$iCountDiff = $oTopic->getCountPost() - (int)$aMarkTopicOld['i'];
				$aMarkData[$sForumId]['marker_unread_item'] = (int)$aMarkData[$sForumId]['marker_unread_item'] - $iCountDiff;
			} else {
				$aMarkData[$sForumId]['marker_unread_item'] = (int)$aMarkData[$sForumId]['marker_unread_item'] - $oTopic->getCountPost();
			}
			// build forum data
			$aMarkData[$sForumId]['marker_read_array'][$oTopic->getId()] = $aMarkTopic;
			$aMarkData[$sForumId]['marker_date'] = date('Y-m-d H:i:s');
			// save
			$this->Session_Set("mark{$sUserId}", addslashes(serialize($aMarkData)));
		}
	}

	public function GetMarker($oForum) {
		if ($oUser = $this->User_GetUserCurrent()) {
			$aData = $this->Session_Get("mark{$oUser->getId()}");
			$aData = unserialize(stripslashes($aData));
			if (isset($aData[$oForum->getId()])) {
				$oMarker = LS::Ent('PluginForum_Forum_Marker', $aData[$oForum->getId()]);
				return $oMarker;
			}
		}
		return null;
	}

	public function SaveMarkers() {
		if ($oUser = $this->User_GetUserCurrent()) {
			$aData = $this->Session_Get("mark{$oUser->getId()}");
			$aData = unserialize(stripslashes($aData));
			foreach ((array)$aData as $sForumId => $aForumData) {
				$aForumData['marker_read_array'] = addslashes(serialize($aForumData['marker_read_array']));
				if ($oMarker = $this->GetMarkerByUserIdAndForumId($aForumData['user_id'], $aForumData['forum_id'])) {
					$oMarker->setReadArray($aForumData['marker_read_array']);
					$oMarker->setDate($aForumData['marker_date']);
					$oMarker->setCountItem($aForumData['marker_count_item']);
					$oMarker->Update();
				} else {
					$oMarker = LS::Ent('PluginForum_Forum_Marker', $aForumData);
					$oMarker->Add();
				}
			}
			$this->Session_Drop("mark{$oUser->getId()}");
		}
	}
	public function LoadMarkers() {
		if ($oUser = $this->User_GetUserCurrent()) {
			$aData = array();
			$aMarkers = $this->GetMarkerItemsByUserId($oUser->getId());
			foreach ((array)$aMarkers as $oMarker) {
				$aData[$oMarker->getForumId()]['user_id'] = $oMarker->getUserId();
				$aData[$oMarker->getForumId()]['forum_id'] = $oMarker->getForumId();
				$aData[$oMarker->getForumId()]['marker_read_array'] = unserialize(stripslashes($oMarker->getReadArray()));
				$aData[$oMarker->getForumId()]['marker_date'] = $oMarker->getDate();
				$aData[$oMarker->getForumId()]['marker_count_item'] = $oMarker->getCountItem();
			}
			$this->Session_Set("mark{$oUser->getId()}", addslashes(serialize($aData)));
		}
	}
}

?>