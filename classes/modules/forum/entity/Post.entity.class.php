<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Post.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityPost extends EntityORM {
	protected $aRelations = array(
		'topic'=>array('belongs_to','PluginForum_ModuleForum_EntityTopic','topic_id'),
		'user'=>array('belongs_to','ModuleUser_EntityUser','user_id'),
		'editor'=>array('belongs_to','ModuleUser_EntityUser','post_editor_id'),
	);

	public function getUrlFull() {
		return Router::GetPath('forum')."findpost/{$this->getId()}/";
	}

	public function getNumber() {
		return $this->_getDataOne('number') ? $this->_getDataOne('number') : $this->getId();
	}
}
?>