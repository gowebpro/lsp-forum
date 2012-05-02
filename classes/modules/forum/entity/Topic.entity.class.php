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

	/**
	 * Определяем правила валидации
	 */
	public function Init() {
		parent::Init();
		$this->aValidateRules[]=array('topic_title','string','min'=>2,'max'=>100,'allowEmpty'=>false,'label'=>$this->Lang_Get('plugin.forum.new_topic_title'));
		$this->aValidateRules[]=array('topic_description','string','max'=>100,'allowEmpty'=>true,'label'=>$this->Lang_Get('plugin.forum.new_topic_description'));
	}

	public function getPaging() {
		$oEngine=Engine::getInstance();
		$oForum=$this->getForum();
		$aPaging=$oEngine->Viewer_MakePaging(
			$this->getCountPost(),
			1,Config::Get('plugin.forum.post_per_page'),
			Config::Get('pagination.pages.count'),
			$this->getUrlFull()
		);
		return $aPaging;
	}

	public function getUrlFull() {
		return Router::GetPath('forum').'topic/'.$this->getId().'/';
	}
}

?>