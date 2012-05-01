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
		$this->AddHook('template_main_menu_item','MainMenu');
		$this->AddHook('template_menu_profile_created_item','MenuProfileCreated');
		$this->AddHook('template_forum_copyright','ForumCopyright');
	}

	public function MainMenu() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'main_menu.tpl');
	}

	public function MenuProfileCreated() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'menu.profile_created.tpl');
	}

	public function ForumCopyright() {
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