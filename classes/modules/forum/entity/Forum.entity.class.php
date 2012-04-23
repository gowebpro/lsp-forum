<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Forum.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityForum extends EntityORM {
	protected $aRelations = array(
		'tree',
		'user'=>array('belongs_to','ModuleUser_EntityUser','last_user_id'),
		'topic'=>array('belongs_to','PluginForum_ModuleForum_EntityTopic','last_topic_id'),
		'post'=>array('belongs_to','PluginForum_ModuleForum_EntityPost','last_post_id')
	);

	public function getUrlFull() {
		return Router::GetPath('forum').($this->getUrl() ? $this->getUrl() : $this->getId()).'/';
	}
}

?>