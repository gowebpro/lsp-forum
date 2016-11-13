<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.1
* @Author: Chiffa
* @LiveStreet version: 1.0
* @File Name: HookSession.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Регистрация хуков
 *
 */
class PluginForum_HookSession extends Hook {
	public function RegisterHook() {
		/**
		 * Регистрируем, только если включено
		 */
		if (Config::Get('plugin.forum.stats.online.enable') && Config::Get('plugin.forum.components.session')) {
			$this->AddHook('init_action', 'SessionInit');
			$this->AddHook('template_forum_show_legend', 'ShowForum');
			$this->AddHook('template_forum_topic_show_legend', 'ShowTopic');
		}
	}

	public function SessionInit() {
		/**
		 * Инициализация сессии
		 */
		$this->PluginForum_Session_InitSession();
		/**
		 * Загружаем сессии в шаблон
		 */
		$aSessions = $this->PluginForum_Session_GetSessionsByPage();
		$aPageSessions = array();
		$iPageUsers = 0;
		$iPageGuest = 0;
		foreach ($aSessions as $oSession) {
			if ($oSession->getUser()) {
				$iPageUsers++;
			} else {
				$iPageGuest++;
			}
			$aPageSessions[] = $oSession;
		}
		$this->Viewer_Assign('aPageSessions', $aPageSessions);
		$this->Viewer_Assign('iPageSessions', $iPageUsers+$iPageGuest);
		$this->Viewer_Assign('iPageUsers', $iPageUsers);
		$this->Viewer_Assign('iPageGuest', $iPageGuest);
	}

	public function ShowForum() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'session.tpl');
	}
	public function ShowTopic() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'session.tpl');
	}

}
?>