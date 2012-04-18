<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: HookForum.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Регистрация хуков
 *
 */
class PluginForum_HookForum extends Hook {
	public function RegisterHook() {
		$this->AddHook('template_main_menu','Menu');
		$this->AddHook('template_forum_copyright','Copyright');
	}

	public function Menu() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'main_menu.tpl');
	}

	public function Copyright() {
		$aPlugins=$this->Plugin_GetList();
		if (!(isset($aPlugins['forum']))) {
			return;
		}
		$aForumData=$aPlugins['forum']['property'];
		$this->Viewer_Assign('aForumData',$aForumData);
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'copyright.tpl');
	}
}

?>