<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet version: 1.X
* @File Name: BlockForum.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

/**
 * Обрабатывает блок активности форум
 *
 */
class PluginForum_BlockForum extends Block {

	public function Exec() {
		/**
		 * Получаем список форумов, открытых для пользователя
		 */
		$aForumsId=$this->PluginForum_Forum_GetOpenForumsUser(LS::CurUsr(),true);
		/**
		 * Получаем последние топики
		 */
		if ($aForumsId) {
			$aLastTopics=$this->PluginForum_Forum_GetTopicItemsAll(
				array(
					'#where'=>array('forum_id IN (?a)'=>array($aForumsId)),
					'#order'=>array('last_post_id'=>'desc'),
					'#page'=>array(1,Config::Get('block.stream.row'))
				)
			);
			if (!empty($aLastTopics['collection'])) {
				$this->Viewer_Assign('aLastTopics',$aLastTopics['collection']);
			}
		}
	}
}
?>