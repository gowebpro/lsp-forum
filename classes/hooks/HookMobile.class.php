<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: HookMobile.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Регистрация хуков
 *
 */
class PluginForum_HookMobile extends Hook {
	public function RegisterHook() {
		if (class_exists('MobileDetect') && MobileDetect::IsMobileTemplate()) {
			$this->AddHook('init_action','InitAction',0,__CLASS__);
		}
	}


	public function InitAction() {
		/**
		 * Подключаем JS
		 */
		$this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__).'js/template.js');
	}

}
?>