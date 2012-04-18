<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Topic.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityTopic extends EntityORM {
	protected $aRelations = array(
		'user'=>array('belongs_to','ModuleUser_EntityUser','user_id'),
		'forum'=>array('belongs_to','PluginForum_ModuleForum_EntityForum','forum_id'),
		'post'=>array('belongs_to','PluginForum_ModuleForum_EntityPost','last_post_id')
	);

	public function getPaging() {
		$oEngine=Engine::getInstance();
		$oForum=$this->getForum();
		$aPaging=$oEngine->Viewer_MakePaging(
			$this->getCountPost(),
			1,Config::Get('plugin.forum.post_per_page'),4,
			Router::GetPath('forum')."topic/{$this->getId()}"
		);
		return $aPaging;
	}

	public function getUrlFull() {
		return Router::GetPath('forum').'topic/'.$this->getId().'/';
	}
}

?>