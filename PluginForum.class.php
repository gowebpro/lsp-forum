<?
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: PluginForum.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginForum extends Plugin {
	protected $aInherits=array(
		'action' => array('ActionProfile'=>'PluginForum_ActionProfile'),
		'module' => array('ModuleACL'=>'PluginForum_ModuleACL')
	);

	/**
	 * Активация плагина
	 */
	public function Activate() {
		if (!$this->isTableExists('prefix_forum')) {
			$this->ExportSQL(dirname(__FILE__).'/sql/install.sql');
		}
		return true;
	}

	/**
	 * Деактивация плагина
	 */
	public function Deactivate() {
		if (Config::Get('plugin.forum.deactivate.delete')) {
			$this->ExportSQL(dirname(__FILE__).'/sql/deinstall.sql');
		}
		return true;
	}

	/**
	 * Инициализация плагина
	 */
	public function Init() {
		/**
		 * Подключаем CSS
		 */
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__).'css/forum.css');
		/**
		 * Подключаем JS
		 */
		$this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__).'js/forum.js');

		return true;
	}
}

?>