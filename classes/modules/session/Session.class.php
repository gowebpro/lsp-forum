<?php


class PluginForum_ModuleSession extends Module
{
	const SESSION_FILE  = 'session.dat';
	const SESSION_TIME  = 300;

	/**
	 * Инициализация модуля
	 */
	public function Init()
	{
		//$this->Session_Drop('visitor');
	}


	/**
	 * Сканирует массив сессий и дропает просроченные
	 *
	 * @param	array	$aData
	 * @return	array
	 */
	protected function CheckSessionsArray($aData=array())
	{
		$iTimeLine = time() - self::SESSION_TIME;
		foreach ($aData as $sId => $aSession) {
			if ($aSession['time'] < $iTimeLine) {
				unset($aData[$sId]);
			}
		}
		$this->SetSessionsArray($aData);
		return $aData;
	}

	/**
	 * Пишет массив сессий в файл
	 *
	 * @param	array	$aData
	 */
	protected function SetSessionsArray($aData=array())
	{
		@file_put_contents($this->GetFilePath(), addslashes(serialize($aData)));
	}

	/**
	 * Возращает массив сессий
	 *
	 * @return	array
	 */
	protected function GetSessionsArray()
	{
		$sFileName = $this->GetFilePath();
		$aData = array();
		if ($sContent = @file_get_contents($this->GetFilePath())) {
			$aData = $this->CheckSessionsArray(unserialize(stripslashes($sContent)));
		}
		return $aData;
	}

	/**
	 * Возвращает полный путь до файла сессий
	 *
	 * @return	string
	 */
	protected function GetFilePath()
	{
		return Config::Get('plugin.forum.path_plugin').'/'.self::SESSION_FILE;
	}

	/**
	 * Формирует уникальные данные для посетителя
	 *
	 * @return	array
	 */
	protected function GetUniqueData()
	{
		if (!$sUniqId = $this->Session_Get('visitor')) {
			$sUniqId = md5(serialize(func_getIp()));
			$this->Session_Set('visitor',$sUniqId);
		}
		$aUniqData = array('id' => $sUniqId, 'agent' => false);

		if ($oUser = $this->User_GetUserCurrent()) {
			$aUniqData['user'] = $oUser->getId();
		}
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$aUniqData['agent'] = $_SERVER['HTTP_USER_AGENT'];
		}
		return $aUniqData;
	}

	/**
	 * Возвращает текущй URL без хоста
	 *
	 * @return	string
	 */
	protected function GetCurrentPage()
	{
		return rtrim(ltrim(str_replace(Config::Get('path.root.web'), '', Router::GetPathWebCurrent()), '/'), '/');
	}

	/**
	 * Инициализация сессии
	 *
	 * @param	array	$aData
	 * @return	array
	 */
	public function InitSession()
	{
		$aData = $this->GetSessionsArray();
		if ($aUniqData = $this->GetUniqueData()) {
			$aData[$aUniqData['id']] = array();
			$aData[$aUniqData['id']]['time'] = time();
			if (isset($aUniqData['user'])) {
				$aData[$aUniqData['id']]['user_id'] = $aUniqData['user'];
			}
			if (isset($aUniqData['agent'])) {
				$aData[$aUniqData['id']]['agent'] = $aUniqData['agent'];
			}
			$aData[$aUniqData['id']]['page'] = $this->GetCurrentPage();
			$this->SetSessionsArray($aData);
		}
		return true;
	}

	/**
	 * Возращает массив сущностей всех сессий
	 *
	 * @return	array
	 */
	public function GetSessions()
	{
		$aSessions = array();
		$aUsersId = array();
		$aData = $this->GetSessionsArray();
		foreach ($aData as $sUid => $aSession) {
			$oSession = Engine::GetEntity('PluginForum_Session', $aSession);
			if ($oSession->getUserId()) {
				$aUsersId[] = $oSession->getUserId();
			}
			$aSessions[] = $oSession;
		}
		if ($aUsersId) {
			$aUsers = $this->User_GetUsersAdditionalData($aUsersId, array());
			foreach ($aSessions as $oSession) {
				if (isset($aUsers[$oSession->getUserId()])) {
					$oSession->setUser($aUsers[$oSession->getUserId()]);
				} else {
					$oSession->setUser(null);
				}
			}
		}
		return $aSessions;
	}

	/**
	 * Возвращает сессии для текущей страницы
	 *
	 * @param	array	$aData
	 * @return	array
	 */
	public function GetSessionsByPage()
	{
		$aSessions = $this->GetSessions();
		$sWebPath = $this->GetCurrentPage();

		$aSessionByPage = array();

		foreach ($aSessions as $oSession) {
			$aSessionByPage[$oSession->getPage()][] = $oSession;
		}

		return isset($aSessionByPage[$sWebPath]) ? $aSessionByPage[$sWebPath] : array();
	}

	/**
	 * Возвращает количество всех сессии
	 *
	 * @return	integer
	 */
	public function GetSessionsCount()
	{
		$aData = $this->GetSessionsArray();
		return is_array($aData) ? sizeof($aData) : 0;
	}

}
