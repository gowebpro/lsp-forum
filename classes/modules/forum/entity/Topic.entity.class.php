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
		'user'=>array(self::RELATION_TYPE_BELONGS_TO,'ModuleUser_EntityUser','user_id'),
		'forum'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityForum','forum_id'),
		'post'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityPost','last_post_id'),
		//'view'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityView','topic_id')
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
		$iCountItems=$this->getCountPost();
		$iPerPage=Config::Get('plugin.forum.post_per_page');
		if (Config::Get('plugin.forum.topic_line_mod')) {
			$iCountItems--;
			$iPerPage--;
		}
		$oEngine=Engine::getInstance();
		$aPaging=$oEngine->Viewer_MakePaging(
			$iCountItems,
			1,$iPerPage,
			Config::Get('pagination.pages.count'),
			$this->getUrlFull()
		);
		return $aPaging;
	}

	public function getUrlFull() {
		return Router::GetPath('forum').'topic/'.$this->getId().'/';
	}

	public function getSubscribeNewPost() {
		if (!($oUserCurrent=$this->User_GetUserCurrent())) {
			return null;
		}
		return $this->Subscribe_GetSubscribeByTargetAndMail('topic_new_post',$this->getId(),$oUserCurrent->getMail());
	}

	public function getViews() {
		//if ($oView = $this->getView()) {
		$oView = null;
		if (false === ($data = $this->Cache_Get("topic_views_{$this->getId()}"))) {
			$oView = $this->PluginForum_Forum_GetTopicViewByTopicId($this->getId());
		} else {
			$oView = $data['obj'];
		}
		return $oView ? $oView->getTopicViews() : 0;
	}
}

?>