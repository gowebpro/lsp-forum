<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: HookForumMarker.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Регистрация хуков
 *
 */
class PluginForum_HookForumMarker extends Hook {
	public function RegisterHook() {
		$this->AddHook('module_user_authorization_after', 'SessionStart', __CLASS__);
		$this->AddHook('module_user_logout_before', 'SessionDrop', __CLASS__);
	}

	public function SessionStart() {
		$this->PluginForum_Forum_LoadMarkers();
	}

	public function SessionDrop() {
		$this->PluginForum_Forum_SaveMarkers();
	}

}
?>